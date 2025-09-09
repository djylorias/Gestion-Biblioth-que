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
	mkdir -p ./migrations
	php bin/console make:migration

generate-tables:
	php bin/console doctrine:migrations:migrate --no-interaction

generate-fixtures:
	php bin/console doctrine:fixtures:load --no-interaction

start: install database
	php -S localhost:8000 -t public

start-dev: install database-dev
	php -S localhost:8000 -t public -d variables_order=EGPCS

symfony-version:
	php bin/console --version

database-dev: create-database generate-migrations generate-tables generate-fixtures

database: create-database generate-tables