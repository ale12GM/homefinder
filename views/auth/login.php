<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Finder - Iniciar sesión</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FEFAE0]  min-h-screen">
    
   
  <div class="flex w-screen h-screen shadow-lg overflow-hidden">
    
    <!-- Formulario Izquierda -->
    <div class="w-1/2 bg-white p-10 flex flex-col justify-center">
      
      <?php if(!empty($errores)): ?>
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
          <?php foreach($errores as $error): ?>
            <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
          <?php endforeach; ?>
        </div>
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
            value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
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
          <a href="#" class="text-[#DDA15E] hover:underline">Haz clic para crear una</a>
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