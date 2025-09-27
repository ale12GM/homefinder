<?php 
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cerrar'])){

  session_destroy();
  header('Location:/login');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
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
    <li><a href="/usuario/home" class="hover:text-[#a66933]">Inicio</a></li>
    <li><a href="#sobre-nosotros" class="hover:text-[#a66933]">Sobre Nosotros</a></li>
    <li><a href="#contacto" class="hover:text-[#a66933]">Contacto</a></li>
    <li><a href="/usuario/propiedades/publicar" class="hover:text-[#a66933]">Vender</a></li>
    <li><a href="/usuario/propiedades" class="hover:text-[#a66933]">Comprar</a></li>
  </ul>

  <div class="mt-6 md:mt-0 flex gap-4 md:ml-8">
    <?php if (!isset($_SESSION['usuario'])): ?>
      <!-- Mostrar solo si NO hay sesión iniciada -->
      <a href="/singUp" class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-500 text-gray-600 hover:bg-gray-100">
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
    class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#DDA15E]">
    <img src="https://i.pravatar.cc/100" alt="Usuario" class="w-full h-full object-cover">
  </button>
</div>

<!-- Overlay del menú perfil -->
<div id="overlayPerfil" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40">

  <!-- Menú desplegable -->
  <div id="menuUser" 
       class="absolute right-4 top-4 w-64 bg-white border rounded-2xl shadow-2xl p-10 z-50">

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
      <button id="btnEditar"
         class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition">
         Editar
      </button>
      <a href="/seguridad" 
         class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition">
         Seguridad
      </a>
      <a href="/usuario/mispropiedades" 
         class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition">
         Ver Propiedades
      </a>
     <form action="" method="post">
    <?php echo $_SESSION['usuario']?>
    <input type="hidden" name="cerrar">
    <button type="submit" class="bg-red-500 hover:bg-red-800 px-4 py-2 rounded-md text-white">
      Cerrar Secion
    </button>
  </form>
    </div>
  </div>
</div>

<!-- Overlay del modal editar perfil -->
<div id="overlayEditar" 
     class="hidden fixed inset-0 bg-black bg-opacity-50 z-40">

  <!-- Subventana Editar Perfil (esquina) -->
  <div id="modalEditar"
       class="absolute right-4 top-5 w-[420px] bg-white border rounded-2xl shadow-2xl p-8 z-50">

    <!-- Botón cerrar modal -->
    <button id="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-xl">
      ✕
    </button>

    <!-- Encabezado -->
    <h2 class="text-2xl font-bold text-left text-[#DDA15E] mb-4">Editar Perfil</h2>

    <!-- Foto y nombre -->
    <div class="flex flex-col items-center mb-6">
      <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#FEFAE0] shadow-md">
        <img src="https://i.pravatar.cc/150?img=3" alt="Usuario" class="w-full h-full object-cover">
      </div>
      <h3 class="mt-3 text-lg font-semibold text-[#5B674D]">Carlos</h3>
    </div>

    <!-- Formulario -->
    <form class="flex flex-col gap-4">
      <input type="text" placeholder="Nombre" 
             class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#DDA15E]">
      <input type="text" placeholder="Apellido" 
             class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#DDA15E]">
      <input type="email" placeholder="Email" 
             class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#DDA15E]">

      <!-- Contraseña con ojito -->
      <div class="relative">
        <input type="password" id="password" placeholder="Contraseña" 
               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#DDA15E]">
        <button type="button" id="togglePassword" 
                class="absolute inset-y-0 right-3 flex items-center text-gray-500">
          👁️
        </button>
      </div>

      <!-- Confirmar contraseña con ojito -->
      <div class="relative">
        <input type="password" id="confirmPassword" placeholder="Confirmar Contraseña" 
               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#DDA15E]">
        <button type="button" id="toggleConfirmPassword" 
                class="absolute inset-y-0 right-3 flex items-center text-gray-500">
          👁️
        </button>
      </div>

      <button type="submit" 
              class="bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition">
        Editar
      </button>
    </form>
  </div>
</div>

<script>
  const avatarBtn = document.getElementById('avatarBtn');
  const overlayPerfil = document.getElementById('overlayPerfil');
  const menuUser = document.getElementById('menuUser');
  const closeMenu = document.getElementById('closeMenu');

  const btnEditar = document.getElementById('btnEditar');
  const overlayEditar = document.getElementById('overlayEditar');
  const closeModal = document.getElementById('closeModal');

  // Mostrar menú perfil
  avatarBtn.addEventListener('click', () => {
    overlayPerfil.classList.remove('hidden');
  });

  // Cerrar menú perfil
  closeMenu.addEventListener('click', () => {
    overlayPerfil.classList.add('hidden');
  });

  // Cerrar perfil clickeando fuera
  overlayPerfil.addEventListener('click', (e) => {
    if (e.target === overlayPerfil) {
      overlayPerfil.classList.add('hidden');
    }
  });

  // Abrir subventana editar
  btnEditar.addEventListener('click', () => {
    overlayEditar.classList.remove('hidden');
    overlayPerfil.classList.add('hidden'); // cerrar perfil al abrir editar
  });

  // Cerrar subventana editar
  closeModal.addEventListener('click', () => {
    overlayEditar.classList.add('hidden');
  });

  // Cerrar editar clickeando fuera
  overlayEditar.addEventListener('click', (e) => {
    if (e.target === overlayEditar) {
      overlayEditar.classList.add('hidden');
    }
  });

  // Mostrar / ocultar contraseñas
  const togglePassword = document.getElementById('togglePassword');
  const password = document.getElementById('password');
  togglePassword.addEventListener('click', () => {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
  });

  const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
  const confirmPassword = document.getElementById('confirmPassword');
  toggleConfirmPassword.addEventListener('click', () => {
    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    confirmPassword.setAttribute('type', type);
  });
</script>
<?php endif; ?>




  </div>
</nav>
    </div>
  </header>

  <script>
    const menuBtn = document.getElementById("menu-btn");
    const menu = document.getElementById("menu");
    menuBtn.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });
  </script>
    <main class="">
        <?php echo $contenido; ?>
    </main>

    <!-- Footer -->
<footer class="bg-[#535E46] text-[#FEFAE0] py-12 px-8 mt-16 font-[Poppins]">
  <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
    
    <!-- Logo -->
    <div class="flex items-center justify-center md:justify-start gap-3">
      <img src="image_logo.png" alt="Logo" class="max-w-full max-h-full w-16 h-16 object-contain">
    </div>

    <!-- Contenido -->
    <div class="text-center md:text-left">
      <h3 class="font-bold mb-4 text-[#FEFAE0]">Contenido</h3>
      <ul class="space-y-2">
        <li><a href="#" class="hover:text-white transition">Inicio</a></li>
        <li><a href="#" class="hover:text-white transition">Sobre Nosotros</a></li>
        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
        <li><a href="#" class="hover:text-white transition">Vender</a></li>
        <li><a href="#" class="hover:text-white transition">Comprar</a></li>
      </ul>
    </div>

    <!-- Síguenos -->
    <div class="text-center md:text-left">
      <h3 class="font-bold mb-4 text-[#FEFAE0]">Síguenos</h3>
      <ul class="space-y-2">
        <li><a href="#" class="hover:text-white transition">Facebook</a></li>
        <li><a href="#" class="hover:text-white transition">Instagram</a></li>
        <li><a href="#" class="hover:text-white transition">X</a></li>
        <li><a href="#" class="hover:text-white transition">TikTok</a></li>
      </ul>
    </div>

    <!-- Contáctanos -->
    <div class="text-center md:text-left">
      <h3 class="font-bold mb-4 text-[#FEFAE0]">Contáctanos</h3>
      <ul class="space-y-2">
        <li>+56 9 6027 0920</li>
        <li><a href="mailto:ejempl@gmail.com" class="hover:text-white transition">ejempl@gmail.com</a></li>
        <li>B/12ejemplo</li>
      </ul>
    </div>
  </div>

  <!-- Derechos -->
  <div class="mt-10 text-center text-sm text-[#FEFAE0]/70 border-t border-[#FEFAE0]/20 pt-6">
    © 2025 Home Finder — Todos los derechos reservados.
  </div>
</footer>


    <script>
        // Toggle the menu visibility when the hamburger button is clicked
        document.getElementById('menuButton').addEventListener('click', () => {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
