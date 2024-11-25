<?php
include 'db.php';
include 'header.php';


if (!isset($_GET['autor_id']) || !is_numeric($_GET['autor_id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>ID de autor no válido.</div></div>";
    include 'footer.php';
    exit;
}

$autor_id = $_GET['autor_id'];


$stmt = $conn->prepare("SELECT * FROM autores WHERE id = ?");
$stmt->execute([$autor_id]);
$autor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$autor) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>El autor no existe.</div></div>";
    include 'footer.php';
    exit;
}


$stmt = $conn->prepare("SELECT * FROM libros WHERE autor_id = ?");
$stmt->execute([$autor_id]);
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1 class="mb-4">Libros de <?= htmlspecialchars($autor['nombre']) ?></h1>

    <?php if (count($libros) > 0): ?>
        <div class="row">
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Imagen del libro -->
                        <img src="data:image/jpeg;base64,<?= base64_encode($libro['imagen']) ?>" class="card-img-top" alt="Portada del libro">
                        <div class="card-body">
                            <!-- Título del libro -->
                            <h5 class="card-title"><?= htmlspecialchars($libro['titulo']) ?></h5>
                            <!-- Descripción del libro -->
                            <p class="card-text"><?= htmlspecialchars($libro['descripcion']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Este autor no tiene libros registrados.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
