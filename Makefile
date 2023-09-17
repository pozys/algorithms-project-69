lint:
	composer exec --verbose phpcs -- --standard=PSR12 src tests
	composer exec --verbose phpstan
	
lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src tests
	
test:
	composer exec --verbose phpunit tests