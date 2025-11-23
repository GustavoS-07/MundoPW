<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/templates/header.php';
?>

<?php
$stmt = $pdo->query('SELECT COUNT(*) FROM paises');
$count_paises = $stmt->fetchColumn();
$stmt = $pdo->query('SELECT COUNT(*) FROM cidades');
$count_cidades = $stmt->fetchColumn();

$top_paises = $pdo->query('SELECT nome, populacao FROM paises ORDER BY populacao DESC LIMIT 5')->fetchAll();

$recent_cidades = $pdo->query('SELECT c.id_cidade, c.nome AS cidade, p.nome AS pais FROM cidades c LEFT JOIN paises p ON c.id_pais = p.id_pais ORDER BY c.id_cidade DESC LIMIT 5')->fetchAll();
?>

<section>
	<h2>Dashboard</h2>
	<div class="cards">
		<div class="card">
			<h3>Países</h3>
			<p class="big"><?= (int)$count_paises ?></p>
			<p><a href="paises/listar_paises.php">Ver países</a></p>
		</div>
		<div class="card">
			<h3>Cidades</h3>
			<p class="big"><?= (int)$count_cidades ?></p>
			<p><a href="cidades/listar_cidades.php">Ver cidades</a></p>
		</div>
	</div>

	<div class="grids">
		<div class="grid-item">
			<h3>Países mais populosos</h3>
			<table>
				<thead><tr><th>Nome</th><th>População</th></tr></thead>
				<tbody>
				<?php foreach($top_paises as $p): ?>
					<tr>
						<td><?= htmlspecialchars($p['nome']) ?></td>
						<td><?= number_format($p['populacao'], 0, ',', '.') ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="grid-item">
			<h3>Cidades recentes</h3>
			<table>
				<thead><tr><th>Nome</th><th>País</th><th>Ações</th></tr></thead>
				<tbody>
				<?php foreach($recent_cidades as $c): ?>
					<tr>
						<td><?= htmlspecialchars($c['cidade']) ?></td>
						<td><?= htmlspecialchars($c['pais'] ?? '—') ?></td>
						<td>
							<a href="cidades/editar_cidade.php?id=<?= $c['id_cidade'] ?>">Editar</a> |
							<a class="btn-delete" href="cidades/excluir_cidade.php?id=<?= $c['id_cidade'] ?>">Excluir</a>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>

<?php include __DIR__ . '/templates/footer.php'; ?>