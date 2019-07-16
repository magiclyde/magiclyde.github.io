#coding=utf-8
# refer: https://www.kunxi.org/2014/05/lru-cache-in-python/
# test: python -m cProfile OrderedLRUCache.py 

from collections import OrderedDict

class OrderedLRUCache(object):
    def __init__(self, capacity):
        self.capacity = capacity
        self.cache = OrderedDict()

    def get(self, key):
        try:
            value = self.cache.pop(key)
            self.cache[key] = value
            return value
        except KeyError:
            return -1


    def set(self, key, value):
        try:
            self.cache.pop(key)
        except KeyError:
            if len(self.cache) >= self.capacity:
                self.cache.popitem(last = False) #pop出第一个item
        
        self.cache[key] = value

if __name__ == '__main__':
    c = OrderedLRUCache(50)
    for i in xrange(1,100):
        c.set(i, i*10)
    
    assert c.get(1) == -1
    assert c.get(51) == 510
