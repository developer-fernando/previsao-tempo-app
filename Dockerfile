# Use uma imagem base PHP com Apache
FROM php:8.2-apache

# Habilita o módulo de reescrita do Apache (mod_rewrite)
RUN a2enmod rewrite

# Define o diretório de trabalho principal dentro do contêiner
# Todos os seus arquivos do projeto serão copiados para este diretório
WORKDIR /app

# Copia todo o conteúdo do seu projeto local para /app no contêiner
# Isso inclui public/, src/, vendor/, composer.json, .htaccess, etc.
COPY . /app/

# Define as permissões corretas para o diretório da aplicação
RUN chown -R www-data:www-data /app

# Instala o Composer se ainda não estiver disponível na imagem (geralmente já vem)
# Se não estiver, você pode descomentar a linha abaixo:
# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Instala as dependências do Composer.
# É crucial que isso seja feito DENTRO do contêiner, APÓS copiar o projeto.
# --no-dev: Não instala dependências de desenvolvimento (ótimo para produção)
# --optimize-autoloader: Otimiza o autoloader para melhor desempenho em produção
RUN composer install --no-dev --optimize-autoloader

# Remove a configuração padrão do Apache
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Copia sua configuração personalizada do Apache para dentro do contêiner
# Esta configuração definirá /app/public como o DocumentRoot
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Habilita sua nova configuração de site
RUN a2ensite 000-default.conf

# Exponha a porta que o Apache está ouvindo
EXPOSE 80

# Comando padrão para iniciar o Apache
CMD ["apache2-foreground"]