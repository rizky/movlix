FROM php:7.0-apache
RUN docker-php-ext-install mysqli

# docker build -t piscine_php_rush00 .
# docker push piscine_php_rush00