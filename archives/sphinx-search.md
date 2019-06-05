## Sphinx Search
created by magiclyde on 2019/03/14


### Installation
    sudo apt install libmysqlclient-dev
    
    wget http://sphinxsearch.com/files/sphinx-2.2.11-release.tar.gz 
    tar -zvxf sphinx-2.2.11-release.tar.gz 
    cd sphinx-2.2.11-release/
    ./configure --prefix=/usr/local/sphinx
    sudo make && make install


### Check if sphinx is installed

    tree /usr/local/sphinx

        /usr/local/sphinx/
        ├── bin
        │   ├── indexer
        │   ├── indextool
        │   ├── searchd
        │   ├── spelldump
        │   └── wordbreaker
        ├── etc
        │   ├── example.sql
        │   ├── sphinx.conf.dist
        │   └── sphinx-min.conf.dist
        ├── share
        │   └── man
        │       └── man1
        │           ├── indexer.1
        │           ├── indextool.1
        │           ├── searchd.1
        │           └── spelldump.1
        └── var
            ├── data
            └── log

    /usr/local/sphinx/bin/searchd -h

        Sphinx 2.2.11-id64-release (95ae9a6)
        Copyright (c) 2001-2016, Andrew Aksyonoff
        Copyright (c) 2008-2016, Sphinx Technologies Inc (http://sphinxsearch.com)
        ...


### Configuration

    vim /usr/local/sphinx/etc/sphinx.conf

    source src1
    {
        type            = mysql

        sql_host        = localhost
        sql_user        = test
        sql_pass        = 
        sql_db          = test
        sql_port        = 3306  # optional, default is 3306

        sql_query       = \
            SELECT id, slug, UNIX_TIMESTAMP(published_at) AS published_at, title, content \
            FROM posts ORDER BY published_at DESC

        sql_attr_uint       = slug
        sql_attr_timestamp  = published_at
    }


    index idx_post
    {
        source          = src1
        path            = /usr/local/sphinx/var/data/idx_post
    }


    indexer
    {
        mem_limit       = 128M
    }


    searchd
    {
        listen          = 9312
        listen          = 9306:mysql41
        log         = /usr/local/sphinx/var/log/searchd.log
        query_log       = /usr/local/sphinx/var/log/query.log
        read_timeout        = 5
        max_children        = 30
        pid_file        = /usr/local/sphinx/var/log/searchd.pid
        seamless_rotate     = 1
        preopen_indexes     = 1
        unlink_old      = 1
        workers         = threads # for RT to work
        binlog_path     = /usr/local/sphinx/var/data
    }


### Indexing index
    /usr/local/sphinx/bin/indexer -c /usr/local/sphinx/etc/sphinx.conf --all --rotate


### Running searchd
    /usr/local/sphinx/bin/searchd -c /usr/local/sphinx/etc/sphinx.conf

Checking if searchd is running  

    ps -ef | grep searchd

