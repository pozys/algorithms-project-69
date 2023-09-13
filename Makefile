lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests
	composer exec --verbose phpstan
	
test:
	composer exec --verbose phpunit tests