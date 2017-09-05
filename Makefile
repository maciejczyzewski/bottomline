install-dev:
	./.install_composer.sh
	php composer.phar install

test:
	vendor/bin/phpunit --configuration phpunit.xml
