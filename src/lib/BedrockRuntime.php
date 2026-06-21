<?php
/**
 * Minimal AWS Bedrock Runtime client using raw HTTP + AWS Signature V4.
 * No SDK dependency — credentials come from env vars (local) or ECS task role (production).
 *
 * To update the model: change MODEL_ID below to any active Bedrock model ID.
 * Check available models: AWS Console → Bedrock → Foundation models → filter Anthropic.
 *
 * Model: anthropic.claude-haiku-4-5-20251001-v1:0
 * Cost:  ~$0.0008/1K input tokens, $0.004/1K output tokens (~$0.006 per blog post)
 */
class BedrockRuntime
{
    const MODEL_ID = 'us.anthropic.claude-haiku-4-5-20251001-v1:0';

    private string $region;
    private string $accessKey;
    private string $secretKey;
    private string $sessionToken;

    public function __construct()
    {
        $this->region = getenv('AWS_DEFAULT_REGION') ?: getenv('AWS_REGION') ?: 'us-east-1';
        $creds = $this->resolveCredentials();
        $this->accessKey    = $creds['key'];
        $this->secretKey    = $creds['secret'];
        $this->sessionToken = $creds['token'];
    }

    /**
     * Invoke the model with a user prompt. Returns ['content' => string] or ['error' => string].
     */
    public function invoke(string $prompt, int $maxTokens = 2000): array
    {
        if (!$this->accessKey || !$this->secretKey) {
            return ['error' => 'AWS credentials not available. Set AWS_ACCESS_KEY_ID + AWS_SECRET_ACCESS_KEY or run on ECS with a task role.'];
        }

        $endpoint = "https://bedrock-runtime.{$this->region}.amazonaws.com/model/" . urlencode(self::MODEL_ID) . "/invoke";
        $host     = "bedrock-runtime.{$this->region}.amazonaws.com";
        $service  = 'bedrock';

        $body = json_encode([
            'anthropic_version' => 'bedrock-2023-05-31',
            'max_tokens'        => $maxTokens,
            'messages'          => [['role' => 'user', 'content' => $prompt]],
        ]);

        $amzDate   = gmdate('Ymd\THis\Z');
        $dateStamp = gmdate('Ymd');

        $headers = [
            'content-type' => 'application/json',
            'host'         => $host,
            'x-amz-date'   => $amzDate,
        ];
        if ($this->sessionToken) {
            $headers['x-amz-security-token'] = $this->sessionToken;
        }

        $authHeader = $this->sign('POST', $endpoint, $headers, $body, $service, $dateStamp, $amzDate);

        $curlHeaders = [];
        foreach ($headers as $k => $v) {
            $curlHeaders[] = "$k: $v";
        }
        $curlHeaders[] = "Authorization: $authHeader";

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $curlHeaders,
            CURLOPT_TIMEOUT        => 60,
        ]);
        $response = curl_exec($ch);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) return ['error' => "cURL error: $curlErr"];

        $data = json_decode($response, true);
        $errMsg = $data['message'] ?? $data['Message'] ?? '';
        if ($errMsg) return ['error' => $errMsg];
        $text = $data['content'][0]['text'] ?? '';
        if (!$text)   return ['error' => 'Empty response from Bedrock: ' . $response];

        return ['content' => $text];
    }

    // ── AWS Signature V4 ────────────────────────────────────────────────────

    private function sign(string $method, string $url, array $headers, string $body, string $service, string $dateStamp, string $amzDate): string
    {
        ksort($headers);

        $canonicalHeaders = '';
        $signedHeadersList = [];
        foreach ($headers as $k => $v) {
            $canonicalHeaders .= strtolower($k) . ':' . trim($v) . "\n";
            $signedHeadersList[] = strtolower($k);
        }
        $signedHeaders = implode(';', $signedHeadersList);

        $parsedUrl    = parse_url($url);
        // AWS Sig V4 requires each path segment to be rawurlencode()'d against the
        // already-percent-encoded path — e.g. the ':' in the model ID is encoded as
        // %3A in the URL, and then that % must be encoded again to %25 → %253A.
        $canonicalUri = implode('/', array_map('rawurlencode', explode('/', $parsedUrl['path'] ?? '/')));
        $canonicalQs  = '';
        $payloadHash   = hash('sha256', $body);

        $canonicalRequest = implode("\n", [
            $method, $canonicalUri, $canonicalQs,
            $canonicalHeaders, $signedHeaders, $payloadHash,
        ]);

        $credentialScope = "$dateStamp/{$this->region}/$service/aws4_request";
        $stringToSign = implode("\n", [
            'AWS4-HMAC-SHA256', $amzDate, $credentialScope,
            hash('sha256', $canonicalRequest),
        ]);

        $signingKey = $this->hmac(
            $this->hmac($this->hmac($this->hmac('AWS4' . $this->secretKey, $dateStamp), $this->region), $service),
            'aws4_request'
        );
        $signature = bin2hex(hash_hmac('sha256', $stringToSign, $signingKey, true));

        return "AWS4-HMAC-SHA256 Credential={$this->accessKey}/{$credentialScope}, SignedHeaders={$signedHeaders}, Signature={$signature}";
    }

    private function hmac(string $key, string $data): string
    {
        return hash_hmac('sha256', $data, $key, true);
    }

    // ── Credential resolution (env vars → ECS task role) ───────────────────

    private function resolveCredentials(): array
    {
        // 1. Explicit env vars (local dev / CI)
        $key    = getenv('AWS_ACCESS_KEY_ID')     ?: '';
        $secret = getenv('AWS_SECRET_ACCESS_KEY') ?: '';
        $token  = getenv('AWS_SESSION_TOKEN')     ?: '';
        if ($key && $secret) {
            return ['key' => $key, 'secret' => $secret, 'token' => $token];
        }

        // 2. ECS task role (production)
        $relUri = getenv('AWS_CONTAINER_CREDENTIALS_RELATIVE_URI');
        if ($relUri) {
            $ch = curl_init('http://169.254.170.2' . $relUri);
            curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 3]);
            $r = curl_exec($ch);
            curl_close($ch);
            $data = $r ? json_decode($r, true) : [];
            if (!empty($data['AccessKeyId'])) {
                return [
                    'key'    => $data['AccessKeyId'],
                    'secret' => $data['SecretAccessKey'],
                    'token'  => $data['Token'] ?? '',
                ];
            }
        }

        return ['key' => '', 'secret' => '', 'token' => ''];
    }
}
