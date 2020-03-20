#!/bin/bash

set -e

echo "####################"
echo "# INSTALL COMPOSER #"
echo "####################"
composer install
echo "####################"
echo "#      TESTS       #"
echo "####################"
./vendor/bin/phpunit || true
if [ -f ./report/phpunit.txt ]; then
  cat ./report/phpunit.txt
  rm -rf ./report
fi
echo "####################"
echo "#   CODE SNIFFER   #"
echo "####################"
./vendor/bin/phpcs -p || true
