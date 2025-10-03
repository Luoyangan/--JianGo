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
 * 插入数据到数据库表
 * @param mysqli $conn 数据库连接
 * @param string $table_name 表名
 * @param array $data 要插入的数据，格式：['字段名' => '字段值', ...]
 * @return bool 插入是否成功
 */
function db_insert($conn, $table_name, $data) {
    $table_name_escaped = mysqli_real_escape_string($conn, $table_name);
    $fields = [];
    $values = [];
    foreach ($data as $field => $value) {
        $escaped_field = mysqli_real_escape_string($conn, $field);
        $fields[] = "`{$escaped_field}`";
        if ($value === null) {
            $values[] = "NULL";
        } elseif (is_bool($value)) {
            $values[] = $value ? 1 : 0;
        } elseif (is_numeric($value) && !is_string($value)) {
            $values[] = $value;
        } else {
            $escaped_value = mysqli_real_escape_string($conn, $value);
            $values[] = "'{$escaped_value}'";
        }
    }
    $sql = "INSERT INTO `{$table_name_escaped}` (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")";
    if (mysqli_query($conn, $sql)) {
        //console_info("数据插入成功，表：`{$table_name}`，影响行数：" . mysqli_affected_rows($conn));
        return true;
    } else {
        console_error("数据插入失败：" . mysqli_error($conn));
        return false;
    }
}

/**
 * 更新数据库表中的数据
 * @param mysqli $conn 数据库连接
 * @param string $table_name 表名
 * @param array $data 要更新的数据，格式：[列名 => 值]
 * @param string $where 可选的WHERE条件，不需要包含WHERE关键字
 * @return int|false 受影响的行数或false
 */
function db_update($conn, $table_name, $data, $where = '') {
    if (!is_object($conn) || $conn->connect_error || empty($table_name) || !is_array($data) || empty($data)) {
        console_error('数据库连接无效或表名/数据为空');
        return false;
    }
    $table_name_escaped = mysqli_real_escape_string($conn, $table_name);
    $set_clauses = [];
    foreach ($data as $column => $value) {
        $column_escaped = mysqli_real_escape_string($conn, $column);
        if ($value === null) {
            $set_clauses[] = "`{$column_escaped}` = NULL";
        } else if (is_bool($value)) {
            $set_clauses[] = "`{$column_escaped}` = " . ($value ? 1 : 0);
        } else if (is_numeric($value) && !is_string($value)) {
            $set_clauses[] = "`{$column_escaped}` = {$value}";
        } else {
            $value_escaped = mysqli_real_escape_string($conn, $value);
            $set_clauses[] = "`{$column_escaped}` = '{$value_escaped}'";
        }
    }
    $sql = "UPDATE `{$table_name_escaped}` SET " . implode(', ', $set_clauses);
    if (!empty($where)) {
        $sql .= " WHERE {$where}";
    }
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        console_error("数据更新失败: " . mysqli_error($conn) . "\nSQL: " . $sql);
        return false;
    }
    $affected_rows = mysqli_affected_rows($conn);
    //console_info("数据更新成功，表：`{$table_name}`，受影响行数：{$affected_rows}");
    return $affected_rows;
}

/**
 * 从数据库表中删除数据
 * @param mysqli $conn 数据库连接
 * @param string $table_name 表名
 * @param string $where 可选的WHERE条件，不需要包含WHERE关键字
 * @return int|false 受影响的行数或false
 */
function db_delete($conn, $table_name, $where = '') {
    $table_name_escaped = mysqli_real_escape_string($conn, $table_name);
    $sql = "DELETE FROM `{$table_name_escaped}`";
    if (!empty($where)) {
        $sql .= " WHERE {$where}";
    }
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        console_error("数据删除失败: " . mysqli_error($conn) . "\nSQL: " . $sql);
        return false;
    }
    $affected_rows = mysqli_affected_rows($conn);
    //console_info("数据删除成功，表：`{$table_name}`，受影响行数：{$affected_rows}");
    return $affected_rows;
}

/**
 * 从数据库表中读取数据
 * @param mysqli $conn 数据库连接
 * @param string $table_name 表名 或 完整的SELECT语句
 * @param array|string $fields 仅在$table_name为表名时有效，默认为'*'
 * @return array|false 查询结果数组或false
 */
function db_select($conn, $table_name, $fields = '*') {
    $sql = '';
    if (stripos(trim($table_name), 'SELECT ') === 0) {
        $sql = $table_name;
    } else {
        $table_name_escaped = mysqli_real_escape_string($conn, $table_name);
        if (is_array($fields)) {
            $escaped_fields = [];
            foreach ($fields as $field) {
                $escaped_field = mysqli_real_escape_string($conn, $field);
                $escaped_fields[] = "`{$escaped_field}`";
            }
            $fields_str = implode(', ', $escaped_fields);
        } else {
            $fields_str = $fields;
        }
        
        $sql = "SELECT {$fields_str} FROM `{$table_name_escaped}`";
    }
    try {
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            throw new Exception(mysqli_error($conn));
        }
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_free_result($result);
        return $data;
    } catch (Exception $e) {
        $error_msg = "数据查询失败：" . $e->getMessage() . "\nSQL: " . $sql;
        console_error($error_msg);
        return false;
    }
}

/**
 * 执行数据查询并返回结果
 * @param mysqli $conn 数据库连接
 * @param string $sql SQL查询语句
 * @param array $params 可选的参数数组，用于预处理语句（防SQL注入）
 * @return array|false 查询结果数组或false（失败时）
 */
function db_fetch($conn, $sql, $params = []) {
    try {
        if (!is_object($conn) || !($conn instanceof mysqli) || $conn->connect_error) {
            throw new Exception("数据库连接无效");
        }
        if (empty($sql) || !is_string($sql)) {
            throw new Exception("无效的SQL语句");
        }
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            throw new Exception(mysqli_error($conn) . "\nSQL: " . $sql);
        }
        $is_select = stripos(trim($sql), 'SELECT ') === 0 || 
                    stripos(trim($sql), 'SHOW ') === 0 || 
                    stripos(trim($sql), 'DESCRIBE ') === 0 || 
                    stripos(trim($sql), 'EXPLAIN ') === 0;
        
        if ($is_select) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            mysqli_free_result($result);
            return $data;
        } else {
            return mysqli_affected_rows($conn);
        }
    } catch (Exception $e) {
        $error_msg = "数据库查询执行失败：" . $e->getMessage();
        console_error($error_msg);
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