<?php
session_start();
require_once __DIR__. '/../../config/.version.php';
require_once __DIR__. '/../inquire/.useragent.php';
require_once __DIR__. '/../pack/.alert.php';
require_once __DIR__. '/../pack/.console_log.php';
require_once __DIR__. '/../print/.model_log.php';

$uid = $_SESSION['uid'] ?? "0";
$currentIp = $_SERVER['REMOTE_ADDR'];
$currentagent = $_SERVER['HTTP_USER_AGENT'];
$currentDate = date('Y-m-d H:i:s');
$currentDay = date('Y-m-d');
$sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));

$dataIP = __DIR__. '/../../data/database/ip.json';

$dataip = [];

if (file_exists($dataIP)) {
    $jsonIP = file_get_contents($dataIP);
    $dataip = json_decode($jsonIP, true) ?: [];
}

$userIndex = null;
foreach ($dataip as $index => $entry) {
    if ($entry['uid'] === $uid) {
        $userIndex = $index;
        break;
    }
}

$latestIpRecord = null;
if ($userIndex !== null && !empty($dataip[$userIndex]['ip'])) {
    $ips = $dataip[$userIndex]['ip'];
    usort($ips, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
    $latestIpRecord = $ips[0];
}

$shouldRecord = false;
if (!$latestIpRecord) {
    $shouldRecord = true;
} else {
    if ($uid === "0") {
        $latestDay = date('Y-m-d', strtotime($latestIpRecord['date']));
        if ($latestIpRecord['addr'] === $currentIp && $latestDay === $currentDay) {
            $shouldRecord = false;
        } else {
            $shouldRecord = true;
        }
    } else {
        if ($latestIpRecord['addr'] !== $currentIp) {
            $shouldRecord = true;
        } elseif (strtotime($latestIpRecord['date']) < strtotime($sevenDaysAgo)) {
            $shouldRecord = true;
        }
    }
}

if ($shouldRecord) {
    $newRecord = [
        'addr' => $currentIp,
        'date' => $currentDate,
		'user-agent' => $currentagent
    ];
    
    if ($userIndex === null) {
        $newEntry = [
            'uid' => $uid,
            'ip' => [ $newRecord ]
        ];
        $dataip[] = $newEntry;
    } else {
        $dataip[$userIndex]['ip'][] = $newRecord;
    }
    
    $jsonIP = json_encode($dataip, JSON_PRETTY_PRINT);
    
    $dir = dirname($dataIP);
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    
    $result = file_put_contents($dataIP, $jsonIP);
	if ($result !== false && $uid === "0") {
		console_warn("未登录");
    } elseif ($result !== false) {
		console_info("已登录");
    } else {
		console_error("失败");
    }
} elseif ($uid === "0") {
	console_warn("未登录，无");
} else {
	console_info("已登录，无");
}