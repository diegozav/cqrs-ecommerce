#!/bin/sh
set -e

git clone --depth 1 --branch master https://github.com/xdebug/xdebug.git
cd xdebug
phpize
./configure
make
make install
