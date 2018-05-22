install-dev:
	./.install_composer.sh
	php composer.phar install --ignore-platform-reqs

test:
	vendor/bin/phpunit --configuration phpunit.xml

bench:
	php bench.php
