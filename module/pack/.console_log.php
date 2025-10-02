<?PHP
require_once __DIR__. '/../../config/.version.php';

/**
 * 控制台普通信息
 * @param mixed $message 普通信息
 * @return void
 */
function console_log($message) {
    if (is_array($message) || is_object($message)) {
        $message = json_encode($message);
    } else {
        $message = json_encode((string)$message);
    }
	echo "<script>console.log({$message});</script>";
}

/**
 * 控制台普通信息
 * @param mixed $message 普通信息
 * @return void
 */
function console_info($message) {
    if (is_array($message) || is_object($message)) {
        $message = json_encode($message);
    } else {
        $message = json_encode((string)$message);
    }
	echo "<script>console.info({$message});</script>";
}

/**
 * 控制台警告信息
 * @param mixed $message 警告信息
 * @return void
 */
function console_warn($message) {
    if (is_array($message) || is_object($message)) {
        $message = json_encode($message);
    } else {
        $message = json_encode((string)$message);
    }
	echo "<script>console.warn({$message});</script>";
}

/**
 * 控制台错误信息
 * @param mixed $message 错误信息
 * @return void
 */
function console_error($message) {
    if (is_array($message) || is_object($message)) {
        $message = json_encode($message);
    } else {
        $message = json_encode((string)$message);
    }
	echo "<script>console.error({$message});</script>";
}