## pagespeed option

#### on 启用，off 关闭
    pagespeed on;

#### 设置缓存文件夹
    pagespeed FileCachePath /usr/local/nginx/ngx_pagespeed_cache;

#### enable CoreFilters
    pagespeed RewriteLevel CoreFilters;

#### 不压缩图片
    pagespeed DisableFilters rewrite_images;

#### 自动将图像转换成 WebP 格式或者是浏览器所支持的其它格式
    pagespeed EnableFilters convert_png_to_jpeg,convert_jpeg_to_webp;

#### 移除 html 空白
    pagespeed EnableFilters collapse_whitespace;

#### 移除 html 注释
    pagespeed EnableFilters remove_comments;

#### DNS 预加载
    pagespeed EnableFilters insert_dns_prefetch;

#### 压缩CSS
    pagespeed EnableFilters rewrite_css;

#### 合并CSS
    pagespeed EnableFilters combine_css;

#### 重写CSS，优化加载渲染页面的CSS规则
    pagespeed EnableFilters prioritize_critical_css;

#### google字体直接写入html 目的是减少浏览器请求和DNS查询
    pagespeed EnableFilters inline_google_font_css;

#### 压缩js
    pagespeed EnableFilters rewrite_javascript;

#### 合并js
    pagespeed EnableFilters combine_javascript;

#### 优化内嵌样式属性
    pagespeed EnableFilters rewrite_style_attributes;

#### 不加载显示区域以外的图片
    pagespeed LazyloadImagesAfterOnload off;

#### 图片预加载
    pagespeed EnableFilters inline_preview_images;

#### 移动端图片自适应重置
    pagespeed EnableFilters resize_mobile_images;

#### 图片延迟加载
    pagespeed EnableFilters lazyload_images;

#### 雪碧图片，图标很多的时候很有用
    pagespeed EnableFilters sprite_images;

#### 扩展缓存 改善页面资源的可缓存性
    pagespeed EnableFilters extend_cache;

#### 重写同步加载 Google Analytics（分析）跟踪代码的页面，以便以异步方式加载它
    pagespeed EnableFilters make_google_analytics_async;

#### 不能删, https://www.modpagespeed.com/doc/admin#handlers
    location ~ "\.pagespeed\.([a-z]\.)?[a-z]{2}\.[^.]{10}\.[^.]+" { add_header "" ""; }
    location ~ "^/ngx_pagespeed_static/" { }
    location ~ "^/ngx_pagespeed_beacon$" { }
    location /ngx_pagespeed_statistics { allow 127.0.0.1; deny all; }
    location /ngx_pagespeed_message { allow 127.0.0.1; deny all; }

