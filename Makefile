install:
	cp .env.example .env
	docker-compose build
	docker-compose run --rm app composer install --no-interaction
	docker-compose run --rm app php artisan key:generate
	docker-compose run --rm app npm install
	docker-compose run --rm app npm run dev
	docker-compose run --rm app php artisan storage:link

start:
	docker-compose up

migrate:
	docker-compose exec app php artisan migrate --no-interaction --force

mfs:
	docker-compose exec app php artisan migrate:fresh --seed --no-interaction --force

docs:
	docker-compose exec app php artisan ide-helper:generate
	docker-compose exec app php artisan ide-helper:meta
	docker-compose exec app php artisan ide-helper:models -M

cache:
	rm -rf ./storage/logs/*.log
	rm -rf ./bootstrap/cache/*.php
	docker-compose exec app php artisan view:clear
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan event:clear
	docker-compose exec app php artisan storage:link

reset:
	docker-compose exec app php artisan migrate:fresh
	docker-compose exec app php artisan db:seed
	make docs
	make cache

test:
	docker-compose exec app php -v
	which php
	docker-compose exec app php --ini

expose:
	expose share https://laravelpt.localhost --subdomain=laravelpt

render-start:
	node public/js/start.js

