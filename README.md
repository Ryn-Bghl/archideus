# Archideus — boutique de plantes

Projet de boutique en ligne de plantes réalisé avec Twig et Doctrine. Le **framework Symfony du projet est en version 8.1** et nécessite **PHP 8.4 ou supérieur**. Symfony CLI est un outil séparé qui sert notamment à lancer le serveur local ; sa version (par exemple 5.16) n’est pas la version du framework.

À ce stade, le projet contient une page d’accueil, un catalogue, des fiches produit et des fixtures de démonstration. Les comptes clients, le panier, les commandes et l’administration décrits dans `CONSIGNES.md` restent à développer. Il n’y a donc pas encore de compte de test.

## Prérequis

- PHP 8.4 ou supérieur, avec les extensions `ctype`, `iconv`, `intl`, `mbstring`, `curl`, `zip`, `xml`, `openssl`, `fileinfo`, `gd` et `pdo_mysql`.
- Composer 2.
- Git.
- Docker Desktop et Docker Compose pour démarrer la base de données et phpMyAdmin avec la configuration fournie.
- Symfony CLI pour lancer le serveur de développement (recommandé).

Vérifier PHP et ses extensions :

```powershell
php -v
php -m
composer --version
docker compose version
symfony -v
```

Le projet utilise Symfony AssetMapper ; **Node.js n’est pas nécessaire** pour l’installation actuelle.

## Installation sous Windows

### 1. Récupérer le projet

```powershell
git clone https://github.com/Ryn-Bghl/archideus.git
cd archideus
```

### 2. Installer les dépendances PHP

```powershell
composer install
```

### 3. Démarrer MySQL et phpMyAdmin

Lancer Docker Desktop, puis depuis la racine du projet :

```powershell
docker compose up -d
```

La configuration de développement démarre MySQL 8 et phpMyAdmin. Les adresses et paramètres de connexion sont définis dans `compose.yaml`. Consultez ce fichier pour configurer votre environnement local ; les identifiants ne sont pas recopiés dans ce README.

phpMyAdmin est disponible à l’adresse locale indiquée par le port publié dans `compose.yaml`. Les identifiants configurés pour le développement local ne doivent pas être réutilisés en production.

### 4. Configurer la connexion à la base

Ouvrir ou créer `.env.local` à la racine du projet :

```powershell
notepad .env.local
```

Ajouter cette ligne en remplaçant les champs par les valeurs de `compose.yaml` :

```dotenv
DATABASE_URL="mysql://{utilisateur}:{mot_de_passe}@{hote}:{port}/{nom_de_base}?serverVersion={version_mysql}&charset=utf8mb4"
```

`utilisateur` et `mot_de_passe` sont les identifiants de la base ; `hote` et `port` son adresse ; `nom_de_base` et `version_mysql` désignent la base et la version MySQL. `.env.local` est ignoré par Git : ne le commitez pas.

### 5. Créer le schéma et charger les données de démonstration

```powershell
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```

La commande des fixtures **efface les données existantes** avant de charger les catégories et plantes de démonstration.

### 6. Lancer l’application

```powershell
symfony serve
```

Ouvrir l’adresse affichée par Symfony CLI, généralement <https://127.0.0.1:8000>. Pour arrêter le serveur, utilisez `Ctrl+C`.

## Commandes utiles

```powershell
# Vérifier la connexion à la base
php bin/console doctrine:query:sql "SELECT 1"

# Afficher les routes de l’application
php bin/console debug:router

# Exécuter les tests automatisés
php bin/phpunit

# Arrêter les conteneurs sans supprimer les données locales
docker compose down
```

Les tests qui accèdent à la base nécessitent une base de test configurée séparément de la base de développement. Ne lancez pas de tests contre des données importantes.

## Dépannage

- **Extensions PHP introuvables** : vérifiez que la version de PHP utilisée par `php` est bien celle configurée et que les DLL requises existent dans son dossier `ext`. `php --ini` affiche le fichier `php.ini` chargé ; `php -m` liste les extensions effectivement activées.
- **Connexion MySQL refusée** : vérifiez que Docker Desktop est démarré et que `docker compose ps` affiche le conteneur `mysql` en cours d’exécution. La connexion depuis Windows utilise le port `3307`, pas `3306`.
- **Base ou identifiants incorrects** : assurez-vous que la valeur `DATABASE_URL` dans `.env.local` correspond aux paramètres de `compose.yaml`.
- **Port déjà utilisé** : libérez le port concerné ou modifiez le port publié dans `compose.yaml`, puis adaptez `DATABASE_URL` si le port MySQL change.
- **Dépendances incompatibles** : vérifiez que Composer utilise le même PHP 8.4+ que `php -v`, puis relancez `composer install`.
- **Vérifier la version du framework** : exécutez `php bin/console about` ou `composer show symfony/framework-bundle`. `symfony -v` affiche la version de Symfony CLI.

Pour plus de contexte sur le sujet et les fonctionnalités attendues, voir [`CONSIGNES.md`](CONSIGNES.md).
