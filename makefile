COVERAGE=

test:
	@./vendor/bin/phpunit $(COVERAGE)

cs:
	@./vendor/bin/phpcs --standard=PSR2 --extensions=php src/

.PHONY: test cs
