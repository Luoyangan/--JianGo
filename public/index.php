<!DOCTYPE html>
<?php
# 依赖函数
require_once __DIR__. '/../module/print/.model_log.php';
require_once __DIR__. '/../module/pack/.title.php';
require_once __DIR__. '/../module/pack/html/.coding.php';
require_once __DIR__. '/../module/pack/html/.lang.php';
require_once __DIR__. '/../module/pack/.formatNumber.php';
lang('zh-CN');
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
charset('UTF-8');
title("简构 JianGo");
# 页面图标-SEO优化
require_once __DIR__. '/../seo/favicon/.icon.php';
?>
    <style>
        .kj {
            background-color: #fff;
            margin-top: 20%;
            margin-block: 20%;
            text-align: center;
        }
    </style>
</head>
</body>
    <div class="kj">
        <h1>简构 (JianGo) 框架 开发中...</h1>
        <p>此框架由 Luoyangan 独家所有</p>
    </div>
<?php
# 页脚-预设功能模块
require_once __DIR__. '/../page/.footer.php';
?>
</body>
</html>