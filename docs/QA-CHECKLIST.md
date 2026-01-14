# QA Checklist - COGNYSENS

## Pre-Launch Checklist

### 1. Configuration WordPress

- [ ] WordPress version à jour
- [ ] PHP version >= 8.0
- [ ] MySQL version >= 5.7
- [ ] Permalinks configurés (/nom-article/)
- [ ] Timezone: Europe/Paris
- [ ] Langue: Français
- [ ] Titre du site: Cognysens
- [ ] Tagline: Expert bâti ancien et AMO

### 2. Thème COGNYSENS

- [ ] Thème activé sans erreur PHP
- [ ] Logo personnalisé uploadé
- [ ] Favicon configuré
- [ ] Menus assignés (primary, footer, legal)
- [ ] Widgets configurés (si utilisés)

### 3. Pages Essentielles

#### Pages principales
- [ ] Accueil (front-page.php)
- [ ] Le Cabinet
- [ ] Contact
- [ ] Prendre rendez-vous

#### Pages Expertise
- [ ] Expertise Amiable Bâti Ancien
- [ ] Assistance Expertise Judiciaire
- [ ] DTG Bâti Ancien Copropriété

#### Pages AMO
- [ ] AMO Bâti Ancien Patrimonial
- [ ] AMO Copropriété
- [ ] AMO Foncière Patrimoniale

#### Pages Tarifs
- [ ] Honoraires et Tarifs

#### Pages GEO SEO
- [ ] Expert Bâti Ancien Paris
- [ ] Expert Bâti Ancien Hauts-de-Seine
- [ ] Expert Bâti Ancien Val-de-Marne
- [ ] Expert Bâti Ancien Yvelines

#### Pages Légales RGPD
- [ ] Mentions Légales
- [ ] Politique de Confidentialité
- [ ] Politique Cookies
- [ ] CGU
- [ ] CGP
- [ ] Données Personnelles et IA

### 4. Formulaires

- [ ] Formulaire contact fonctionne
- [ ] Formulaire RDV fonctionne
- [ ] Emails de notification reçus
- [ ] Cases RGPD obligatoires
- [ ] Messages de confirmation affichés

### 5. SEO

#### Meta Tags
- [ ] Title unique par page
- [ ] Meta description sur chaque page
- [ ] Canonical URLs correctes
- [ ] Open Graph tags présents
- [ ] Twitter Cards configurés

#### Schema.org
- [ ] Organization (homepage)
- [ ] LocalBusiness (pages GEO)
- [ ] Service (pages expertise/AMO)
- [ ] FAQPage (pages avec FAQ)
- [ ] BreadcrumbList (toutes pages)

#### Technique
- [ ] Sitemap XML généré
- [ ] robots.txt configuré
- [ ] Pas de pages en noindex (sauf dev)
- [ ] Liens internes fonctionnels
- [ ] Pas de liens cassés (404)

### 6. Performance

#### Core Web Vitals
- [ ] LCP < 2.5s
- [ ] FID < 100ms
- [ ] CLS < 0.1

#### Optimisations
- [ ] GZIP activé
- [ ] Cache navigateur configuré
- [ ] Images optimisées (WebP)
- [ ] Lazy loading actif
- [ ] CSS critique inline
- [ ] Scripts defer/async

#### Tests
- [ ] Google PageSpeed Insights > 90
- [ ] GTmetrix Grade A
- [ ] Mobile-friendly test OK

### 7. Sécurité

- [ ] SSL/HTTPS actif
- [ ] Headers sécurité configurés
- [ ] wp-config.php sécurisé
- [ ] Utilisateur admin renommé
- [ ] Mot de passe fort
- [ ] Clés SALT uniques
- [ ] Debug mode désactivé
- [ ] xmlrpc.php bloqué

### 8. RGPD

- [ ] Bandeau cookies Complianz
- [ ] Refus aussi facile qu'acceptation
- [ ] Politique confidentialité complète
- [ ] Mention IA sur formulaire RDV
- [ ] Durée conservation données définie
- [ ] Contact DPO mentionné

### 9. Responsive Design

- [ ] Desktop (1920px)
- [ ] Laptop (1366px)
- [ ] Tablet (768px)
- [ ] Mobile (375px)
- [ ] Menu mobile fonctionnel
- [ ] Images responsive
- [ ] Texte lisible sans zoom

### 10. Cross-Browser

- [ ] Chrome (dernière version)
- [ ] Firefox (dernière version)
- [ ] Safari (dernière version)
- [ ] Edge (dernière version)
- [ ] Safari iOS
- [ ] Chrome Android

### 11. Accessibilité

- [ ] Skip link présent
- [ ] Alt text sur images
- [ ] Contraste suffisant (WCAG AA)
- [ ] Navigation clavier possible
- [ ] Focus visible
- [ ] Labels sur formulaires
- [ ] ARIA labels si nécessaire

### 12. Plugins Requis

- [ ] RankMath SEO (configuré)
- [ ] Complianz RGPD (configuré)
- [ ] WP Rocket ou équivalent
- [ ] Gravity Forms (si formulaires avancés)
- [ ] Amelia/SSA (si booking)
- [ ] ACF Pro (si blocs custom)

---

## Tests Fonctionnels

### Navigation
```
[ ] Logo cliquable -> Accueil
[ ] Menu principal -> 6 entrées max
[ ] Sous-menus fonctionnels
[ ] Menu mobile toggle
[ ] Footer liens légaux
[ ] Breadcrumb correct
```

### Formulaire Contact
```
[ ] Champs obligatoires validés
[ ] Email format vérifié
[ ] Case RGPD obligatoire
[ ] Message succès affiché
[ ] Email reçu (admin)
[ ] Pas de spam
```

### Formulaire RDV
```
[ ] 4 sections complètes
[ ] Validation côté client
[ ] Notice IA visible
[ ] Envoi fonctionne
[ ] Redirection confirmation
```

### Pages Tarifs
```
[ ] Cards tarifs affichées
[ ] Prix corrects
[ ] FAQ accordéon fonctionne
[ ] CTA boutons cliquables
```

---

## Commandes de Test

### Vérifier syntaxe PHP
```bash
find wordpress/wp-content/themes/cognysens -name "*.php" -exec php -l {} \;
```

### Vérifier CSS
```bash
npx stylelint "wordpress/wp-content/themes/cognysens/**/*.css"
```

### Vérifier liens cassés
```bash
npx broken-link-checker https://cognysens.fr
```

### Test Lighthouse CLI
```bash
npx lighthouse https://cognysens.fr --output=json --output-path=./lighthouse-report.json
```

---

## Checklist Post-Launch

- [ ] Google Search Console configuré
- [ ] Google Analytics/Matomo configuré
- [ ] Sitemap soumis à Google
- [ ] Monitoring uptime actif
- [ ] Backups automatiques
- [ ] Plan de maintenance défini

---

## Contacts

- **Développeur**: [À compléter]
- **Client**: Cognysens
- **Hébergeur**: [À compléter]

---

*Dernière mise à jour: Janvier 2026*
