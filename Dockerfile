FROM php:8.3-fpm-alpine

# Install necessary PHP extensions for WordPress
RUN apk update && apk add --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
		git \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
    && docker-php-ext-install -j${NPROC} gd mysqli pdo pdo_mysql zip

WORKDIR /var/www/html

COPY . .


RUN set -ex; \
	\
        cd /tmp && \
	curl -LO https://github.com/humanmade/S3-Uploads/releases/download/3.0.7/manual-install.zip && \
	apk add unzip && \
	mkdir -p /var/www/html/wp-content/plugins/s3-uploads && \
	unzip manual-install.zip -d /var/www/html/wp-content/plugins/s3-uploads && \
	rm -vf manual-install.zip

RUN chown -R www-data:www-data /var/www/html


# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
