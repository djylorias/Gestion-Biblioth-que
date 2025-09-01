.PHONY: install start database

.DEFAULT_GOAL: start

vendor: composer.json
	composer install

composer.lock: composer.json
	composer update

install: vendor composer.lock

create-database:
	php bin/console doctrine:database:create

generate-migrations:
	php bin/console make:migration --no-interaction

generate-tables:
	php bin/console doctrine:migrations:migrate --no-interaction

generate-fixtures:
	php bin/console doctrine:fixtures:load --no-interaction

start: install create-database
	php -S localhost:8000 -t public

symfony-version:
	php bin/console --version

database: create-database generate-migrations generate-tables generate-fixtures