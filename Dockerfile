FROM php:8.2-apache

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto para o container
# Nota: Para desenvolvimento, o docker-compose sobrescreverá isso com um volume
COPY . /var/www/html/

# Ajustar permissões para o servidor web
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expor a porta 80
EXPOSE 80
