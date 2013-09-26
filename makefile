test:
	@./vendor/bin/phpunit

cs:
	@./vendor/bin/phpcs --standard=PSR2 --extensions=php src/

.PHONY: test cs
