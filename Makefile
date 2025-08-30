.PHONY: install start

vendor: composer.json
	composer install

composer.lock: composer.json
	composer update

install: vendor composer.lock

start: install
	php -S localhost:8000 -t public

symfony-version:
	php bin/console --version