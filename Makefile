PROJECT_NAME:="visit"
TAG:="local-visit"

CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

SHORT_COMPOSE := && cd build/docker && docker-compose -f docker-compose.yml
VARIABLES:= export CURRENT_UID=$(CURRENT_UID) CURRENT_GID=$(CURRENT_GID) COMPOSE_PROJECT_NAME=$(PROJECT_NAME) TAG=$(TAG)
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

# Смотрим все запущенные контейнеры в docker-compose
ps:
	$(COMPOSE) ps

# Поднимает все сервисы
up:
	make up-db
	make up-http

# Собирает образ
build-php:
	$(COMPOSE) build

# Поднимает контейнер с nginx
up-http:
	$(COMPOSE) up -d http

# Поднимает контейнер с бд
up-db:
	$(COMPOSE) up -d db

# Выключает все контейнеры
down:
	$(COMPOSE) down

# Вход в контейнер с php
app:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app
.PHONY: app

# Подготавливает файлы и проверяет их на ошибки линтером
prepare:
	make larastan
	make fix-ide-helper
	make fix-cs

# Запускает проверку на ошибки
larastan:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php /var/www/vendor/bin/phpstan analyse --memory-limit 500M"

# Делает форматирование кода
fix-cs:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan php-cs-fixer:fix --verbose --config .php_cs.laravel.php"

# Добавляет/обновляет файл для работы с Laravel в IDE
fix-ide-helper:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan ide-helper:generate"
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan ide-helper:meta"
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan ide-helper:models -W"

# Применение миграции
migrate:
	$(COMPOSE) run --rm -u $(CURRENT_UID) --entrypoint bash app -c "php artisan migrate"

# Скачивание и добавление сертификата с ssl доступом
ssl-cert-macos:
	brew install mkcert && \
	 mkcert -install && \
	 mkcert -key-file key.pem -cert-file cert.pem localhost
