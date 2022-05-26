run:
	docker-compose up -d

	docker-compose exec php supervisord -c /etc/supervisord.conf

install-webapp: run
	docker-compose exec php composer install
	docker-compose exec php php artisan key:generate

db-backup:
	scripts/backup.sh

e-web:
	docker-compose exec php bash

test:
	docker-compose exec php ./vendor/bin/phpunit

clear:
	docker-compose exec php php artisan config:clear
	docker-compose exec php php artisan route:clear
	docker-compose exec php php artisan cache:clear

optimize:
	docker-compose exec php php artisan optimize

deploy:
	docker-compose exec php php artisan down
	git pull origin master
	docker-compose exec php php artisan migrate
	make clear
	docker-compose exec php php artisan up

format:
	docker-compose exec php php artisan ide-helper:model -q
	docker-compose exec php php artisan ide-helper:eloquent -q
	docker-compose exec php php artisan ide-helper:meta -q
	docker-compose exec php php artisan ide-helper:generate -q


elastic-reindex:
	docker-compose exec php php artisan elastic:create-index "App\Modules\Products\Services\ProductIndexConfigurator"
	docker-compose exec php php artisan elastic:update-mapping "\App\Modules\Products\Models\Product"
	docker-compose exec php php artisan scout:import "\App\Modules\Products\Models\Product"

swagger-generate:
	docker-compose exec php php artisan l5-swagger:generate
