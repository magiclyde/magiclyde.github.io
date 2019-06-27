#!/usr/bin/eny python
#coding=utf-8

import urllib2
from urllib import urlencode
import json

def get_iciba(**kwargs):
    """
    金山词霸-每日一句
    http://open.iciba.com/?c=wiki
    """

    url = 'http://open.iciba.com/dsapi/'
    if kwargs:
        qs = urlencode(kwargs)
        url = url + '?' + qs

    req = urllib2.Request(url)
    resp = urllib2.urlopen(req)
    raw_json_data = resp.read()

    # to python obj
    d = json.loads(raw_json_data)
    
    json_data = json.dumps(d, ensure_ascii=False, encoding='utf-8')

    return json_data


if __name__ == '__main__':

    data = get_iciba()

    #data = get_iciba(date='2019-06-26')

    #data = get_iciba(date='2019-06-25', type='next')
    
    print data
