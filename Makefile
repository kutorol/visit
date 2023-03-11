PROJECT_NAME:="visit"
TAG:="local-visit"
APP_URL:="visit.com"
APP_URL_HTTPS:="https://${APP_URL}"

CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

SHORT_COMPOSE := && cd build/docker && docker-compose -f docker-compose.yml -f docker-compose.dev.yml
VARIABLES:= export CURRENT_UID=$(CURRENT_UID) APP_URL=$(APP_URL) APP_URL_HTTPS=$(APP_URL_HTTPS) CURRENT_GID=$(CURRENT_GID) COMPOSE_PROJECT_NAME=$(PROJECT_NAME) TAG=$(TAG)
COMPOSE:=$(VARIABLES) $(SHORT_COMPOSE)

# Шаг 1. Собирает образ
build-app:
	$(COMPOSE) build

# Шаг 2. Поднимает контейнер с nginx и после запускаем composer обновление
up:
	$(COMPOSE) up -d nginx
	$(COMPOSE) up composer

# Шаг 3. Устанавливаем нужные зависимости для авторизации
.PHONY: init
init:
	make install-passport
	make install-passport-keys
	make install-js

# Шаг 3. Выключает все контейнеры
down:
	$(COMPOSE) down

install-js:
	$(COMPOSE) up node

.PHONY: install-passport
install-passport:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash php -c "php artisan passport:install"

.PHONY: install-passport-keys
install-passport-keys:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash php -c "php artisan passport:keys --force"

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

# Смотрим все запущенные контейнеры в docker-compose
ps:
	$(COMPOSE) ps

# Вход в контейнер с php
php:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash php

# Вход в контейнер с composer
composer:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash composer

node:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash node
# Вход в контейнер с nginx
nginx:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash nginx

# Подготавливает файлы и проверяет их на ошибки линтером
prepare:
	make larastan
	make fix-ide-helper
	make fix-cs

# Запускает проверку на ошибки
larastan:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash composer -c "php /var/www/vendor/bin/phpstan analyse --memory-limit 500M"

# Делает форматирование кода
fix-cs:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash composer -c "php artisan php-cs-fixer:fix --verbose --config .php_cs.laravel.php"

# Добавляет/обновляет файл для работы с Laravel в IDE
fix-ide-helper:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash php -c "php artisan ide-helper:generate"
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash php -c "php artisan ide-helper:meta"
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash php -c "php artisan ide-helper:models -W"

# Применение миграции
migrate:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash php -c "php artisan migrate"

# Скачивание и добавление сертификата с ssl доступом
ssl-cert-macos:
	brew install mkcert && \
	 mkcert -install && \
	 mkcert -key-file key.pem -cert-file cert.pem $(APP_URL)
