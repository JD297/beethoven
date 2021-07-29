# beethoven

[![Minimum PHP Version](https://img.shields.io/badge/php-7.4-8892bf.svg)](https://php.net/)
[![License](https://img.shields.io/github/license/jd297/beethoven.svg)](https://github.com/JD297/beethoven/blob/master/LICENSE.md)
![Lastcommit](https://img.shields.io/github/last-commit/jd297/beethoven.svg)
![Total lines](https://img.shields.io/tokei/lines/github/jd297/beethoven)

## Setup and install

To set up the environment and install with a basic setup run the following commands:

``` bash
# clone the newest version from github
$ git clone https://github.com/JD297/beethoven beethoven
$ cd beethoven

# install beethoven and dependencies according to the composer.lock
$ composer install

# setup env
$ bin/console beethoven:setup-env

# create databse
$ bin/console beethoven:install

# compile frontend styles
$ bin/build-frontend.sh
```

## Load DemoFixtures (optional)

If you want a quick overview over beethoven then start with the demo fixtures:

``` bash
# load demo fixtures
$ bin/console doctrine:fixtures:load
```

## Development

### PHP-CS-Fixer

The PHP Coding Standards Fixer helps you to follow coding standards. This helps keeping the code base clean and nice. Before you create a pull request, it is required to run this tool and commit or amend the changes.

```bash
# Check the changes made by php-cs-fixer without changing anything
$ vendor/bin/php-cs-fixer fix --diff --dry-run

# Fix files according to the .php-cs-fixer.dist.php
$ vendor/bin/php-cs-fixer fix
```

## License
Beethoven is completely free and released under the [BSD-2-Clause License](LICENSE.md).
