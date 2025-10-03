<?php
require_once __DIR__. '/../../config/.version.php';
/**
 * 根据文件扩展名返回示例代码
 * @param string $extension 文件扩展名
 * @return string 示例代码
 */
function getSampleCodeByExtension($extension) {
    switch (strtolower($extension)) {
        case 'php':
            return '# 未找到此文件
# 请确保文件路径正确，或创建一个新的PHP文件';
        case 'html':
            return '# 未找到此文件
# 请确保文件路径正确，或创建一个新的HTML文件';
        case 'css':
            return '# 未找到此文件
# 请确保文件路径正确，或创建一个新的CSS文件';
        case 'js':
            return '# 未找到此文件
# 请确保文件路径正确，或创建一个新的JS文件';
        case 'txt':
            return '未找到此文件
请确保文件路径正确，或创建一个新的TXT文件';
        case 'json':
            return '{
    "error": "未找到此文件",
    "message": "确保文件路径正确，或创建一个新的JSON文件"
}';
        case 'xml':
            return '<!-- 未找到此文件 -->
<!-- 确保文件路径正确，或创建一个新的XML文件 -->';
        default:
            return '# 未知文件类型
# 目前支持的文件类型: .php, .html, .css, .js, .txt, .json, .xml';
    }
}
