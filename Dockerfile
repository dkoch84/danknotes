FROM php:8.0.3-apache-buster
EXPOSE 80
EXPOSE 443
COPY danknotes/apache/apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/