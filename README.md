# 🌦️ API Consulta de Clima - Projeto PHP

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
* **Gestão de Variáveis de Ambiente:** Utilização de arquivos `.env` para gerenciar chaves de API e configurações sensíveis. Isso garante que credenciais não sejam versionadas no controle de código-fonte e permite diferentes configurações por ambiente (desenvolvimento, homologação, produção).
* **Tratamento de Exceções Semântico:** Implementação de classes de exceção personalizadas (`CidadeNaoEncontradaException`, `ErroComunicacaoException`) para fornecer feedback detalhado e específico em caso de falhas, melhorando a depuração e a experiência do usuário.

---

## 📈 Pensando em Escalabilidade e Futuro

A arquitetura desta aplicação foi concebida com a **escalabilidade e a extensibilidade em mente**, mesmo em um contexto de PHP puro. Isso demonstra como os princípios de design de software podem ser aplicados para construir sistemas robustos.

1.  **Modularidade e Manutenibilidade:**
    * A clara separação entre as camadas permite que partes da aplicação sejam desenvolvidas, testadas e mantidas de forma independente. Uma equipe pode trabalhar em diferentes serviços sem causar conflitos massivos.
    * **Facilidade de Refatoração:** Se o provedor de clima mudar, apenas o `ClimaService` precisaria ser adaptado, sem afetar Controladores ou Views.
    * **Acoplamento Flexível:** A Injeção de Dependência permite que, no futuro, componentes mais complexos (como um gerenciador de cache ou um cliente HTTP diferente) sejam "plugados" sem a necessidade de reescrever grandes partes do código.

2.  **Preparação para Alto Tráfego:**
    * **Estratégias de Cache:** O `ClimaService` é o ponto ideal para a implementação de uma camada de cache (ex: Redis, Memcached). Isso reduziria drasticamente o número de requisições à API externa para cidades frequentemente consultadas, melhorando a performance sob carga e reduzindo custos com APIs de terceiros.
    * **Otimização de Banco de Dados (Futuro):** Embora este projeto não utilize banco de dados, a estrutura permitiria a fácil integração com uma camada de persistência. A separação de responsabilidades asseguraria que a otimização de queries ou a adoção de um ORM não afetasse a lógica de negócio ou os controladores.

3.  **Expansão de Funcionalidades:**
    * **Novas APIs e Serviços:** Se a aplicação precisar integrar com outras APIs (ex: geolocalização, notícias relacionadas ao clima), novos serviços podem ser adicionados e injetados nos controladores sem modificar a arquitetura existente.
    * **Processamento Assíncrono:** Para operações que consomem mais tempo (como o envio de relatórios diários por e-mail ou o processamento de grandes volumes de dados históricos), a arquitetura suportaria a integração com filas de mensagens (ex: RabbitMQ, Apache Kafka). Os serviços poderiam enfileirar tarefas para serem processadas em segundo plano, liberando a resposta HTTP rapidamente.

4.  **Migração para Frameworks (Decisão de Arquitetura):**
    * A estrutura com Front Controller, autoloading (PSR-4), namespaces e a separação clara de responsabilidades segue os padrões de design que são a base de frameworks PHP modernos como Laravel, Symfony ou Zend Framework.
    * Isso significa que, caso o projeto escale a um ponto onde os benefícios de um framework (ORM, sistema de rotas avançado, autenticação, etc.) superem a simplicidade do PHP puro, a migração seria significativamente mais suave e rápida, pois a maior parte da lógica de negócio e organização já estaria em conformidade com as melhores práticas.

---

## ⚙️ Como Rodar o Projeto Localmente

Siga os passos abaixo para configurar e executar o projeto em sua máquina:

1.  **Pré-requisitos:** Certifique-se de ter o [XAMPP](https://www.apachefriends.org/pt_br/index.html) (ou WAMP/MAMP) instalado e configurado, com Apache e PHP funcionando.

2.  **Clonar o Repositório:** Abra seu terminal ou prompt de comando e clone este repositório dentro do diretório `htdocs` do seu XAMPP (ex: `C:\xampp\htdocs\` no Windows ou `/Applications/XAMPP/htdocs/` no macOS).
    ```bash
    cd /caminho/para/seu/htdocs
    git clone [https://github.com/developer-fernando/previsao-tempo-app.git](https://github.com/developer-fernando/previsao-tempo-app.git)
    cd previsao-tempo-app # Entre na pasta do projeto clonado
    ```

3.  **Instalar Dependências:** Com o terminal ainda na pasta raiz do projeto, execute o Composer para instalar as dependências:
    ```bash
    composer install
    ```

4.  **Configurar a API Key:**
    * Crie um arquivo chamado `.env` na raiz do projeto (o mesmo nível de `composer.json` e `public`).
    * Obtenha sua chave gratuita da WeatherAPI em [https://www.weatherapi.com/](https://www.weatherapi.com/).
    * Adicione as seguintes linhas ao seu arquivo `.env`, substituindo `sua-chave-api` pela sua chave real:
        ```
        API_KEY=sua-chave-api
        API_URL=[http://api.weatherapi.com/v1](http://api.weatherapi.com/v1)
        ```

5.  **Ajustes no Apache (Importante para o Funcionamento do `.htaccess`):**
    Para que o Apache processe corretamente as regras de reescrita e sirva o `public/index.php` como Front Controller, você **precisa** garantir que a diretiva `AllowOverride All` esteja configurada para o diretório `C:/xampp/htdocs` em seu `httpd.conf`. Além disso, o módulo `mod_rewrite` deve estar habilitado.
    * Abra `C:\xampp\apache\conf\httpd.conf`.
    * **Verifique/Descomente:** `LoadModule rewrite_module modules/mod_rewrite.so`
    * **Verifique/Altere:** Na seção `<Directory "C:/xampp/htdocs">`, defina `AllowOverride All`.
    * **Salve** o arquivo `httpd.conf` e **Reinicie o Apache** no painel do XAMPP.

6.  **Configurar `.htaccess` na raiz do Projeto:**
    Crie (ou adapte) o arquivo `C:/xampp/htdocs/previsao-tempo-app/.htaccess` com as seguintes regras para rotear todas as requisições para `public/index.php` e permitir o acesso a assets:

    ```apache
    # Ativa o módulo de reescrita
    RewriteEngine On

    # Define o diretório base para as regras de reescrita
    RewriteBase /previsao-tempo-app/ # Substitua pelo nome da sua pasta de projeto

    # Regra para servir arquivos ou diretórios que existem diretamente
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L] # Serve o arquivo/diretório diretamente e para as regras

    # Regra de Segurança (Opcional, pode ser removida se causar conflitos no seu XAMPP):
    # Bloqueia o acesso direto a arquivos sensíveis pela web (como .env, composer.json, .lock, vendor/)
    RewriteRule ^(composer\.json|composer\.lock|\.env|vendor/.*)$ - [F,L]

    # Regra principal de roteamento:
    # Se a requisição não foi para um arquivo/diretório existente, reescreve para public/index.php
    RewriteRule ^(.*)$ public/index.php [QSA,L]
    ```
    * **Importante:** Substitua `/previsao-tempo-app/` pelo nome real da sua pasta de projeto dentro de `htdocs`.

7.  **Ajustar `basePath` nos Arquivos PHP:**
    No `public/index.php` e em seus controladores (`ClimaController.php`, `ErrorController.php`), o `$basePath` deve ser calculado dinamicamente para corresponder ao caminho da sua pasta no servidor.
    ```php
    // Exemplo de cálculo do basePath
    $scriptName = $_SERVER['SCRIPT_NAME']; // Ex: /previsao-tempo-app/public/index.php
    $publicDir = dirname($scriptName);     // Ex: /previsao-tempo-app/public
    $basePath = dirname($publicDir);       // Ex: /previsao-tempo-app
    // Para acesso direto em http://localhost/previsao-tempo-app/
    ```

8.  **Ajustar Links de Assets nos Templates:**
    Nos seus arquivos de template (`public/templates/header.php`, `public/templates/footer.php`), use o `$basePath` para referenciar seus assets:
    ```html
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath ?? '') ?>/public/assets/css/style.css">
    <link rel="icon" href="<?= htmlspecialchars($basePath ?? '') ?>/public/favicon.png" type="image/png">
    <script src="<?= htmlspecialchars($basePath ?? '') ?>/public/assets/js/script.js"></script>
    ```

9.  **Acessar a Aplicação:**
    Após todos os passos acima, inicie o Apache no XAMPP, limpe o cache do seu navegador e acesse o projeto através de: `http://localhost/previsao-tempo-app/` (substitua `previsao-tempo-app` pelo nome da sua pasta de projeto).

---

## 🎯 Funcionalidades Detalhadas

* **Busca Avançada:** Implementação de um sistema de autocomplete com requisições assíncronas (Fetch API) para oferecer sugestões de cidades em tempo real, melhorando a experiência e a precisão da busca.
* **Precisão Geográfica:** Capacidade de diferenciar cidades com o mesmo nome em diferentes regiões ou países, garantindo que o usuário obtenha a previsão da localização exata desejada (ex: Barcelona, Espanha vs. Barcelona, Venezuela).
* **Exibição Dinâmica:** Informações de clima atual e previsão de 3 a 7 dias (com base na configuração do botão "Ver Todos").
* **Indicador de Chuva:** Uma barra gráfica intuitiva que visualiza a probabilidade de precipitação para cada dia.
* **Interatividade:** Botões "Ver Todos" e "Ocultar" para expandir/recolher a previsão dos dias, controlando a quantidade de informação exibida.
* **Interface Amigável:** Layout limpo, com design focado na legibilidade e facilidade de uso, adaptando-se a dispositivos móveis.

---

## 🌐 Integração com APIs Externas

Este projeto integra-se com APIs externas para obter dados meteorológicos. A camada de `Services` é responsável por essa comunicação, garantindo que a lógica de negócio esteja desacoplada dos detalhes de implementação da API de terceiros.

* **Chaves de API Seguras:** As chaves de API são gerenciadas via variáveis de ambiente (`.env`), garantindo que credenciais sensíveis não sejam expostas no código-fonte ou no controle de versão. Isso também permite flexibilidade para alternar entre diferentes ambientes (desenvolvimento, produção) ou provedores de API sem alterar o código.
* **Tratamento de Falhas Robusto:** O projeto implementa um tratamento de exceções detalhado para lidar com falhas de comunicação ou respostas inesperadas das APIs externas. Isso inclui a captura de erros de rede, tempo limite e respostas malformadas, fornecendo feedback amigável ao usuário e evitando que a aplicação quebre inesperadamente.

---

## 📝 Licença
Este projeto está licenciado sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para mais informações.

---

## 👨‍💻 Desenvolvedor
**Fernando Santana**
* [🔗 LinkedIn](https://www.linkedin.com/in/dev-fernando/)
* [🔗 GitHub](https://github.com/developer-fernando)

---