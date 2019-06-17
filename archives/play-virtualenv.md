### 1. 安装 virtualenv
    pip install virtualenv


### 2. 创建虚拟环境

SYNOPSIS：

    $ virtualenv  [OPTIONS]  [ENV_NAME]


    [OPTIONS]


        --no-site-packages ：
            默认情况下，虚拟环境会依赖系统环境中的 site package，如果不想依赖这些 package，可加上 --no-site-packages 

        --no-setuptools  在新建的虚拟环境中不安装工具包:

        -p PYTHON_EXE, --python=PYTHON_EXE  指定生成的虚拟环境使用的 Python 解释器：
                                            virtualenv -p /usr/bin/python ENV_NAME

        ...


示例：

    比如要在 microblog 文件夹下创建一个虚拟环境，命名为 venv ， 指定 python 版本为 python3.7：  

    /microblog$ virtualenv --python=/usr/local/python3.7/bin/python3  --no-site-packages venv 



### 3. 启动环境
    /microblog$ source venv/bin/activate

进入虚拟环境后，此时命令行的提示符会加入虚拟环境的名称，例如： 
    (venv) /microblog$


### 4. 退出环境
退出当前的 venv 环境，使用 deactivate 命令：

    (venv) /microblog$ deactivate


