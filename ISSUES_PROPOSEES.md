# Issues proposées pour le kanban

> **Brouillon pour validation par l'équipe — aucune issue ci-dessous n'a été créée sur GitHub.**
>
> L'issue #2, « Create the header with the menu », existe déjà et n'est pas recréée ici. Les issues 1 à 18 couvrent le socle du devoir et ses livrables ; les issues 19 à 25 sont des bonus facultatifs.

## Socle du devoir et livrables

### 1. Présenter la boutique sur la page d'accueil

Ajouter sous le menu un bloc d'accueil avec le titre « La nature trouve sa place chez vous », une phrase de présentation de la boutique et un bouton « Découvrir nos plantes ». Le bouton mène à la route actuelle du catalogue. Reprendre la palette déjà utilisée dans le projet : vert forêt `#344e41` et crème `#dad7cd`. La mise en page doit rester lisible sur mobile. Ne pas ajouter de carousel, de formulaire ou de contenu de blog.

**Critères d'acceptation**
- La page d'accueil affiche le titre, le texte de présentation et le bouton.
- Le bouton mène au catalogue.
- La page s'affiche correctement sur petit écran.
- Un test HTTP vérifie la réponse 200 et la présence du contenu et du lien.

### 2. Afficher les plantes mises en avant sur l'accueil

Ajouter un booléen `isFeatured` à `Product`, avec migration, et marquer trois produits dans les fixtures. Sous le bloc d'accueil, afficher une section « Nos plantes à la une » sous forme de cartes responsives. Chaque carte présente le nom, la catégorie, le prix et un lien vers la fiche produit. L'image reste facultative ; aucune image ne doit être nécessaire pour que la carte s'affiche.

**Critères d'acceptation**
- Seuls les produits marqués sont affichés dans cette section.
- Les trois produits de démonstration sont marqués dans les fixtures.
- Un test vérifie l'affichage des produits mis en avant et l'absence des autres.
- Le formulaire d'administration des produits (issue 14) permet de modifier ce booléen.

### 3. Rechercher une plante par son nom

Brancher le paramètre GET `q` du catalogue sur la recherche existante du repository. La recherche doit retourner les noms contenant la valeur saisie, sans distinguer majuscules et minuscules. Une valeur vide affiche toutes les plantes. La recherche doit conserver le filtre de catégorie sélectionné.

**Critères d'acceptation**
- Une recherche partielle par nom retourne les plantes correspondantes.
- Une recherche vide retourne le catalogue complet.
- Une recherche sans résultat affiche un message explicite.
- Le filtre de catégorie reste appliqué en même temps que la recherche.
- Des tests HTTP couvrent ces résultats.

### 4. Filtrer le catalogue par catégorie

Ajouter au catalogue un formulaire GET qui propose les catégories existantes. La valeur transmise dans `category` est le slug de la catégorie. Sans catégorie sélectionnée, le catalogue complet est affiché. Le filtre doit conserver la recherche `q`.

**Critères d'acceptation**
- La liste de catégories est chargée depuis la base et affichée dans le formulaire.
- Choisir une catégorie n'affiche que les plantes de cette catégorie.
- Le choix vide affiche toutes les plantes.
- La recherche par nom est conservée lorsque le filtre est appliqué.
- Des tests HTTP couvrent le filtre seul et combiné à la recherche.

### 5. Afficher la fiche détaillée d'une plante

Compléter la route `/product/{slug}` pour charger et afficher la plante correspondante : nom, catégorie, description, prix, stock, entretien, lumière et arrosage. Afficher une image si le produit en possède une. Un slug inconnu doit produire une page 404.

**Critères d'acceptation**
- Chaque plante du catalogue possède un lien vers sa fiche.
- La fiche affiche les données enregistrées pour le produit.
- L'absence d'image ne casse pas la page.
- Un slug inconnu retourne une 404.
- Des tests HTTP couvrent une fiche valide et un slug inconnu.

### 6. Gérer le panier dans la session

Créer `CartService` qui stocke en session les quantités indexées par identifiant de produit. Implémenter `add`, `decrease`, `remove`, `clear`, `getItems`, `getTotal` et `count`. `add` refuse un produit inexistant et ne dépasse jamais le stock. `decrease` retire l'article lorsque sa quantité atteint zéro. Les montants restent calculés en centimes.

**Critères d'acceptation**
- Le panier survit aux requêtes de la même session.
- Les méthodes gèrent correctement ajout, diminution, retrait et vidage.
- La quantité ne peut pas dépasser le stock disponible.
- `getTotal` calcule le total à partir des prix en centimes.
- Des tests de service couvrent ces cas.

### 7. Consulter et modifier le panier

Créer la page `GET /panier`, affichant le produit, sa quantité, le sous-total de ligne et le total. Ajouter les actions POST `/panier/ajouter/{id}`, `/panier/diminuer/{id}`, `/panier/supprimer/{id}` et `/panier/vider`. Chaque action POST vérifie le jeton CSRF `cart`. Ajouter une action d'ajout au panier depuis la fiche produit et afficher un message si le stock empêche l'ajout.

**Critères d'acceptation**
- La page affiche le contenu et le total du panier.
- Les actions POST modifient le panier puis redirigent vers sa page.
- Une requête avec un jeton CSRF invalide ne modifie pas le panier.
- Le stock est respecté et un message explique le refus d'ajout.
- Des tests HTTP couvrent l'affichage et les actions.
- Cette issue dépend de l'issue 6.

### 8. Créer un compte client

Créer une entité utilisateur persistée avec e-mail unique, mot de passe haché et rôle par défaut `ROLE_USER`. Créer un formulaire d'inscription avec e-mail, mot de passe et confirmation du mot de passe. Après inscription valide, connecter l'utilisateur ou le rediriger vers la page de connexion.

**Critères d'acceptation**
- Un visiteur peut créer un compte avec un e-mail valide et un mot de passe confirmé.
- Un e-mail déjà utilisé ou une confirmation incorrecte est refusé avec un message.
- Le rôle par défaut est `ROLE_USER`.
- Le mot de passe est stocké haché et jamais en clair.
- Des tests HTTP couvrent l'inscription valide et les erreurs de validation.

### 9. Se connecter et appliquer les rôles

Créer les formulaires Symfony de connexion et de déconnexion avec protection CSRF. Les pages `/compte` et ses sous-pages nécessitent `ROLE_USER`. Les pages `/admin` et ses sous-pages nécessitent `ROLE_ADMIN`. Un utilisateur inscrit ne peut pas s'attribuer le rôle administrateur.

**Critères d'acceptation**
- Un utilisateur valide peut se connecter et se déconnecter.
- Un identifiant invalide ne crée pas de session authentifiée.
- Un visiteur anonyme ne peut pas accéder à `/compte`.
- Un client ne peut pas accéder à `/admin`.
- Le rôle n'est jamais modifiable depuis l'inscription ou le profil.
- Des tests HTTP couvrent ces règles.

### 10. Enregistrer les commandes et leurs lignes

Créer `Order` avec le client, la date de création, le statut initial `pending`, le total en centimes et les informations de livraison : nom du destinataire, adresse, code postal et ville. Créer `OrderItem` avec la commande, le produit, la quantité et le prix unitaire au moment de l'achat, en centimes. Générer et appliquer la migration.

**Critères d'acceptation**
- Les relations entre utilisateur, commande, lignes et produit sont définies.
- Les prix de ligne et le total sont des entiers en centimes.
- Les informations de livraison sont persistées avec la commande.
- `doctrine:schema:validate` valide le mapping et la base.
- Un test d'intégration crée une commande et ses lignes puis les relit.
- Cette issue dépend de l'issue 8.

### 11. Passer une commande depuis le panier

Créer `GET/POST /commander`, réservé aux clients connectés, avec les champs destinataire, adresse, code postal et ville. Refuser un panier vide. Au moment de valider, recharger les produits et vérifier à nouveau leur stock. Dans une transaction Doctrine, enregistrer la commande et ses lignes avec les prix en centimes et décrémenter le stock. Vider la session du panier uniquement après la validation de la transaction. Après validation, afficher une confirmation et un lien vers la commande.

**Critères d'acceptation**
- Un utilisateur non connecté est redirigé vers la connexion.
- Les champs de livraison obligatoires sont validés.
- Un panier vide ou un stock insuffisant empêche la commande.
- Une commande valide crée les lignes, sauvegarde les prix et décrémente le stock.
- En cas d'échec, aucune commande n'est enregistrée, le stock ne change pas et le panier est conservé.
- Des tests HTTP couvrent les cas valides et les erreurs.
- Cette issue dépend des issues 6, 7, 9 et 10.

### 12. Consulter ses commandes

Créer `/compte/commandes` pour l'utilisateur connecté. Afficher pour chaque commande la date, le statut, le total et un lien vers le détail. Le détail affiche les plantes achetées, les quantités et les prix unitaires.

**Critères d'acceptation**
- Le client voit uniquement ses propres commandes.
- Le détail affiche les lignes enregistrées au moment de l'achat.
- L'accès au détail d'une commande appartenant à un autre compte est refusé.
- Un visiteur non connecté est redirigé vers la connexion.
- Des tests HTTP couvrent liste, détail et contrôle d'accès.
- Cette issue dépend des issues 9, 10 et 11.

### 13. Modifier son profil client

Créer `/compte/profil` pour permettre au client connecté de modifier son e-mail et son mot de passe. Le changement de mot de passe demande le mot de passe actuel et une confirmation du nouveau. Les rôles ne sont pas modifiables depuis ce formulaire.

**Critères d'acceptation**
- Un e-mail déjà utilisé est refusé avec un message.
- Le nouveau mot de passe n'est enregistré que si l'ancien est correct et la confirmation valide.
- Le mot de passe reste haché en base.
- Le client ne peut ni modifier ni supprimer son rôle.
- Des tests HTTP couvrent ces cas.
- Cette issue dépend de l'issue 9.

### 14. Gérer les plantes dans l'administration

Créer une liste et des formulaires d'ajout, modification et suppression de produits, accessibles uniquement à `ROLE_ADMIN`. Les champs gérés sont nom, slug, description, prix, stock, catégorie, entretien, lumière, arrosage et indicateur « mis en avant ». Le prix saisi en euros est enregistré en centimes.

**Critères d'acceptation**
- Un administrateur peut créer, consulter, modifier et supprimer un produit.
- Le formulaire permet de choisir une catégorie existante et de modifier `isFeatured`.
- Un prix ou stock négatif est refusé.
- Un utilisateur non administrateur ne peut consulter ni soumettre les routes CRUD.
- Des tests HTTP couvrent CRUD, validation et autorisation.
- Cette issue dépend des issues 2 et 9.

### 15. Gérer les catégories dans l'administration

Créer une liste et des formulaires d'ajout, modification et suppression de catégories, accessibles uniquement à `ROLE_ADMIN`. Les champs gérés sont nom, slug et description. Empêcher la suppression d'une catégorie tant que des plantes lui sont associées et expliquer ce blocage.

**Critères d'acceptation**
- Un administrateur peut créer, consulter et modifier une catégorie.
- Un slug déjà utilisé est refusé.
- Une catégorie liée à des plantes ne peut pas être supprimée ; un message l'explique.
- Un utilisateur non administrateur ne peut accéder aux routes CRUD.
- Des tests HTTP couvrent ces cas.
- Cette issue dépend de l'issue 9.

### 16. Gérer les commandes dans l'administration

Créer une liste des commandes affichant client, date, total et statut, ainsi qu'une page de détail. Permettre les transitions `pending` vers `processing` ou `cancelled`, puis `processing` vers `shipped` ou `cancelled`. Les statuts `shipped` et `cancelled` sont terminaux.

**Critères d'acceptation**
- Seul `ROLE_ADMIN` peut consulter et modifier les commandes.
- Les transitions de statut autorisées sont appliquées ; les autres sont refusées.
- Le changement de statut utilise POST et vérifie le jeton CSRF.
- Des tests HTTP couvrent les transitions et les restrictions d'accès.
- Cette issue dépend des issues 9 et 10.

### 17. Fournir des comptes de démonstration

Ajouter aux fixtures un client `client@example.test` avec le mot de passe `ClientTest123!` et un administrateur `admin@example.test` avec le mot de passe `AdminTest123!`. Les mots de passe doivent être hachés. Documenter les identifiants dans le README en précisant qu'ils sont réservés au développement et ne doivent pas être utilisés en production.

**Critères d'acceptation**
- Le chargement des fixtures crée les deux comptes avec les rôles attendus.
- Il est possible de se connecter avec chacun d'eux.
- Le mot de passe n'est jamais stocké en clair.
- Le README affiche les identifiants comme comptes de test locaux uniquement.
- Cette issue dépend de l'issue 9.

### 18. Documenter le scénario de démonstration

Ajouter au README une section avec un scénario oral reproductible : ouvrir le catalogue, rechercher et filtrer, consulter une fiche, se connecter comme client, passer une commande, consulter son historique, puis se connecter comme administrateur et changer le statut d'une commande. Indiquer aussi les commandes pour démarrer la base, charger les fixtures et lancer le serveur.

**Critères d'acceptation**
- Les étapes sont écrites dans l'ordre et utilisent les routes et commandes réellement disponibles.
- Les comptes de test de l'issue 17 sont utilisés pour les étapes authentifiées.
- Le scénario complet est vérifié depuis une installation propre.
- Cette issue dépend des issues 11, 12, 16 et 17.

## Bonus facultatifs

### 19. Payer une commande avec Stripe Checkout

Installer le SDK Stripe. Lire `STRIPE_SECRET_KEY` et `STRIPE_WEBHOOK_SECRET` depuis la configuration locale, sans commiter de secret. Pour une commande `pending`, créer une session Checkout basée sur les lignes et les montants enregistrés, puis rediriger le client vers Stripe. Vérifier la signature du webhook et traiter chaque événement au plus une fois.

**Critères d'acceptation**
- Les secrets Stripe ne sont pas committés.
- Une commande en attente peut démarrer le paiement avec ses montants persistés.
- Un webhook à signature invalide ne change pas le statut.
- Un événement confirmé marque la commande payée une seule fois.
- Des tests simulés couvrent ces cas.
- Cette issue dépend de l'issue 11.

### 20. Envoyer un e-mail de confirmation de commande

Envoyer au client un e-mail après la création réussie de sa commande (statut `pending`), contenant sa référence, les plantes, les quantités et le total. Utiliser Symfony Mailer et configurer `MAILER_DSN` localement.

**Critères d'acceptation**
- Le destinataire est l'adresse du client ayant passé la commande.
- Le message contient les détails et le total de la commande.
- Aucun secret de transport n'est commité.
- Le test utilise le transport mémoire et n'envoie pas de vrai e-mail.
- Cette issue dépend de l'issue 11.

### 21. Téléverser les photos des plantes

Installer VichUploaderBundle via Composer/Flex et configurer le stockage des images produit. N'accepter que les images JPEG, PNG et WebP jusqu'à 5 Mo ; chaque fichier reçoit un nom unique. Permettre à l'administrateur d'ajouter et remplacer une image, puis l'afficher dans les cartes et fiches produit.

**Critères d'acceptation**
- Les formats autorisés sont enregistrés et les autres refusés.
- Les fichiers de plus de 5 Mo sont refusés.
- Les noms de fichiers stockés sont uniques.
- Une plante sans image s'affiche correctement.
- Des tests couvrent formats, taille et rendu.
- Cette issue dépend de l'issue 14.

### 22. Ajouter la pagination et des filtres avancés au catalogue

Afficher 9 plantes par page. Lire le numéro de page depuis GET `page` et revenir à la première page si sa valeur est invalide. Ajouter les filtres GET de prix minimum/maximum en euros et d'exposition. Les liens de pagination conservent recherche, catégorie et filtres.

**Critères d'acceptation**
- Une page affiche au plus 9 plantes.
- Les liens précédent/suivant affichent les bons produits.
- Les filtres de prix et d'exposition peuvent être combinés.
- Recherche et catégorie sont conservées lors du changement de page.
- Des tests HTTP couvrent pagination et filtres.
- Cette issue dépend des issues 3 et 4.

### 23. Créer les pages légales

Créer les pages CGV, mentions légales, confidentialité/RGPD et cookies, accessibles depuis le pied de page. Les informations légales inconnues doivent être signalées par « À renseigner » ; ne pas inventer d'identité ou de coordonnées.

**Critères d'acceptation**
- Une route distincte existe pour chacune des quatre pages.
- Les liens sont présents dans le pied de page.
- Chaque route retourne une réponse HTTP 200.
- Les informations inconnues sont clairement signalées pour validation.

### 24. Améliorer le référencement du site

Ajouter un titre et une meta description adaptés à l'accueil, au catalogue et à chaque fiche produit. Générer un sitemap XML contenant l'accueil, le catalogue et les fiches produit existantes ; les URLs sont absolues et utilisent `DEFAULT_URI`.

**Critères d'acceptation**
- Les pages concernées ont un titre et une meta description non vides et spécifiques.
- Le sitemap est un XML valide et contient les routes attendues.
- Les URLs du sitemap sont absolues et utilisent le domaine configuré.
- Des tests vérifient les métadonnées et le sitemap.
- Cette issue dépend de l'issue 5.

### 25. Tester le parcours complet d'achat

Ajouter des tests HTTP couvrant le parcours visiteur → recherche → panier → connexion → commande, puis vérifier la commande créée, le stock et l'historique. Ajouter aussi un test de contrôle d'accès entre client et administrateur.

**Critères d'acceptation**
- Le test du parcours client passe sans service externe de paiement ou d'e-mail.
- Le test confirme les données de commande, le stock et l'historique.
- Un client ne peut pas accéder à l'administration ; un administrateur peut consulter les commandes.
- Les tests s'exécutent avec `php bin/phpunit`.
- Cette issue dépend des issues 7, 9, 11, 12 et 16.

## Dépendances et contexte

- Le panier (issue 7) dépend du service de panier (issue 6) ; la commande (issue 11) dépend du panier, de l'authentification et du modèle de commande.
- L'historique et l'administration dépendent de l'authentification et des commandes.
- Le projet utilise Symfony 8.1, Doctrine ORM et MySQL avec Docker Compose. Les entités `Product` et `Category`, la migration et les fixtures produit existent déjà.
- La recherche et le filtre existent dans le repository mais ne sont pas encore reliés au contrôleur. L'accueil et la fiche produit sont encore provisoires.
- Blog et liste de souhaits apparaissent dans l'issue #2 existante, mais ne figurent pas dans les consignes du PDF.
