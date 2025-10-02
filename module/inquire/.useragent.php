<?PHP
require_once __DIR__. '/../../config/.version.php';
# 设备判断
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $isDesktop = strpos($userAgent, 'Windows NT')!== false ||
        strpos($userAgent, 'Macintosh')!== false ||
        strpos($userAgent, 'X11; Linux')!== false;
}