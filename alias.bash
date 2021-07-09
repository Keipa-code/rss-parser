################################################################################
################################################################################

# PROXIES (to Docker-containers commands)
alias php="docker-compose run --rm php-cli"
alias node-cli="docker-compose run --rm frontend-node-cli"
alias composer="docker-compose run --rm php-cli composer"
alias app="docker-compose run --rm php-cli php bin/app.php --ansi --no-interaction"
alias linter="docker-compose run --rm php-cli composer lint"
alias test-e2e="api-fixtures && cucumber-clear && cucumber-e2e"
alias api-test="docker-compose run --rm php-cli composer test"

# Symfony
alias console="docker-compose run --rm php-fpm php ./bin/console"
}