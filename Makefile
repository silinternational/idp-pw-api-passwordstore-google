start: deps

clean:
	docker-compose kill
	docker system prune -f

deps:
	docker-compose run --rm cli composer install --no-scripts

depsupdate:
	docker-compose run --rm cli composer update --no-scripts

test: deps
	echo No tests yet
