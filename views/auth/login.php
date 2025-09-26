<?php
// Suponiendo que $errores ya viene definido desde tu lógica PHP
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
    
   <header class="bg-white border-b border-gray-200"> 
    <div class="container mx-auto flex justify-between items-center px-6 py-4">
      
      <!-- Logo -->
      <div>
        <a href="#hero"> <!-- Apunta a la sección hero para "Inicio" -->
          <img src="../../src/logo.svg" alt="Logo" class="h-10">
        </a>
      </div>

      <!-- Botón menú móvil -->
      <button id="menu-btn" class="md:hidden text-[#4d5c3d] focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Menú navegación -->
<nav id="menu" class="hidden md:flex md:items-center md:space-x-8 font-bold text-[#d29057] absolute md:static top-16 left-0 w-full md:w-auto bg-white md:bg-transparent p-6 md:p-0 shadow-md md:shadow-none">
  <ul class="flex flex-col md:flex-row gap-6 md:gap-8">
    <li><a href="#hero" class="hover:text-[#a66933]">Inicio</a></li>
    <li><a href="#sobre-nosotros" class="hover:text-[#a66933]">Sobre Nosotros</a></li>
    <li><a href="#contacto" class="hover:text-[#a66933]">Contacto</a></li>
    <li><a href="http://localhost:8000/login/publicar_propiedad" class="hover:text-[#a66933]">Vender</a></li>
    <li><a href="/login/venta" class="hover:text-[#a66933]">Comprar</a></li>
  </ul>

  <div class="mt-6 md:mt-0 flex gap-4 md:ml-8">
    <?php if (!isset($_SESSION["email"])): ?>
      <!-- Mostrar solo si NO hay sesión iniciada -->
      <a href="/signup" class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-500 text-gray-600 hover:bg-gray-100">
        Sign up
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-3-3.87M12 3a9 9 0 100 18 9 9 0 000-18z" />
        </svg>
      </a>
      <a href="/login" class="flex items-center gap-2 px-4 py-2 rounded-full bg-[#4d5c3d] text-white hover:opacity-80">
        Login
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m0 0l3-3m-3 3l3 3m6-6v6a9 9 0 11-18 0V6a9 9 0 1118 0z" />
        </svg>
      </a>
  <?php else: ?>
<!-- Botón de avatar -->
<div class="relative inline-block text-left">
  <button id="avatarBtn" type="button" 
    class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <img src="https://i.pravatar.cc/100" alt="Usuario" class="w-full h-full object-cover">
  </button>

  <!-- Menú desplegable -->
<div id="menuUser" 
     class="hidden absolute right-4 top-16 w-64 bg-white border rounded-2xl shadow-2xl p-10 z-50">

  <!-- Botón cerrar -->
  <button id="closeMenu" class="absolute top-3 right-3 text-gray-400 hover:text-red-500">
    ✕
  </button>

  <!-- Foto y nombre -->
  <div class="flex flex-col items-center mb-4">
    <img src="https://via.placeholder.com/80" 
         alt="Foto usuario" 
         class="w-20 h-20 rounded-full border-4 border-gray-200 shadow">
    <h2 class="mt-2 text-lg font-bold text-[#DDA15E]">Carlos</h2>
  </div>

  <!-- Opciones -->
  <div class="flex flex-col gap-3">
    <a href="/editar" 
       class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition">
       Editar
    </a>
    <a href="/seguridad" 
       class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition">
       Seguridad
    </a>
    <a href="/propiedades" 
       class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition">
       Ver Propiedades
    </a>
    <a href="/logout.php" 
       class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-red-700 transition font-semibold">
       Cerrar Sesión
    </a>
  </div>
</div>


<script>
  // Mostrar/ocultar el menú al hacer click en la foto
    document.getElementById('avatarBtn').addEventListener('click', () => {
    document.getElementById('menuUser').classList.toggle('hidden');
  });
  // Cerrar cuando se hace click en la X
    closeMenu.addEventListener('click', () => {
    menuUser.classList.add('hidden');
  });
</script>

<?php endif; ?>

  </div>
</nav>
    </div>
  </header>


  <div class="flex w-screen h-screen rounded-xl p- shadow-lg overflow-hidden">
    
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