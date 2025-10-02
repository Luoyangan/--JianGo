<?PHP
require_once __DIR__. '/../inquire/.useragent.php';
require_once __DIR__. '/../pack/.console_log.php';
require_once __DIR__. '/../../config/.version.php';
# 控制台日志输出 PC/手机 设备
if (isset($isDesktop)) {
    if ($isDesktop) {
    	console_log("PC设备");
    } else {
    	console_log("手机设备");
    }
} else {
    console_log("未知设备");
}