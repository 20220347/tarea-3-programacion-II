<?php
include 'db.php';
include 'header.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Validar datos
    if (!empty($nombre) && !empty($email) && !empty($mensaje)) {
        $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, mensaje) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $mensaje]);
        $mensaje_exito = "¡Gracias por contactarnos! Tu mensaje ha sido enviado.";
    } else {
        $mensaje_error = "Por favor, completa todos los campos.";
    }
}
?>

<div class="container mt-5">
    <h1 class="mb-4">Contacto</h1>

    <?php if (isset($mensaje_exito)): ?>
        <div class="alert alert-success"><?= $mensaje_exito ?></div>
    <?php elseif (isset($mensaje_error)): ?>
        <div class="alert alert-danger"><?= $mensaje_error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required>
        </div>
        <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<?php include 'footer.php'; ?>
