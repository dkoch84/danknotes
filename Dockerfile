FROM php:8.0.3-apache-buster AS base
EXPOSE 80
EXPOSE 443
COPY . /var/www/html
COPY danknotes/apache/apache.conf /etc/apache2/sites-available/000-default.conf
RUN apt update && apt -y install git