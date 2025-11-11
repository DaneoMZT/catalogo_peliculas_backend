# Imagen base: PHP + Apache
FROM php:8.2-apache

# Instalar extensiones MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar todo el contenido del proyecto
COPY . /var/www/html/

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto web
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]

