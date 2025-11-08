<?php
require_once __DIR__ . '/../config/config.php';
include __DIR__ . '/templates/header.php';
?>
<main class="welcome-section">
  <h1>Bem-vindo ao Gerenciador de Países e Cidades</h1>
  <p>Desenvolvido por <strong>Gustavo Soares Pimentel</strong>, este sistema foi criado para centralizar e gerenciar registros de países e cidades de forma eficiente.</p>
  
  <h2>Sobre o Sistema</h2>
  <p>O sistema utiliza as seguintes tecnologias:</p>
  <ul>
    <li>SQL</li>
    <li>HTML</li>
    <li>PHP</li>
    <li>JavaScript</li>
    <li>CSS</li>
  </ul>
  
  <p>Funcionalidades principais:</p>
  <ul>
    <li>CRUD completo para países e cidades.</li>
    <li>Integração com APIs externas:</li>
    <ul>
      <li><strong>Restcountries</strong>: Informações sobre capital, moeda e bandeira dos países cadastrados.</li>
      <li><strong>OpenWeather</strong>: Exibição de clima, temperatura e umidade das cidades cadastradas.</li>
    </ul>
  </ul>
</main>
<?php include __DIR__ . '/templates/footer.php'; ?>