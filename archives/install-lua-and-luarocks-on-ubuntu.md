# Install lua and luarocks on ubuntu

## Install dependencies

    $ sudo apt-get install libreadline-dev libncurses5-dev

## Install lua

    $ curl -R -O http://www.lua.org/ftp/lua-5.1.5.tar.gz
    $ tar zxf lua-5.1.5.tar.gz
    $ cd lua-5.1.5
    $ make linux test
    $ make linux

also try, 

    $ make install
    cd src && mkdir -p /usr/local/bin /usr/local/include /usr/local/lib /usr/local/man/man1 /usr/local/share/lua/5.1 /usr/local/lib/lua/5.1
    cd src && install -p -m 0755 lua luac /usr/local/bin
    cd src && install -p -m 0644 lua.h luaconf.h lualib.h lauxlib.h ../etc/lua.hpp /usr/local/include
    cd src && install -p -m 0644 liblua.a /usr/local/lib
    cd doc && install -p -m 0644 lua.1 luac.1 /usr/local/man/man1


    $ lua -h
    usage: lua [options] [script [args]].
    Available options are:
      -e stat  execute string 'stat'
      -l name  require library 'name'
      -i       enter interactive mode after executing 'script'
      -v       show version information
      --       stop handling options
      -        execute stdin and stop handling options

---

## Install luarocks

    $ wget https://github.com/luarocks/luarocks/archive/v3.1.3.tar.gz
    $ tar -xzvf v3.1.3.tar.gz
    $ cd luarocks-3.1.3/
    $ ./configure
    $ make
    $ sudo make install

## Using luarocks 

    $ luarocks install md5
    Installing https://luarocks.org/md5-1.3-1.rockspec

    ...


# Refer
https://www.lua.org/download.html  
https://github.com/luarocks/luarocks/wiki/Download  
