<?php

function getRealIP() {

    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']))
        return $_SERVER['HTTP_CF_CONNECTING_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];

    return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
}


function detectBot($userAgent) {

    $bots = [
        'Googlebot',
        'Bingbot',
        'YandexBot',
        'DuckDuckBot',
        'Baiduspider',
        'facebookexternalhit',
        'Twitterbot',
        'LinkedInBot',
        'WhatsApp',
        'TelegramBot',
        'Applebot',
        'AhrefsBot',
        'SemrushBot',
        'MJ12bot'
    ];

    foreach ($bots as $bot) {
        if (stripos($userAgent, $bot) !== false) {
            return $bot;
        }
    }

    if (preg_match('/bot|crawl|spider|slurp/i', $userAgent)) {
        return 'Unknown bot';
    }

    return false;
}


function detectDevice($ua) {

    if (preg_match('/tablet|ipad/i', $ua)) {
        return 'tablet';
    }

    if (preg_match('/mobile/i', $ua)) {
        return 'mobile';
    }

    return 'desktop';
}


function detectOS($ua) {

    $oses = [
        'Windows' => 'Windows',
        'Mac' => 'MacOS',
        'iPhone' => 'iOS',
        'iPad' => 'iOS',
        'Android' => 'Android',
        'Linux' => 'Linux'
    ];

    foreach ($oses as $key => $value) {
        if (stripos($ua, $key) !== false) {
            return $value;
        }
    }

    return 'Unknown';
}


function getGeo($ip) {

    $url = "http://ip-api.com/json/$ip";

    $json = @file_get_contents($url);

    if (!$json) {
        return ['', '', ''];
    }

    $data = json_decode($json, true);

    return [
        $data['country'] ?? '',
        $data['city'] ?? '',
        $data['isp'] ?? ''
    ];
}


function logVisit($pdo, $startTime, $lang) {

    $ip = getRealIP();

    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $acceptLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    $sessionId = session_id();

    $botName = detectBot($userAgent);
    $isBot = $botName ? 1 : 0;

    $deviceType = detectDevice($userAgent);
    $os = detectOS($userAgent);

    list($country, $city, $isp) = getGeo($ip);

    $headers = getallheaders();
    $headersJson = json_encode($headers, JSON_UNESCAPED_UNICODE);

    $loadTime = round((microtime(true) - $startTime) * 1000);

    $stmt = $pdo->prepare("
    INSERT INTO page_visits
    (
    ip,
    country,
    city,
    isp,
    is_bot,
    bot_name,
    device_type,
    os,
    load_time_ms,
    user_agent,
    accept_language,
    page_lang,
    referer,
    request_uri,
    headers,
    session_id
    )
    VALUES
    (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $ip,
        $country,
        $city,
        $isp,
        $isBot,
        $botName,
        $deviceType,
        $os,
        $loadTime,
        $userAgent,
        $acceptLang,
        $lang,
        $referer,
        $requestUri,
        $headersJson,
        $sessionId
    ]);
}