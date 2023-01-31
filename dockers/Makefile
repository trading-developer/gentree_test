init: up composer_install
up:
	docker-compose up -d
composer_install:
	docker-compose run --rm app-php-gentree composer install
recreate-php:
	docker-compose up -d --force-recreate --no-deps --build app-php-gentree
gophp:
	docker-compose exec app-php-gentree bash
tests:
	docker-compose run app-php-gentree ./vendor/bin/phpunit tests
