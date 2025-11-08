<?php
require_once __DIR__ . '/../../config/config.php';
$apiKey = defined('OPENWEATHER_API_KEY') ? OPENWEATHER_API_KEY : (getenv('OPENWEATHER_API_KEY') ?: null);
if(!$apiKey){ http_response_code(500); echo json_encode(['error'=>'OpenWeather API key not configured']); exit; }
if(!isset($_GET['q'])){ http_response_code(400); echo json_encode(['error'=>'q param required']); exit; }
$q = urlencode($_GET['q']);
$ch = curl_init("https://api.openweathermap.org/data/2.5/weather?q=$q&units=metric&appid=$apiKey&lang=pt_br");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($res === false){ http_response_code(500); echo json_encode(['error'=>'curl']); exit; }
http_response_code($code);
header('Content-Type: application/json; charset=utf-8');
echo $res;
?>
