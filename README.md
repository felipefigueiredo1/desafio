# Desafio tecnico php + vue 

## Instruções 

O back-end está com um docker compose configurado, para iniciar o projeto basta entrar no diretorio back-end e rodar docker compose up -d.
Após rodar esse comando entre no container do php e execute : docker exec -it php-fpm composer install.
Já esta configurado no front e back para apontar certinho os containers.

Mas se quiser rodar sem docker faça as configurações abaixo: 

- Em '/back/postgres' faça o restore do arquivo init.sql ( postgresql )
- Em '/back/config/bootstrap.php' coloque as credenciais do banco
- Rode composer install em /back
- Em '/front/services/http.ts' coloque as credenciais do dominio rodando o php

Já deixei um usuário como padrão para fazer login no formulario. Enviei o build do vue como pedido, para acessar tem que está configurado para acessar o index.html do projeto ou simplesmente rodar npm install e npm run dev para ele ja abrir um server para execução.
