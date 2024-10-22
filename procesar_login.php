<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Función para validar entradas
    function validarEntrada($entrada, $tipo) {
        switch ($tipo) {
            case 'username':
                // Validar que el nombre de usuario solo contenga letras, números y guiones bajos
                if (preg_match('/^[a-zA-Z0-9_]{3,20}$/', $entrada)) {
                    return $entrada; // Entrada válida
                } else {
                    throw new Exception("Nombre de usuario inválido.");
                }
                break;

            case 'password':
                // Validar que la contraseña tenga una longitud mínima
                if (strlen($entrada) >= 6) {
                    return $entrada; // Entrada válida
                } else {
                    throw new Exception("La contraseña debe tener al menos 6 caracteres.");
                }
                break;

            default:
                throw new Exception("Tipo de entrada no válida.");
        }
    }

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

        // Obtener y validar los datos del formulario
        $user_input = validarEntrada($_POST['username'], 'username');
        $password_input = validarEntrada($_POST['password'], 'password');

        // Consulta preparada para evitar inyección SQL
        $stmt = $conn->prepare("SELECT password FROM usuarios WHERE username = :username");
        // Asignar el valor del parámetro
        $stmt->bindParam(':username', $user_input);
        $stmt->execute();

        // Obtener el resultado
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y la contraseña es correcta
        if ($row) {
            // Aquí debes usar `password_verify` si la contraseña está encriptada
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

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn = null;
}
?>

