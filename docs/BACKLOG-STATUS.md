# Status Backlog COGNYSENS

*Mis a jour: 14 Janvier 2026*

## Resume

| Epic | Progres | Status |
|------|---------|--------|
| A - Environnement & socle | 70% | En cours |
| B - Design system | 60% | En cours |
| C - Architecture & templates | 75% | En cours |
| D - SEO technique | 85% | Quasi complet |
| E - Tarifs & contenus prix | 40% | A faire |
| F - Formulaires leads | 20% | A faire |
| G - RDV avec IA | 0% | A faire |
| H - RGPD / CNIL | 80% | Quasi complet |
| I - Tracking & observabilite | 0% | A faire |
| J - Mise en ligne & QA | 30% | A faire |

---

## EPIC A — Environnement & socle WordPress

### US-A1 — Environnement de dev reproductible ✅ DONE

| Critere | Status |
|---------|--------|
| docker-compose.yml fonctionnel | ✅ |
| README installation | ✅ |
| Mailhog pour test emails | ✅ |

### US-A2 — Installation WordPress et permaliens SEO ✅ DONE

| Critere | Status |
|---------|--------|
| Permaliens /%postname%/ | ✅ |
| noindex en dev | ✅ (COGNYSENS_DEV_MODE) |
| HTTPS staging/prod | ⏳ (a configurer en prod) |

### US-A3 — Theme custom leger ✅ DONE

| Critere | Status |
|---------|--------|
| Theme maison (pas Elementor) | ✅ cognysens |
| Gutenberg + blocs | ✅ |
| CSS/JS minimises | ✅ critical.css, main.css |

### US-A4 — Plugins socle ⚠️ PARTIEL

| Critere | Status | Action |
|---------|--------|--------|
| SEO: RankMath | ✅ Installe | Configurer wizard |
| Cache: WP Rocket | ❌ | Installer (premium) ou alternative |
| Securite: Wordfence | ❌ | Installer |
| Redirections | ❌ | Installer plugin |
| Sauvegardes | ❌ | Documenter solution |

---

## EPIC B — Design system "Chanel × Apple"

### US-B1 — Design tokens & typographies ✅ DONE

| Critere | Status |
|---------|--------|
| Palette noir/blanc/gris | ✅ |
| Typo serif + sans | ✅ Cormorant + Inter |
| Espacements genereux | ✅ |
| Mobile excellent | ✅ |

### US-B2 — Composants UI reutilisables ⚠️ PARTIEL

| Bloc | Status |
|------|--------|
| Hero | ✅ |
| Section | ✅ |
| CTA discret | ✅ |
| Quand nous solliciter | ⚠️ A creer |
| Livrables | ⚠️ A creer |
| Tarifs fourchettes | ✅ (page-tarifs) |
| FAQ | ✅ |
| Table comparatif | ⚠️ A creer |

---

## EPIC C — Architecture & templates

### US-C1 — Arborescence complete ✅ DONE

| Critere | Status |
|---------|--------|
| 54+ pages creees | ✅ |
| Slugs conformes | ✅ |
| Menu principal 6 items | ✅ |
| Footer pages legales | ✅ |
| Footer adresse + zones | ⚠️ A verifier |

### US-C2 — Templates types ⚠️ PARTIEL

| Template | Status |
|----------|--------|
| Prestation Money | ✅ page-expertise.php, page-amo.php |
| Pathologie | ⚠️ A creer specifiquement |
| Tarifs | ✅ page-tarifs.php |
| Article | ⚠️ single.php basique |

### US-C3 — Fil d'Ariane ⚠️ PARTIEL

| Critere | Status |
|---------|--------|
| Breadcrumbs visuels | ⚠️ A ajouter |
| Schema BreadcrumbList | ✅ seo.php |

---

## EPIC D — SEO technique & GEO SEO

### US-D1 — SEO on-page ✅ DONE

| Critere | Status |
|---------|--------|
| Champs SEO par page | ✅ RankMath |
| OpenGraph | ✅ seo.php |
| Twitter Cards | ✅ seo.php |
| Canonicals | ✅ |

### US-D2 — Schema.org complet ✅ DONE

| Schema | Status |
|--------|--------|
| Organization | ✅ |
| Service | ✅ |
| FAQPage | ✅ |
| BreadcrumbList | ✅ |
| LocalBusiness | ✅ |

### US-D3 — GEO SEO pages ✅ DONE

| Critere | Status |
|---------|--------|
| Pages GEO creees | ✅ Paris/92/94/78 |
| Maillage interne | ⚠️ A renforcer |
| NAP coherent | ✅ |

### US-D4 — Performance & Core Web Vitals ✅ DONE

| Critere | Status |
|---------|--------|
| Critical CSS | ✅ |
| Lazy load | ✅ |
| Fonts preload | ✅ |
| JS/CSS minimises | ✅ |

---

## EPIC E — Tarifs & contenus prix

### US-E1 — Bloc Tarifs reutilisable ⚠️ PARTIEL

| Critere | Status |
|---------|--------|
| Champs fourchette | ✅ page-tarifs |
| Responsive | ✅ |
| Bloc ACF reutilisable | ❌ A creer |

### US-E2 — Pages "Combien coute..." ❌ A FAIRE

| Critere | Status |
|---------|--------|
| Template dedie | ❌ |
| Sections standards | ❌ |
| CTA RDV | ❌ |

---

## EPIC F — Formulaires leads qualifies

### US-F1 — Formulaire contact qualifiant ⚠️ PARTIEL

| Critere | Status |
|---------|--------|
| Formulaire basique | ✅ page-contact.php |
| Champs qualification | ⚠️ Basiques |
| RGPD checkbox | ✅ |
| Gravity Forms | ❌ Non installe (premium) |

### US-F2 — Routage interne leads ❌ A FAIRE

| Critere | Status |
|---------|--------|
| Notifications email | ⚠️ Basique |
| Enregistrement WP | ❌ |
| Export CSV | ❌ |
| Webhook Make/n8n | ❌ |

---

## EPIC G — Prise de RDV avec IA

### US-G1 — Page booking ❌ A FAIRE

| Critere | Status |
|---------|--------|
| Amelia/SSA installe | ❌ |
| Google Calendar sync | ❌ |
| Emails confirmation | ❌ |

### US-G2 — Qualification IA ❌ A FAIRE

| Critere | Status |
|---------|--------|
| Webhook Make/n8n | ❌ |
| Appel IA | ❌ |
| Mention RGPD IA | ✅ (page-rdv.php) |

### US-G3 — Fiche lead structuree ❌ A FAIRE

| Critere | Status |
|---------|--------|
| Google Sheet/CRM | ❌ |
| Resume IA | ❌ |
| Lien calendrier | ❌ |

---

## EPIC H — RGPD / CNIL

### US-H1 — Pages legales ✅ DONE

| Critere | Status |
|---------|--------|
| Pages creees | ✅ 6 pages |
| Accessibles footer | ✅ Menu Legal |
| Adresse affichee | ✅ |

### US-H2 — Consentement cookies ✅ DONE

| Critere | Status |
|---------|--------|
| Complianz installe | ✅ |
| Refus simple | ✅ (Complianz) |
| Pas cookies avant consent | ✅ |

### US-H3 — RGPD formulaires + IA ✅ DONE

| Critere | Status |
|---------|--------|
| Checkboxes non pre-cochees | ✅ |
| Liens politique | ✅ |
| Mention IA | ✅ page-rdv.php |

---

## EPIC I — Tracking & observabilite

### US-I1 — Analytics ❌ A FAIRE

| Critere | Status |
|---------|--------|
| GA4/Matomo | ❌ |
| Search Console | ❌ |
| Events conversions | ❌ |

### US-I2 — Logs & monitoring ❌ A FAIRE

| Critere | Status |
|---------|--------|
| Sauvegardes auto | ❌ |
| Uptime monitoring | ❌ |
| Procedure rollback | ❌ |

---

## EPIC J — Mise en ligne & QA

### US-J1 — Recette fonctionnelle ⚠️ PARTIEL

| Critere | Status |
|---------|--------|
| QA Checklist | ✅ docs/QA-CHECKLIST.md |
| Health Check | ✅ 12/16 |
| Tests manuels | ⏳ |

### US-J2 — Passage production ❌ A FAIRE

| Critere | Status |
|---------|--------|
| Retrait noindex | ⏳ |
| Sitemap soumis | ❌ |
| Page 404 | ⚠️ A verifier |
| Performance mobile | ✅ |

---

## Prochaines priorites

### Haute priorite
1. **US-A4**: Installer plugins securite + cache + redirections
2. **US-C3**: Ajouter breadcrumbs visuels
3. **US-E2**: Creer template "Combien coute"
4. **US-F1**: Configurer formulaires avances (Gravity Forms ou alternative)

### Moyenne priorite
5. **US-B2**: Creer blocs manquants (Livrables, Quand solliciter)
6. **US-G1**: Installer systeme booking
7. **US-I1**: Configurer Analytics

### Basse priorite (prod)
8. **US-G2/G3**: Integration IA
9. **US-I2**: Monitoring
10. **US-J2**: Mise en production

---

## Definition of Done

- [x] Responsive mobile OK
- [x] Temps de chargement correct
- [x] Accessibilite minimale
- [x] RGPD respecte
- [x] SEO on-page conforme
- [ ] Maillage interne complet
- [ ] Tests fonctionnels complets
