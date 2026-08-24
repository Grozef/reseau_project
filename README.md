# reseau_project

Application Symfony de multidiffusion sociale : rattacher des comptes de plateformes et y
publier des contenus.

## Modele

Entites (`src/Entity/`) : `User`, `SocialAccount`, `Platform`, `Post`, `Media`, `Message`.

Controleurs (`src/Controller/`) : `AuthController`, `UserController`,
`SocialAccountController`, `PostController`, `MediaController`, `MessageController`.

Les medias televerses sont stockes dans `public/uploads` (`MEDIA_DIRECTORY`).

## Stack

Symfony avec Doctrine ORM et migrations, AssetMapper pour les assets, Twig pour les vues,
Messenger sur transport Doctrine. Tests PHPUnit.

## Lancer

```sh
composer install
```

Configurer `DATABASE_URL`, puis :

```sh
php bin/console doctrine:migrations:migrate
php bin/console asset-map:compile
```

`compose.yaml` et `compose.override.yaml` fournissent les services de developpement.

> Le `.env` versionne contient des identifiants d'application Meta. Placer les valeurs
> reelles dans un `.env.local` non versionne.
