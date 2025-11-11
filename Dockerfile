# -----------------------------
# Dockerfile para Angular + PHP
# -----------------------------

# 1️⃣ Usamos PHP 8.3 con Apache
FROM php:8.3-apache

# 2️⃣ Definimos la raíz del servidor Apache al build de Angular
ENV APACHE_DOCUMENT_ROOT /var/www/html/public/browser

# 3️⃣ Copiamos todos los archivos del proyecto al contenedor
COPY . /var/www/html/

# 4️⃣ Actualizamos la configuración de Apache para la nueva raíz
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/sites-available/*.conf && \
    sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" \
    /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5️⃣ Permitimos que Apache use index.html y index.php como páginas iniciales
RUN echo "DirectoryIndex index.html index.php" >> /etc/apache2/mods-enabled/dir.conf

# 6️⃣ Activamos módulos de Apache necesarios (rewrite para Angular routing, headers)
RUN a2enmod rewrite headers

# 7️⃣ Agregamos archivo .htaccess para Angular routing
RUN echo 'RewriteEngine On\nRewriteBase /\nRewriteRule ^index\.html$ - [L]\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule . /index.html [L]' \
    > /var/www/html/public/browser/.htaccess

# 8️⃣ Asignamos permisos correctos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# 9️⃣ Exponemos el puerto 80
EXPOSE 80

# 🔟 Comando para iniciar Apache en primer plano
CMD ["apache2-foreground"]
