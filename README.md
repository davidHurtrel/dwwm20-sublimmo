# SYMFONY

## NOUVEAU PROJET

- ouvrir un nouveau terminal
- se rendre dans le dossier où l'on veut créer le projet (ex.: MAMP/htdocs) :
```
cd chemin_vers_le_dossier
```
- créer le projet avec Symfony CLI (pas besoin de créer le dossier du projet) :
```
symfony new --webapp nom_du_projet --version=5.4
```
- créer le projet avec Composer (pas besoin de créer le dossier du projet) :
```
composer create-project symfony/website-skeleton nom_du_projet ^5.4
```

## GIT

- créer un dépôt Git sur GitHub
- avec un terminal, se rendre dnas le dossier du projet (cd chemin_du_dossier ou VSC)
- initialiser un dépôt local :
```
git init
```
- lier le dépôt local au dépôt distant :
```
git remote add origin https://github.com/nom_d_utilisateur/nom_du_depot_distant.git
```
- ajouter tous les fichiers :
```
git add *
```
- donner un nom au commit :
```
git commit -m "message_du_commit"
```
- récupérer les dernières modifications :
```
git pull origin main
```
- envoyer les modifications :
```
git push origin main (ou master)
```
- voir la liste des commits (flèches haut et bas pour naviguer dans la liste, q pour quitter) :
```
git log
```

## RÉCUPÉRER UN PROJET

- télécharger le zip ou faire un pull
- recréer le fichier .env à la racine du projet (avec ses propres informations), les informations importantes sont APP_ENV, APP_SECRET et DATABASE_URL (éventuellement MAILER_URL)
- mettre à jour le projet (installer les dépendances, générer le cache, ...) :
```
composer install
```
- créer la base de données (si cela n'a pas déjà été fait) :
```
php bin/console doctrine:database:create
```
- mettre à jour la base de données (créer, modifier ou supprimer les tables) :
```
php bin/console doctrine:migrations:migrate
```

## SYMFONY SERVER

- démarrer le serveur Symfony :
```
symfony server:start (Ctrl + C pour quitter)
```
- démarrer le serveur en arrière-plan
```
symfony server:start -d
```
- arrêter le serveur :
```
symfony server:stop
```

## APACHE-PACK

- suite d'outils pour Apache (barre de débug, routing, .htaccess)
- dans le terminal :
```
composer require symfony/apache-pack
```

## CONTROLLER

```
php bin/console make:controller nom_du_controller
```

## BASE DE DONNÉES

- .env :
```
DATABASE_URL="mysql://utilisateur:mot_de_passe@127.0.0.1:3306/nom_de_la_base_de_donnees?serverVersion=5.7"
```
- créer la base de données :
```
php bin/console doctrine:database:create
```
- créer une entité (table) :
```
php bin/console make:entity nom_de_l_entite
```
- migration :
```
php bin/console make:migration
```
```
php bin/console doctrine:migrations:migrate
```

## FIXTURES

- installer le bundle :
```
composer require --dev orm-fixtures
```
- compléter le fichier srv/DataFixtures/AppFixtures.php
- persist()
- flush()
- envoyer en base de données (en écrasant) :
```
php bin/console doctrine:fixtures:load
```
- envoyer en base de données (en ajoutant à la suite) :
```
php bin/console doctrine:fixtures:load --append
```
- bundle pour générer de fausses données :
```
composer require fakerphp/faker
```

## FORMULAIRE

- créer le formulaire :
```
php bin/console make:form nom_du_formulaire
```
- mise en forme des formulaires avec un thème (config/packages/twig.yaml) :
```
twig:
    form_themes: ['bootstrap_5_layout.html.twig']
```
