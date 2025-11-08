<?php
if (!isset($_GET['name'])) { http_response_code(400); echo json_encode(['error'=>'name required']); exit; }
$name = urlencode($_GET['name']);
$ch = curl_init("https://restcountries.com/v3.1/translation/$name");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$res = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($res === false){ http_response_code(500); echo json_encode(['error'=>'curl']); exit; }
http_response_code($code);
header('Content-Type: application/json; charset=utf-8');
echo $res;
?>