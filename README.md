# UEX Contatos

Sistema de cadastro de contatos com Laravel, integração Via CEP e Google Maps.

# Requisitos

PHP 8.4+

Laravel 12+

MySQL ou outro banco de dados compatível

Chave de API do Google Maps

# Instalação
Clonar o repositório
git clone https://github.com/seu-usuario/uex-contacts.git
cd uex-contacts


# Instalar dependências
composer install


# Configurar ambiente
cp .env.example .env
php artisan key:generate


# Configurar banco de dados e chave do Google Maps no .env


# Rodar migrações
php artisan migrate


# Iniciar servidor
php artisan serve