<?php
require_once __DIR__ . '/../../config/config.php';
include __DIR__ . '/../templates/headerpaises.php';
$stmt = $pdo->query('SELECT * FROM paises ORDER BY nome');
$paises = $stmt->fetchAll();
?>
<section>
  <h2>Países</h2>
  <a href="adicionar_pais.php">Adicionar país</a>
  <table>
    <thead><tr><th>ID</th><th>Nome</th><th>Continente</th><th>População</th><th>Idioma</th><th>Capital</th><th>Moeda</th><th>Bandeira</th><th>Ações</th></tr></thead>
    <tbody id="tpaises">
    <?php foreach($paises as $p): ?>
      <tr>
        <td><?=htmlspecialchars($p['id_pais'])?></td>
        <td><?=htmlspecialchars($p['nome'])?></td>
        <td><?=htmlspecialchars($p['continente'])?></td>
        <td><?=number_format($p['populacao'], 0, ',', '.')?></td>
        <td><?=htmlspecialchars($p['idioma'])?></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
          <a href="editar_pais.php?id=<?= $p['id_pais'] ?>">Editar</a> |
          <a class="btn-delete" href="excluir_pais.php?id=<?= $p['id_pais'] ?>">Excluir</a> |
          <a href="../cidades/listar_cidades.php?filter_pais=<?= $p['id_pais'] ?>">Ver cidades</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</section>

<script>
  const tpaises = document.querySelector('#tpaises');
  
  async function fetchCountryData() {
    for (let tr of tpaises.children) {
      try {
        const response = await fetch(`../api/restcountries_proxy.php?name=${encodeURIComponent(tr.children[1].textContent)}`);
        const res = await response.json();

        tr.children[5].textContent = res[0].capital[0];

        tr.children[7].innerHTML = `<img src="${res[0].flags.png}" alt="${res[0].flags.alt}" width="50">`;

        const moeda = res[0].currencies;

        Object.keys(moeda).forEach(key => {
          tr.children[6].textContent = `${moeda[key]['name']} (${key})`;
        })
      } catch (error) {
        tr.children[5].textContent = 'Capital não encontrada';
        tr.children[6].textContent = 'Moeda não encontrada';
        tr.children[7].innerHTML = `<img src="../assets/img/erroimg.png" alt="Bandeira não encontrada" width="50">`;
      }
    }
  }

  fetchCountryData();
</script>

<?php include __DIR__ . '/../templates/footer.php'; ?>