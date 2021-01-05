include .env

help: 	 		## Show this help.
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

build: 		 	## Build all docker containers.
	@docker-compose -f ./docker-compose.yaml build --no-cache

up: 	 		## Up all docker containers.
	@docker-compose -f ./docker-compose.yaml up -d

down: 	 		## Down all docker containers.
	@docker-compose -f ./docker-compose.yaml down

refresh:  		## Put down, rebuild and up all docker containers.
	@bash ./.docker/scripts/refresh.sh

in: 	        	## Show user a list of avaliable docker containers to go inside like root.
	@bash ./.docker/scripts/in.sh

composer-install:	## Install composer in php container.
	@bash ./.docker/scripts/composer-install.sh

composer-dump:		## Run composer dump in php container.
	@bash ./.docker/scripts/composer-dump.sh

refresh-db:   		## Drop all tables, re-run migrations and re-seed in php container.
	@bash ./.docker/scripts/refresh-db.sh

permissions:   		## Run permissions in some directories
	@bash ./.docker/scripts/permissions.sh
