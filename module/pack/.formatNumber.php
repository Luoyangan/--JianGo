<?php
require_once __DIR__. '/../../config/.version.php';
# 格式化数字
function formatNumber($num) {
	if (!is_numeric($num)) {
		return '0';
	}
	$num = (float)$num;					
	if ($num >= 100000000) {
		return number_format($num / 100000000, 1). '亿';// 亿
	} elseif ($num >= 10000) {
		$decimalPlaces = $num >= 100000? 1 : 0;
		return number_format($num / 10000, $decimalPlaces). 'w';// 万
	} elseif ($num >= 1000) {
		$value = $num / 1000;
		return $value == (int)$value? (int)$value. 'k' : number_format($value, 1). 'k';// 千
	}
	return $num == (int)$num? (int)$num : $num;
}