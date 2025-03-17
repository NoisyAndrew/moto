#!/usr/bin/env bash

PHP_HOME=$(git rev-parse --show-toplevel) bash -c 'php -S localhost:8080 -c php.ini -t ${PHP_HOME}/public'