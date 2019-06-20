## php-memcached

### 安装依赖

    yum install libmemcached libmemcached-devel
    yum install zlib zlib-devel

### 安装 memcached 扩展

memcached 包在 PECL 上的地址是： https://pecl.php.net/package/memcached  

机器原先装有 php5，这里选择 memcached-2.x 

    wget https://pecl.php.net/get/memcached-2.2.0.tgz
    tar -zxvf memcached-2.2.0.tgz
    cd memcached-2.2.0
    phpize
    ./configure --enable-memcached-sasl 
    make && make install


### 添加拓展

    echo "extension=memcached.so" >> /usr/local/php/etc/php.ini
    echo "memcached.use_sasl = 1" >> /usr/local/php/etc/php.ini
    
    service php-fpm reload


### PHP 代码示例

    <?php

        $connect = new Memcached;  //声明一个新的memcached链接
        $connect->setOption(Memcached::OPT_COMPRESSION, false); //关闭压缩功能
        $connect->setOption(Memcached::OPT_BINARY_PROTOCOL, true); //使用 binary二进制协议
        $connect->setOption(Memcached::OPT_TCP_NODELAY, true); //重要，php memcached有个bug，当get的值不存在，有固定40ms延迟，开启这个参数，可以避免这个bug
        $connect->addServer('127.0.0.1', 11211); 
        $connect->setSaslAuthData('memcachedadmin', 'password'); //设置帐号密码进行鉴权，如已开启免密码功能
        $connect->set("hello", "world");
        echo 'hello: ',$connect->get("hello");
        $connect->quit();



### refer
https://github.com/php-memcached-dev/php-memcached
https://www.php.net/manual/zh/memcached.installation.php  
https://www.alibabacloud.com/help/zh/doc-detail/48432.htm  

