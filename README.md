# Contact Form

Exercice technique / fonctionnel utilisé par Artmajeur pour ses recrutements.


## Contexte

Vous êtes développeur chez Artmajeur. Vous recevez une demande de la direction pour la mise en place d'une nouvelle fonctionnalité sur son site Internet.


> Nous souhaiterions mettre en place un formulaire de contact sur notre site.
> Le formulaire de contact doit être simple : il doit nous permettre de connaitre les coordonnées de l'internaute, et sa question.
> Il nous faut au moins son nom, son email, et sa question pour que nous traitions sa demande.

> Il nous faudrait aussi un petit back-office avec accès sécurisé pour permettre au webmaster de consulter la liste des demandes, et de pouvoir cocher les messages que nous avons traité

Les règles de gestion suivantes sont à mettre en place :

> Un utilisateur qui dépose plusieurs demande de contact avec le même email, doit voir ses demandes regroupées et se cumulées pour ce contact

> Toute demande de contact doit déclencher la création d'un fichier JSON unique dans un répertoire spécifique non exposé par le serveur web, qui contient l'ensemble du contenu de la demande : informations du contact et contenu de la demande. A terme d'autres notifications seront déclenchées.

Il vous est demandé de mettre en place la solution sur la base du Framework Symfony.


## Réponse apportée 

J'ai implémenté la solution comme demandé avec Symfony. 
J'ai réalisé quelques tests avec Behat même s'ils ne couvrent pas entièrement le projet,
un des scénario nécessite Selenium et un web driver car l'interface est testée avec Mink.
Je suis allé au plus simple pour le front, avec plus de temps je pourrais éventuellement 
rajouter de la validation front dans le formulaire de contact, et éventuellement transformer
la partie admin en petite app react avec de la pagination, et une API qui permettrait 
de récupérer le détail des messages par email.

Néanmoins le scénario proposé est implémenté !

L'admin créé par défaut ici pour tester :

- email: admin@artmajeur.com
- mot de passe: admin

(cf UserService.php)

## Demarrer le projet en dev

- installer les dépendances front et back
- démarrer le docker compose
- effectuer les migrations de la base de donnée
- démarrer symfony et yarn
- visiter localhost:8000


