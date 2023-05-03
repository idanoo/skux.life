# skux.life
Anonymous Photo Stream

Required things:
```
php-fpm
php-imagick
composer
nginx
```

Config:
```
# clone repo
git clone https://github.com/idanoo/skux.life.git && cd skux.life
composer install 
vendor/bin/phinx migrate
```

Running locally to test:
```
cd public && php -S 127.0.0.1:1234
```
http://127.0.0.1:1234/