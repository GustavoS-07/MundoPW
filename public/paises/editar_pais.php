<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../templates/headerpaises.php';
$id = intval($_GET['id'] ?? 0);
if(!$id){ header('Location: /paises/listar_paises.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM paises WHERE id_pais = ?');
$stmt->execute([$id]);
$pais = $stmt->fetch();
if(!$pais){ echo '<p>País não encontrado.</p>'; include __DIR__ . '/../templates/footer.php'; exit; }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $continente = trim($_POST['continente'] ?? '');
    $populacao = intval($_POST['populacao'] ?? 0);
    $idioma = trim($_POST['idioma'] ?? '');
    if ($nome === '') $errors[] = 'Nome é obrigatório.';
    if ($continente === '') $errors[] = 'Continente é obrigatório.';
    if (empty($errors)) {
        $u = $pdo->prepare('UPDATE paises SET nome=?, continente=?, populacao=?, idioma=? WHERE id_pais=?');
        $u->execute([$nome, $continente, $populacao, $idioma, $id]);
        header('Location: listar_paises.php');
        exit;
    }
}
?>
<section>
  <h2>Editar País</h2>
  <?php if($errors): ?>
    <div class="errors"><?php foreach($errors as $e) echo '<p>'.htmlspecialchars($e).'</p>'; ?></div>
  <?php endif; ?>
  <form method="post" onsubmit="return validateCountryForm(this)">
    <label>Nome<input name="nome" value="<?=htmlspecialchars($pais['nome'])?>" required></label>
    <label>Continente<input name="continente" value="<?=htmlspecialchars($pais['continente'])?>" required></label>
    <label>População<input name="populacao" type="number" min="0" value="<?=htmlspecialchars($pais['populacao'])?>"></label>
    <label>Idioma principal<input name="idioma" value="<?=htmlspecialchars($pais['idioma'])?>"></label>
    <button type="submit">Salvar</button>
  </form>
</section>
<?php include __DIR__ . '/../templates/footer.php'; ?>