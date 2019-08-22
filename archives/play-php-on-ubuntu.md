## Play php on Ubuntu
### Build dependencies

    sudo apt-get install build-essential libxml2 libxml2-dev libmcrypt-dev libssl-dev libcurl4-openssl-dev libpng-dev pkg-config  
    ln -s /usr/include/x86_64-linux-gnu/curl /usr/include/  

### Install freetype

    wget https://download.savannah.gnu.org/releases/freetype/freetype-2.7.1.tar.gz
    tar -zxvf freetype-2.7.1.tar.gz
    cd freetype-2.7.1
    ./configure --prefix=/usr/local/freetype/2.7.1 --without-harfbuzz
    make && make install

### Install jpeg

    wget http://www.ijg.org/files/jpegsrc.v8b.tar.gz
    tar -zxvf jpegsrc.v8b.tar.gz 
    cd jpeg-8b
    ./configure --prefix=/usr/local/jpeg --enable-shared --enable-static 
    make && make install

### Install php 

    wget https://www.php.net/distributions/php-7.3.6.tar.bz2
    tar -jxvf php-7.3.6.tar.bz2
    cd php-7.3.6
    ./configure --prefix=/usr/local/php7 --with-config-file-path=/usr/local/php7/etc --enable-fpm --enable-mbstring --enable-pcntl  --enable-sockets --enable-pdo --with-zlib --with-curl --with-mysqli --with-mysql-sock --with-pdo-mysql --with-gettext --with-gd --with-freetype-dir=/usr/local/freetype/2.7.1/ --with-jpeg-dir=/usr/local/jpeg/  --with-openssl
    make && make install

### Setting php.ini

    sudo cp php.ini-development /usr/local/php7/etc/php.ini

> use the below command to locate your php.ini file  

    /usr/local/php7/bin/php -i | grep php.ini

### Create symbolic links for php binary files

    ln -s /usr/local/php7/bin/* /usr/local/bin/
    ln -s /usr/local/php7/sbin/php-fpm /usr/local/bin/

### Config php-fpm 

    cd /usr/local/php7/etc  
    cp php-fpm.conf.default php-fpm.conf  
    cp php-fpm.d/www.conf.default php-fpm.d/www.conf  

### Add default user's group

    groupadd nobody 

### Start php-fpm
    
    sudo php-fpm -c /usr/local/php7/etc/php-fpm.conf

> use the below command to find the process 

    root@vm:/usr/local/php7/etc# netstat -nltp | grep php-fpm
    tcp        0      0 127.0.0.1:9000          0.0.0.0:*               LISTEN      7383/php-fpm: maste 

### Add init.d script

    cd php-7.3.6 ## your source code path
    cp sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm
    sudo chmod +x /etc/init.d/php-fpm
    update-rc.d php-fpm defaults
    
> from here, you can do
  
    service php-fpm {start|stop|force-quit|restart|reload|status|configtest}


