<?php
require_once __DIR__ . '/../../config/config.php';
$id = intval($_GET['id'] ?? 0);
if(!$id){ header('Location: ./listar_cidades.php'); exit; }
$d = $pdo->prepare('DELETE FROM cidades WHERE id_cidade = ?');
$d->execute([$id]);
header('Location: ./listar_cidades.php');
exit;
?>