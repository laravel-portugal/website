install:
	cp .env.example .env
	composer install --no-interaction
	php artisan key:generate
	npm install
	npm run dev
	php artisan storage:link

start:
	docker-compose up

migrate:
	php artisan migrate --no-interaction --force

mfs:
	php artisan migrate:fresh --seed --no-interaction --force

docs:
	php artisan ide-helper:generate
	php artisan ide-helper:meta
	php artisan ide-helper:models -M

cache:
	rm -rf ./storage/logs/*.log
	rm -rf ./bootstrap/cache/*.php
	php artisan view:clear
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan event:clear
	php artisan storage:link

reset:
	php artisan migrate:fresh
	php artisan db:seed
	make docs
	make cache

test:
	php -v
	which php
	php --ini

expose:
	expose share https://laravelpt.localhost --subdomain=laravelpt
