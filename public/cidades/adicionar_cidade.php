<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../templates/headercidades.php';

$ps = $pdo->query('SELECT id_pais, nome FROM paises ORDER BY nome')->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $populacao = intval($_POST['populacao'] ?? 0);
    $id_pais = intval($_POST['id_pais'] ?? 0);
    if ($nome === '') $errors[] = 'Nome da cidade é obrigatório.';
    if ($id_pais <= 0) $errors[] = 'Selecione um país.';
    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO cidades (nome, populacao, id_pais) VALUES (?, ?, ?)');
        $stmt->execute([$nome, $populacao, $id_pais]);
        header('Location: listar_cidades.php');
        exit;
    }
}
?>
<section>
  <h2>Adicionar Cidade</h2>
  <?php if($errors): ?><div class="errors"><?php foreach($errors as $e) echo '<p>'.htmlspecialchars($e).'</p>'; ?></div><?php endif; ?>
  <form method="post" onsubmit="return validateCityForm(this)">
    <label>Nome<input name="nome" required></label>
    <label>População<input name="populacao" type="number" min="0"></label>
    <label>País
      <select name="id_pais" required>
        <option value="">-- selecione --</option>
        <?php foreach($ps as $p): ?>
          <option value="<?= $p['id_pais'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <button type="submit">Salvar</button>
  </form>
</section>
<?php include __DIR__ . '/../templates/footer.php'; ?>