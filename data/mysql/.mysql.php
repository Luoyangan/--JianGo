<?php
require_once __DIR__ . '/../../config/.set.php';
require_once __DIR__ . '/../../module/pack/.console_log.php';
require_once __DIR__. '/../../config/.version.php';

/**
 * 获取数据库连接
 * @return mysqli|false 返回数据库连接对象或false
 */
function get_db_connection() {
    global $servername, $port, $dbname, $username, $password;
    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
    if (!$conn) {
        $error = '数据库连接失败: ' . mysqli_connect_error();
        console_error($error);
        return false;
    }
    mysqli_set_charset($conn, 'utf8mb4');
    return $conn;
}

/**
 * 关闭数据库连接
 * @param mysqli $conn 数据库连接
 */
function close_db_connection($conn) {
    if ($conn) {
        mysqli_close($conn);
    }
}

/**
 * 创建数据库表
 * @param mysqli $conn 数据库连接
 * @param string $table_name 表名
 * @param array $columns 列定义数组，格式：['列名' => '列类型及属性', ...]
 * @param bool $if_not_exists 是否添加IF NOT EXISTS
 * @param string $engine 存储引擎
 * @param string $charset 字符集
 * @return bool 创建结果
 */
function db_create_table($conn, $table_name, $columns, $if_not_exists = true, $engine = 'InnoDB', $charset = 'utf8mb4') {
    $table_name_escaped = mysqli_real_escape_string($conn, $table_name);
    $sql = "CREATE TABLE " . ($if_not_exists ? "IF NOT EXISTS " : "");
    $sql .= "`{$table_name_escaped}` (\n";
    $column_definitions = [];
    foreach ($columns as $column_name => $column_type) {
        $escaped_column = mysqli_real_escape_string($conn, $column_name);
        $column_definitions[] = "  `{$escaped_column}` {$column_type}";
    }
    $sql .= implode(",\n", $column_definitions);
    $sql .= "\n) ENGINE={$engine} DEFAULT CHARSET={$charset}";
    if (mysqli_query($conn, $sql)) {
        console_info("数据表 `{$table_name}` 创建成功");
        return true;
    } else {
        $error = "创建数据表 `{$table_name}` 错误: " . mysqli_error($conn);
        console_error($error);
        return false;
    }
}

/**
 * 转义字符串（防止SQL注入）
 * @param mysqli $conn 数据库连接
 * @param string $str 要转义的字符串
 * @return string 转义后的字符串
 */
function db_escape($conn, $str) {
    return mysqli_real_escape_string($conn, $str);
}

/**
 * 开始事务
 * @param mysqli $conn 数据库连接
 * @return bool 是否成功
 */
function db_begin_transaction($conn) {
    return mysqli_begin_transaction($conn);
}

/**
 * 提交事务
 * @param mysqli $conn 数据库连接
 * @return bool 是否成功
 */
function db_commit($conn) {
    return mysqli_commit($conn);
}

/**
 * 回滚事务
 * @param mysqli $conn 数据库连接
 * @return bool 是否成功
 */
function db_rollback($conn) {
    return mysqli_rollback($conn);
}