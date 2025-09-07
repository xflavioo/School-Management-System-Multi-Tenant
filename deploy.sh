#!/bin/bash

# Script de Deploy para Produção - Sistema de Gestão Escolar
# Execute este script sempre que fizer atualizações em produção

echo "======================================"
echo "Deploy do Sistema de Gestão Escolar"
echo "======================================"

# Entrar em modo de manutenção
echo "Colocando aplicação em modo de manutenção..."
php artisan down

# Atualizar código do repositório
echo "Atualizando código..."
git pull origin main

# Instalar/atualizar dependências
echo "Atualizando dependências do Composer..."
composer install --no-dev --optimize-autoloader

# Atualizar dependências do NPM e compilar assets
echo "Atualizando dependências do NPM..."
npm ci
npm run production

# Limpar caches
echo "Limpando caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Executar migrações
echo "Executando migrações do banco de dados..."
php artisan migrate --force

# Otimizar aplicação
echo "Otimizando aplicação..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Configurar permissões
echo "Configurando permissões..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Sair do modo de manutenção
echo "Tirando aplicação do modo de manutenção..."
php artisan up

echo "======================================"
echo "Deploy concluído com sucesso!"
echo "======================================"