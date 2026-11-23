# Contribuer au projet

Ce guide décrit le workflow pour contribuer à Archideus. Le projet utilise Symfony 8.1, PHP 8.4 ou supérieur, Doctrine ORM, Twig et MySQL.

## 1. Choisir une tâche

- Consultez les issues GitHub et le kanban de l'équipe avant de commencer.
- `ISSUES_PROPOSEES.md` contient des brouillons en attente de validation par l'équipe. Ils ne sont pas encore des issues : attendez leur validation et leur création avant de les prendre.
- Vérifiez que personne ne travaille déjà sur l'issue choisie et coordonnez-vous avec l'équipe en cas de doute.
- Si le travail ne correspond à aucune issue approuvée, proposez une issue et attendez l'accord de l'équipe avant de développer.

## 2. Installer le projet

Suivez les étapes du [`README.md`](README.md) pour installer les dépendances, configurer `.env.local`, démarrer MySQL avec Docker Compose, appliquer les migrations et lancer le serveur.

Ne commitez jamais `.env.local`, de mots de passe réels ou de clés API. Le chargement des fixtures peut effacer les données de la base ciblée : utilisez uniquement une base locale de développement ou de test.

## 3. Créer une branche

Partez de la branche `main` à jour et créez une branche dédiée à l'issue :

```powershell
git switch main
git pull --ff-only
git switch -c feat/123-short-description
```

Remplacez `123` par le numéro de l'issue approuvée. Utilisez `fix/` pour une correction et `docs/` pour une modification documentaire.

## 4. Développer et tester

- Gardez les changements limités au besoin décrit dans l'issue.
- Suivez les conventions déjà utilisées dans le projet : contrôleurs Symfony minces, vues Twig, métadonnées Symfony par attributs et services autowirés.
- Stockez les prix en centimes. Toute modification du modèle de données doit inclure une nouvelle migration ; ne modifiez pas une migration déjà appliquée.
- Ajoutez ou mettez à jour un test qui vérifie le comportement demandé. Utilisez un test HTTP pour une route ou un contrôleur.
- N'exécutez pas de tests sur la base de développement ou des données importantes. Configurez une base de test séparée lorsqu'un test utilise Doctrine.

Avant d'ouvrir une pull request, lancez les vérifications pertinentes :

```powershell
php bin/phpunit
php bin/console doctrine:schema:validate
```

La validation Doctrine nécessite que la base de données soit démarrée et que `.env.local` soit configuré.

## 5. Commiter et ouvrir une pull request

Faites des commits ciblés avec un message qui décrit le changement, par exemple :

```text
feat: add category filter to catalogue
fix: prevent cart quantity from exceeding stock
test: cover product search
docs: explain contribution workflow
```

Poussez votre branche puis ouvrez une pull request vers `main`. Dans sa description :

- référencez l'issue approuvée, par exemple `Closes #123` ;
- résumez le changement et les décisions importantes ;
- indiquez les commandes de test exécutées et leur résultat ;
- ajoutez des captures d'écran pour les changements d'interface.

Demandez une revue à l'équipe et attendez son approbation avant de fusionner.
