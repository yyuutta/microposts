sudo yum -y install php71 php71-cli php71-common php71-devel php71-mysqlnd php71-pdo php71-xml php71-gd php71-intl php71-mbstring php71-mcrypt php71-opcache php71-pecl-apcu php71-pecl-imagick php71-pecl-memcached php71-pecl-redis php71-pecl-xdebug
sudo alternatives --set php /usr/bin/php-7.1
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer