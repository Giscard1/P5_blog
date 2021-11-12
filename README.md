Projet 5 OpenClassrooms - Créez votre premier blog en PHP
Lien repository GitHub - https://github.com/Giscard1/P5_blog

Projet 5 de mon parcours Développeur d'application PHP/Symfony chez OpenClassrooms. Création d'un Blog via une architecture MVC.

Parcours Développeur d'application - PHP / Symfony

Code Quality:

La qualité du code a été validé par Codacy.
Lien codacy - https://app.codacy.com/gh/Giscard1/P5_blog/dashboard?branch=main


Description du projet:

Voici les principales fonctionnalités disponibles suivant les différents statuts utilisateur:
Le visiteur:

    • Visiter la page d'accueil et ouvrir les différents liens disponibles (twitter, facebook etc).
    • Envoyer un message au créateur du blog.
    • Parcourir la liste des blogs et parcourir la liste de ses commentaires.
    • Accès au CV.

L'utilisateur:

    • Prérequis: s'être enregistré via le formulaire d'inscription.
    • Accès aux mêmes fonctionnalités que le visiteur.

Administrateur:

    • Prérequis: avoir le status administrateur.
    • Accès aux mêmes fonctionnalités que le visiteur.
    • Ajout/suppression/modification d’articles.
    • Validation/Ajout/suppression de commentaires.
    • Validation/suppression d’utilisateur.


Informations:

Le Front-end a été développé avec Bootstrap.


Prérequis:

Php ainsi que Composer doivent être installés sur votre serveur afin de pouvoir correctement lancé le blog.
Installation

Etape 1 : Cloner le Repositary sur votre serveur.
Etape 2 : Créer une base de données sur votre SGBD.
Etape 3 : Nommez la base de données P5.
Etape 4 : Entrez vos informations de connexion à la base de données dans le fichier src/Repository/AbstractRepository.
Etape 5 : Remplir le fichier App/Config/mail_config.php avec les accès à votre compte email.
Etape 6 : Installer les dependances 
           Twig -> composer require "twig/twig:^2.0"
           Swiftmailer -> composer require "swiftmailer/swiftmailer:^6.0"
           Slim Framework CSRF Protection -> composer require slim/csrf
           Slim Framework Twig View -> composer require slim/twig-view:^3.0
           Symfony routing -> composer require symfony/routing:^3.4
Etape 7 : Votre blog est désormais fonctionnel.


Librairies utilisées
    • Bootstrap
    • Swiftmailer
    • Twig
    • Slim Framework CSRF Protection
    • Slim Framework Twig View
    • Symfony routing



    


