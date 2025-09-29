<?php
// No es necesario añadir lógica PHP aquí para el controlador
// Solo se usa para renderizar el HTML y mostrar los datos pasados.
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Finder - Iniciar sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome para el icono del ojo, si no lo tienes ya -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-[#FEFAE0] min-h-screen">
    

  <div class="flex w-screen h-screen shadow-lg overflow-hidden">
    
    <!-- Formulario Izquierda -->
    <div class="w-1/2 bg-white p-10 flex flex-col justify-center">
      
      <?php if(!empty($errores)): ?>
        <?php 
        $esCuentaDesactivada = false;
        foreach($errores as $error) {
          if(strpos($error, 'desactivada') !== false) {
            $esCuentaDesactivada = true;
            break;
          }
        }
        ?>
        
        <?php if($esCuentaDesactivada): ?>
          <!-- Mensaje especial para cuenta desactivada -->
          <div class="mb-4 p-4 rounded-lg bg-orange-50 text-orange-800 border border-orange-200">
            <div class="flex items-center mb-2">
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
              <span class="font-semibold">Cuenta desactivada</span>
            </div>
            <p class="text-sm mb-2">Tu cuenta ha sido desactivada temporalmente.</p>
            <p class="text-xs text-orange-600">Por favor, contacta al administrador del sistema para reactivar tu cuenta.</p>
          </div>
        <?php else: ?>
          <!-- Mensaje normal de error -->
          <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-800 border border-red-200">
            <div class="flex items-center mb-2">
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
              </svg>
              <span class="font-semibold">Error de acceso</span>
            </div>
            <?php foreach($errores as $error): ?>
              <p class="text-sm"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">¡Bienvenido de vuelta!</h2>

      <form action="" method="POST" class="space-y-5">
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input 
            type="email" 
            id="email" 
            name="email"
            placeholder="Correo electrónico"
            class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E]"
            required
            value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8'); ?>"
          >
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
          <div class="relative">
            <input 
              type="password" 
              id="password" 
              name="password"
              placeholder="Contraseña"
              class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E] pr-10"
              required
              value="<?php echo htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            >
            <i id="togglePassword" class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
          </div>
        </div>

        <div class="text-sm mb-4">
          <a href="#" class="text-[#DDA15E] hover:underline">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="w-full bg-[#DDA15E] hover:bg-[#c48d4b] text-white font-semibold py-2 rounded-full transition">
          Iniciar sesión
        </button>

        <p class="text-sm text-center text-gray-600">
          ¿No tienes una cuenta? 
          <a href="/singUp" class="text-[#DDA15E] hover:underline">Haz clic para crear una</a>
        </p>

      </form>

    </div>

    <!-- Panel Derecha -->
    <div class="w-1/2 bg-[#DDA15E] flex flex-col items-center justify-center text-white">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mb-6" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 3l8 6v12a1 1 0 01-1 1h-5v-6H10v6H5a1 1 0 01-1-1V9l8-6z" />
      </svg>
      <h1 class="text-3xl font-bold">Home Finder</h1>
    </div>

  </div>

  <script>
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    togglePasswordButton.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>

</html>