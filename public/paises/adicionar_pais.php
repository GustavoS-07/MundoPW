<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../templates/headerpaises.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = trim($_POST['nome'] ?? '');
  $continente = trim($_POST['continente'] ?? '');
  $populacao = intval($_POST['populacao'] ?? 0);
  $idioma = trim($_POST['idioma'] ?? '');
  if ($nome === '')
    $errors[] = 'Nome é obrigatório.';
  if ($continente === '')
    $errors[] = 'Continente é obrigatório.';
  if (empty($errors)) {
    $stmt = $pdo->prepare('INSERT INTO paises (nome, continente, populacao, idioma) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nome, $continente, $populacao, $idioma]);
    header('Location: listar_paises.php');
    exit;
  }
}
?>
<section>
  <h2>Adicionar País</h2>
  <?php if ($errors): ?>
    <div class="errors">
      <?php foreach ($errors as $e)
        echo '<p>' . htmlspecialchars($e) . '</p>'; ?>
    </div>
  <?php endif; ?>
  <form method="post" onsubmit="return validateCountryForm(this)">
    <label>Nome<input name="nome" required></label>
    <label>Continente<input name="continente" required></label>
    <label>População<input name="populacao" type="number" min="0"></label>
    <label>Idioma principal<input name="idioma"></label>
    <button type="submit">Salvar</button>
  </form>
</section>
<?php include __DIR__ . '/../templates/footer.php'; ?>