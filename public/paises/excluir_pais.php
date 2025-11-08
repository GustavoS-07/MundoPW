<?php
require_once __DIR__ . '/../../config/config.php';
$id = intval($_GET['id'] ?? 0);
if(!$id){ header('Location: /paises/listar_paises.php'); exit; }

$c = $pdo->prepare('SELECT COUNT(*) AS qtd FROM cidades WHERE id_pais = ?');
$c->execute([$id]);
$row = $c->fetch();
if($row['qtd'] > 0){

    header('Location: listar_paises.php?error=has_cities');
    exit;
}
$d = $pdo->prepare('DELETE FROM paises WHERE id_pais = ?');
$d->execute([$id]);
header('Location: listar_paises.php');
exit;
?>