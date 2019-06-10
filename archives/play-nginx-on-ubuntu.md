## Play nginx on ubuntu18.04
### Build dependencies
    sudo apt-get update
    sudo apt-get install build-essential libpcre3 libpcre3-dev openssl uuid-dev libssl-dev libperl-dev zlib1g-dev  


### Make dir to store packages
    mkdir /ngx-src-pkg && cd /ngx-src-pkg


### Download source code
    wget -c http://nginx.org/download/nginx-1.14.0.tar.gz && tar -xzvf nginx-1.14.0.tar.gz && rm nginx-1.14.0.tar.gz

    git clone https://github.com/google/ngx_brotli.git && cd ngx_brotli && git submodule update --init && cd ../   

    wget -c https://github.com/apache/incubator-pagespeed-ngx/archive/v1.13.35.2-stable.zip && unzip v1.13.35.2-stable.zip && rm v1.13.35.2-stable.zip && cd incubator-pagespeed-ngx-1.13.35.2-stable  

    wget -c https://dl.google.com/dl/page-speed/psol/1.13.35.2-x64.tar.gz && tar -xzvf 1.13.35.2-x64.tar.gz && rm 1.13.35.2-x64.tar.gz && cd ../ && mv incubator-pagespeed-ngx-1.13.35.2-stable pagespeed   

After that dir tree looks like 

    /ngx-src-pkg/
        |__ nginx-1.14.0/
        |__ ngx_brotli/
        |__ pagespeed/
            |__ psol/
            ...


### Conf && compile && install 
    cd /ngx-src-pkg/nginx-1.14.0
    ./configure --prefix=/usr/local/nginx --with-http_ssl_module --with-http_v2_module --with-http_realip_module --add-module=/ngx-src-pkg/pagespeed --add-module=/ngx-src-pkg/ngx_brotli 
    make
    sudo make install


### Test the installation 
    /usr/local/nginx/sbin/nginx -V  

> Output  
> nginx version: nginx/1.14.0
built by gcc 5.4.0 20160609 (Ubuntu 5.4.0-6ubuntu1~16.04.4) 
configure arguments: --prefix=/usr/local/nginx --add-module=/ngx-src-pkg/pagespeed --add-module=/ngx-src-pkg/ngx_brotli
    


### Enable brotli
see https://github.com/google/ngx_brotli#configuration-directives


### Enable pagespeed
    sudo mkdir /usr/local/nginx/ngx_pagespeed_cache
    sudo chown -R nobody:nobody /usr/local/nginx/ngx_pagespeed_cache

    vim /usr/local/nginx/conf/nginx.conf

    http {
        ...

        pagespeed on;
        pagespeed FileCachePath /usr/local/nginx/ngx_pagespeed_cache;

        server {
            listen 80;
            server_name localhost;
            ...


            #pagespeed on;
            #pagespeed FileCachePath /usr/local/nginx/ngx_pagespeed_cache;

            # enable CoreFilters
            pagespeed RewriteLevel CoreFilters;

            # disable particular filter(s) in CoreFilters
            pagespeed DisableFilters rewrite_images;

            # enable additional filter(s) selectively
            pagespeed EnableFilters collapse_whitespace;
            pagespeed EnableFilters lazyload_images;
            pagespeed EnableFilters insert_dns_prefetch;

        }

    }


### Start nginx
    ln -s /usr/local/nginx/sbin/nginx /usr/bin/nginx  
    nginx -c /usr/local/nginx/conf/nginx.conf  

> Note: -c specifies the path of the configuration file.


### Add init script
    cd /etc/init.d
    wget https://raw.githubusercontent.com/JasonGiedymin/nginx-init-ubuntu/master/nginx
    chmod +x /etc/init.d/nginx
    update-rc.d -f nginx defaults
    service nginx start


## Refer
https://www.modpagespeed.com/doc/build_ngx_pagespeed_from_source

