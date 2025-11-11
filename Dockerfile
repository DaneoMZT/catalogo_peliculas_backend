# Usamos PHP con Apache
FROM php:8.3-apache

# Variables de entorno para la raíz de Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Copiamos todos los archivos al contenedor
COPY . /var/www/html/

# Actualizamos la configuración de Apache para la nueva raíz
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/sites-available/*.conf && \
    sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permitir que Apache use index.html como página inicial
RUN echo "DirectoryIndex index.html index.php" >> /etc/apache2/mods-enabled/dir.conf

# Activar módulos de Apache necesarios (rewrite, headers)
RUN a2enmod rewrite headers

# Dar permisos correctos a los archivos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Exponemos el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
