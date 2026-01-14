# COGNYSENS - Site WordPress

Cabinet independant d'expertise et d'assistance a maitrise d'ouvrage (AMO) specialise dans le bati ancien et patrimonial en region parisienne.

## Sommaire

- [Demarrage rapide](#demarrage-rapide)
- [Fonctionnalites](#fonctionnalites)
- [Structure du projet](#structure-du-projet)
- [Theme Cognysens](#theme-cognysens)
- [Plugins requis](#plugins-requis)
- [Documentation](#documentation)
- [Deploiement](#deploiement)

---

## Demarrage rapide

### Prerequis

- Docker Desktop
- Git

### Installation

```bash
# Cloner le repository
git clone https://github.com/plateformedev/gognysens.git
cd gognysens

# Copier le fichier d'environnement
cp .env.example .env

# Demarrer les conteneurs
docker-compose up -d
```

### Acces

| Service | URL |
|---------|-----|
| WordPress | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| Mailhog | http://localhost:8025 |

### Premiere installation

1. Acceder a http://localhost:8080
2. Suivre l'assistant WordPress
3. Activer le theme "Cognysens"
4. Aller dans Apparence > Health Check pour valider

---

## Fonctionnalites

### Design

- **Style**: CHANEL x APPLE (luxe minimaliste noir/blanc)
- **Typographie**: Cormorant Garamond (titres) + Inter (corps)
- **Responsive**: Desktop, tablet, mobile

### SEO

- Meta descriptions automatiques
- Schema.org (Organization, LocalBusiness, Service, FAQPage)
- Open Graph / Twitter Cards
- Sitemap XML configure
- Robots.txt optimise

### Performance

- Critical CSS inline
- Lazy loading images/iframes
- Preload ressources critiques
- Scripts defer
- Cache headers optimises
- Core Web Vitals: LCP < 2.5s, CLS < 0.1

### RGPD

- Bandeau cookies configurable
- Checkboxes consentement formulaires
- Notice IA pour booking intelligent
- Pages legales completes

### Outils developpeur

- Health Check (page admin)
- API REST monitoring `/cognysens/v1/health`
- Debug logging (mode dev)
- Mode noindex pour preprod

---

## Structure du projet

```
gognysens/
├── docker-compose.yml          # Configuration Docker
├── .env.example                # Variables d'environnement
├── README.md
│
├── wordpress/
│   ├── wp-content/
│   │   ├── themes/cognysens/   # Theme custom
│   │   ├── plugins/            # Plugins
│   │   └── mu-plugins/         # Must-use plugins
│   ├── robots.txt
│   └── .htaccess.example       # Config Apache
│
├── config/                     # Configs serveur
│   ├── nginx.conf
│   └── php.ini
│
├── scripts/                    # Scripts utilitaires
│   ├── setup.sh
│   ├── import-content.php
│   └── seed-pages.json
│
└── docs/                       # Documentation
    ├── INSTALLATION.md
    ├── THEME-GUIDE.md
    ├── SEO-CHECKLIST.md
    ├── QA-CHECKLIST.md
    └── STRUCTURE-PAGES.md
```

---

## Theme Cognysens

### Templates disponibles

| Template | Usage |
|----------|-------|
| front-page.php | Page d'accueil |
| page-cabinet.php | Presentation cabinet |
| page-expertise.php | Services expertise |
| page-amo.php | Services AMO |
| page-tarifs.php | Grille tarifaire |
| page-contact.php | Formulaire contact |
| page-rdv.php | Prise de rendez-vous |
| page-legal.php | Pages legales |

### Fichiers inc/

| Fichier | Description |
|---------|-------------|
| seo.php | SEO & Schema.org |
| performance.php | Optimisations Core Web Vitals |
| health-check.php | Validation et monitoring |
| debug.php | Logging developpement |
| dev-mode.php | Mode noindex |
| rgpd-forms.php | Helpers formulaires RGPD |
| cookie-banner.php | Bandeau cookies |
| sitemap-config.php | Priorites sitemap |

---

## Plugins requis

### Gratuits (via WordPress)

| Plugin | Usage |
|--------|-------|
| RankMath SEO | SEO avance |
| Complianz | RGPD/Cookies |

### Premium (optionnels)

| Plugin | Usage |
|--------|-------|
| Gravity Forms | Formulaires avances |
| Amelia / SSA | Booking en ligne |
| ACF Pro | Blocs custom |
| WP Rocket | Cache & performance |

---

## Pages

Le site contient **60+ pages** organisees en sections :

| Section | Nombre | Description |
|---------|--------|-------------|
| Cabinet | 6 + 4 GEO | Presentation, equipe |
| Expertises | 6 | Services expertise |
| AMO | 6 | Assistance maitrise d'ouvrage |
| Domaines | 8 | Types de batiments |
| Pathologies | 7 | Problemes courants |
| Tarifs | 7 | Grilles tarifaires |
| Contact | 2 | Contact et RDV |
| Legal | 6 | RGPD, CGU, etc. |

### Import du contenu

```bash
docker exec -it cognysens-wp php /var/www/html/wp-content/scripts/import-content.php
```

---

## Documentation

| Document | Description |
|----------|-------------|
| [INSTALLATION.md](docs/INSTALLATION.md) | Guide installation complet |
| [THEME-GUIDE.md](docs/THEME-GUIDE.md) | Documentation technique theme |
| [SEO-CHECKLIST.md](docs/SEO-CHECKLIST.md) | Checklist SEO |
| [QA-CHECKLIST.md](docs/QA-CHECKLIST.md) | Checklist pre-lancement |
| [STRUCTURE-PAGES.md](docs/STRUCTURE-PAGES.md) | Structure des pages |

---

## Deploiement

### 1. Export base de donnees

```bash
docker exec cognysens-db mysqldump -u root -p cognysens_db > backup.sql
```

### 2. Modification URLs

```bash
wp search-replace 'http://localhost:8080' 'https://cognysens.fr' --all-tables
```

### 3. Configuration serveur

- PHP >= 8.0
- MySQL >= 8.0
- SSL obligatoire
- Copier `.htaccess.example` vers `.htaccess`

### 4. Post-deploiement

- [ ] Desactiver mode dev (`cognysens_dev_mode`)
- [ ] Verifier Health Check
- [ ] Tester formulaires
- [ ] Valider Schema.org
- [ ] Soumettre sitemap a Google

---

## Commandes utiles

```bash
# Demarrer/arreter
docker-compose up -d
docker-compose down

# Logs
docker-compose logs -f wordpress

# WP-CLI
docker exec -it cognysens-wp wp --info

# Syntaxe PHP
find wordpress/wp-content/themes/cognysens -name "*.php" -exec php -l {} \;

# Lighthouse
npx lighthouse https://cognysens.fr --output=html
```

---

## License

Code open source - MIT License

---

## Contact

**COGNYSENS**
109 chemin de Ronde
78290 Croissy-sur-Seine
