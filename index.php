<?php
include 'db.php';
include 'header.php';

// Buscar libros 
$query = '';
$mensaje_error = '';
if (isset($_GET['buscar'])) {
    $query = $_GET['buscar'];
    $stmt = $conn->prepare("
        SELECT libros.*, autores.nombre AS autor_nombre 
        FROM libros 
        LEFT JOIN autores ON libros.autor_id = autores.id
        WHERE libros.titulo LIKE ? OR autores.nombre LIKE ?");
    $stmt->execute(['%' . $query . '%', '%' . $query . '%']);
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($libros)) {
        $mensaje_error = "No se encontraron libros que coincidan con tu búsqueda.";
    }
} else {
    // Mostrar todos los libros
    $stmt = $conn->prepare("
        SELECT libros.*, autores.nombre AS autor_nombre 
        FROM libros 
        LEFT JOIN autores ON libros.autor_id = autores.id
    ");
    $stmt->execute();
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-5">
    <h1 class="mb-4">Biblioteca de Libros</h1>

  
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar libros o autores..." value="<?= htmlspecialchars($query) ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <?php if ($mensaje_error): ?>
        <div class="alert alert-danger"><?= $mensaje_error ?></div>
    <?php endif; ?>


    <div class="row">
        <?php foreach ($libros as $libro): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Imagen del libro -->
                    <img src="data:image/jpeg;base64,<?= base64_encode($libro['imagen']) ?>" class="card-img-top" alt="Portada del libro">
                    <div class="card-body">
                        <!-- Título del libro -->
                        <h5 class="card-title"><?= htmlspecialchars($libro['titulo']) ?></h5>
                        <!-- Autor del libro -->
                        <p class="card-text"><strong>Autor:</strong> <?= htmlspecialchars($libro['autor_nombre']) ?></p>
                        <!-- Descripción del libro -->
                        <p class="card-text"><?= htmlspecialchars($libro['descripcion']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
