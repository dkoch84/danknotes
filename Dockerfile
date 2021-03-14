FROM php:8.0.3-apache-buster
RUN apt update && apt -y install git
EXPOSE 80
EXPOSE 443
EXPOSE 22
COPY danknotes/ssh/id_rsa /root/.ssh/id_rsa
RUN chmod 600 /root/.ssh/id_rsa
COPY danknotes/ssh/known_hosts /root/.ssh/known_hosts
COPY danknotes/apache/apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/