### 目录
[TOC]

### 1. 安装依赖

    # yum install gcc libevent-devel

因为接下来的编译使用 --enable-sasl 选项，所以需安装 sasl 对应的包，先搜索下

    # yum search sasl | grep dev

    cyrus-sasl-devel.i686 : Files needed for developing applications with Cyrus SASL
    cyrus-sasl-devel.x86_64 : Files needed for developing applications with Cyrus
    saslwrapper-devel.x86_64 : Header files for developing with saslwrapper

这里选择 cyrus-sasl-devel.x86_64 
    
    # yum install -y cyrus-sasl-devel.x86_64

查看安装的 sasl 包

    # rpm -qa | grep sasl
    cyrus-sasl-plain-2.1.26-23.el7.x86_64
    cyrus-sasl-2.1.26-23.el7.x86_64
    cyrus-sasl-devel-2.1.26-23.el7.x86_64
    cyrus-sasl-lib-2.1.26-23.el7.x86_64



### 2. 安装 memcached

    # wget http://www.memcached.org/files/memcached-1.5.0.tar.gz
    # tar -zxvf memcached-1.5.0.tar.gz
    # cd memcached-1.5.0
    # ./configure --prefix=/usr/local/memcached --enable-sasl
    # make && make test && sudo make install



### 3. 配置、运行 memcached

#### 3.1 创建系统用户
memcached 不能以 root 用户启动，所以先创建个专属用户并设置密码

    # useradd  memcachedadmin
    # passwd memcachedadmin 


#### 3.2 启动 sasl 服务
**查看 saslauthd 版本及支持的验证方式**
    # saslauthd -v
    saslauthd 2.1.26
    authentication mechanisms: getpwent kerberos5 pam rimap shadow ldap httpform
	
这里测试使用 shadow，即 linux 本地账户的验证方式
	
    # cp /etc/sysconfig/saslauthd /etc/sysconfig/saslauthd.save
    # sed -i 's/MECH=pam/MECH=shadow/' /etc/sysconfig/saslauthd


**启动 sasl 服务**
    # service saslauthd restart 
	

#### 3.3 测试 sasl 用户认证

**测试 saslauthd 的认证功能**
    # testsaslauthd -u os_user -p passwd_of_os_user

    # testsaslauthd -u memcachedadmin -p 'xxx' 
    0: NO "authentication failed"

(⊙o⊙)… 验证错误，查看系统日志
    # tail  /var/log/messages
    Jun 19 11:50:36 localhost systemd: Started SASL authentication daemon..
    Jun 19 11:50:52 localhost saslauthd[14792]: do_auth         : auth failure: [user=memcachedadmin] [service=imap] [realm=] [mech=shadow] [reason=Username shadow lookup failure: Permission denied]
    Jun 19 11:51:39 localhost dhclient[23205]: DHCPREQUEST on ens192 to 192.168.18.1 port 67 (xid=0x6abf9716)


发现需要授予 saslauthd 引用 /etc/shadow 的权限，运行下面命令

    # setsebool -P saslauthd_read_shadow on

再次测试 ok
    # testsaslauthd -u memcachedadmin -p 'xxx'
    0: OK "Success."

#### 3.4 添加 sasl 用户

**为 memcached 添加 sasl 认证用户，用于 memcache-client 连接**

    # saslpasswd2 -a memcached -c memcachedadmin
	
运行上述命令后会输入密码，为了测试方便这里填写 123456，注意这个密码是给 memcache-client 用的，比如 python-client, java-client, 用户名是 memcachedadmin （这个用户必须是服务器存在的）


**查看 sasl 账号列表**

    # sasldblistusers2
    memcachedadmin@localhost.localdomain: userPassword

由于 saslpasswd2 生成的 sasl 账户密码默认保存在 /etc/sasldb2 文件里，但是该文件权限为 0640 或者 0660，对于运行 Memcached 的 user/group 不可读，因此需要做一些权限上面的修改
	
    chown :memcachedadmin /etc/sasldb2

#### 3.5 启动 memcached

    # /usr/local/memcached/bin/memcached -S -d -u memcachedadmin -m 64 -p 11311 -l 127.0.0.1

启动参数说明：

    -S：开启 SASL 认证
    -d 以 daemon 后台方式启动
    -u 选择用户
    -m 指定内存大小，单位 M
    -p 绑定端口
    -l 监听 ip

更多选项 /usr/local/memcached/bin/memcached -h

### 4. 连接、验证 memcached with sasl 
    # yum install python-pip
    # pip install python-binary-memcached

    # python
    Python 2.7.5 (default, Apr  9 2019, 14:30:50) 
    [GCC 4.8.5 20150623 (Red Hat 4.8.5-36)] on linux2
    Type "help", "copyright", "credits" or "license" for more information.
    >>> 
    >>> import bmemcached
    >>> client = bmemcached.Client(('127.0.0.1:11311', ), 'memcachedadmin', '123456')
    >>> 
    >>> s = client.set('k1', 'v1')
    >>> s
    True
    >>> client.get('k1')
    'v1'
    >>> quit()


### 5. refer
https://memcached.org/  
https://blog.stdio.io/850  
https://linux.die.net/man/8/saslpasswd2  
https://serverfault.com/questions/799488/sasl-how-to-delete-all-mech-entries-from-a-user    
https://www.iana.org/assignments/sasl-mechanisms/sasl-mechanisms.xhtml  
https://github.com/jaysonsantos/python-binary-memcached  


