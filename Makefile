.DEFAULT_GOAL := help

SERVICE_NAME = php-fpm

ifneq (,$(findstring xterm,${TERM}))
	YELLOW  := $(shell tput -Txterm setaf 3)
	RESET   := $(shell tput -Txterm sgr0)
else
	YELLOW  := ""
	RESET   := ""
endif

TARGET_COLOR := $(YELLOW)

# DOCKER-RELATED COMMANDS

up: ## Starts the service
	@docker-compose up --remove-orphans -d
	@docker-compose exec ${SERVICE_NAME} composer update

down: ## Stops the service
	@docker-compose down

build: ## Builds the service
	@docker-compose build

restart: ## Restarts the service
	@docker-compose restart ${SERVICE_NAME}

logs: ## Exposes logs from service
	@docker-compose logs ${SERVICE_NAME}

bash: ## Opens a Bash terminal with main service
	@docker-compose exec ${SERVICE_NAME} bash

# QA

phpcs: ## Runs the PHPCodeSniffer tool
	@docker-compose exec ${SERVICE_NAME} bash -c "./vendor/bin/phpcs --standard=PSR12 ./app ./tests"

phpcbf: ## Runs the PHPCodeBeautifierAndFixer tool
	@docker-compose exec ${SERVICE_NAME} bash -c "./vendor/bin/phpcbf --standard=PSR12 ./app ./tests"

phpstan: ## Runs the PHPStan tool
	@docker-compose exec ${SERVICE_NAME} bash -c "./vendor/bin/phpstan analyse --level 5 --memory-limit 1G ./app ./tests"

# TESTING

phpunit: ## Runs the PHPUnit test suite
	@docker-compose exec ${SERVICE_NAME} bash -c "./vendor/bin/phpunit"

paratest: ## Runs the PHPUnit test suite in parallel
	@docker-compose exec ${SERVICE_NAME} bash -c "./vendor/bin/paratest --parallel-suite --processes=8"

# MISCELANEOUS

help:
	@clear
	@echo "╔══════════════════════════════════════════════════════════════════════════════╗"
	@echo "║                                                                              ║"
	@echo "║                           ${TARGET_COLOR}.:${RESET} AVAILABLE COMMANDS ${TARGET_COLOR}:.${RESET}                           ║"
	@echo "║                                                                              ║"
	@echo "╚══════════════════════════════════════════════════════════════════════════════╝"
	@echo ""
	@grep -E '^[a-zA-Z_0-9%-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "· ${TARGET_COLOR}%-30s${RESET} %s\n", $$1, $$2}'
	@echo ""