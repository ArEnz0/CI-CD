<?php
$nombre = $_POST['nombre'];
$asunto = $_POST['asunto'];
$mensaje = $_POST['mensaje'];

$servername = "localhost";
$database = "usuarios";
$username = "root";
$password = ""; // Sin contraseña en XAMPP por defecto

try {
    // Crear la conexión usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configurar el modo de error a excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa";

    // Preparar la consulta SQL
    $sql = "INSERT INTO registros (nombre, asunto, mensaje) VALUES (:nombre, :asunto, :mensaje)";

    // Preparar la declaración con parámetros
    $stmt = $conn->prepare($sql);
    
    // Asignar valores a los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':asunto', $asunto);
    $stmt->bindParam(':mensaje', $mensaje);
    
    // Ejecutar la consulta
    $stmt->execute();

    echo "Nuevo registro creado exitosamente";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
