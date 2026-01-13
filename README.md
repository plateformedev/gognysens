# COGNISENS - Site WordPress

Cabinet d'expertise et d'assistance a maitrise d'ouvrage (AMO) specialise dans le bati ancien et patrimonial.

## Demarrage rapide

### Prerequis

- Docker Desktop installe
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

- **WordPress** : http://localhost:8080
- **phpMyAdmin** : http://localhost:8081
- **Mailhog** : http://localhost:8025

### Premiere installation WordPress

1. Acceder a http://localhost:8080
2. Suivre l'assistant d'installation WordPress
3. Activer le theme "Cognisens"
4. Installer les plugins requis

## Structure du projet

```
gognysens/
├── docker-compose.yml      # Configuration Docker
├── wordpress/wp-content/
│   ├── themes/cognisens/   # Theme custom
│   ├── plugins/            # Plugins
│   └── mu-plugins/         # Must-use plugins
├── config/                 # Configs serveur
├── scripts/                # Scripts utilitaires
└── docs/                   # Documentation
```

## Theme Cognisens

Theme WordPress custom avec :

- Design CHANEL x APPLE (luxe sobre)
- Full Site Editing (Gutenberg)
- SEO optimise (Schema.org)
- RGPD conforme
- Performance optimisee

## Plugins requis

| Plugin | Usage | Type |
|--------|-------|------|
| RankMath SEO | SEO | Gratuit |
| Complianz | RGPD/Cookies | Gratuit/Premium |
| Gravity Forms | Formulaires | Premium |
| Amelia | Booking | Premium |
| ACF Pro | Champs custom | Premium |

## Pages

Le site contient 60+ pages organisees en sections :

- Cabinet (6 pages + 4 GEO)
- Expertises (6 pages)
- AMO (6 pages)
- Domaines techniques (8 pages)
- Pathologies (7 pages)
- Tarifs (7 pages)
- Contact (2 pages)
- Pages legales (6 pages)

## Import du contenu

```bash
# Depuis le conteneur WordPress
docker exec -it cognisens-wp php /var/www/html/wp-content/scripts/import-content.php
```

## Developpement

### Modifier le theme

Les fichiers du theme sont dans `wordpress/wp-content/themes/cognisens/`

### Ajouter des blocs Gutenberg

Creer les blocs dans `themes/cognisens/blocks/`

## Deploiement

1. Exporter la base de donnees
2. Modifier les URLs (Search-Replace)
3. Deployer sur le serveur de production
4. Configurer SSL et cache

## License

Code open source - MIT License

## Contact

COGNISENS
109 chemin de Ronde
78290 Croissy-sur-Seine
