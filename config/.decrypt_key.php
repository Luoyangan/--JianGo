<?php
require_once __DIR__. '/../admin/.decrypt.php';
require_once __DIR__. '/.version.php';
/**
 * 解密并执行加密代码
 * @param string $encrypted_codes 加密的代码字符串
 */
function decrypt($encrypted_codes) {
    $key_part1 = "10086";
    try {
        decrypt_and_run($encrypted_codes, "_", $key_part1);
    } catch (Exception $e) {
        echo "执行失败: " . $e->getMessage();
    }
}