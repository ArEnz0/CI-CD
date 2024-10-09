<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de la base de datos
    $servername = "localhost"; // Servidor MySQL
    $username = "root"; // Usuario de MySQL
    $password = ""; // Sin contraseña por defecto en XAMPP
    $database = "usuarios"; // Nombre de la base de datos

    try {
        // Conexión a la base de datos usando PDO
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // Configurar PDO para lanzar excepciones en caso de error
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener los datos del formulario
        $user_input = $_POST['username'];
        $password_input = $_POST['password'];

        // Consulta preparada para evitar inyección SQL
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = :username");
        // Asignar el valor del parámetro
        $stmt->bindParam(':username', $user_input);
        $stmt->execute();

        // Obtener el resultado
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y la contraseña es correcta
        if ($row) {
            // Aquí debes usar `password_verify` si la contraseña está encriptada, pero como estás comparando directamente:
            if ($password_input === $row['password']) {
                // Inicio de sesión exitoso, redirigir a la página principal
                header("Location: index.html");
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn = null;
}
?>
