<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
$user = $_POST["username"] ?? '';
$password = $_POST["password"] ?? '';
$valido = false;


if(empty($user) || empty($password)) {
    $mensaje = "Por favor, complete todos los campos.";
}else{
    foreach($usuarios as $us) {
        // Comparar usando password_verify
        if($us['email'] === $user && password_verify($password, $us['contrasenia_hash'])){
            $mensaje = "Acceso permitido. Bienvenido, {$us['nombre']} ";
            $_SESSION['usuario'] = $us['id'];
            $valido = true;
            break;
        }
    }
    if(!$valido) {
        $mensaje = "Usuario o clave incorrectos";
    }
}

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home Finder - Iniciar sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body class="flex h-screen">
  <!-- Izquierda: Formulario -->
  <div class="w-1/2 flex items-center justify-center bg-white">
    <div class="w-full max-w-sm px-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">¡Bienvenido de vuelta!</h2>

      <form method="POST" action="">
        <!-- Nombre de usuario -->
        <div class="mb-4">
          <label for="username" class="block text-sm text-gray-700 mb-1">Nombre</label>
          <input type="email" id="username" name='username' placeholder="Nombre usuario" class="w-full px-4 py-2 border rounded-full outline-none focus:ring-2 focus:ring-amber-500">
        </div>

        <!-- Contraseña -->
        <div class="mb-2">
          <label for="password" class="block text-sm text-gray-700 mb-1">Contraseña</label>
          <div class="relative">
            <input type="password" id="password" name='password' placeholder="Contraseña" class="w-full px-4 py-2 border rounded-full outline-none focus:ring-2 focus:ring-amber-500 pr-10">
        <i id="togglePassword" class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
          </div>
        </div>

        <!-- ¿Olvidaste tu contraseña? -->
        <div class="text-sm mb-4">
          <a href="#" class="text-amber-600 hover:underline">¿Olvidaste tu contraseña?</a>
        </div>
        <?php if (isset($mensaje)) {
    echo "<p>$mensaje</p>";
} ?>
        <!-- Botón de inicio de sesión -->
        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 rounded-full mb-4">
          Iniciar sesión
        </button>

        <!-- Crear cuenta -->
        <p class="text-sm text-center text-gray-600">
          ¿No tienes una cuenta? <a href="#" class="text-amber-600 hover:underline">Haz clic para crear una</a>
        </p>
      </form>
    </div>
  </div>

  <!-- Derecha: Logo y nombre -->
  <div class="w-1/2 bg-amber-400 flex flex-col items-center justify-center text-white">
    <!-- Ícono de casa -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mb-4" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 3l8 6v12a1 1 0 01-1 1h-5v-6H10v6H5a1 1 0 01-1-1V9l8-6z" />
    </svg>
    <h1 class="text-3xl font-bold">Home Finder</h1>
  </div>


  <script>
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    togglePasswordButton.addEventListener('click', function () {
      // Cambia el tipo del input entre 'password' y 'text'
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);

      // Cambia el ícono entre 'fa-eye' y 'fa-eye-slash'
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>
</html>