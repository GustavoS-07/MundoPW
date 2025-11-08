<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../templates/headercidades.php';
$filter_pais = intval($_GET['filter_pais'] ?? 0);
if($filter_pais){
  $stmt = $pdo->prepare('SELECT c.*, p.nome AS nome_pais FROM cidades c JOIN paises p ON c.id_pais = p.id_pais WHERE p.id_pais = ? ORDER BY c.nome');
  $stmt->execute([$filter_pais]);
} else {
  $stmt = $pdo->query('SELECT c.*, p.nome AS nome_pais FROM cidades c JOIN paises p ON c.id_pais = p.id_pais ORDER BY p.nome, c.nome');
}
$cidades = $stmt->fetchAll();
?>
<section>
  <h2>Cidades</h2>
  <a href="adicionar_cidade.php">Adicionar cidade</a>
  <table>
    <thead><tr><th>ID</th><th>Nome</th><th>População</th><th>País</th><th>Clima</th><th>Temperatura</th><th>Umidade</th><th>Ações</th></tr></thead>
    <tbody id="tcidades">
    <?php foreach($cidades as $c): ?>
      <tr>
        <td><?=htmlspecialchars($c['id_cidade'])?></td>
        <td><?=htmlspecialchars($c['nome'])?></td>
        <td><?=number_format($c['populacao'],0,',','.')?></td>
        <td><?=htmlspecialchars($c['nome_pais'])?></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
          <a href="./editar_cidade.php?id=<?= $c['id_cidade'] ?>">Editar</a> |
          <a class="btn-delete" href="./excluir_cidade.php?id=<?= $c['id_cidade'] ?>">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</section>
<script>
  const tcidades = document.querySelector('#tcidades');

  async function fetchWeatherData() {
    for (let tr of tcidades.children) {
      try {
        const response = await fetch(`../api/openweather_proxy.php?q=${encodeURIComponent(tr.children[1].textContent)}`);
        const res = await response.json();

        tr.children[4].textContent = res.weather[0].description;
        tr.children[5].textContent = res.main.temp + ' °C';
        tr.children[6].textContent = res.main.humidity + ' %';
      } catch (error) {
        tr.children[4].textContent = 'Clima não encontrado';
        tr.children[5].textContent = 'Temperatura não encontrada';
        tr.children[6].textContent = 'Umidade não encontrada';
      }
    }
  }

  fetchWeatherData();
</script>
<?php include __DIR__ . '/../templates/footer.php'; ?>