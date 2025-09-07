# Guia de Instalação e Configuração para Produção

## Sistema de Gestão Escolar Multi-Tenant

Este guia fornece instruções completas para instalar e configurar o Sistema de Gestão Escolar em ambiente de produção no Brasil.

## Pré-requisitos

### Servidor Web
- Ubuntu Server 20.04+ (recomendado)
- PHP 7.4+ ou 8.0+
- MySQL 8.0+ ou MariaDB 10.4+
- Nginx ou Apache
- Node.js 14+ e NPM
- Composer 2.0+

### Extensões PHP Necessárias
```bash
sudo apt update
sudo apt install php8.0-fpm php8.0-mysql php8.0-mbstring php8.0-xml php8.0-gd php8.0-curl php8.0-zip php8.0-bcmath php8.0-json php8.0-tokenizer
```

## Instalação

### 1. Download do Código
```bash
git clone https://github.com/xflavioo/School-Management-System-Multi-Tenant.git
cd School-Management-System-Multi-Tenant
```

### 2. Instalação Automática
```bash
chmod +x instalar.sh
./instalar.sh
```

### 3. Configuração Manual (alternativa)

#### 3.1. Dependências do Composer
```bash
composer install --no-dev --optimize-autoloader
```

#### 3.2. Dependências do NPM
```bash
npm ci
npm run production
```

#### 3.3. Configuração do Ambiente
```bash
cp .env.example .env
php artisan key:generate
```

#### 3.4. Configurar Banco de Dados
Edite o arquivo `.env` com suas credenciais:
```env
APP_NAME="Sistema de Gestão Escolar"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com.br

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_gestao_escolar
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

#### 3.5. Migração e Seeds
```bash
php artisan migrate
php artisan db:seed
```

#### 3.6. Storage Link
```bash
php artisan storage:link
```

## Configuração do Servidor Web

### Nginx (Recomendado)

Crie o arquivo `/etc/nginx/sites-available/gestao-escolar`:

```nginx
server {
    listen 80;
    server_name seudominio.com.br;
    root /var/www/html/School-Management-System-Multi-Tenant/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Ative o site:
```bash
sudo ln -s /etc/nginx/sites-available/gestao-escolar /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Apache

Crie o arquivo `/etc/apache2/sites-available/gestao-escolar.conf`:

```apache
<VirtualHost *:80>
    ServerName seudominio.com.br
    DocumentRoot /var/www/html/School-Management-System-Multi-Tenant/public

    <Directory /var/www/html/School-Management-System-Multi-Tenant>
        AllowOverride All
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/gestao-escolar_error.log
    CustomLog ${APACHE_LOG_DIR}/gestao-escolar_access.log combined
</VirtualHost>
```

Ative o site:
```bash
sudo a2ensite gestao-escolar
sudo a2enmod rewrite
sudo systemctl reload apache2
```

## Configuração SSL (HTTPS)

### Usando Certbot (Let's Encrypt)
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d seudominio.com.br
```

## Otimização para Produção

### 1. Executar Script de Otimização
```bash
chmod +x otimizar.sh
./otimizar.sh
```

### 2. Configurações de Cache
No arquivo `.env`, adicione:
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Instalar Redis
```bash
sudo apt install redis-server
sudo systemctl enable redis-server
```

## Configuração de Email

### Gmail SMTP
```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-de-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### SendGrid
```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=sua-api-key-sendgrid
MAIL_ENCRYPTION=tls
```

## Backup e Manutenção

### Script de Backup
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="sistema_gestao_escolar"

# Backup do banco
mysqldump -u root -p $DB_NAME > backup_db_$DATE.sql

# Backup dos arquivos
tar -czf backup_files_$DATE.tar.gz storage/app/public

echo "Backup concluído: backup_db_$DATE.sql e backup_files_$DATE.tar.gz"
```

### Cron Jobs para Manutenção
Adicione ao crontab (`crontab -e`):
```bash
# Backup diário às 2:00
0 2 * * * /caminho/para/script-backup.sh

# Limpeza de logs semanalmente
0 3 * * 0 cd /var/www/html/School-Management-System-Multi-Tenant && php artisan log:clear

# Queue workers (se usando filas)
* * * * * cd /var/www/html/School-Management-System-Multi-Tenant && php artisan schedule:run >> /dev/null 2>&1
```

## Deploy de Atualizações

Para atualizações futuras, use o script de deploy:
```bash
chmod +x deploy.sh
./deploy.sh
```

## Monitoramento

### Logs da Aplicação
- Laravel logs: `storage/logs/`
- Nginx logs: `/var/log/nginx/`
- PHP-FPM logs: `/var/log/php8.0-fpm.log`

### Verificação de Saúde
Crie um endpoint de health check ou monitore:
- Status HTTP da aplicação
- Conectividade com banco de dados
- Espaço em disco
- Uso de memória

## Credenciais Padrão

Após a instalação, as credenciais padrão são:

| Tipo de Conta | Usuário | Email | Senha |
|---------------|---------|-------|-------|
| Super Administrador | cj | cj@cj.com | cj |
| Administrador | admin | admin@admin.com | cj |
| Professor | teacher | teacher@teacher.com | cj |
| Responsável | parent | parent@parent.com | cj |
| Contador | accountant | accountant@accountant.com | cj |
| Estudante | student | student@student.com | cj |

**IMPORTANTE:** Altere todas as senhas padrão imediatamente após a instalação!

## Solução de Problemas

### Problemas Comuns

1. **Erro 500**: Verifique permissões e logs
2. **Erro de conexão com BD**: Verifique credenciais no .env
3. **Assets não carregam**: Execute `npm run production`
4. **Cache problems**: Execute `php artisan cache:clear`

### Comandos Úteis
```bash
# Limpar todos os caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recriar caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Verificar configuração
php artisan config:show

# Status da aplicação
php artisan about
```

## Suporte

Para suporte técnico ou dúvidas sobre a implementação, consulte:
- Documentação do Laravel: https://laravel.com/docs
- Issues do projeto no GitHub
- Comunidade Laravel Brasil