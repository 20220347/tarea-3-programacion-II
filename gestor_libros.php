<?php
include 'db.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $autor_id = $_POST['autor_id'];
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']);

        $stmt = $conn->prepare("INSERT INTO libros (titulo, descripcion, autor_id, imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $descripcion, $autor_id, $imagen]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM libros WHERE id = ?");
        $stmt->execute([$id]);
    }
}

$libros = $conn->query("SELECT libros.*, autores.nombre AS autor FROM libros LEFT JOIN autores ON libros.autor_id = autores.id")->fetchAll(PDO::FETCH_ASSOC);
$autores = $conn->query("SELECT * FROM autores")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1 class="mb-4">Gestión de Libros</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" id="titulo" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" id="descripcion" required></textarea>
        </div>
        <div class="mb-3">
            <label for="autor_id" class="form-label">Autor</label>
            <select name="autor_id" class="form-control" id="autor_id" required>
                <?php foreach ($autores as $autor): ?>
                    <option value="<?= $autor['id'] ?>"><?= $autor['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control" id="imagen" required>
        </div>
        <button type="submit" name="add" class="btn btn-primary">Agregar Libro</button>
    </form>

    <h2 class="mt-5">Lista de Libros</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Autor</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?= htmlspecialchars($libro['titulo']) ?></td>
                    <td><?= htmlspecialchars($libro['descripcion']) ?></td>
                    <td><?= htmlspecialchars($libro['autor']) ?></td>
                    <td><img src="data:image/jpeg;base64,<?= base64_encode($libro['imagen']) ?>" alt="Portada" width="50"></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $libro['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
