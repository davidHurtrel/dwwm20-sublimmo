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
- importer les "fausses" données (s'il y en a) :
```
php bin/console doctrine:fixtures:load
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

- créer un controller (et le template asscoié) :
```
php bin/console make:controller nom_du_controller
```
- générer un crud :
```
php bin/console make:crud nom_de_l_entite
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

## ROUTER

- voir toutes les routes :
```
php bin/console debug:router
```
- vérifier si une route existe (et obtenir ses informations) :
```
php bin/console router:match /url_de_la_route
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

## MESSAGES FLASH

- dans un controller :
```PHP
$this->addFlash('success', 'La maison a bien été ajoutée');
```
- à l'endroit où l'on veut afficher les messages (template) :
```PHP
{% for label, messages in app.flashes %}
    {% for message in messages %}
        <div class="flash-{{ label }} bg-{{ label }} text-light p-3 mb-5 rounded">
            {{ message }}
        </div>
    {% endfor %}
{% endfor %}
```

## REGISTER

- créer l'entité User :
```
php bin/console make:user
```
- ajouter des champs à l'entité User :
```
php bin/console make:entity user
```
- migration
- créer le formulaire d'inscription :
```
php bin/console make:registration-form
```
- installer le bundle de vérification d'email :
```
composer require symfonycasts/verify-email-bundle
```
- modifier la dernière redirection après la vérification de l'adresse mail (RegistrationController::verifyUserEmail())
- gérer l'affichage des messages flash (register.html.twig, ...)
- personnaliser le formulaire, le controller et les templates
- migration pour générer la propriété User::isVerified
- installer Rollerworks :
```
composer require rollerworks/password-strength-bundle
```
- dans le formulaire :
```
use Rollerworks\...\PasswordStrength
```
```
new PasswordStrength
```
- y ajouter les contraintes souhaitées

## LOGIN

- créer "l'authentification" :
```
php bin/console make:auth
```
- 1
- LoginFormAuthenticator
- SecurityController
- yes
- pour se déconnecter :
```
<a href="{{ path('app_logout') }}"></a>
```

## SÉCURITÉ - DROITS - ACCES - HIÉRARCHIE

- dans config/packages/security.yaml, décommenter :
```
access_control:
    - { path: ^/admin, roles: ROLE_ADMIN }
    ...
role_hierarchy:
    ROLE_ADMIN: ROLE_USER
    ROLE_SUPER_ADMIN: ROLE_ADMIN
```
- afficher du code selon un rôle :
```
{% if is_granted('LE_ROLE') %}
    le_code_ici
{% endif %}
```

## EMAIL

- installer le mailer :
```
composer require symfony/mailer
```
- installer le package tiers :
```
composer require symfony/google-mailer
```
- dans les paramètres du compte Google => Sécurité => Connexion à Google : activer la Validation en deux étapes pour pouvoir accéder aux Mots de passe des applications
- créer un nouveau mot de passe d'application
- .env :
```
MAILER_DSN=gmail://USERNAME:PASSWORD@default
```

## COMMANDES IMPORTANTES

- vider le cache :
```
php bin/console cache:clear
```

## RESTE À FAIRE

- formulaire de contact
- ajout au panier
- paiement avec Stripe
- pages d'erreur
- pagination

## PISTES

- installer verify-email-bundle avant registration-form