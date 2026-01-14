# Guide du Theme COGNYSENS

## Vue d'ensemble

Theme WordPress custom concu pour un cabinet d'expertise en bati ancien.

**Design**: CHANEL x APPLE (luxe minimaliste)
**Objectif**: Performance, SEO, RGPD

---

## Architecture des fichiers

```
themes/cognysens/
├── style.css               # Metadata theme
├── functions.php           # Setup et includes
├── theme.json              # Config Gutenberg
├── header.php              # En-tete site
├── footer.php              # Pied de page
├── front-page.php          # Page d'accueil
├── page.php                # Template par defaut
├── single.php              # Articles
├── 404.php                 # Page erreur
│
├── templates/              # Templates de pages
│   ├── page-cabinet.php
│   ├── page-expertise.php
│   ├── page-amo.php
│   ├── page-tarifs.php
│   ├── page-contact.php
│   ├── page-rdv.php
│   └── page-legal.php
│
├── inc/                    # Fonctionnalites PHP
│   ├── template-functions.php
│   ├── blocks.php
│   ├── acf-fields.php
│   ├── seo.php             # SEO & Schema.org
│   ├── performance.php     # Core Web Vitals
│   ├── health-check.php    # Validation theme
│   ├── debug.php           # Logging (dev)
│   ├── dev-mode.php        # Mode noindex
│   ├── recommended-plugins.php
│   ├── rgpd-forms.php
│   ├── cookie-banner.php
│   └── sitemap-config.php
│
├── blocks/                 # Blocs ACF custom
│   ├── faq/
│   ├── tarif/
│   └── cta/
│
└── assets/
    ├── css/
    │   ├── main.css        # Styles principaux
    │   ├── critical.css    # CSS inline
    │   ├── blocks.css      # Styles blocs
    │   └── gutenberg.css   # Styles editeur
    └── js/
        └── main.js         # Scripts front
```

---

## Design System

### Couleurs

```css
--color-black: #000000;      /* Texte principal */
--color-white: #FFFFFF;      /* Fond principal */
--color-stone: #F5F5F0;      /* Fond sections alternees */
--color-gray-dark: #333333;  /* Texte secondaire */
--color-gray-light: #E5E5E5; /* Bordures, separateurs */
--color-accent: #8B7355;     /* Accent pierre (usage minimal) */
```

### Typographies

```css
--font-heading: 'Cormorant Garamond', Georgia, serif;
--font-body: 'Inter', -apple-system, sans-serif;
```

### Espacements

```css
--spacing-section: 80px;  /* Entre sections */
--max-width: 1200px;      /* Largeur max conteneur */
```

---

## Templates

### front-page.php (Accueil)

Sections:
1. Hero - Titre accrocheur + CTA
2. Trust Indicators - Chiffres cles
3. Services - Expertise & AMO
4. Pathologies - Points de douleur
5. Domaines - Types de batiments
6. Zones - Couverture geographique
7. Tarifs Preview - Incitation
8. CTA Final - Prise de RDV

### page-tarifs.php

- Cards tarifs avec badge "populaire"
- Schema.org Service + FAQPage
- Grille modalites
- FAQ accordeon

### page-rdv.php

- Formulaire 4 sections (projet, bien, coordonnees, disponibilites)
- Notice IA pour RGPD
- Integration Amelia/SSA possible
- Validation cote client

### page-contact.php

- Formulaire simple (nom, email, sujet, message)
- Coordonnees cabinet
- Carte ou plan optionnel

---

## Fonctionnalites SEO

### inc/seo.php

**Active si aucun plugin SEO detecte** (RankMath, Yoast, AIOSEO)

- Meta descriptions automatiques
- Open Graph tags
- Twitter Cards
- Schema.org:
  - WebSite (searchbox)
  - BreadcrumbList
  - Organization
  - LocalBusiness (pages GEO)
  - Service (pages services)

### Utilisation

```php
// Verifier si un plugin SEO est actif
if (cognysens_has_seo_plugin()) {
    // Plugin gere le SEO
}
```

---

## Fonctionnalites Performance

### inc/performance.php

- **Lazy loading**: images et iframes
- **FetchPriority**: hero images prioritaires
- **Preload**: CSS, fonts critiques
- **Defer**: scripts non-critiques
- **Cache headers**: optimises
- **Heartbeat**: desactive front-end
- **jQuery Migrate**: supprime si inutile

### assets/css/critical.css

CSS inline dans `<head>` pour le first paint:
- Variables CSS essentielles
- Header, navigation
- Hero section
- Boutons CTA

---

## Health Check

### inc/health-check.php

**Page admin**: Apparence > Health Check

Verifications:
- Version PHP (>= 8.0)
- Version WordPress (>= 6.0)
- Fichiers requis
- Menus assignes
- SSL/HTTPS
- Permalinks
- Debug mode
- Memory limit
- Plugins SEO/Cache/RGPD

### API REST

```
GET /wp-json/cognysens/v1/health
```

Reponse:
```json
{
  "status": "healthy",
  "checks": {...},
  "timestamp": "2026-01-14T12:00:00+01:00"
}
```

---

## Debug & Logging

### inc/debug.php

**Active uniquement si WP_DEBUG = true**

Fonctions:
```php
// Logger un message
cognysens_log($message, 'info|warning|error');

// Logger une soumission formulaire
cognysens_log_form_submission($data, 'contact');

// Debug dump
cognysens_dump($variable, $die = false);
```

Fonctionnalites auto:
- Infos debug dans footer (HTML comment)
- Log des erreurs 404
- Log des slow queries
- Indicateur dev mode dans admin bar

---

## Mode Developpement

### inc/dev-mode.php

Active via admin ou `wp-config.php`:

```php
define('COGNYSENS_DEV_MODE', true);
```

Effets:
- `noindex, nofollow` sur toutes les pages
- Notice dans l'admin
- Bandeau visuel optionnel

---

## RGPD

### inc/rgpd-forms.php

Helper pour formulaires:
```php
cognysens_rgpd_checkbox('contact');
// Genere la checkbox obligatoire avec lien
```

### inc/cookie-banner.php

Configuration pour Complianz ou fallback simple.

---

## Blocs Gutenberg Custom

### FAQ Block

```html
<!-- wp:cognysens/faq -->
<div class="faq-item">
  <h3 class="faq-question">Question ?</h3>
  <div class="faq-answer">Reponse...</div>
</div>
<!-- /wp:cognysens/faq -->
```

### Tarif Block

```html
<!-- wp:cognysens/tarif -->
<div class="tarif-card" data-featured="true">
  <h3>Titre</h3>
  <div class="tarif-price">A partir de X EUR</div>
  <ul>...</ul>
</div>
<!-- /wp:cognysens/tarif -->
```

---

## Personnalisation

### Modifier les couleurs

Editer `assets/css/main.css`:
```css
:root {
    --color-accent: #nouveau-code;
}
```

### Ajouter un template

1. Creer `templates/page-nouveau.php`
2. Ajouter l'en-tete:
```php
<?php
/**
 * Template Name: Nouveau Template
 */
```
3. Coder le template

### Ajouter un bloc ACF

1. Creer dossier `blocks/nouveau/`
2. Ajouter `block.json` et `render.php`
3. Enregistrer dans `inc/blocks.php`

---

## Tests

### Lighthouse

```bash
npx lighthouse https://cognysens.fr --output=html
```

### Validation Schema.org

https://validator.schema.org/

### Syntaxe PHP

```bash
find wordpress/wp-content/themes/cognysens -name "*.php" -exec php -l {} \;
```

---

## Support

Issues: https://github.com/plateformedev/gognysens/issues
