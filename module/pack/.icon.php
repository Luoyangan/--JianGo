<?PHP
require_once __DIR__. '/../../config/.version.php';
/**
 * 设置HMTL页面图标
 * @param string $favicon_ico 图标路径 路径要绝对路径，如：/favicon.ico
 * @return void
 */
function favicon_ico($favicon_ico) {
    if (is_array($favicon_ico) || is_object($favicon_ico)) {
        $favicon_icos = $favicon_ico;
    } else {
        $favicon_icos = (string)$favicon_ico;
    }
    $url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $url .= "://" . $_SERVER['HTTP_HOST'];
    echo '<link rel="icon" href="'.$url.$favicon_icos.'" type="image/x-icon">';
}