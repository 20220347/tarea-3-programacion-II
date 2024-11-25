<?php
include 'db.php';
include 'header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $nombre = $_POST['nombre'];
        $stmt = $conn->prepare("INSERT INTO autores (nombre) VALUES (?)");
        $stmt->execute([$nombre]);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM autores WHERE id = ?");
        $stmt->execute([$id]);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $stmt = $conn->prepare("UPDATE autores SET nombre = ? WHERE id = ?");
        $stmt->execute([$nombre, $id]);
    }
}

$autores = $conn->query("SELECT * FROM autores")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1 class="mb-4">Gestión de Autores</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Autor</label>
            <input type="text" name="nombre" class="form-control" id="nombre" required>
        </div>
        <button type="submit" name="add" class="btn btn-primary">Agregar Autor</button>
    </form>

    <h2 class="mt-5">Lista de Autores</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($autores as $autor): ?>
                <tr>
                    <td><?= htmlspecialchars($autor['nombre']) ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $autor['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $autor['id'] ?>">
                            <input type="text" name="nombre" class="form-control d-inline-block" placeholder="Nuevo Nombre" style="width: auto;" required>
                            <button type="submit" name="update" class="btn btn-warning btn-sm">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
