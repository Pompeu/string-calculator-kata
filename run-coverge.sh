#!/bin/bash

vendor/bin/phpunit --coverage-html coverge \
&& sensible-browser coverge/index.html 
