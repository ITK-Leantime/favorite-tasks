# Favorite tasks plugin

A plugin for selecting and displaying favorite tasks.

## Development

Clone this repository into your Leantime plugins folder:

``` shell
git clone https://github.com/ITK-Leantime/favorite-tasks.git app/Plugins/FavoriteTasks
```

Run composer install

```shell name=development-install
docker run --interactive --rm --volume ${PWD}:/app itkdev/php8.3-fpm:latest composer install
```

### Composer normalize

```shell name=composer-normalize
docker run --rm --volume ${PWD}:/app itkdev/php8.3-fpm:latest composer normalize
```

### Coding standards

#### Blade lint

```shell name=blade-apply
docker run --rm --volume "$PWD:/app" -w /app shufo/blade-formatter:1.11.11 Templates/*.blade.php --write
```

```shell name=blade-check
docker run --rm --volume "$PWD:/app" -w /app shufo/blade-formatter:1.11.11 Templates/*.blade.php --check-formatted
```

#### Check and apply with phpcs

```shell name=check-coding-standards
docker run --interactive --rm --volume ${PWD}:/app itkdev/php8.3-fpm:latest composer coding-standards-check
```

```shell name=apply-coding-standards
docker run --interactive --rm --volume ${PWD}:/app itkdev/php8.3-fpm:latest composer coding-standards-apply
```

#### Check and apply markdownlint

```shell name=markdown-check
docker run --rm --volume $PWD:/md peterdavehello/markdownlint markdownlint --ignore vendor --ignore LICENSE.md '**/*.md'
```

```shell name=markdown-apply
docker run --rm --volume $PWD:/md peterdavehello/markdownlint markdownlint --ignore vendor --ignore LICENSE.md '**/*.md' --fix
```

#### Check with shellcheck

```shell name=shell-check
docker run --rm --volume "$PWD:/app" --workdir /app peterdavehello/shellcheck shellcheck bin/create-release
docker run --rm --volume "$PWD:/app" --workdir /app peterdavehello/shellcheck shellcheck bin/deploy
docker run --rm --volume "$PWD:/app" --workdir /app peterdavehello/shellcheck shellcheck bin/local.create-release
```

### Code analysis

```shell name=code-analysis
docker run --interactive --rm --volume ${PWD}:/app itkdev/php8.3-fpm:latest composer code-analysis
```

## Test release build

```shell name=test-create-release
docker compose build && docker compose run --rm php bin/create-release dev-test
```

## Deploy

The deploy script downloads a [release](https://github.com/ITK-Leantime/favorite-tasks/releases) from Github and unzips
it. The script should be passed a tag as argument. In the process the script deletes itself, but the script finishes
because it [is still in memory](https://linux.die.net/man/3/unlink).
