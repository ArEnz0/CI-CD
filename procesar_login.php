<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos de la base de datos
    $servername = "localhost"; // Aquí debes colocar el nombre del servidor o 'localhost'
    $database = "usuarios"; // Tu nombre de base de datos
    $username = "root"; // Usuario de la base de datos (no el del formulario)
    $password = "00root00"; // Contraseña de la base de datos (no la del formulario)

    // Conexión a la base de datos
    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Obteniendo los datos del formulario
    $user_input = $_POST['username']; // 'username' debería ser el valor 'name' del campo en tu formulario
    $password_input = $_POST['password']; // 'password' debería ser el valor 'name' del campo en tu formulario

    // Consulta a la base de datos para verificar si el usuario y la contraseña son correctos
    $sql = "SELECT * FROM usuarios WHERE username = '$user_input' AND password = '$password_input'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Redirige a la página de contacto después de iniciar sesión exitosamente
        header("Location: contacto.html");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos. Inténtalo de nuevo.";
    }

    // Cerrar la conexión
    mysqli_close($conn);
}
?>
