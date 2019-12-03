.PHONY: shell start stop test build create-network

PROJECT_NAME=product-manager
ENV_FILE=$(CURDIR)/env/.env.develop
NETWORK=develop-network

shell:
	docker run --rm -it -v $(CURDIR)/app:/application -p 8080:8080 --env-file=$(ENV_FILE) --network=$(NETWORK) $(PROJECT_NAME) sh

start:
	docker run --rm --name $(PROJECT_NAME) --hostname=$(PROJECT_NAME) --env-file=$(ENV_FILE) --network=$(NETWORK) -d -p 8080:8080 $(PROJECT_NAME) composer start

stop:
	docker stop $(PROJECT_NAME)

test:
	docker run --rm -it -v $(CURDIR)/app:/application $(PROJECT_NAME) /application/vendor/bin/phpunit

build:
	docker build -t $(PROJECT_NAME) $(CURDIR)

create-network:
	docker network create $(NETWORK)

start-postgres:
	docker run -it --rm -d --network=$(NETWORK) --name=$(PROJECT_NAME)-postgres --hostname=$(PROJECT_NAME)-postgres postgres:12.1

stop-postgres:
	docker stop $(PROJECT_NAME)-postgres
