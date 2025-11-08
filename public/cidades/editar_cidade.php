<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../templates/headercidades.php';
$id = intval($_GET['id'] ?? 0);
if(!$id){ header('Location: /cidades/listar_cidades.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM cidades WHERE id_cidade = ?');
$stmt->execute([$id]);
$cidade = $stmt->fetch();
if(!$cidade){ echo '<p>Cidade não encontrada.</p>'; include __DIR__ . '/../templates/footer.php'; exit; }
$ps = $pdo->query('SELECT id_pais, nome FROM paises ORDER BY nome')->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $populacao = intval($_POST['populacao'] ?? 0);
    $id_pais = intval($_POST['id_pais'] ?? 0);
    if ($nome === '') $errors[] = 'Nome da cidade é obrigatório.';
    if ($id_pais <= 0) $errors[] = 'Selecione um país.';
    if (empty($errors)) {
        $u = $pdo->prepare('UPDATE cidades SET nome=?, populacao=?, id_pais=? WHERE id_cidade=?');
        $u->execute([$nome, $populacao, $id_pais, $id]);
        header('Location: ./listar_cidades.php');
        exit;
    }
}
?>
<section class="container">
  <h2>Editar Cidade</h2>
  <?php if($errors): ?>
    <div class="errors">
      <?php foreach($errors as $e): ?>
        <p><?= htmlspecialchars($e) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <form method="post" onsubmit="return validateCityForm(this)">
    <label>Nome
      <input name="nome" value="<?= htmlspecialchars($cidade['nome']) ?>" required>
    </label>
    <label>População
      <input name="populacao" type="number" min="0" value="<?= htmlspecialchars($cidade['populacao']) ?>">
    </label>
    <label>País
      <select name="id_pais" required>
        <option value="">-- selecione --</option>
        <?php foreach($ps as $p): ?>
          <option value="<?= $p['id_pais'] ?>" <?= $p['id_pais'] == $cidade['id_pais'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['nome']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <button type="submit">Salvar</button>
  </form>
</section>
<?php include __DIR__ . '/../templates/footer.php'; ?>