# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Site Does

**MyGodzillaShop** (mygodzillashop.com) is an online auction marketplace for **movie posters and collectibles**, specializing in Godzilla/kaiju and classic film memorabilia. Sellers list posters; buyers bid on them or purchase at fixed price. The platform handles the full lifecycle: listing → approval → bidding/offers → invoicing → PayPal payment → shipping.

## Local Development

```bash
# Start the full stack (PHP app, MySQL, CloudBeaver DB browser)
docker-compose up

# App:         http://localhost:8080
# MySQL:       localhost:3306  (root:root, database: mpe)
# CloudBeaver: http://localhost:8978  (admin:admin)
```

The `src/` directory is bind-mounted into the container at `/var/www/html`, so PHP file changes take effect immediately without rebuilding.

## Database Migrations

Migrations are PHP scripts in `src/migrations/`. Run them via the admin panel at `/admin/admin_run_migration.php` (requires admin login) or by directly executing the PHP file inside the container. There is no versioning system — track which have been run manually.

## Deployment

Push to `main` triggers the full deployment pipeline via GitHub Actions (`.github/workflows/deploy.yml`):
1. Builds and pushes Docker image to AWS ECR
2. Syncs `src/css/` and `src/javascript/` to S3 + invalidates CloudFront
3. Updates ECS task definition and deploys to `showcase-prod-cluster` / `showcase-prod-web`

Infrastructure changes use Terraform in `infra/` — plan runs on PR, apply runs on merge.

## Auction Types & Data Model

The site has multiple listing types controlled by `fk_auction_type_id`:

| `fk_auction_type_id` | Type | Tables |
|---|---|---|
| 1 | Fixed Price | `tbl_auction`, `tbl_poster` |
| 2 | Weekly Live Auction | `tbl_auction_live`, `tbl_poster_live` |
| 3 | Monthly Auction | `tbl_auction_live`, `tbl_poster_live` |
| 4 | Stills | `tbl_auction_live`, `tbl_poster_live` |

**Live vs. fixed-price table split:** Active live/timed auction records (types 2, 3, 4) live in `tbl_auction_live` and `tbl_poster_live`. Fixed-price items (type 1) stay in `tbl_auction` and `tbl_poster`. A cron job (`cron_live.php`) promotes approved auctions into the `_live` tables when they go active, and clears them when they end. Images mirror the same split: `tbl_poster_images` (fixed) vs `tbl_poster_images_live` (live).

**Weekly auctions** (type 2) are grouped by `fk_auction_week_id` → `tbl_auction_week`, which holds the schedule window (`auction_week_start_date`, `auction_week_end_date`). `AuctionWeek.php` manages fetching active, upcoming, and closed weeks.

**Monthly auctions** (type 3) are tied to `tbl_event` via `fk_event_id` and require `is_approved_for_monthly_auction = 1`.

**Auction status fields:**
- `auction_is_approved`: 0 = pending admin approval, 1 = approved/live
- `auction_is_sold`: 0 = active, 1 = sold, 2 = reserve not met, 3 = reopened/relisted

**Bidding vs. offers:**
- Live auctions (types 2–4): buyers place bids in `tbl_bid`. Winning bid gets `bid_is_won = 1` when the auction closes (set by cron). Proxy bids tracked via `is_proxy` flag.
- Fixed price (type 1): buyers submit offers via `tbl_offer` against `auction_reserve_offer_price` (which can be a flat amount or a percentage, controlled by `is_offer_price_percentage`).

**Poster attributes** are stored as category joins via `tbl_poster_to_category` → `tbl_category` (typed by `tbl_category_type`): Size (type 1), Genre (type 2), Decade (type 3), Country (type 4), Condition (type 5). A newer subcategory system uses `tbl_subcategory` / `tbl_shop_category`.

**Item lifecycle:** Seller creates `tbl_poster` + `tbl_auction` (approved=0) → admin approves → cron copies to `_live` tables → bidding/offers → auction ends → winning bid marked, invoice created in `tbl_invoice` linked via `tbl_invoice_to_auction` → PayPal payment → seller paid with MPE commission deducted.

## Architecture

**Stack:** PHP 8.3 + Apache, MySQL 8.0, Smarty 3 templates, raw MySQLi (no ORM), jQuery frontend.

**Core class pattern:** `src/classes/DBCommon.php` is the base class providing `selectData()`, `insertData()`, `updateData()`, `deleteData()`, `countData()`. All domain classes (`Auction`, `Bid`, `User`, `Invoice`, `Cart`, `Category`) extend it. The global DB connection lives in `$GLOBALS['db_connect']`.

**Request flow:** Entry-point PHP files in `src/` (e.g., `buy.php`, `cart.php`, `auth.php`) handle routing. They use classes from `src/classes/`, utility functions from `src/lib/function.php`, and render via Smarty templates in `src/templates/` (frontend) or `src/admin_templates/` (admin panel).

**Configuration:** `src/lib/configures.php` reads env vars and the `tbl_config` database table at runtime. `APP_ENV=local` vs `production` controls CDN paths. No `.env` file — env vars are injected by Docker Compose locally and by AWS Secrets Manager / SSM in production.

**Static assets:** CSS and JS in `src/css/` and `src/javascript/` are served via CloudFront CDN in production. The CDN URL is `CDN_STATIC_URL` (defaults to the CloudFront distribution domain). Changes are picked up only after a deploy syncs and invalidates CloudFront.

**Scheduled tasks:** `src/cron_live.php` and `src/cron_invoice_expiry.php` are triggered by AWS EventBridge (see `infra/eventbridge.tf`).

**SOAP web service:** Legacy NuSOAP endpoint at `src/webservice/server.php`. AJAX calls go to `src/ajax.php`.

**Smarty cache:** Compiled templates write to `src/templates_c/` and `src/admin_templates_c/` (git-ignored). The Docker entrypoint clears these on container start. In production, Smarty cache lives on an EFS mount shared across ECS tasks.

## Key Environment Variables

| Variable | Local default | Purpose |
|---|---|---|
| `DB_SERVER` | `mysql` | MySQL hostname |
| `DB_NAME` | `mpe` | Database name |
| `DB_USER` | `root` | DB user |
| `DB_PASSWORD` | `root` | DB password |
| `APP_ENV` | `local` | `local` disables CDN paths and S3 uploads |
| `CDN_STATIC_URL` | `https://d294w6g1afjpvs.cloudfront.net` | CloudFront base URL for all static assets |
| `S3_STATIC_BUCKET` | _(not set locally)_ | S3 bucket name for static assets + poster images |

## Template Variables & CDN Paths

**`$actualPathJSCSS`** — resolves to the HTTPS CDN URL (`https://d294w6g1afjpvs.cloudfront.net/`) in production. Use this for all JS/CSS asset references in templates (not `DOMAIN_PATH` or `$actualPath`).

**`DOMAIN_PATH`** — always `http://` regardless of environment (defined in `src/lib/configures.php`). Never use it for JS/CSS/image resources — it causes mixed content blocking on the HTTPS production site.

**`CLOUD_POSTER_THUMB_BUY`** — resolves to `https://d294w6g1afjpvs.cloudfront.net/poster_photo/thumb_buy/` in production (served from S3 via CloudFront). In local dev it resolves to `http://localhost:8080/poster_photo/thumb_buy/` (served from EFS). All five `CLOUD_POSTER_*` constants follow the same pattern. Do not hardcode the ECS hostname for image URLs.

**`CLOUD_STATIC`** / **`CLOUD_STATIC_ADMIN`** — CDN base URLs for static images. `is_cloud` on `tbl_poster_images` rows is always `'1'` — it is a legacy flag that no longer meaningfully distinguishes storage location; all images use the `CLOUD_POSTER_*` constants regardless.

**Smarty NULL checks** — `{if $var != ''}` evaluates to FALSE when the DB value is NULL. Always use `{if $var}` (truthy) when the column may be NULL (e.g. `tracking_number`).

**Smarty + JavaScript** — PayPal SDK JS object literals like `{action: 'create_order'}` are treated as Smarty tags. Always wrap PayPal/JS code in `{literal}…{/literal}` and output any Smarty variables into a plain `<script>var _pp = {…};</script>` block placed **before** the `{literal}` block.

## Poster Image Storage (S3 + CloudFront)

Poster images are stored in S3 and served via CloudFront in production. Local dev continues to use the EFS-mounted filesystem at `/var/www/html/poster_photo/`.

**Five size variants** are generated on upload by `dynamicPosterUpload()` in `src/lib/function.php` using PHP GD:

| S3 key prefix | Size | Used by |
|---|---|---|
| `poster_photo/` | Original | Admin, full-size view |
| `poster_photo/thumbnail/` | 100×100 | Admin thumbnails |
| `poster_photo/thumb_buy/` | 150×150 | Buy/search listings |
| `poster_photo/thumb_buy_gallery/` | 200×200 | Gallery grid |
| `poster_photo/thumb_big_slider/` | 570×430 | Homepage slider |

In production, after GD generates all five variants locally, `dynamicPosterUpload()` uploads each to S3 (using the ECS task role — no credentials in code) and deletes the local copies. The S3 key mirrors the filesystem path, so CloudFront's `/poster_photo/*` behavior routes them correctly.

**CloudFront behavior** for `/poster_photo/*` is defined in `infra/cloudfront.tf`, targeting the `s3-static` origin with a 30-day TTL.

**`tbl_poster_images`** stores only the filename (e.g. `123.jpg`), not the full path. The `CLOUD_POSTER_*` constants provide the base URL. Both `tbl_poster_images` and `tbl_poster_images_live` use the same filename — no separate CDN column needed.

## PayPal Checkout (REST v2)

The site supports two PayPal payment paths. The modern path (REST v2) is the default; the legacy Express Checkout is kept as a fallback.

**Flow:** `my_invoice?mode=order` → shipping info → `choose_option_for_payment_invoice.tpl` → `my_invoice?mode=do_paypal_v2` → `paypal_checkout_v2.tpl` → JS calls `paypal_orders.php` → PayPal API.

**Key files:**

- `src/paypal_orders.php` — JSON REST endpoint. Handles two actions: `create_order` (calls PayPal `/v2/checkout/orders`) and `capture_order` (calls `/v2/checkout/orders/{id}/capture`, then mirrors `pay_now()` DB updates: serializes addresses, sets `is_paid=1`, updates `auction_payment_is_done=1`, calls `generateSellerInvoice()` + `mailInvoice()`).
- `src/templates/paypal_checkout_v2.tpl` — checkout page. Renders PayPal Smart Buttons (PayPal / Venmo / Pay Later by eligibility) and Hosted Card Fields (requires PayPal Advanced Payments enrollment on the merchant account).
- `src/templates/choose_option_for_payment_invoice.tpl` — payment method picker. Primary option links to `do_paypal_v2`; secondary links to legacy `do_express_checkout`.

**PayPal credentials** are stored in `config_table` as `paypal_client_id` / `paypal_client_secret` (columns added by migration `src/admin/admin_run_migration.php`). They are exposed as PHP constants `PAYPAL_CLIENT_ID`, `PAYPAL_CLIENT_SECRET`, and `PAYPAL_V2_BASE_URL` (sandbox vs production) via `src/lib/configures.php`.

**Critical implementation notes:**
- `paypal_orders.php` starts with `ob_start()` and every response path calls `ob_clean()` before `json_encode()`. This guards against `DBCommon::countData()`'s `or die(mysqli_error())` corrupting the JSON response body. Never use `countData()` inside a JSON API endpoint — use direct `mysqli_query()` instead.
- The invoice ownership check requires `is_paid=0`, `is_approved=1`, `is_cancelled=0` — same conditions used throughout `my_invoice.php`.
- Hosted Fields `createOrder` fires on page render (not on card submit). If it returns `undefined` (because `create_order` failed), card submission shows PayPal's generic "We weren't able to add this card" — always throw in the `createOrder` callback if `data.id` is missing.
- Hosted Fields expiry placeholder must be `MM / YY` (2-digit year) — PayPal rejects 4-digit year input.
- Session shipping info is set by `chooseOptionForPayment()` under the key `$_SESSION['invoice_{id}']['shipping_info']` before the user reaches the checkout page. `doPaypalV2Checkout()` redirects to shipping info if this key is missing.

## Invoice System

**`tbl_invoice`** — one row per invoice. Key fields: `is_paid`, `is_cancelled`, `is_approved`, `is_ordered`, `tracking_number` (nullable), `total_amount`.

**`tbl_invoice_to_auction`** — links an invoice to one or more auction items (combined invoices).

**Invoice templates:**
- Buyer print (frontend): `src/templates/my_invoice_print.tpl` — rendered in a fancybox iframe
- Buyer print (admin): `src/admin_templates/admin_manage_invoice_buyer_print.tpl`
- Seller reconciliation (admin): `src/admin_templates/admin_manage_invoice_seller_print.tpl`
- Buyer invoice list: `src/templates/my_invoice_display.tpl` (uses fancybox 2.1.5)
- Buyer archived list: `src/templates/my_invoice_display_archive.tpl` (uses fancybox 1.3.4)

**Fancybox versions:**
- `my_invoice_display.tpl` uses fancybox **2.1.5** (`$.fancybox.open()` API). CSS/JS served from CDN at `https://d294w6g1afjpvs.cloudfront.net/css/jquery.fancybox.css` and `.../js/jquery.fancybox.js`.
- `my_invoice_display_archive.tpl` uses fancybox **1.3.4** (older `$("#id").fancybox()` API). Always use pixel values for `width`/`height` — percentage values are ignored by 1.3.4.

## Homepage (`index.php` / `index_demo.tpl`)

**Big slider** — `is_set_for_home_big_slider='1'` on `tbl_auction` or `tbl_auction_live` rows. Images use `CLOUD_POSTER_THUMB_BIG_GALLERY`. The `dataArrSlider` array is built by merging results from both the fixed-price query (`tbl_auction`) and the live query (`tbl_auction_live`) using a shared counter `$k` — do NOT reset `$k` between the two loops or `big_image` will overwrite the wrong indices.

**Carousel sections** — jCarousel 1.3.4. CSS and JS must be loaded via `{$actualPathJSCSS}` (not `DOMAIN_PATH`) to avoid mixed content blocking. Resources live at `src/javascript/slider/`.

## Known Codebase Constraints

- **Raw SQL everywhere** — queries use string concatenation, not prepared statements. Be careful when modifying queries to avoid worsening injection surface.
- **MD5 password hashing** — `User::checkLogin()` uses MD5. Do not introduce new password storage without upgrading to `password_hash()`.
- **No test suite** — there are no application-level tests. Only `src/lib/cloudfiles/` has a PHPUnit config (legacy dependency).
- **`ONLY_FULL_GROUP_BY` disabled** — MySQL runs in a permissive mode to support legacy GROUP BY queries.
- **Timezone** — MySQL session timezone is forced to `America/New_York`.
- **`DBCommon::countData()` uses `or die()`** — line 108 of `src/classes/DBCommon.php` calls `mysqli_query(...) or die(mysqli_error(...))`. Any query failure immediately outputs raw MySQL error text as the HTTP response body. Never call `countData()` (or any `DBCommon` method) inside a JSON API endpoint — use direct `mysqli_query()` wrapped in `ob_start()` / `ob_clean()` instead.
- **`is_cloud` flag is misleading** — `tbl_poster_images.is_cloud` is always `'1'` on every row but historically meant nothing (images were still on local EFS). Post-migration, all images are genuinely on S3/CloudFront. Do not use this flag to branch URL logic; use `CLOUD_POSTER_*` constants directly.
