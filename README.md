# 🌦️ API Consulta de Clima - Projeto PHP

## 🔗 Link da Aplicação (Produção)
Acesse a aplicação online aqui: [https://previsao-tempo-app.onrender.com/](https://previsao-tempo-app.onrender.com/)

## 📜 Descrição
Este projeto é uma aplicação web desenvolvida em PHP puro que permite aos usuários consultar o clima atual e a previsão para os próximos dias de qualquer cidade do mundo. O foco foi em criar uma interface de usuário intuitiva, responsiva e com um sistema de busca preciso, utilizando a **WeatherAPI**.

**Funcionalidades Principais:**

* **Busca Inteligente por Cidade:** Campo de busca com **autocomplete (autocompletar)** que sugere cidades com base no que o usuário digita. Isso garante precisão na busca, mesmo para cidades com nomes similares em diferentes localidades (ex: "Barcelona, Espanha" vs. "Barcelona, Venezuela").
* **Clima Atual Detalhado:** Exibe a temperatura atual, condição do tempo e ícone representativo.
* **Previsão Abrangente:** Mostra a previsão para os próximos dias em formato de cartões, incluindo:
    * Data da previsão.
    * **Probabilidade de Chuva (%)** com uma barra gráfica visual.
    * Temperaturas mínima e máxima do dia.
* **Visualização Flexível:** Botões interativos "Ver Todos" e "Ocultar" para alternar entre a exibição completa ou resumida da previsão.
* **Design Responsivo:** Layout limpo e profissional, otimizado para diferentes tamanhos de tela (desktop, tablet, mobile).

---

## 🚀 Tecnologias Utilizadas
O projeto foi construído utilizando as seguintes tecnologias:

* **PHP (Puro):** Lógica de backend, integração com a API e renderização dinâmica das informações.
* **HTML5/CSS3:** Estruturação do conteúdo e estilização da interface, incluindo um design responsivo e moderno.
* **JavaScript:** Para a funcionalidade de autocomplete, interatividade do formulário e manipulação dinâmica do DOM.
* **cURL:** Biblioteca PHP para realizar requisições HTTP seguras e eficientes à API externa.
* **WeatherAPI:** API de dados meteorológicos para obter informações precisas sobre o clima.
* **XAMPP/Apache:** Ambiente de desenvolvimento local para execução do servidor PHP.
* **Composer:** Gerenciador de dependências PHP (utilizado para carregar classes automaticamente via `autoload` [PSR-4] e gerenciar bibliotecas).
* **Docker:** Para conteinerização da aplicação, garantindo um ambiente isolado e consistente para desenvolvimento e produção.
* **Render:** Plataforma de nuvem para deployment contínuo e hospedagem da aplicação em ambiente de produção.

---

## 💡 Abordagem Técnica e Boas Práticas

Este projeto, embora desenvolvido em PHP "puro" sem um framework full-stack, foi arquitetado com base em princípios de **engenharia de software sólida** para garantir manutenibilidade, extensibilidade e testabilidade.

* **Front Controller Pattern:** Todas as requisições são direcionadas a um único ponto de entrada (`public/index.php`), centralizando o fluxo da aplicação. Isso simplifica o roteamento e a inicialização de recursos globais.
* **Separação de Responsabilidades (SRP):** As responsabilidades foram claramente divididas em camadas:
    * **Controladores (Controllers):** Gerenciam o fluxo da requisição, orquestram a lógica de negócio e preparam os dados para as visualizações.
    * **Serviços (Services):** Encapsulam a lógica de negócio principal e a comunicação com APIs externas, isolando o núcleo da aplicação.
    * **Requisições (Requests):** Validam e saneiam os dados de entrada, garantindo a segurança e a integridade antes que cheguem à lógica de negócio.
    * **Helpers (Auxiliares):** Funções utilitárias reutilizáveis para tarefas como renderização de views e escape de saída (segurança contra XSS).
* **Injeção de Dependência (DI):** As dependências são passadas para as classes via construtores (ex: `ClimaService` injetado em `ClimaController`). Isso promove o **baixo acoplamento**, facilita a substituição de implementações e torna a aplicação mais fácil de testar (permitindo o uso de mocks para dependências externas).
* **Gestão de Variáveis de Ambiente:** Utilização de um método resiliente na classe `App\Config\Env` para carregar configurações sensíveis. Embora o `.env` seja usado localmente, em produção, as variáveis são lidas diretamente do ambiente do sistema (ex: Render), garantindo que credenciais não sejam versionadas no controle de código-fonte e permitindo diferentes configurações por ambiente.
* **Tratamento de Exceções Semântico:** Implementação de classes de exceção personalizadas (`CidadeNaoEncontradaException`, `ErroComunicacaoException`) para fornecer feedback detalhado e específico em caso de falhas, melhorando a depuração e a experiência do usuário.

---

## ⚙️ Configuração e Deployment

Este projeto é conteinerizado com Docker e implantado na plataforma Render. A configuração detalhada do ambiente é crucial para o seu funcionamento tanto em desenvolvimento local quanto em produção.

### **1. Ambiente Local (XAMPP/Apache)**

Para rodar o projeto em seu ambiente de desenvolvimento local usando XAMPP:

1.  **Pré-requisitos:** Certifique-se de ter o [XAMPP](https://www.apachefriends.com/pt_br/index.html) (ou WAMP/MAMP) instalado e configurado, com Apache e PHP funcionando.

2.  **Clonar o Repositório:** Abra seu terminal ou prompt de comando e clone este repositório dentro do diretório `htdocs` do seu XAMPP (ex: `C:\xampp\htdocs\` no Windows ou `/Applications/XAMPP/htdocs/` no macOS).
    ```bash
    cd /caminho/para/seu/htdocs
    git clone [https://github.com/developer-fernando/previsao-tempo-app.git](https://github.com/developer-fernando/previsao-tempo-app.git)
    cd previsao-tempo-app # Entre na pasta do projeto clonado
    ```

3.  **Instalar Dependências:** Com o terminal ainda na pasta raiz do projeto, execute o Composer para instalar as dependências e gerar a pasta `vendor/` e o `autoload.php`.
    ```bash
    composer install
    ```

4.  **Configurar Variáveis de Ambiente Local (`.env`):**
    * Crie um arquivo chamado `.env` na raiz do projeto (o mesmo nível de `composer.json` e `public`).
    * Obtenha sua chave gratuita da WeatherAPI em [https://www.weatherapi.com/](https://www.weatherapi.com/).
    * Adicione as seguintes linhas ao seu arquivo `.env`, substituindo `sua-chave-api` pela sua chave real:
        ```dotenv
        API_KEY="sua-chave-api"
        API_URL="[http://api.weatherapi.com/v1](http://api.weatherapi.com/v1)"
        ```
    * **Importante:** O arquivo `.env` **não** deve ser versionado no Git por questões de segurança. Ele deve estar listado no `.gitignore`. Um arquivo `.env.example` é fornecido como modelo.

5.  **Ajustes no Apache do XAMPP (Configuração do `httpd.conf` e `mod_rewrite`):**
    Para que o Apache processe corretamente as regras de reescrita e sirva o `public/index.php` como Front Controller, você **precisa** garantir que a diretiva `AllowOverride All` esteja configurada para o diretório raiz dos seus projetos (`htdocs`) em seu `httpd.conf`. Além disso, o módulo `mod_rewrite` deve estar habilitado.
    * Abra `C:\xampp\apache\conf\httpd.conf`.
    * **Verifique/Descomente:** `LoadModule rewrite_module modules/mod_rewrite.so`
    * **Verifique/Altere:** Na seção `<Directory "C:/xampp/htdocs">`, defina `AllowOverride All`.
    * **Salve** o arquivo `httpd.conf` e **Reinicie o Apache** no painel do XAMPP.

6.  **Configurar `.htaccess` na raiz do Projeto:**
    Certifique-se de que o arquivo `.htaccess` na raiz do seu projeto (`previsao-tempo-app/.htaccess`) possui as seguintes regras para rotear todas as requisições para `public/index.php` e permitir o acesso a assets estáticos:
    ```apache
    # Ativa o módulo de reescrita
    RewriteEngine On

    # Define o diretório base para as regras de reescrita
    RewriteBase /previsao-tempo-app/ # Substitua pelo nome da sua pasta de projeto

    # Regra para servir arquivos ou diretórios que existem diretamente (assets, etc.)
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L] # Serve o arquivo/diretório diretamente e para as regras

    # Regra de Segurança (Opcional, mas recomendado):
    # Bloqueia o acesso direto a arquivos sensíveis pela web (como .env, composer.json, .lock, vendor/)
    RewriteRule ^(composer\.json|composer\.lock|\.env|vendor/.*)$ - [F,L]

    # Regra principal de roteamento:
    # Se a requisição não foi para um arquivo/diretório existente, reescreve para public/index.php
    RewriteRule ^(.*)$ public/index.php [QSA,L]
    ```
    * **Importante:** Substitua `/previsao-tempo-app/` pelo nome real da sua pasta de projeto dentro de `htdocs`.

7.  **Ajustar `basePath` e Links de Assets nos Arquivos PHP:**
    No `public/index.php` e em seus arquivos de template (`public/templates/header.php`, `public/templates/footer.php`), o `$basePath` deve ser calculado dinamicamente para corresponder ao caminho da sua pasta no servidor local, e os links para assets devem usá-lo. Exemplo de cálculo em `public/index.php`:
    ```php
    $scriptName = $_SERVER['SCRIPT_NAME']; // Ex: /previsao-tempo-app/public/index.php
    $publicDir = dirname($scriptName);     // Ex: /previsao-tempo-app/public
    $basePath = dirname($publicDir);       // Ex: /previsao-tempo-app
    ```
    E uso nos templates:
    ```html
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath ?? '') ?>/public/assets/css/style.css">
    <script src="<?= htmlspecialchars($basePath ?? '') ?>/public/assets/js/script.js"></script>
    ```

8.  **Acessar a Aplicação:** Após todos os passos acima, inicie o Apache no XAMPP, limpe o cache do seu navegador e acesse o projeto através de: `http://localhost/previsao-tempo-app/` (substitua `previsao-tempo-app` pelo nome da sua pasta de projeto).

### **2. Ambiente de Produção (Docker e Render)**

A aplicação é conteinerizada com Docker para um ambiente de produção consistente e é implantada na plataforma Render.

#### **2.1. Configuração do Dockerfile**

O `Dockerfile` é a receita para construir a imagem Docker da sua aplicação. Ele define o ambiente, instala dependências e configura o servidor web. Certifique-se de que este arquivo (`Dockerfile`) esteja na raiz do seu projeto no repositório.

```dockerfile
# Use uma imagem base PHP com Apache (PHP 8.2)
FROM php:8.2-apache

# Habilita o módulo de reescrita do Apache (mod_rewrite), essencial para o .htaccess
RUN a2enmod rewrite

# Instala o Composer na imagem, copiando o binário de uma imagem temporária do Composer.
# Isso garante que o Composer esteja disponível para gerenciar as dependências.
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define o diretório de trabalho principal dentro do contêiner para /app.
# Todos os arquivos do projeto serão copiados para este diretório.
WORKDIR /app

# Instala o Git dentro do contêiner. Isso é crucial para o Composer baixar
# dependências que utilizam repositórios Git como fonte (via clonagem).
RUN apt-get update && apt-get install -y git

# Copia os arquivos do Composer (composer.json e composer.lock) primeiro.
# Esta etapa otimiza o cache do Docker: se esses arquivos não mudarem,
# o passo de instalação do Composer será reutilizado de um build anterior.
COPY composer.json composer.lock ./

# Instala as dependências PHP via Composer.
# Este é o passo que cria a pasta 'vendor/' e o 'autoload.php' dentro do contêiner.
# --no-dev: Não instala dependências de desenvolvimento (ideal para produção).
# --optimize-autoloader: Otimiza o autoloader para melhor desempenho em produção.
RUN composer install --no-dev --optimize-autoloader

# Copia o restante do seu código fonte da aplicação para o diretório /app.
# Isso é feito APÓS a instalação das dependências para aproveitar o cache do Docker
# e garantir que a pasta 'vendor/' já esteja no lugar.
COPY . .

# Define as permissões corretas para o diretório da aplicação,
# garantindo que o usuário do servidor web (www-data) possa ler e gravar arquivos.
RUN chown -R www-data:www-data /app

# Remove a configuração padrão do Apache que vem com a imagem base.
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Copia a configuração personalizada do Apache para dentro do contêiner.
# Esta configuração (apache-config.conf) define o 'DocumentRoot' para a pasta 'public'.
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Habilita o site com a sua nova configuração no Apache.
RUN a2ensite 000-default.conf

# Expõe a porta 80, que é a porta padrão que o Apache está ouvindo.
EXPOSE 80

# Define o comando padrão para iniciar o Apache em primeiro plano,
# o que é necessário para execução em contêineres Docker.
CMD ["apache2-foreground"]


#### **2.2. Configuração do Apache (apache-config.conf)**

Este arquivo, localizado na raiz do projeto junto ao `Dockerfile`, instrui o Apache a servir a aplicação a partir da subpasta `public/` e a processar as regras do `.htaccess`.

```apache
<VirtualHost *:80>
    # Define o DocumentRoot do Apache para apontar para a sua pasta public/ dentro do contêiner (/app/public)
    DocumentRoot /app/public

    # Configurações para a pasta public
    <Directory /app/public>
        # Permite o uso de Options e FollowSymLinks (necessário para reescritas)
        Options Indexes FollowSymLinks

        # Habilita o uso de arquivos .htaccess dentro desta pasta, permitindo suas regras de roteamento e segurança.
        AllowOverride All

        # Permite o acesso a todos os recursos nesta pasta
        Require all granted
    </Directory>

    # Configurações de log (opcional, mas recomendado para depuração em produção)
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

#### **2.3. Gestão de Variáveis de Ambiente para Produção (Render)**

Em ambientes de produção, como o Render, variáveis de ambiente sensíveis (ex: chaves de API) **NÃO são armazenadas em arquivos `.env` no repositório**. Em vez disso, são configuradas diretamente na plataforma de hospedagem.

* **No Render:** Acesse o painel do seu serviço, vá para a seção "Environment" e adicione cada `Key` (ex: `API_KEY`, `API_URL`) com seu respectivo `Value`.
* **Acesso no Código:** Sua classe `App\Config\Env` (`src/Config/Env.php`) foi ajustada para ser resiliente: ela tenta ler o `.env` localmente (se existir), mas em ambientes onde o `.env` não é versionado, ela acessa diretamente as variáveis injetadas pelo ambiente do sistema (via `getenv()`), garantindo a funcionalidade sem expor credenciais.

#### **2.4. Estratégia de Deploy com Render**

O Render integra-se diretamente com o GitHub para um processo de **Deployment Contínuo (CI/CD)**:

1.  **Conexão com GitHub:** Seu serviço Render é configurado para monitorar uma branch específica do seu repositório GitHub (ex: `main`).
2.  **Disparo de Build:** A cada `git push` para essa branch monitorada, o Render automaticamente dispara um novo processo de build.
3.  **Processo de Build (Baseado no Dockerfile):**
    * O Render clona o repositório.
    * Ele executa os comandos definidos no `Dockerfile`: instala o Git, copia `composer.json` e `composer.lock`, executa `composer install` (criando o `vendor/` e `autoload.php` dentro do contêiner), copia o restante do código, configura o Apache com `apache-config.conf` e define permissões.
    * Se o build for bem-sucedido, uma nova imagem Docker é criada.
4.  **Deployment:** A nova imagem Docker é implantada e o serviço é iniciado no Render, expondo sua aplicação na URL fornecida pela plataforma. As variáveis de ambiente configuradas no painel do Render são injetadas no ambiente do contêiner durante a execução.
```
---

## 📝 Licença
Este projeto está licenciado sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para mais informações.

---

## 👨‍💻 Desenvolvedor
**Fernando Santana**
* [🔗 LinkedIn](https://www.linkedin.com/in/dev-fernando/)
* [🔗 GitHub](https://github.com/developer-fernando)