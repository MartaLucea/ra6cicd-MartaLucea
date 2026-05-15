<?php
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('DB_NAME') ?: 'taskmanager';
$user = getenv('DB_USER') ?: 'taskuser';
$pass = getenv('DB_PASS') ?: 'taskpass';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connexió fallida: " . $conn->connect_error);
}

// Afegir tasca
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tasca'])) {
    $stmt = $conn->prepare("INSERT INTO tasques (text, done) VALUES (?, 0)");
    $stmt->bind_param("s", $_POST['tasca']);
    $stmt->execute();
}

// Marcar com a feta
if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $conn->query("UPDATE tasques SET done = NOT done WHERE id = $id");
}

$result = $conn->query("SELECT * FROM tasques ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Task Manager – DAWe</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <header>
    <div class="header-inner">
      <span class="logo">✅</span>
      <h1>Task Manager</h1>
      <span class="badge">DAWe · RA6</span>
    </div>
  </header>
  <main>
    <section class="add-task">
      <h2>Nova tasca</h2>
      <form method="POST" class="task-form">
        <input type="text" name="tasca" placeholder="Escriu una nova tasca..." class="task-input" required>
        <button type="submit" class="btn-add">Afegir</button>
      </form>
    </section>
    <section class="task-list-section">
      <h2>Tasques</h2>
      <ul class="task-list">
        <?php while ($row = $result->fetch_assoc()): ?>
          <li class="task-item <?= $row['done'] ? 'done' : 'pending' ?>">
            <a href="?toggle=<?= $row['id'] ?>" style="text-decoration:none">
              <span class="task-status"><?= $row['done'] ? '✓' : '○' ?></span>
            </a>
            <span class="task-text"><?= htmlspecialchars($row['text']) ?></span>
            <span class="task-tag"><?= $row['done'] ? 'Fet' : 'Pendent' ?></span>
          </li>
        <?php endwhile; ?>
      </ul>
    </section>
  </main>
  <footer>
    <p>Mòdul 0614 – Desplegament d'Aplicacions Web · Institut Tecnològic de Barcelona</p>
  </footer>
</body>
</html>