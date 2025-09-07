#!/bin/bash

# Script de instalação para produção - Sistema de Gestão Escolar
# Para uso em ambientes Linux/Ubuntu

echo "======================================"
echo "Sistema de Gestão Escolar - Instalação"
echo "======================================"

# Verificar se o PHP está instalado
if ! command -v php &> /dev/null; then
    echo "PHP não está instalado. Por favor, instale o PHP 7.4+ primeiro."
    exit 1
fi

# Verificar versão do PHP
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
echo "Versão do PHP detectada: $PHP_VERSION"

# Verificar se o Composer está instalado
if ! command -v composer &> /dev/null; then
    echo "Composer não está instalado. Instalando..."
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
fi

echo "Instalando dependências do Composer..."
composer install --no-dev --optimize-autoloader

echo "Copiando arquivo de configuração..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Arquivo .env criado. Por favor, configure suas credenciais do banco de dados."
fi

echo "Gerando chave da aplicação..."
php artisan key:generate

echo "Criando link simbólico para storage..."
php artisan storage:link

echo "Configurando permissões..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo "======================================"
echo "Instalação concluída!"
echo "======================================"
echo ""
echo "Próximos passos:"
echo "1. Configure seu banco de dados no arquivo .env"
echo "2. Execute: php artisan migrate"
echo "3. Execute: php artisan db:seed"
echo "4. Configure seu servidor web (Apache/Nginx)"
echo ""
echo "Para desenvolvimento local, execute:"
echo "php artisan serve"