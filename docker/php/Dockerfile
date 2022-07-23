FROM php:8.1-fpm

# create user
RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel laravel

WORKDIR /var/project

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y vim \
    # Extensions
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install zip \
    && docker-php-ext-install gd \
    && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable pgsql \
    # install
    && apt-get -y install imagemagick php8.1-imagick php8.1-pcntl php8.1-gd php8.1-pgsql php8.1-sqlite nano php8.1-redis php-bcmath php8.1-zmq, pdo_pgsql php8.1-pgsql pdo \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
#    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.idekey=VSCODE" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && echo "xdebug.log=/var/www/html/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
#    && touch /var/www/html/xdebug.log \
#    && chown developer:www-data /var/www/html/xdebug.log \
#    && chmod 775 /var/www/html/xdebug.log


#RUN docker-php-ext-enable xdebug

# Install Postgre PDO
#RUN #apt-get install -y libpq-dev \
#    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# install Postgres
#RUN apt-get install -y libpq-dev \
#    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install MySQLi
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install PDO
# RUN docker-php-ext-install pdo_mysql
# RUN docker-php-ext-install pdo pdo_pgsql

# Composer installing
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer


COPY ./php.ini /usr/local/etc/php/conf.d/php.ini
RUN mkdir "/var/project/storage" && chown -R laravel:laravel /var/project/storage

