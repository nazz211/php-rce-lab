FROM php:8.2-apache

LABEL maintainer="Educational Lab"
LABEL description="Intentionally vulnerable PHP lab for local cybersecurity education"

WORKDIR /var/www/html

COPY app/ /var/www/html/

RUN mkdir -p /var/www/html/uploads && chown -R www-data:www-data /var/www/html/uploads && chmod 755 /var/www/html/uploads

EXPOSE 80

CMD ["apache2-foreground"]
