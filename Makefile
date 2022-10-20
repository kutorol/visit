PROJECT_NAME:="visit"
PORT_NUMBER_MODIFIER:=5
#SHELL := /bin/bash
TAG:="local-visit"


CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

##### PORTS ######
REDIS_PORT:=$(shell echo ${PORT_NUMBER_MODIFIER}+6379 | bc)
### END PORTS ####

SHORT_COMPOSE := && cd build/docker && docker-compose -f docker-compose.yml
VARIABLES:= export REDIS_PORT=$(REDIS_PORT) CURRENT_UID=$(CURRENT_UID) CURRENT_GID=$(CURRENT_GID) COMPOSE_PROJECT_NAME=$(PROJECT_NAME) TAG=$(TAG)
COMPOSE:=$(VARIABLES) $(SHORT_COMPOSE)

up2:
	cd ../l.com && make down
	cd ../goods && docker-compose down
	cd ../admin-2.0 && make down
	cd ../traefik.com && make down
	make up
	docker run -v jiraVolume:/var/atlassian/application-data/jira --name="jira" -d -p 8080:8080 atlassian/jira-software
	@echo "http://localhost:8080"

down2:
	make down
	docker stop jira && docker rm jira
	cd ../traefik.com && make up-mac
	cd ../l.com && make up
	cd ../goods && make first
	cd ../admin-2.0 && make up

ps:
	$(COMPOSE) ps

up:
	make up-db
	make up-http


build-php:
	$(COMPOSE) build

up-http:
	$(COMPOSE) up -d http

up-db:
	$(COMPOSE) up -d db

down:
	$(COMPOSE) down

app:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app
.PHONY: app

prepare:
	make larastan
	make fix-ide-helper
	make fix-cs

larastan:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php /var/www/vendor/bin/phpstan analyse"

fix-cs:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan php-cs-fixer:fix --verbose --config .php_cs.laravel.php"

fix-ide-helper:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan ide-helper:generate"
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan ide-helper:meta"
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan ide-helper:models -W"

migrate:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan migrate"
