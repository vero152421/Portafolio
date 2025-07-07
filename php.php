<?php
$conexion = new mysqli("localhost", "root", "", "portafolio_db");
$conexion->set_charset("utf8");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_POST['name'])) {
    $nombre = $_POST['name'];
} else {
    $nombre = '';
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    $email = '';
}

if (isset($_POST['phone'])) {
    $telefono = $_POST['phone'];
} else {
    $telefono = '';
}

if (isset($_POST['message'])) {
    $mensaje = $_POST['message'];
} else {
    $mensaje = '';
}

if (empty($nombre) || empty($email) || empty($telefono) || empty($mensaje)) {
    // Mensaje bonito de error
    echo '
    <html>
    <head>
        <title>Error en formulario</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f8d7da; color: #721c24; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
            .container { background: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 400px; text-align: center; }
            a { color: #721c24; text-decoration: none; font-weight: bold; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>❌ Faltan campos por completar.</h2>
            <p>Por favor, <a href="contact.html">regresa al formulario</a> y completa todos los campos.</p>
        </div>
    </body>
    </html>
    ';
    exit;
}

$sql = "INSERT INTO contactos (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssss", $nombre, $email, $telefono, $mensaje);

if ($stmt->execute()) {
    // Mensaje bonito de éxito
    echo '
    <html>
    <head>
        <title>Mensaje enviado</title>
        <style>
            body { font-family: Arial, sans-serif; background: #d4edda; color: #155724; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
            .container { background: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 400px; text-align: center; }
            a { color: #155724; text-decoration: none; font-weight: bold; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>✅ ¡Mensaje enviado correctamente!</h2>
            <p>Gracias por contactarnos, ' . htmlspecialchars($nombre) . '.<br>
            <a href="contact.html">Volver al formulario</a></p>
        </div>
    </body>
    </html>
    ';
} else {
    // Mensaje bonito de error en BD
    echo '
    <html>
    <head>
        <title>Error al guardar</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f8d7da; color: #721c24; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
            .container { background: white; padding: 20px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 400px; text-align: center; }
            a { color: #721c24; text-decoration: none; font-weight: bold; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>❌ Error al guardar los datos</h2>
            <p>Por favor, intenta nuevamente.<br>
            <a href="contact.html">Volver al formulario</a></p>
        </div>
    </body>
    </html>
    ';
}

$stmt->close();
$conexion->close();
?>
