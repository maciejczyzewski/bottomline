install-dev:
	./.install_composer.sh
	php composer.phar install

test:
	vendor/bin/phpunit --configuration phpunit.xml

bench:
	php bench.php

doc:
	php tools/phpDocGen.php && make cs-fix

CS_FIXER := vendor/bin/php-cs-fixer

cs-fix:
	php $(CS_FIXER) fix

cs-check:
	php $(CS_FIXER) fix --dry-run -v --diff
