## 常用正则表达式 
> Last Modified in Oct 10, 2017

#### 匹配中文字符:
    [\u4e00-\u9fa5]

#### 匹配双字节字符(包括汉字在内): 
    [^\x00-\xff]

#### 匹配空白行:
    \n\s*\r

#### 匹配 Email 地址:
    [\w!#$%&'*+/=?^_`{|}~-]+(?:\.[\w!#$%&'*+/=?^_`{|}~-]+)*@(?:[\w](?:[\w-]*[\w])?\.)+[\w](?:[\w-]*[\w])?

#### 匹配网址URL:
    [a-zA-z]+://[^\s]*

#### 匹配国内电话号码:
    \d{3}-\d{8}|\d{4}-\{7,8}

#### 匹配腾讯QQ号:
    [1-9][0-9]{4,}

#### 匹配中国邮政编码:
    [1-9]\d{5}(?!\d)

#### 匹配18位身份证号:
    ^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$

#### 匹配整数:
    ^-?[1-9]\d*$

#### 匹配非负整数（正整数 + 0):
    ^[1-9]\d*|0$

#### 匹配非正整数（负整数 + 0):
    ^-[1-9]\d*|0$

#### 匹配正浮点数:
    ^[1-9]\d*\.\d*|0\.\d*[1-9]\d*$

#### 匹配负浮点数:
    ^-[1-9]\d*\.\d*|-0\.\d*[1-9]\d*$