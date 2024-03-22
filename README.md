# Favorite tasks plugin

A plugin for selecting and displaying favorite tasks.

### Coding standards

``` shell
docker run --tty --interactive --rm --env COMPOSER=composer-plugin.json --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer install
docker run --tty --interactive --rm --env COMPOSER=composer-plugin.json --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer coding-standards-check
docker run --tty --interactive --rm --env COMPOSER=composer-plugin.json --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer coding-standards-apply
```