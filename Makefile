start:
	php -S localhost:8000 -t public/

install:
	composer install

migrate:
	composer exec doctrine orm:schema-tool:update -- --dump-sql
