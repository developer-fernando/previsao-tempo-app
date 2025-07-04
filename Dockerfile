# Imagem com Apache + PHP 8.2
FROM php:8.2-apache

# Ativa mod_rewrite (necessário para .htaccess funcionar)
RUN a2enmod rewrite

# Copia apenas o conteúdo da pasta public para o diretório raiz do Apache
COPY public/ /var/www/html/

# Copia o restante do projeto (src/, vendor/, etc)
COPY . /var/www/

# Permissões
RUN chown -R www-data:www-data /var/www/

# Define o diretório do Apache
WORKDIR /var/www/html

# Define variáveis de ambiente (opcional, mas recomendado)
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Porta padrão do Apache
EXPOSE 80
