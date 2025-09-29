<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Finder - Registro</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FEFAE0] min-h-screen">
   
  <div class="flex w-screen h-screen shadow-lg overflow-hidden">
    
    <!-- Formulario Izquierda -->
    <div class="w-1/2 bg-white p-10 flex flex-col justify-center">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">¡Crea una cuenta!</h2>
        
      <form method="POST" class="space-y-5">
        
        <div>
          <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre:</label>
          <input type="text" id="nombre" name="usuarios[nombre]" placeholder="Nombre"
                 class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E]"
                 required>
          <?php if(!empty($errores['nombre'])): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $errores['nombre']; ?></p>
          <?php endif; ?>    
        </div>

        <div>
          <label for="apellido" class="block text-sm font-medium text-gray-700 mb-1">Apellido:</label>
          <input type="text" id="apellido" name="usuarios[apellido]" placeholder="Apellido"
                 class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E]"
                 required>
          <?php if(!empty($errores['apellido'])): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $errores['apellido']; ?></p>
          <?php endif; ?> 
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
          <input type="email" id="email" name="usuarios[email]" placeholder="Email"
                 class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E]"
                 required>
          <?php if(!empty($errores['email'])): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $errores['email']; ?></p>
          <?php endif; ?> 
        </div>

        <div>
          <label for="contraseña" class="block text-sm font-medium text-gray-700 mb-1">Contraseña:</label>
          <input type="password" id="contraseña" name="usuarios[password]" placeholder="Contraseña"
                 class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E]"
                 required>
          <?php if(!empty($errores['password'])): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $errores['password']; ?></p>
          <?php endif; ?> 
        </div>

        <div>
          <label for="confirmar" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña:</label>
          <input type="password" id="confirmar" name="confirmar" placeholder="Confirmar contraseña"
                 class="w-full px-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-[#DDA15E]"
                 required>
          <?php if(!empty($errores['confirmar'])): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $errores['confirmar']; ?></p>
          <?php endif; ?> 
        </div>

        <button type="submit" class="w-full bg-[#DDA15E] hover:bg-[#c48d4b] text-white font-semibold py-2 rounded-full transition">
          Crear cuenta
        </button>

        <p class="text-sm text-center text-gray-600">
          ¿Ya tienes una cuenta? 
          <a href="/login" class="text-[#DDA15E] hover:underline">Haz clic para iniciar sesión</a>
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

</body>
</html>