# 简构 (JianGou)

简构 (JianGou) 是一款专注于模块化设计的轻量级PHP开发框架

非常适合刚开始学习PHP的开发者，也适合有一定PHP开发经验的开发者

# 项目介绍

这是一个基于PHP所开发的轻量级模块框架，用于快速开发和部署PHP项目，它提供了模块化的结构，便于代码组织和维护。

此框架大大减少了项目的开发时间和维护成本，同时也提高了项目的可维护性和可扩展性。

同时，此框架还提供了一些常用的功能模块，如数据库操作、数据记录、会话处理等，方便开发者快速实现项目需求。

# 环境要求

建议使用 PHP 7.4 及以上版本，推荐使用 PHP 8.4

推荐使用 Apache 或 Nginx 作为服务器

部署或运行时请将网站的运行目录改为 public/

# 项目结构

框架采用清晰的目录分层设计，主要包括：

```
module/：核心功能模块，如功能封装、日志记录、用户代理检测等
page/：页面组件，包括页头、页脚和各类HTML元素
public/：公共访问目录，包含入口文件和静态资源
config/：配置文件目录，存储框架关键配置信息
data/：数据存储目录，包含数据库配置和JSON数据
```

# Nginx 配置

请将以下添加或修改到Nginx配置文件(nginx.conf)中的 server 块中

```nginx
server {

    # 请将以下添加或修改到 server 块中

    # error_page 403 /error/403.php;
    error_page 404 /error/404.php;
    # error_page 502 /error/502.php;

    # 禁止外部访问前缀带(.)的文件，并指向404页面
    # 但内部请求可以访问
    location ~ /\. {
        return 404;
        internal;
    }

    location / {
        try_files $uri $uri/ @php_rewrite;
    }
    
    # 请求时可以不用带(.php)后缀
    # 但内部请求必须带(.php)后缀
    location @php_rewrite {
        rewrite ^/(.*)$ /$1.php last;
    }
}
```

# 关于作者

简构 (JianGou) 框架由独立开发者Luoyangan精心打造，持续更新维护，如有疑问或建议，可通过官方网站 https://mcyszl.top 或 QQ群 812500721 进行交流。