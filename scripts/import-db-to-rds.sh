#!/bin/bash
set -e

################################################################################
# Import local MySQL dump to AWS RDS
# Usage: ./scripts/import-db-to-rds.sh
################################################################################

DB_INSTANCE_ID="showcase-prod-mysql"
DB_USER="showcaseadmin"
DB_NAME="showcase"
DUMP_FILE="/Users/sumansouravray/projects/mpe/mpe_dump.sql"
REGION="us-east-1"

echo "=== MPE Database Import to RDS ==="
echo ""

# --- Pre-checks ---
if [ ! -f "$DUMP_FILE" ]; then
  echo "ERROR: Dump file not found: $DUMP_FILE"
  echo "Export it first: docker exec mysql_db mysqldump -uroot -proot mpe > mpe_dump.sql"
  exit 1
fi

if ! command -v mysql &> /dev/null; then
  echo "ERROR: mysql client not found."
  echo "Install it:"
  echo "  brew install mysql-client"
  echo "  export PATH=\"/opt/homebrew/opt/mysql-client/bin:\$PATH\""
  exit 1
fi

if ! command -v aws &> /dev/null; then
  echo "ERROR: AWS CLI not found. Install it first."
  exit 1
fi

echo "[1/8] Getting RDS endpoint..."
RDS_ENDPOINT=$(aws rds describe-db-instances \
  --db-instance-identifier "$DB_INSTANCE_ID" \
  --query 'DBInstances[0].Endpoint.Address' \
  --output text \
  --region "$REGION")
echo "  Endpoint: $RDS_ENDPOINT"

echo ""
echo "[2/8] Getting RDS security group..."
SG_ID=$(aws rds describe-db-instances \
  --db-instance-identifier "$DB_INSTANCE_ID" \
  --query 'DBInstances[0].VpcSecurityGroups[0].VpcSecurityGroupId' \
  --output text \
  --region "$REGION")
echo "  Security Group: $SG_ID"

echo ""
echo "[3/8] Getting your public IPv4 address..."
MY_IP=$(curl -4 -s https://api.ipify.org)
if [ -z "$MY_IP" ]; then
  echo "ERROR: Could not determine your IPv4 address."
  exit 1
fi
echo "  Your IP: $MY_IP"

echo ""
echo "[4/8] Getting DB password from SSM..."
DB_PASSWORD=$(aws ssm get-parameter \
  --name "/mpe/prod/DB_PASSWORD" \
  --with-decryption \
  --query 'Parameter.Value' \
  --output text \
  --region "$REGION")
if [ -z "$DB_PASSWORD" ]; then
  echo "ERROR: Could not retrieve DB password from SSM."
  exit 1
fi
echo "  Password retrieved."

echo ""
echo "[5/8] Making RDS publicly accessible..."
aws rds modify-db-instance \
  --db-instance-identifier "$DB_INSTANCE_ID" \
  --publicly-accessible \
  --apply-immediately \
  --region "$REGION" > /dev/null
echo "  Modification submitted."

echo ""
echo "[6/8] Adding security group rule for your IP..."
# Try to add the rule; ignore error if it already exists
aws ec2 authorize-security-group-ingress \
  --group-id "$SG_ID" \
  --protocol tcp \
  --port 3306 \
  --cidr "${MY_IP}/32" \
  --region "$REGION" 2>/dev/null || echo "  (Rule may already exist, continuing...)"
echo "  Rule added: ${MY_IP}/32 -> port 3306"

echo ""
echo "  Waiting 60 seconds for RDS modification to take effect..."
sleep 60

echo ""
echo "[7/8] Importing database..."
echo "  Source: $DUMP_FILE"
echo "  Target: $DB_USER@$RDS_ENDPOINT/$DB_NAME"
echo ""
MYSQL_PWD="$DB_PASSWORD" mysql \
  -h "$RDS_ENDPOINT" \
  -u "$DB_USER" \
  "$DB_NAME" < "$DUMP_FILE"
echo ""
echo "  Import complete!"

echo ""
echo "[8/8] Reverting RDS public access..."

echo "  Removing security group rule..."
aws ec2 revoke-security-group-ingress \
  --group-id "$SG_ID" \
  --protocol tcp \
  --port 3306 \
  --cidr "${MY_IP}/32" \
  --region "$REGION" 2>/dev/null || echo "  (Rule already removed)"

echo "  Making RDS private again..."
aws rds modify-db-instance \
  --db-instance-identifier "$DB_INSTANCE_ID" \
  --no-publicly-accessible \
  --apply-immediately \
  --region "$REGION" > /dev/null

echo ""
echo "=== Done! ==="
echo ""
echo "Your database has been imported and RDS is private again."
echo "Visit http://www.mygodzillashop.com/ to verify the site works."
