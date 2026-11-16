# Projet Symfony : boutique e-commerce de plantes

### Sujet, consignes et guide pas à pas pour les étudiants

## 1. Présentation du sujet

Vous devez réaliser un **site e-commerce de vente de plantes** avec le framework **Symfony**,
une **base de données MySQL/MariaDB** et le moteur de templates **Twig**. Le site permet à
un visiteur de parcourir un catalogue de plantes, de les filtrer, de consulter une fiche
détaillée et de remplir un panier. Les clients pourront ensuite créer un compte, passer
commande et payer en ligne. Un administrateur gère le catalogue depuis un back-office.

### Objectifs pédagogiques

- Installer et vérifier un environnement de développement PHP/Symfony.
- Concevoir un modèle de données (entités, relations) avec Doctrine.
- Gérer le schéma de la base avec les migrations et les fixtures.
- Créer des contrôleurs, des routes et des vues Twig.
- Gérer un panier en session avec un service dédié.
- Mettre en place l’authentification, les rôles et la sécurité (CSRF).
- Découvrir un paiement en ligne et un back-office.

## 2. Cahier des charges

### Fonctionnalités obligatoires

| N°  | Fonctionnalité  | Détail                                                                  |
| --- | --------------- | ----------------------------------------------------------------------- |
| 1   | Catalogue       | Liste des plantes, recherche par nom, filtre par catégorie              |
| 2   | Fiche produit   | Description, prix, stock, entretien, exposition,arrosage                |
| 3   | Accueil         | Présentation et plantes mises en avant                                  |
| 4   | Panier          | Ajouter, diminuer, supprimer, vider, total, vérification du stock       |
| 5   | Comptes clients | Inscription, connexion, déconnexion                                     |
| 6   | Commande        | Formulaire de livraison, enregistrement de la commande et de ses lignes |
| 7   | Espace client   | Historique des commandes                                                |
| 8   | Administration  | Gestion des produits, catégories et commandes (rôle ROLE_ADMIN)         |

### Fonctionnalités bonus

- Paiement avec Stripe Checkout et webhook de confirmation.
- Upload de photos des plantes (VichUploaderBundle).
- Pagination du catalogue et filtres avancés (prix, exposition).
- Envoi d’un email de confirmation (Symfony Mailer).
- Pages légales : CGV, mentions légales, RGPD, cookies.
- Tests automatisés avec PHPUnit.
- SEO : balises meta, sitemap.

### Contraintes techniques

- Symfony **7.4 LTS** (PHP 8.2 minimum) ou **8.1** (PHP 8.4 minimum).
- Base de données MySQL/MariaDB gérée par Doctrine ORM.
- Prix stockés en **centimes** (entier) pour éviter les erreurs d’arrondi.
- Formulaires protégés par un **jeton CSRF**.
- Code versionné avec **Git** (commits réguliers, messages clairs).

## 3. Livrables et évaluation

**Livrables** : le dépôt Git du projet, un fichier `README.md` (installation, comptes de test), un
export de la base ou les fixtures, et une courte démonstration orale.

| Critère                                            | Points |
| -------------------------------------------------- | ------ |
| Environnement et installation documentée           | 2      |
| Modèle de données (entités, relations, migrations) | 4      |
| Catalogue, fiche produit, accueil                  | 4      |
| Panier                                             | 4      |
| Authentification et sécurité                       | 3      |
| Commande et espace client                          | 3      |
| Back-office                                        | 3      |
| Qualité du code et du Git                          | 2      |
| Bonus (paiement, upload, tests...)                 | +2     |

Barème indicatif, à adapter par l’enseignant.

## 4. Environnement requis

Exemple de configuration utilisée (Windows) :

| Outil           | Version utilisée | Détail                                 |
| --------------- | ---------------- | -------------------------------------- |
| PHP             | 8.5.11           | 8.2 (Symfony 7.4) ou 8.4 (Symfony 8.x) |
| Composer        | 2.10             | 2.x                                    |
| Symfony CLI     | 5.20             | à jour                                 |
| Git             | 2.47             | 2.x                                    |
| Node.js         | 22               | optionnel                              |
| MariaDB (XAMPP) | 10.4.32          | MySQL 8 / MariaDB 10.4+                |

**Extensions PHP obligatoires** : `intl` , `mbstring` , `curl` , `zip` , `xml` , `ctype` , `iconv` ,
`openssl` , `fileinfo` , `gd` , `pdo_mysql` .

### INSTALLER `ctype` & `iconv`, il semble qu'il ne sont pas dans php.ini.

Symfony 8.0 n’est plus maintenue : choisissez la **7.4 LTS** ou la **8.1**.
