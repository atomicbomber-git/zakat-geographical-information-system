@servers(['production' => $production])

@task('deploy', ['on' => 'production'])
    cd /var/www/zakat-geographical-information-system/
    git pull origin master
    composer install --optimize-autoloader --no-dev
    php artisan config:cache
    php artisan route:cache
    php artisan migrate --force
@endtask
