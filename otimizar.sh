#!/bin/bash

# Script de Otimização para Produção
# Execute após a instalação inicial para otimizar o desempenho

echo "======================================"
echo "Otimização para Produção"
echo "======================================"

# Verificar se está em produção
if [ "$APP_ENV" != "production" ]; then
    echo "ATENÇÃO: Certifique-se de que APP_ENV=production no arquivo .env"
    echo "Você deseja continuar? (s/n)"
    read -r response
    if [[ ! $response =~ ^[Ss]$ ]]; then
        exit 1
    fi
fi

# Otimizar autoloader do Composer
echo "Otimizando autoloader do Composer..."
composer dump-autoload --optimize --no-dev

# Cache de configuração
echo "Criando cache de configuração..."
php artisan config:cache

# Cache de rotas
echo "Criando cache de rotas..."
php artisan route:cache

# Cache de views
echo "Criando cache de views..."
php artisan view:cache

# Cache de eventos
echo "Criando cache de eventos..."
php artisan event:cache

# Otimizar imagens (se imagemagick estiver instalado)
if command -v convert &> /dev/null; then
    echo "Otimizando imagens..."
    find public/img -name "*.jpg" -exec jpegoptim --strip-all --max=85 {} \;
    find public/img -name "*.png" -exec optipng -o7 {} \;
fi

# Configurar permissões finais
echo "Configurando permissões finais..."
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 755 public
sudo chmod -R 775 storage bootstrap/cache

echo "======================================"
echo "Otimização concluída!"
echo "======================================"
echo ""
echo "Dicas para produção:"
echo "- Configure um servidor de cache como Redis"
echo "- Use um CDN para assets estáticos"
echo "- Configure SSL/HTTPS"
echo "- Configure backups automáticos do banco"
echo "- Configure monitoramento de logs"