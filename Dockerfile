FROM php:8.1-cli

RUN apt-get update && apt-get install -y locales \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen

ENV LC_ALL=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US.UTF-8

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY . /var/www/html

EXPOSE 8000

CMD [ "php", "-S", "0.0.0.0:8000" ]
