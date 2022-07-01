.DEFAULT_GOAL := help

# CONSTANTS - COLORS

ifneq (,$(findstring xterm,${TERM}))
	YELLOW  := $(shell tput -Txterm setaf 3)
	RESET   := $(shell tput -Txterm sgr0)
else
	YELLOW  := ""
	RESET   := ""
endif

# CONSTANTS - SERVICE

SERVICE_NAME 		= php-fpm

DOCKER_COMPOSE 		= @docker-compose
DOCKER_COMPOSE_EXEC = ${DOCKER_COMPOSE} exec ${SERVICE_NAME}

# DOCKER-RELATED COMMANDS

build: CMD=build 						## Builds the service
down: CMD=down 							## Stops the service
logs: CMD=logs ${SERVICE_NAME} 			## Exposes the service logs
restart: CMD=restart ${SERVICE_NAME} 	## Restarts the service
up: CMD=up --remove-orphans -d 			## Starts the service
bash: CMD=bash 							## Opens a Bash terminal with main service

build down logs restart up:
	${DOCKER_COMPOSE} ${CMD}

# COMPOSER-RELATED COMMANDS

composer-install: CMD=composer install --optimize-autoloader							## Runs <composer install>
composer-update: CMD=composer update --optimize-autoloader --with-all-dependencies		## Runs <composer update>
composer-require: CMD=composer require --optimize-autoloader --with-all-dependencies	## Runs <composer require>
composer-remove: CMD=composer remove --optimize-autoloader --with-all-dependencies		## Runs <composer remove>
composer-dump: CMD=composer dump-auto --optimize 										## Runs <composer dump-auto>

composer-install composer-update composer-require composer-remove composer-dump:
	${DOCKER_COMPOSE_EXEC} ${CMD} --ignore-platform-reqs --no-scripts --no-plugins --ansi --profile

# ADDITIONAL COMMANDS

qa-linter: CMD=./vendor/bin/parallel-lint -e php -j 10 --colors ./app ./tests
qa-phpcbf: CMD=./vendor/bin/phpcbf --standard=PSR12 ./app ./tests
qa-phpcs: CMD=./vendor/bin/phpcs --standard=PSR12 ./app ./tests
qa-phpstan: CMD=./vendor/bin/phpstan analyse --level 5 --memory-limit 1G ./app ./tests
qa-phpcsfixer: CMD=./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php
tests-phpunit: CMD=./vendor/bin/phpunit --coverage-text --coverage-xml=./coverage/xml --coverage-html=./coverage/html --log-junit=./coverage/junit.xml
tests-paratest: CMD=./vendor/bin/paratest --parallel-suite --processes=8
tests-infection: CMD=./vendor/bin/infection --threads=4 --coverage=./coverage
metrics-phpmetrics: CMD=./vendor/bin/phpmetrics --junit=./coverage/junit.xml --report-html=./metrics ./app

bash qa-linter qa-phpcbf qa-phpcs qa-phpstan qa-phpcsfixer tests-phpunit tests-paratest tests-infection metrics-phpmetrics:
	${DOCKER_COMPOSE_EXEC} ${CMD}

# SHORTCUTS

qa: qa-linter qa-phpcs qa-phpcbf qa-phpcsfixer qa-phpstan ## Checks the source code
tests: tests-phpunit tests-infection ## Runs the Tests Suites
metrics: metrics-phpmetrics ## Generates a report with some metrics

# HELP

help:
	@clear
	@echo "╔══════════════════════════════════════════════════════════════════════════════╗"
	@echo "║                                                                              ║"
	@echo "║                           ${YELLOW}.:${RESET} AVAILABLE COMMANDS ${YELLOW}:.${RESET}                           ║"
	@echo "║                                                                              ║"
	@echo "╚══════════════════════════════════════════════════════════════════════════════╝"
	@echo ""
	@grep -E '^[a-zA-Z_0-9%-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "· ${YELLOW}%-30s${RESET} %s\n", $$1, $$2}'
	@echo ""