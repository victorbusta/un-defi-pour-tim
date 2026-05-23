# Un Défi Pour Tim — Project Context

## What this project is

Rebuilding the website `defitim.fr` from scratch. Victor lost access to the original site (specifically `/en/a-challenge-for-tim/`). He is designing it in Claude and will hand off the design for implementation here.

The site is a fundraising/awareness platform for a solidarity challenge organized by Paris firefighters (BSPP) in support of their injured comrade, Corporal Timothé Bernardeau.

---

## Who is Tim

**Corporal Timothé Bernardeau**, born in Nantes, now 33 years old.

- **September 2012**: Joins the Paris Fire Brigade (BSPP), 11th fire & rescue company, Le Marais, 4th arrondissement. Role: pump machine operator.
- Present during the November 2015 Paris terrorist attacks. Multiple commendations from commanders.
- **April 2015**: Joins the elite BSPP gymnastics group (founded 1919) — acrobatic/artistic team promoting the BSPP. Performs in 40+ shows across France and Europe (circus venues, stadiums).
- **Before his accident**: Completed the New York City Marathon.
- **May 2018**: During a gymnastics performance for sick children, suffers a severe spinal injury → **quadriplegia (tétraplégie)**.
- After ~2.5 years at the Institution Nationale des Invalides, he now lives at home with his nurse partner and their daughter **Lyla**.
- Described as showing exceptional resilience — maintains a strong bond with his barracks and the BSPP, passes on his "force et courage" to his brothers-in-arms.

---

## The Challenge — Current Edition (2026)

**Event**: Marathon de l'Espace — Kourou, French Guiana  
**Race date**: **29 March 2026**  
**Full trip**: 25 March → 1 April 2026

Since 1991, a 42.195 km foot race has been organized annually in Kourou around the Ariane rocket launches. The route is a round-trip between "la pointe des roches" and the Ariane launch complexes (Orchidée fire station), through the Guiana Space Centre jungle roads.

The team will run it as a **relay** (5 runners + a final stretch together):
| Relay | Distance |
|-------|----------|
| 1 | 9.360 km |
| 2 | 7.640 km |
| 3 | 8.080 km |
| 4 | 7.760 km |
| 5 | 7.580 km |
| 6 (all together) | 1.775 km |

**Why Kourou specifically**: Kourou hosts a BSPP detachment (French Guiana Space Centre fire brigade). Meeting brothers-in-arms abroad adds symbolic weight.

**Why it's meaningful**: Tim ran the NYC Marathon before his accident. A relay marathon — though different — proves that everything is still possible.

### Previous challenges
1. **2021**: Tunnel to Towers 5K Run, New York — ran in full firefighter uniform for Tim
2. **2023**: Tunnel to Towers Run again, alongside American firefighter colleagues
3. **2025**: "Course en soutien au Bleuet de France" (support race for French veterans charity)

---

## The Team (26 participants + Tim)

- 12 Paris firefighters (including 6 from the gymnastics group)
- 6 former Paris firefighters
- 5 civilians (Bernardeau family)
- 3 children

---

## Trip Program

| Date | Activity |
|------|----------|
| 25 March | Flight Paris → Cayenne |
| 26 March | Visit BSPP Kourou detachment; meet fellow firefighters |
| 27 March | Space Museum visit; Guianese culture museum |
| 29 March | **Marathon de l'Espace** |
| 1 April | Flight Cayenne → Paris |

---

## Budget

| Item | Amount |
|------|--------|
| Flights (24 economy + 3 business PMR) | €25,000 |
| Accommodation (26 + 1 PMR) | €12,000 |
| Food | €4,680 |
| On-site transport (PMR vehicle + minibus) | €2,650 |
| Visits | €500 |
| Race registration + running gear | €3,350 |
| "Un défi pour Tim" team outfits (6 days) | €4,600 |
| **Total** | **€52,780** |
| Own contribution | €10,000 |
| **Funding needed** | **€42,780** |

Donations by check to **ASASPP** (postal address below).

---

## Sponsorship benefits (mécénat)

- Logo on all race advertising materials
- Brand visible at BSPP gymnastics demonstrations across France
- Social media presence (Instagram, Facebook, LinkedIn) before/during/after the event
- Sponsor banner carried during the Kourou event
- Brand associated with values: **Fraternité · Cohésion · Solidarité**

---

## Contacts

**Adjudant Chef Benjamin GUY** — Project Lead  
Tel: 06 69 65 81 45 | benjamin.guy@pompiersparis.fr  
BSPP - Caserne Masséna, 3 rue Darmesteter, 75013 Paris

**Timothé Bernardeau** — Project Coordinator  
Tel: 06 22 16 24 33 | bernardeau.t@gmail.com

---

## Visual identity (from existing materials)

- **Color palette**: Navy blue + red (BSPP institutional colors); multicolor paint splashes (symbolizing life/energy)
- **Typography**: Bold sans-serif for "Un défi pour Tim"; "Tim" rendered in red
- **Key visual**: Silhouette of a gymnast/runner overlaid with multicolor paint splashes on white background
- **Logo**: BSPP Eiffel Tower logo (pompiersparis.fr)
- **Social**: Facebook, Instagram, YouTube, Twitter/X
- **Tone**: Solidarity, brotherhood, resilience, hope — not pity

---

## Website rebuild notes

- Original URL: `defitim.fr` (French) / `defitim.fr/en/` (English) — lost access, rebuilding from scratch
- **New domain**: `un-defi-pour-tim` (TLD to confirm — .com / .fr / .org) registered on **Namecheap**
- Design is being created in Claude first, then handed off here for implementation
- Both French and English versions needed
- Key sections to rebuild:
  - Who is Tim (his story)
  - The challenge / event details
  - Previous challenges (timeline)
  - How to support / donate
  - Sponsors / mécénat
  - Contact

## CMS — WordPress

**Chosen**: **WordPress** — sister manages everything from `defitim.fr/wp-admin`. Email/password login, visual editor, media library, full page/post management. No technical knowledge needed.

- WordPress IS the CMS and the frontend (replaces Astro, Decap, Sveltia, Tina entirely)
- Custom theme built to match the design
- Custom plugin handles HelloAsso integration (PHP, no Cloudflare Worker needed)
- Multilingual: **Polylang** plugin (free) — manages FR/EN content from the same admin

## CI/CD Pipeline

### Stack

| Layer | Technology |
|-------|-----------|
| CMS + Frontend | WordPress (PHP) |
| Hosting | Hetzner Cloud CX22 (~€4.15/month), Ubuntu 24.04, Nginx + PHP-FPM + MySQL |
| Version control | GitHub (`victorbusta/un-defi-pour-tim`) |
| GitHub auth | PAT already configured via `gh` CLI as `victorbusta` |
| Deploy | GitHub Actions → SSH to OVH VPS |
| Server automation | Hetzner Cloud API via GitHub Actions |
| Payment | HelloAsso PHP plugin (custom) |
| Multilingual | Polylang (free WP plugin) |
| Domain | `un-defi-pour-tim.com` on Namecheap |
| DNS | Hetzner DNS (managed via Hetzner Cloud API) |
| SSL | Let's Encrypt via Certbot (auto-renew) |
| Billing | OVH billing contact set to peer's OVH NIC — invoices go to them, not Victor |

### Source control — GitHub

Only custom code lives in the repo — not WordPress core (downloaded on server) and not the database (managed on hosting).

```
defitim.fr/
├── themes/
│   └── defitim/              # Custom WordPress theme
│       ├── style.css
│       ├── functions.php
│       ├── index.php
│       ├── page-*.php        # Page templates
│       └── assets/
├── plugins/
│   └── defitim-helloasso/    # Custom HelloAsso plugin
│       ├── defitim-helloasso.php
│       └── includes/
│           ├── class-oauth.php
│           ├── class-checkout.php
│           └── class-webhook.php
├── .github/
│   └── workflows/
│       ├── deploy.yml        # Push to main → deploy to prod
│       └── lint.yml          # PR → PHP lint + PHPCS
└── composer.json             # PHP dependencies
```

**Branch strategy**:
- `main` → production (`defitim.fr`)
- Feature branches → PR → code review → merge to `main` → auto-deploy
- Sister edits content via WordPress admin — no git involved for content changes

### DNS — Namecheap → OVH

**Registrar**: Namecheap (un-defi-pour-tim.com)  
**DNS provider**: OVH (fully manageable via OVH API — no manual steps needed after initial nameserver change)

**One-time Namecheap step (Victor)**:  
Domain List → un-defi-pour-tim.com → Nameservers → Custom DNS:
- `dns1.ovh.net`
- `ns1.ovh.net`

After that, all DNS records (A, AAAA, MX, TXT) are managed via OVH API in GitHub Actions. No Namecheap dashboard access needed again.

**SSL**: Let's Encrypt via Certbot — provisioned automatically by the server setup script, auto-renews every 90 days via cron.

### Hosting — Hetzner Cloud

- **Plan**: CX22 (~€4.15/month) — 2 vCPU, 4GB RAM, 40GB SSD, Ubuntu 24.04, Frankfurt datacenter
- **Stack on VPS**: Nginx + PHP 8.2-FPM + MySQL 8.0 + Certbot — provisioned via cloud-init on first boot
- **Deploy**: GitHub Actions SSHs into server, rsyncs theme + plugin, reloads PHP-FPM
- **WordPress core**: installed via WP-CLI on first run, auto-updates enabled for security patches
- **Database**: MySQL on the server, daily backup via GitHub Actions artifact
- **Billing**: Hetzner account under the peer's email — Victor has no billing access; peer pays independently

### GitHub Actions workflows

**`.github/workflows/deploy.yml`** — push to `main` → deploy theme + plugin via SSH rsync to OVH VPS:
```yaml
on:
  push:
    branches: [main]
jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Deploy theme + plugin via rsync
        run: |
          rsync -avz --delete \
            themes/defitim/ \
            ${{ secrets.VPS_USER }}@${{ secrets.VPS_HOST }}:/var/www/html/wp-content/themes/defitim/
          rsync -avz --delete \
            plugins/defitim-helloasso/ \
            ${{ secrets.VPS_USER }}@${{ secrets.VPS_HOST }}:/var/www/html/wp-content/plugins/defitim-helloasso/
      - name: Reload PHP-FPM
        run: ssh ${{ secrets.VPS_USER }}@${{ secrets.VPS_HOST }} "sudo systemctl reload php8.2-fpm"
```

**`.github/workflows/provision.yml`** — runs once on first deploy: installs Nginx, PHP, MySQL, WP-CLI, WordPress, Certbot via SSH.

**`.github/workflows/lint.yml`** — runs on PRs: PHP syntax check + WordPress coding standards (PHPCS).

### Secrets inventory

Stored in **GitHub repository secrets**:

| Secret | Where used | Value source |
|--------|-----------|--------------|
| `VPS_HOST` | GitHub Actions deploy | Hetzner Cloud console (server IP) |
| `VPS_USER` | GitHub Actions deploy | `root` or dedicated deploy user |
| `SSH_PRIVATE_KEY` | GitHub Actions deploy | Generated locally, public key added to Hetzner server |
| `HETZNER_API_TOKEN` | GitHub Actions (Hetzner API) | Hetzner Cloud console → API tokens |

**HelloAsso credentials stored in WordPress options** (wp_options table), configurable from a settings page in wp-admin — never in wp-config.php or code files. The sister must be able to update API keys without touching the server.

Plugin settings page at **wp-admin → Settings → HelloAsso**:
- Client ID
- Client Secret
- Organization slug
- Webhook secret
- Return URL / Error URL / Back URL
- Test mode toggle (sandbox vs production)

### Full deploy flow

```
Sister edits content in WordPress admin
  → Saves page/image/text
  → Live immediately on un-defi-pour-tim.[tld] (no deploy needed)

Developer pushes theme/plugin change
  → PR opened → GitHub Actions: PHP lint
  → PR merged to main
  → GitHub Actions: rsync to Infomaniak via SSH (~10s)
  → defitim.fr reflects new code ✓

Donor clicks "Payer avec HelloAsso"
  → WordPress page → PHP plugin creates checkout intent
  → Plugin calls HelloAsso API (OAuth2 + POST /checkout-intents)
  → Donor redirected to HelloAsso payment page
  → Donor pays → redirected back to un-defi-pour-tim.[tld]/merci
  → HelloAsso sends webhook → WP plugin endpoint verifies + stores
```

### Ownership model

**Victor** = technician on call only. Sets up infrastructure once (GitHub repo, Infomaniak, SSH deploy pipeline), then steps back completely.

**Sister + Tim's team** = own everything day-to-day with no technical help needed:
- All WordPress content (pages, images, news, sponsors, dates, budget)
- HelloAsso API configuration via wp-admin settings page
- WordPress user accounts
- Donation page text and amounts

**Hard rule for the build**: after the initial deploy, zero server access should ever be needed for routine operations. Every configuration must be reachable from wp-admin.

### What Victor needs to provide once

| # | What | How |
|---|------|-----|
| 1 | **Hetzner Cloud server** | Peer creates Hetzner account, orders CX22 Ubuntu 24.04 (Frankfurt), shares server IP + root password |
| 2 | **Hetzner API token** | Hetzner console → Project → Security → API tokens → create → share token |
| 3 | **Namecheap DNS** | Point `un-defi-pour-tim.com` A record to the Hetzner server IP |
| 4 | **HelloAsso org slug** | The identifier in their HelloAsso URL — API keys entered by sister post-handoff via wp-admin |

GitHub: already authenticated as `victorbusta` via `gh` CLI. Repo `victorbusta/un-defi-pour-tim` is empty and ready.

### Running cost summary

| Item | Cost |
|------|------|
| GitHub repo | Free |
| Hetzner Cloud CX22 (Ubuntu + Nginx + PHP + MySQL) | ~€4.15/month |
| WordPress core | Free |
| Polylang (FR/EN plugin) | Free |
| HelloAsso payment processing | Free (association model) |
| Domain `un-defi-pour-tim.[tld]` on Namecheap | ~€12-15/year |
| **Total** | **~€54/year (~€4.50/month)** — paid by peer via OVH billing contact |

## Payment processing — HelloAsso

**Platform**: [HelloAsso](https://www.helloasso.com) — French association-focused payment platform.  
**Cost to the association**: Free. HelloAsso uses a "modèle solidaire" — donors can optionally tip HelloAsso on top of their donation; 100% of the donation amount goes to the association.  
**API docs**: https://dev.helloasso.com/docs/  
**Sandbox**: https://api.helloasso-sandbox.com/v5

### How it works

HelloAsso Checkout is **redirect-based** (no iframe for the payment step itself). Flow:
1. Site calls HelloAsso API to create a **checkout intent** (POST to `/v5/organizations/{slug}/checkout-intents`)
2. API returns a redirect URL (valid 15 minutes)
3. Donor is sent to HelloAsso's hosted payment page
4. After payment, donor is redirected back to `returnUrl` / `errorUrl` / `backUrl`
5. **Webhook** confirms payment server-side (do not trust redirect params alone — they can be falsified)

### Authentication
OAuth2. Requires a client ID + secret from HelloAsso back-office. Token exchange must happen **server-side** — cannot be done in the browser (secrets must not be exposed).

### Key API parameters for a donation intent
```json
{
  "totalAmount": 5000,       // in cents (€50.00)
  "initialAmount": 5000,
  "itemName": "Don - Un défi pour Tim",
  "backUrl": "https://defitim.fr/don",
  "errorUrl": "https://defitim.fr/don?erreur=1",
  "returnUrl": "https://defitim.fr/don?merci=1",
  "containsDonation": true
}
```

### Architecture implication — backend required

The OAuth2 token exchange and checkout intent creation **cannot run in a purely static site**. We need a small server-side component:

- **Chosen solution**: **Cloudflare Worker** (free tier: 100k requests/day)
- The Worker handles: token exchange, checkout intent creation, webhook verification
- The static site (Astro on Cloudflare Pages) calls the Worker endpoint
- Zero additional cost

### "Payer avec HelloAsso" button
HelloAsso provides a branded button (purple, #4c40cf) with Visa/Mastercard/CB logos and "Paiement sécurisé" badge. Use this on the donation page — it builds trust with French donors who recognize the HelloAsso brand.

### Important caveats
- API checkout does **not** auto-generate fiscal receipts (reçus fiscaux) — relevant if donors want tax deductions. If needed, configure receipts in HelloAsso back-office separately.
- From June 2025: new associations must pass a compliance check (`isCashInCompliant`) before receiving payments. Verify the ASASPP account is compliant.
- Checkout UI is available in French (default), English, and Spanish (auto-detected from browser — good for the bilingual site).

### Suggested donation page flow
1. Donor fills optional fields (name, amount, message) on the defitim.fr donation page
2. Clicks "Payer avec HelloAsso"
3. Site calls Cloudflare Worker → Worker calls HelloAsso API → gets redirect URL
4. Donor is redirected to HelloAsso payment page
5. After payment → back to `defitim.fr/don?merci=1` with a thank-you message
6. Webhook (Worker endpoint) updates any internal state if needed
