FROM php:fpm
LABEL authors="Mitesh Shah Mr.Miteshah@gmail.com"

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Install WPCLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp
