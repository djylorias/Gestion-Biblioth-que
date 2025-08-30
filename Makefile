.PHONY: install start create-database

.DEFAULT_GOAL: start

vendor: composer.json
	composer install

composer.lock: composer.json
	composer update

install: vendor composer.lock

create-database:
	php bin/console doctrine:database:create

start: install create-database
	php -S localhost:8000 -t public

symfony-version:
	php bin/console --version