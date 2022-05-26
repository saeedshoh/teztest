FROM php:7.4-fpm

MAINTAINER Mehrubon Khusaynov <husaynov888@gmail.com>
ENV APP_ROOT=/var/www/html QUEUE_DRIVER=redis NUM_PROCS=4

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    supervisor \
    curl

# Install extensions
RUN docker-php-ext-install \
    tokenizer \
    pdo_mysql \
    pcntl \
    gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


ADD supervisord.conf /etc/


#COPY crontab /var/spool/cron/crontabs/
#RUN cat /var/spool/cron/crontabs/crontab >> /var/spool/cron/crontabs/root
#RUN mkdir -p /var/log/cron \
# && touch /var/log/cron/cron.log

#VOLUME /var/log/cron

EXPOSE 9000
CMD ["php-fpm"]