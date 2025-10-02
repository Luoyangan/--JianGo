<?php
# HTML页面语言-可以提高SEO优化
function lang($lang) {
    $supported_langs = [
        'zh-CN', 'zh-TW', 'zh-HK',   // 中文系列
        'en-US', 'en-GB',            // 英语系列
        'es-ES', 'es-MX',            // 西班牙语系列
        'fr-FR', 'fr-CA',            // 法语系列
        'de-DE', 'ja-JP', 'ko-KR',   // 德、日、韩
        'ru-RU', 'pt-PT', 'pt-BR',   // 俄、葡语系列
        'ar-SA', 'ar-EG', 'it-IT',   // 阿拉伯语、意大利语
        'nl-NL', 'nl-BE', 'hi-IN',   // 荷兰语、印地语
        'ur-PK', 'tr-TR', 'pl-PL',   // 乌尔都语、土耳其语、波兰语
        'sv-SE'                      // 瑞典语
    ];
    if (in_array($lang, $supported_langs)) {
        echo "<html lang=\"$lang\">";
    } else {
        echo '<html lang="zh-CN">'; // 默认语言
    }
}