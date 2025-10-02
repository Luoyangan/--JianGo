<?PHP
require_once __DIR__. '/../../config/.version.php';
# HTML页面标题
function title($title) {
    if (is_array($title) || is_object($title)) {
        $titlea = $title;
    } else {
        $titlea = (string)$title;
    }
	echo "<title>{$titlea}</title>";
}