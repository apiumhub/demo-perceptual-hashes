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