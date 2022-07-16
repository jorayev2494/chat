.DEFAULT_GOAL := help

COMPOSE_FILE_PATH := ./docker/docker-compose.yml

init:
	@make init_project && $make init_docker

init_project:
	@cp .env.example .env

init_docker:
	@cp ./docker/.env.example ./docker/.env

install:
	@make -s init

up:		## Up project
	@docker-compose --file $(COMPOSE_FILE_PATH) up --build -d

down:		## Down project
	docker-compose --file $(COMPOSE_FILE_PATH) down

restart:	## Restart project
	@docker-compose --file $(COMPOSE_FILE_PATH) restart

bash:	## Project bash terminal
	@docker-compose --file $(COMPOSE_FILE_PATH) exec php-fpm bash

ps:		## Show project process
	@docker-compose --file $(COMPOSE_FILE_PATH) ps

cc:		## Clear cache
	@docker-compose --file $(COMPOSE_FILE_PATH) exec php-fpm ./artisan optimize:clear
 
vendor_install:		## Vendor install
	@docker-compose --file $(COMPOSE_FILE_PATH) exec php-fpm composer install --ignore-platform-reqs

nginxLogs:		## Logs Nginx
	@docker-compose --file $(COMPOSE_FILE_PATH) logs -f nginx

nginxRestart:	## Restart Nginx
	@docker-compose --file $(COMPOSE_FILE_PATH) restart nginx

wsLogs:		## Logs web-socket
	@docker-compose --file $(COMPOSE_FILE_PATH) logs -f web-socket

wsRestart:	## Restart web-socket
	@docker-compose --file $(COMPOSE_FILE_PATH) restart web-socket

rabbitMQLogs:
	@docker-compose --file $(COMPOSE_FILE_PATH) logs -f rabbitmq

rabbitMQRestart:
	@docker-compose --file $(COMPOSE_FILE_PATH) restart rabbitmq

migrate:		## Migrate
	@docker-compose --file $(COMPOSE_FILE_PATH) exec php-fpm ./artisan migrate

migrateSeed:		## Migrate Seed
	@docker-compose --file $(COMPOSE_FILE_PATH) exec php-fpm ./artisan migrate:fresh --seed

.PHONY: help
help:	## Show Project commands
	@#echo ${Cyan}"\t\t This project 'job' REST API Server!"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo ${Red}"----------------------------------------------------------------------"
