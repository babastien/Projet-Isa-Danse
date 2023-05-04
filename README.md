Site de danse - cours en ligne

Installation :

1/ importer la base de données à l'aide du fichier isa_danse.sql (dans le dossier database)

2/ télécharger var-dumper et autoload (si vous n'utilisez pas laragon, il faut d'abord installer composer) :

    - taper dans le terminal à la racine du dossier :
    composer require symfony/var-dumper

    - modifier le fichier composer.json en ajoutant : 
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }

    - taper dans le terminal à la racine du dossier :
    composer dump-autoload

3/ télécharger mailer :

    - taper dans le terminal à la racine du dossier :
    composer require symfony/mailer

4/ créer un fichier config.php dans le dossier app en suivant le fichier config.example.php

Vous pouvez désormai utiliser le site
    Compte admin test :
        Email de connexion : test@gmail.com
        Mot de passe de connexion : Azerty123