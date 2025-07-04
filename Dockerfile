# Use uma imagem base PHP com Apache
FROM php:8.2-apache

# Habilita o módulo de reescrita do Apache (mod_rewrite)
RUN a2enmod rewrite

# Instala o Composer na imagem
# Usa uma imagem temporária do Composer para copiar o binário
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define o diretório de trabalho principal dentro do contêiner
# Este é o diretório raiz do seu projeto no contêiner
WORKDIR /app

# Copia os arquivos do Composer (composer.json e composer.lock) primeiro
# Isso aproveita o cache do Docker. Se esses arquivos não mudarem,
# os passos seguintes (composer install) não precisarão ser reexecutados.
COPY composer.json composer.lock ./

# Instala as dependências do Composer.
# Este é o passo que CRIA a pasta 'vendor/' dentro do contêiner.
# --no-dev: Não instala dependências de desenvolvimento (ótimo para produção)
# --optimize-autoloader: Otimiza o autoloader para melhor desempenho em produção
RUN composer install --no-dev --optimize-autoloader

# Copia o restante do seu código fonte APÓS as dependências terem sido instaladas.
# Isso garante que a pasta 'vendor/' já existe e o 'autoload.php' está no lugar.
# Também aproveita o cache do Docker se apenas o código-fonte muda.
COPY . .

# Define as permissões corretas para o diretório da aplicação
RUN chown -R www-data:www-data /app

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