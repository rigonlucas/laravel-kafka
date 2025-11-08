# Technical Test

## Estrutura dos Módulos

O projeto segue uma arquitetura modular, com os principais módulos localizados em `app/Modules/`. 
Cada módulo é responsável por uma funcionalidade específica do sistema:

- **Auth/**: Autenticação de usuários.
- **Collaborator/**: Gerenciamento de colaboradores.
- **Import/**: Importação de colaboradores via CSV.
- **User/**: Gerenciamento de usuários. (Aqui está apenas o Resource do User, sem CRUD completo).

Cada módulo pode conter Controllers, Services, Datas (DTOs) e outros componentes relacionados à sua funcionalidade.

- Para controle de permissões, utilizei uma abordagem bitwise, onde cada permissão é representada por um bit em um inteiro. Alinhado ao middleware `ManagerAccessControlMiddleware` para verificar as permissões do usuário.

## Como rodar os testes

1. Instale as dependências no container:
   ```sh
   composer install
   ```
2. Rode os testes:
   ```sh
   php artisan test
   ```

Os testes de importação de colaboradores isolado está em `tests/Feature/Serivices/ImportCollaboratorsTest.php` 
O teste que agrupa fila, email e import está em `tests/Feature/E2e/ImportCollaboratorsTest.php`.

## Docker
O projeto pode ser executado utilizando Docker. Siga os passos abaixo:
1. Nginx e PHP-FPM:
   ```sh
   docker-compose up -d --build
   ```
2. Banco de dados (MySQL) e Redis estão configurados no `docker-compose.yml`.

## Observações
- O projeto utiliza Laravel 12 e PHP 8.4.
- Arquivo fornecido em tests/Helpers/employees_list.csv
- O sistema foi desenvolvido visando modularização e testes automatizados.
