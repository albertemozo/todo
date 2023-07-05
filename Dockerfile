FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_pgsql \
