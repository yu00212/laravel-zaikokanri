FROM php:7.4-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

# RUN apt-get update && \
#   apt-get -y install git unzip libzip-dev libicu-dev libonig-dev && \
#   apt-get clean && \
#   rm -rf /var/lib/apt/lists/* && \
#   docker-php-ext-install intl pdo_mysql zip bcmath

RUN apt-get update && \
  apt-get -y install git unzip libzip-dev libicu-dev libonig-dev \
  zlib1g-dev \ 
  libjpeg-dev \
  libpng-dev \
  libfreetype6-dev \
  libjpeg62-turbo-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql zip bcmath
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd 
RUN pwd

COPY ./php.ini /usr/local/etc/php/php.ini
RUN pwd

RUN mkdir /root/.ssh
COPY .ssh/ /root/.ssh/
RUN pwd

WORKDIR /var/www/html
RUN curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
RUN unzip awscliv2.zip
RUN ./aws/install
RUN pwd

WORKDIR /work
