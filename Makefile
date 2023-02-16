#!/usr/bin/make
SHELL = /bin/sh

export USER_ID 	:= $(shell id -u)
export GROUP_ID := $(shell id -g)
export IMAGE 	 = cqrs-symfony-php-8.1:latest


.PHONY: build
build:
	docker-compose build --build-arg USER_ID=$(USER_ID)

.PHONY: dependencies
dependencies:
	docker-compose run --rm cqrs-web-php composer install

.PHONY: start
start:
	docker-compose up

.PHONY: start
container:
	docker exec -it cqrs-web-php sh

