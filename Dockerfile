FROM php:8.1-fpm-alpine

USER root


# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install dependencies
RUN apk update && \
        apk add bash build-base gcc wget git autoconf libmcrypt-dev \
        g++ make openssl-dev \
        php81-openssl \
        php81-pdo_mysql \
        php81-mbstring

 RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Add user for laravel application
ARG USER_UID=1000
ARG GROUP_GID=1000
ARG UGNAME=www
RUN if getent passwd ${USER_UID} >/dev/null; then \
    deluser $(getent passwd ${USER_UID} | cut -d: -f1); fi

RUN if getent group ${GROUP_GID} >/dev/null; then \
    delgroup $(getent group ${GROUP_GID} | cut -d: -f1); fi

RUN addgroup --system --gid ${GROUP_GID} ${UGNAME}

RUN adduser --system --disabled-password --home /home/${UGNAME} \
    --uid ${USER_UID} --ingroup ${UGNAME} ${UGNAME}


# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

