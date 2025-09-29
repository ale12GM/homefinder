<?php
// Aquí más adelante podrías procesar errores
$errores = $errores ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Finder - Restablecer contraseña</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a2d9d5a64a.js" crossorigin="anonymous"></script>
</head>

<body class="bg-[#FEFAE0] min-h-screen flex items-center justify-center">

  <!-- Contenedor centrado -->
  <div class="w-full max-w-md bg-white p-10 rounded-lg shadow-lg">

    <?php if(!empty($errores)): ?>
      <div class="mb-4 p-3 rounded bg-red-100 text-red-700 border border-red-300">
        <?php foreach($errores as $error): ?>
          <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Restablecer contraseña</h2>

    <form action="" method="POST" class="space-y-5">

      <!-- Nueva contraseña -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Ingresar nueva contraseña</label>
        <div class="relative">
          <input 
            type="password" 
            id="password" 
            name="password"
            placeholder="Nueva contraseña"
            class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E] pr-10"
            required
            minlength="0"
          >
          <i id="togglePassword" class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
        </div>
      </div>

      <!-- Confirmar contraseña -->
      <div>
        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
        <div class="relative">
          <input 
            type="password" 
            id="confirm_password" 
            name="confirm_password"
            placeholder="Repite tu contraseña"
            class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E] pr-10"
            required
            minlength="0"
          >
          <i id="toggleConfirmPassword" class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
        </div>
      </div>

      <button type="submit" class="w-full bg-[#DDA15E] hover:bg-[#c48d4b] text-white font-semibold py-2 rounded-full transition">
        Confirmar
      </button>
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES); ?>">
    </form>
  </div>

  <script>
    // Toggle para ver/ocultar contraseñas
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('togglePassword');

    const confirmInput = document.getElementById('confirm_password');
    const toggleConfirmButton = document.getElementById('toggleConfirmPassword');

    togglePasswordButton.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    toggleConfirmButton.addEventListener('click', function () {
      const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmInput.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>
</html>
