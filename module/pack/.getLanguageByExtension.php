<?php
require_once __DIR__. '/../../config/.version.php';
# 根据文件扩展名自动检测语言
function getLanguageByExtension($filename, $mappings) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return isset($mappings[$extension]) ? $mappings[$extension] : 'plaintext';
}