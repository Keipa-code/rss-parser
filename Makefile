init: docker-down-clear \
	docker-pull docker-build docker-up \
	api-init

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-build:
	docker-compose build --pull

docker-rebuild: docker-build docker-down docker-up

docker-restart: docker-down docker-up

docker-pull:
	docker-compose pull

docker-down-clear:
	docker-compose down -v --remove-orphans

api-init: api-composer-install api-wait-db api-migrations

api-clear:
	docker run --rm -v ${PWD}/api://var/www -w /var/www alpine sh -c 'rm -rf var/log/cli/* var/log/fpm-fcgi/* var/cache/* var/upload/* var/thumbs/*'

api-composer-install:
	docker-compose run --rm php-cli composer install

api-wait-db:
	docker-compose run --rm php-cli wait-for-it postgres:5432 -t 30

api-migrations:
	docker-compose run --rm php-cli ./bin/console migrations:migrate -- --no-interaction
