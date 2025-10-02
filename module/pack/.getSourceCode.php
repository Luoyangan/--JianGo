<?php
require_once __DIR__. '/../../config/.version.php';
# 读取文件内容并返回Base64编码，若文件不存在则返回示例代码
function getSourceCode($targetFile) {
    if (file_exists($targetFile) && is_readable($targetFile)) {
        $content = file_get_contents($targetFile);
        $content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, GBK, GB2312, LATIN1', true));
    } else {
        $extension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $content = getSampleCodeByExtension($extension);
    }

    return base64_encode($content);
}