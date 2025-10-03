<?php
require_once __DIR__. '/../../config/.version.php';
/**
 * 根据文件扩展名自动检测语言
 * @param string $filename 文件名
 * @param array $mappings 扩展名到语言的映射数组
 * @return string 检测到的语言
 */
function getLanguageByExtension($filename, $mappings) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return isset($mappings[$extension]) ? $mappings[$extension] : 'plaintext';
}