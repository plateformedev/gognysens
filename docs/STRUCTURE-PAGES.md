# Structure des Pages COGNISENS

## Vue d'ensemble

Le site COGNISENS compte 53+ pages organisees en 8 sections principales.

## Arborescence

### 1. CABINET (10 pages)

```
/le-cabinet/
├── /equipe/
├── /methodologie/
├── /independance-deontologie/
├── /cadre-juridique/
└── /zone-intervention/
    ├── /expert-bati-ancien-paris/
    ├── /expert-bati-ancien-hauts-de-seine/
    ├── /expert-bati-ancien-val-de-marne/
    └── /expert-bati-ancien-yvelines/
```

### 2. EXPERTISES (6 pages)

```
/expertise-amiable-bati-ancien/
/assistance-expertise-judiciaire-bati-patrimonial/
/dtg-bati-ancien-copropriete/
/expertise-fissuration-facade-bati-ancien/
/expertise-ravalement-parisien/
/expertise-pathologies-bois-bati-ancien/
```

### 3. AMO (6 pages)

```
/amo-bati-ancien-patrimonial/
/amo-copropriete-eviter-surpayer-travaux/
/amo-fonciere-patrimoniale/
/amo-particulier-bati-ancien/
/amo-indivision-sci-bati-ancien/
/amo-apres-expertise/
```

### 4. DOMAINES TECHNIQUES (8 pages)

```
/expertise-pierre-pierre-de-taille/
/expertise-sculpture-pierre/
/expertise-pan-de-bois-colombage/
/expertise-charpente-traditionnelle/
/expertise-couverture-zinc-ardoise/
/expertise-zinguerie-patrimoniale/
/expertise-stucs-parisiens/
/expertise-modenatures/
```

### 5. PATHOLOGIES (7 pages)

```
/fissures-facade-immeuble-ancien/
/infiltrations-toiture-zinc-ardoise/
/bois-champignons-insectes-humidite/
/pierre-qui-se-delite/
/decollement-enduit-facade/
/desordres-apres-ravalement/
/deformations-structurelles-bati-ancien/
```

### 6. TARIFS (7 pages)

```
/honoraires-tarifs-expertise-amo/
├── /combien-coute-expertise-fissure-facade/
├── /combien-coute-dtg-bati-ancien/
├── /combien-coute-assistance-expertise-judiciaire/
├── /combien-coute-amo-copropriete/
├── /combien-coutent-travaux-ravalement-parisien/
└── /combien-coutent-travaux-charpente-ancienne/
```

### 7. CONTACT (2 pages)

```
/contact/
/prendre-rendez-vous/
```

### 8. PAGES LEGALES (6 pages)

```
/mentions-legales/
/politique-de-confidentialite/
/politique-cookies/
/conditions-generales-utilisation/
/conditions-generales-prestations/
/donnees-personnelles-et-ia/
```

## Templates

| Template | Usage |
|----------|-------|
| `front-page.php` | Page d'accueil |
| `page.php` | Pages standard |
| `templates/page-tarifs.php` | Pages tarifs |
| `templates/page-contact.php` | Pages contact/RDV |
| `templates/page-legal.php` | Pages legales |

## SEO par section

### Pages GEO

Les 4 pages geographiques ont un Schema.org `LocalBusiness` specifique avec :
- Zone desservie
- Adresse
- Services proposes

### Pages Services

Les pages d'expertise et AMO ont un Schema.org `Service` avec :
- Nom du service
- Description
- Zone d'intervention
- Fournisseur (Cognisens)

### Pages Tarifs

Les pages tarifs incluent :
- Tableau de prix structure
- FAQ avec Schema.org `FAQPage`
- CTA vers prise de rendez-vous

## Maillage interne

### Liens recommandes

1. **Pages expertise** → Pages pathologies correspondantes
2. **Pages pathologies** → Page tarifs expertise
3. **Pages tarifs** → Page contact/RDV
4. **Pages GEO** → Pages services disponibles
5. **Footer** → Toutes les pages principales

### Exemple de maillage pour une page fissures

```
/fissures-facade-immeuble-ancien/
├── Lien vers /expertise-fissuration-facade-bati-ancien/
├── Lien vers /combien-coute-expertise-fissure-facade/
├── Lien vers /expert-bati-ancien-paris/ (et autres zones)
└── CTA vers /prendre-rendez-vous/
```

## Contenu type par page

### Page Service (Expertise/AMO)

1. Introduction (2-3 paragraphes)
2. Pourquoi faire appel a un expert
3. Deroulement de la prestation
4. Livrables
5. Tarifs indicatifs
6. FAQ (3-5 questions)
7. CTA rendez-vous

### Page Pathologie

1. Description du probleme
2. Causes possibles
3. Consequences si non traite
4. Solutions
5. Notre approche
6. Lien vers expertise correspondante
7. CTA rendez-vous

### Page Tarif

1. Explication de la tarification
2. Tableau des prix
3. Ce qui est inclus
4. Ce qui est en option
5. FAQ sur les prix
6. CTA devis personnalise
