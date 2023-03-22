#!/usr/bin/make
SHELL = /bin/sh

export USER_ID 	:= $(shell id -u)
export GROUP_ID := $(shell id -g)
export IMAGE 	 = cqrs-symfony-php-8.1:latest


.PHONY: build
build:
	docker-compose build --build-arg USER_ID=$(USER_ID)
	make dependencies

.PHONY: dependencies
dependencies:
	docker-compose run --rm cqrs-web-php composer install

.PHONY: start
start:
	docker-compose up -d

.PHONY: start
shell:
	docker exec -it cqrs-web-php sh

.PHONY: code-format
format-code:
	docker-compose run --rm cqrs-web-php composer run format:code

.PHONY: ping-postgres
ping-database:
	@docker exec cqrs-web-postgres bash -c "pg_isready -U postgres -d postgres"

.PHONY: test-unit
test-unit:
	docker-compose run --rm cqrs-web-php composer run test:unit

.PHONY: test-acceptance
test-acceptance:
	docker exec -t cqrs-web-php composer run test:acceptance
