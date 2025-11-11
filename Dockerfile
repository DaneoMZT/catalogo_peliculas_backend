# -----------------------------------------------------------
# 1️⃣ Imagen base: PHP con Apache
# -----------------------------------------------------------
FROM php:8.3-apache

# -----------------------------------------------------------
# 2️⃣ Configurar Apache: DocumentRoot a /var/www/html/public
# -----------------------------------------------------------
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "DirectoryIndex index.html index.php" >> /etc/apache2/apache2.conf

# -----------------------------------------------------------
# 3️⃣ Copiar todos los archivos del proyecto al contenedor
# -----------------------------------------------------------
COPY . /var/www/html/

# -----------------------------------------------------------
# 4️⃣ Permisos
# -----------------------------------------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# -----------------------------------------------------------
# 5️⃣ Instalar Node.js y Angular CLI para build dentro del contenedor
# -----------------------------------------------------------
RUN apt-get update && apt-get install -y curl unzip git \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g @angular/cli \
    && cd /var/www/html \
    && npm install \
    && ng build --output-path=public --base-href ./ \
    && rm -rf node_modules

# -----------------------------------------------------------
# 6️⃣ Exponer el puerto 80
# -----------------------------------------------------------
EXPOSE 80

# -----------------------------------------------------------
# 7️⃣ Comando por defecto para iniciar Apache
# -----------------------------------------------------------
CMD ["apache2-foreground"]
