start:
	php -S localhost:8000 -t public/

install:
	composer install

prepare-db:
	rm database/db.sqlite
	composer exec doctrine orm:schema-tool:create

migrate:
	composer exec doctrine orm:schema-tool:update -- --dump-sql

migrate-fresh: prepare-db migrate