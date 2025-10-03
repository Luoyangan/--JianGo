<?PHP
require_once __DIR__. '/../../config/.version.php';
/**
 * 页面弹窗
 * @param mixed $alert 弹窗内容
 * @return void
 */
function alert($alert) {
    if (is_array($alert) || is_object($alert)) {
        $alert = json_encode($alert);
    } else {
        $messalertage = json_encode((string)$alert);
    }
	echo "<script>console.log({$alert});</script>";
}