def rdlimg(url, path, headers = None):
    '''
    remote download img
    '''
    import os
    import requests
    from PIL import Image
    from io import BytesIO
    
    isExists = os.path.exists(path)

    if not isExists:
        if headers:
            r = requests.get(url, headers = headers)
        else:    
            r = requests.get(url)
        
        if r.status_code != 200 :
            print(url + ' 图片下载失败')
            print("status_code %d" % r.status_code)
            return False

        try:
            image = Image.open(BytesIO(r.content))
            image.save(path)
            print(path + ' 图片下载保存成功')
            rt = True
        except IOError:
            print(path + ' 图片保存失败')
            rt = False

        return rt
    else:
        print(path + ' 图片已存在')
        return False
