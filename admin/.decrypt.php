<?php
require_once __DIR__. '/../config/.version.php';
/**
 * 解密并执行加密代码
 * @param string $encrypted_code 加密的代码字符串
 * @param string $key_part1 密钥部分1
 * @param string $key_part2 密钥部分2
 * @throws Exception 如果解密或执行失败则抛出异常
 */
function decrypt_and_run($encrypted_code, $key_part1, $key_part2) {
    $key = 'luoyangan' . $key_part1 . $key_part2;
    
    $decoded = base64_decode($encrypted_code);
    if ($decoded === false) {
        throw new Exception("数据解码失败");
    }
    
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    if (strlen($decoded) < $iv_length) {
        throw new Exception("加密数据不完整");
    }
    $iv = substr($decoded, 0, $iv_length);
    $encrypted_data = substr($decoded, $iv_length);
    
    $decrypted = openssl_decrypt(
        $encrypted_data,
        'aes-256-cbc',
        hash('sha256', $key, true),
        OPENSSL_RAW_DATA,
        $iv
    );
    
    if ($decrypted === false) {
        throw new Exception("解密失败，可能原因：1.密钥错误 2.加密数据损换 3.解密算法错误");
    }
    
    ob_start();
    eval('?>'.$decrypted.'<?php ');
    ob_end_flush();
}