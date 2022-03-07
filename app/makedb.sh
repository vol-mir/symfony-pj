php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:drop --force --full-database
php bin/console doctrine:migration:diff
php bin/console doctrine:migration:migrate