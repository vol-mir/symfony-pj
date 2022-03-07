FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev g++ curl git zip unzip netcat libxml2-dev libpq-dev libzip-dev libicu-dev && \
    pecl install apcu && \
    docker-php-ext-configure zip && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo pdo_mysql pdo_pgsql pgsql && \
    docker-php-ext-enable apcu pdo_pgsql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# RUN docker exec -it php74-container bin/console doctrine:database:create --if-not-exists
# RUN php /var/www/app/bin/console doctrine:database:create --if-not-exists --no-interaction;
# RUN php /var/www/app/bin/console doctrine:migrations:migrate --no-interaction;
# CMD composer i -o ; wait-for-it db:5432 -- bin/console doctrine:migrations:migrate ;  php-fpm 
