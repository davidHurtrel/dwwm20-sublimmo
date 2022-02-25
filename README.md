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
- voir les mails dans la toolbar (config/packages/dev/web_profiler.yaml) :
```YAML
web_profiler:
    ...
    intercept_redirects: true # intercepte les redirections
```
(un message apparaît ensuite dans la toolbar)
- config/packages/mailer.yaml :
```YAML
framework:
    mailer:
        dsn: 'null://null' # désactive l'envoi de mail
        envelope:
            recipients: ['david.hurtrel@gmail.com'] # envoie tous les mails à cette adresse
```

## FORMULAIRE DE CONTACT

- créer le formulaire de contact
- créer le controller associé
- afficher le formulaire dans une vue (template)
- créer le template de mail (contact/contact_email.html.twig)

## PAIEMENT STRIPE

- créer un controller (et la vue associée)
- ajouter le script à la page de paiement (front) :
```HTML
<script src="https://js.stripe.com/v3/"></script>
```
- installer le bundle (back) :
```
composer require stripe/stripe-php
```
- ajouter le lien sur la page panier

## AUTOWIRING

- voir tous les services :
```
php bin/console debug:autowiring
```
- en voir plus (en ahut de liste : nos controllers, fixtures, forms, repositories en font partie) :
```
php bin/console debug:autowiring --all
```
- exemple :
```
composer require cebe/markdown
```
- la classe se trouve dans vendor
- services.yaml :
```
services:
    cebe\markdown\GithubMarkdown: ~
```
- rechercher un service particulier disponible avec l'autowiring :
```
php bin/console debug:autowiring --all markdown
```

## SERVICES

- services = objets qui font une tâche, des outils (réutilisables)
- créer le dossier Service (si pas déjà existant)
- y créer le fichier CartService.php

## API - OPEN WEATHER MAP

- créer un compte sur le site https://openweathermap.org/
- créer une clé API (préciser un nom)
- endpoint = URL, emplacement à partir duquel les applications peuvent accéder aux ressources dont elles ont besoin
- tester un appel dnas la barre d'url
- créer le service WeatherService

## PAGES D'ERREUR

- si nécessaire :
```
composer require symfony/twig-pack
```
- créer l'arborescence templates/bundles/TwigBundle/Exception/
- y créer les fichiers avec l'écriture errorXXX.html.twig (où XXX est le numéro d'erreur)
- error.html.twig pour toutes les autres

- 1xx : information
- 2xx : succès
- 3xx : redirection
- 4xx : client web
    - 401 : accès refusé
    - 403 : accès interdit
    - 404 : non trouvé
- 5xx : serveur
    - 500 : erreur interne
    - 503 : service indisponible

## PASSER DE SYMFONY 6.0 À SYMFONY 5.4

- composer.json :
    - remplacer 6.0 par 5.4
    - supprimer symfony/doctrine-messenger
    - supprimer symfony/messenger
- supprimer les dossiers var et vendor
- supprimer config/packages/messenger.yaml
- .env :
    - supprimer symfony/webapp-meta
    - supprimer symfony/messenger
- ajouter les méthodes suivantes dans src/Entity/User.php :
```PHP
/**
 * A visual identifier that represents this user.
 *
 * @see UserInterface
 */
public function getUsername(): string
{
    return (string) $this->email;
}
```
```PHP
/**
* Returning a salt is only needed, if you are not using a modern
* hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
*
* @see UserInterface
*/
public function getSalt(): ?string
{
    return null;
}
```
- composer update

## COMMANDES IMPORTANTES

- vider le cache :
```
php bin/console cache:clear
```
- envoyer les messages (mails, ...) :
```
php bin/console messenger:consume async
```

## RESTE À FAIRE

- pages d'erreur
- embedding services
- pagination
- utiliser CartService partout dans PaymentController

## PISTES

- installer verify-email-bundle avant registration-form