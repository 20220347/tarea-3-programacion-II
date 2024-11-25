<?php
include 'db.php';
include 'header.php';


$stmt = $conn->prepare("SELECT * FROM autores ORDER BY nombre ASC");
$stmt->execute();
$autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1 class="mb-4">Lista de Autores</h1>

    <?php if (count($autores) > 0): ?>
        <ul class="list-group">
            <?php foreach ($autores as $autor): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <!-- Nombre del autor -->
                    <?= htmlspecialchars($autor['nombre']) ?>
                    
                    <!-- Ver libros del autor -->
                    <a href="libros_por_autor.php?autor_id=<?= $autor['id'] ?>" class="btn btn-primary btn-sm">
                        Ver libros
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-warning">No hay autores registrados.</div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
