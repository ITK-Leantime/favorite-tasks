# Favorite tasks plugin

A plugin for selecting and displaying favorite tasks.

## Development

Clone this repository into your Leantime plugins folder:

``` shell
git clone https://github.com/ITK-Leantime/favorite-tasks.git app/Plugins/FavoriteTasks
```

### Coding standards

``` shell
docker run --tty --interactive --rm --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer install
docker run --tty --interactive --rm --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer coding-standards-apply
docker run --tty --interactive --rm --volume ${PWD}:/app itkdev/php8.1-fpm:latest composer coding-standards-check
```
