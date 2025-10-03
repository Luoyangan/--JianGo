<?PHP
require_once __DIR__. '/../../config/.version.php';
/**
 * 设置HTML页面标题
 * @param string $title 页面标题
 * @return void
 */
function title($title) {
    if (is_array($title) || is_object($title)) {
        $titlea = $title;
    } else {
        $titlea = (string)$title;
    }
	echo "<title>{$titlea}</title>";
}