# Run PHP-CS
docker-compose exec php vendor/bin/phpcs

# Run Static analysis
docker-compose exec php vendor/bin/phpstan

# Run PHPUnit
docker-compose exec php vendor/bin/phpunit
