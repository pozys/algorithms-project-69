lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests
	
test:
	composer exec --verbose phpunit tests