#!/bin/sh

php /project/phpcs.par --config-set default-standard PSR2
php /project/phpcs.phar /project/pirogue
