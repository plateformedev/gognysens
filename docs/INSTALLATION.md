# Installation COGNYSENS

## Prerequis

- Docker Desktop
- Git
- Node.js (optionnel, pour le build des assets)

## Installation locale

### 1. Cloner le repository

```bash
git clone https://github.com/plateformedev/gognysens.git
cd gognysens
```

### 2. Configurer l'environnement

```bash
cp .env.example .env
```

Modifier `.env` si necessaire :
- `DB_PASSWORD` : mot de passe de la base de donnees
- `WP_DEBUG` : true pour le developpement

### 3. Demarrer les conteneurs

```bash
docker-compose up -d
```

### 4. Acceder a WordPress

- Site : http://localhost:8080
- phpMyAdmin : http://localhost:8081
- Mailhog : http://localhost:8025

### 5. Installation WordPress

1. Suivre l'assistant d'installation WordPress
2. Creer un compte administrateur
3. Activer le theme "Cognysens"
4. Activer le plugin "Cognysens Core"

### 6. Importer le contenu

Via WP-CLI (dans le conteneur) :

```bash
docker exec -it cognysens-wp wp eval-file /var/www/html/wp-content/scripts/import-content.php
```

Ou via l'interface admin :
1. Aller dans Cognysens > Import
2. Lancer l'import des pages

## Plugins a installer

### Plugins gratuits (via admin WordPress)

- RankMath SEO
- Complianz (RGPD)

### Plugins premium (a telecharger)

- Gravity Forms
- Amelia ou Simply Schedule Appointments
- ACF Pro (optionnel)

## Configuration post-installation

### 1. Menus

Les menus sont crees automatiquement lors de l'import.
Verifier dans Apparence > Menus.

### 2. Page d'accueil

Verifier dans Reglages > Lecture que la page d'accueil statique est bien configuree.

### 3. Permaliens

Aller dans Reglages > Permaliens et selectionner "Nom de l'article".

### 4. RankMath SEO

1. Suivre l'assistant de configuration
2. Verifier les meta titles/descriptions des pages principales

### 5. RGPD

1. Configurer Complianz
2. Verifier le bandeau cookies
3. Tester le refus des cookies

## Deploiement en production

### 1. Export de la base

```bash
docker exec cognysens-db mysqldump -u root -p cognysens_db > backup.sql
```

### 2. Modification des URLs

Utiliser WP-CLI :

```bash
wp search-replace 'http://localhost:8080' 'https://cognysens.fr' --all-tables
```

### 3. Configuration serveur

- PHP 8.0+
- MySQL 8.0+
- SSL obligatoire
- Cache (WP Rocket recommande)

## Commandes utiles

```bash
# Redemarrer les conteneurs
docker-compose restart

# Voir les logs
docker-compose logs -f wordpress

# Acceder au conteneur WordPress
docker exec -it cognysens-wp bash

# WP-CLI
docker exec -it cognysens-wp wp --info

# Arreter les conteneurs
docker-compose down

# Supprimer les volumes (attention, perte de donnees)
docker-compose down -v
```

## Depannage

### Le site ne s'affiche pas

1. Verifier que Docker tourne : `docker ps`
2. Verifier les logs : `docker-compose logs wordpress`

### Erreur de connexion a la base

1. Verifier les variables d'environnement dans `.env`
2. Redemarrer les conteneurs : `docker-compose restart`

### Le theme n'apparait pas

1. Verifier les permissions : `chmod -R 755 wordpress/wp-content/themes/cognysens`
2. Desactiver le cache si active

## Support

Pour toute question, ouvrir une issue sur le repository GitHub.
