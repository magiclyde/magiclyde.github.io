#!/usr/bin/env python
#coding=utf-8

import urllib2
from urllib import urlencode
import json

def get_iciba(**kw):
    """
    金山词霸-每日一句
    http://open.iciba.com/?c=wiki
    """

    file = 'json'
    url = 'http://open.iciba.com/dsapi/'

    
    if kw:
        if kw.has_key('file'):
            if kw['file'] == 'json' or kw['file'] == 'xml':
                file = kw['file']
            else:
                raise ValueError('param:file only support json and xml')

        qs = urlencode(kw)
        url = url + '?' + qs


    req = urllib2.Request(url)
    resp = urllib2.urlopen(req)
    data = resp.read()


    if file == 'json':    
        tmp = json.loads(data)
        data = json.dumps(tmp, ensure_ascii=False, encoding='utf-8')
     
    return data


if __name__ == '__main__':

    #data = get_iciba()
    #data = get_iciba(file='xml')
    #data = get_iciba(date='2019-06-26')
    data = get_iciba(file='json', date='2019-06-26', type='next')
    
    print data
