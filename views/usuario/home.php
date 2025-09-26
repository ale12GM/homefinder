<?php 
session_start();
$_SESSION["email"] = "ale@gmail.com";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Finder</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Importar fuente Poppins para toda la página si se desea -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome para los íconos de redes sociales -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body class="h-screen w-full bg-white" style="font-family: 'Poppins', sans-serif;">

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


<section id="hero" class="relative h-screen w-full bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1350&q=80');">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-50"></div>

  <!-- Contenido -->
  <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">

    <!-- Título -->
    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-8" style="color: #FEFAE0;">HOME FINDER</h1>

    <!-- Barra de búsqueda -->
    <div class="flex items-center rounded-full shadow-lg w-full max-w-2xl overflow-hidden" style="background-color: #FEFAE0;">

      <!-- Icono lupa + input -->
      <div class="flex items-center flex-1">
        <span class="pl-4 pr-2 text-lg">
          <img src="../../src/lupa.svg" alt="Lupa" class="w-5 h-5" style="filter: invert(47%) sepia(21%) saturate(1478%) hue-rotate(352deg) brightness(97%) contrast(85%);">
        </span>
        <input type="text" placeholder="Buscar hogar..."
               class="flex-1 py-3 focus:outline-none" style="color: #DDA15E; background-color: #FEFAE0;">
      </div>

      <!-- Botones -->
      <div class="flex w-1/4 rounded-full m-1 overflow-hidden transition-all duration-500">
        <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2 text-white font-medium transition-all duration-500 bg-[#DDA15E] hover:flex-[10] hover:gap-3">
          <img src="../../src/buy.svg" alt="Buy" class="w-5 h-5 transition-all duration-500" style="filter: brightness(0) invert(1);">BUY
        </button>
        <button class="flex-1 flex items-center justify-center gap-2 px-4 py-2 text-white font-medium transition-all duration-500 bg-[#DDA15E] hover:flex-[10] hover:gap-3">
          <img src="../../src/sell.svg" alt="Sell" class="w-5 h-5 transition-all duration-500" style="filter: brightness(0) invert(1);">SELL
        </button>
      </div>
    </div>

    <!-- Subtítulo -->
    <p class="mt-6 text-base sm:text-lg md:text-xl font-light px-2" style="color: #FEFAE0;">
      "Encuentra tu próximo hogar con nosotros: fácil, rápido y seguro."
    </p>
  </div>
</section>

  <!-- ================= SOBRE NOSOTROS ================= -->
<section id="sobre-nosotros" class="py-12 bg-white">
  <!-- Contenido de Sobre Nosotros -->
  <h2 class="text-center text-4xl md:text-5xl font-bold text-orange-400 mb-10">
    Sobre Nosotros
  </h2>

  <!-- Contenedor -->
  <div class="bg-[#535E46] grid grid-cols-1 md:grid-cols-2 items-center gap-8 mx-auto py-12 px-10 relative overflow-hidden min-h-[66vh]">

    <!-- Texto -->
    <div class="text-[#FEFAE0] p-8 flex flex-col justify-center ml-8 md:ml-20">
      
      <h3 class="text-4xl md:text-5xl font-bold mb-8 text-left leading-snug">
        Construimos más que espacios, creamos hogares
      </h3>
      
      <p class="mb-10 text-lg md:text-xl leading-relaxed text-left">
        Creemos que cada hogar cuenta una historia.  
        Por eso, nos enfocamos en acompañar a cada persona en la búsqueda de un espacio donde pueda crecer, disfrutar y sentirse en paz.
      </p>

      <!-- Botón centrado dentro de su mitad -->
      <div class="flex justify-center">
        <button class="flex items-center gap-3 px-7 py-3.5 bg-[#B1BCA4] text-[#FEFAE0] text-lg font-semibold rounded-full hover:bg-[#9FA88F] transition">
          <img src="../../src/telefono.svg" alt="Teléfono" class="w-6 h-6">
          CONTÁCTANOS
        </button>
      </div>
    </div>

    <!-- Imagen alta centrada -->
    <div class="flex justify-center relative">
      <img src="https://images.pexels.com/photos/7642004/pexels-photo-7642004.jpeg?auto=compress&cs=tinysrgb&w=600&h=900&dpr=1" 
           alt="Entrega de llaves contrato inmobiliaria" 
           class="h-[550px] md:h-[700px] w-auto rounded-2xl shadow-lg relative z-10 object-cover">
    </div>
  </div>
</section>


<section class="py-20 bg-white">
  <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-20 px-4">

    <!-- Columna izquierda -->
    <div class="flex flex-col">
      <!-- Título -->
      <h2 class="text-4xl md:text-5xl font-bold text-[#2E3B1F] mb-10">Nuestro trabajo</h2>
      
      <!-- Imagen -->
      <img src="https://ventramelidecor.com.br/wp-content/uploads/2024/05/casa-moderna-linhas-retas-1024x512.jpg"
           alt="Casa moderna"
           class="w-full h-96 rounded-2xl shadow-lg mb-10 object-cover">
      
      <!-- Info de la casa -->
      <div class="text-left text-gray-700 space-y-4 text-xl">
        <p><strong>Ubicación:</strong> Av. Los Pinos 123, Lima</p>
        <p><strong>Habitaciones:</strong> 3 dormitorios, 2 baños</p>
        <p><strong>Área:</strong> 150 m²</p>
        <p><strong>Precio:</strong> $120,000</p>
      </div>
    </div>

    <!-- Columna derecha -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-20 gap-y-16 items-start text-center">

      <!-- Elemento 1 -->
      <div class="flex flex-col items-center space-y-4 p-4">
        <img src="../../src/comodo.svg" alt="Cómodo" class="w-24 h-24 mb-2" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);">
        <p class="text-xl text-gray-800 font-medium">Propiedades cómodas para tu bienestar</p>
      </div>

      <!-- Elemento 2 -->
      <div class="flex flex-col items-center space-y-4 p-4">
        <img src="../../src/ahorrar.svg" alt="Ahorro" class="w-24 h-24 mb-2" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);">
        <p class="text-xl text-gray-800 font-medium">Opciones accesibles para que ahorres</p>
      </div>

      <!-- Elemento 3 -->
      <div class="flex flex-col items-center space-y-4 p-4">
        <img src="../../src/comunicacion.svg" alt="Comunicación" class="w-24 h-24 mb-2" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);">
        <p class="text-xl text-gray-800 font-medium">Comunicación clara y constante</p>
      </div>

      <!-- Elemento 4 -->
      <div class="flex flex-col items-center space-y-4 p-4">
        <img src="../../src/casa.svg" alt="Calidad" class="w-24 h-24 mb-2" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);">
        <p class="text-xl text-gray-800 font-medium">Casas de calidad garantizada</p>
      </div>

    </div>
  </div>
</section>



<section class="py-12" style="background-color: #F5F5F5;">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <!-- Título -->
    <h2 class="text-2xl md:text-3xl font-bold text-[#244434] mb-8">
      Más de 100 Instituciones y Marcas que confían en nosotros
    </h2>

    <!-- Carrusel con bordes de desvanecimiento -->
    <div class="relative overflow-hidden">
<!-- Desvanecimiento izquierdo -->
      <div class="absolute left-0 top-0 h-full w-32 z-10 pointer-events-none" 
          style="background: linear-gradient(to right, #F5F5F5 0%, rgba(245,245,245,0.9) 30%, rgba(245,245,245,0.5) 60%, transparent 100%);"></div>

      <!-- Desvanecimiento derecho -->
      <div class="absolute right-0 top-0 h-full w-32 z-10 pointer-events-none" 
          style="background: linear-gradient(to left, #F5F5F5 0%, rgba(245,245,245,0.9) 30%, rgba(245,245,245,0.5) 60%, transparent 100%);"></div>


      <!-- Logos -->
      <div class="flex animate-scroll space-x-12">
        
        <!-- Logos (primer set) -->
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg" alt="IBM" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg" alt="Samsung" class="h-16 object-contain">
        
        <!-- Logos (duplicados para loop continuo) -->
        <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg" alt="IBM" class="h-16 object-contain">
        <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg" alt="Samsung" class="h-16 object-contain">
      </div>
    </div>
  </div>
</section>

<!-- Animación CSS -->
<style>
@keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.animate-scroll {
  display: flex;
  width: max-content;
  animation: scroll 25s linear infinite;
}
</style>


<!-- Animación CSS -->
<style>
@keyframes scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.animate-scroll {
  display: flex;
  width: max-content;
  animation: scroll 25s linear infinite;
}
</style>





<section class="py-20 bg-white text-center">
  <div class="max-w-5xl mx-auto px-6">

    <h2 class="text-4xl md:text-5xl font-bold mb-4 text-[#244434]">
      Tu viaje inmobiliario comienza aquí
    </h2>
    <p class="text-xl md:text-2xl mb-12 text-[#244434]">
      Ya sea que esté comprando, vendiendo o alquilando, brindamos las herramientas y los recursos para que su experiencia sea fluida y exitosa.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

      <div class="group flex flex-col items-start text-left border-2 rounded-2xl p-8 cursor-pointer transition duration-300 hover:shadow-lg
                  border-[#DDA15E] bg-[#FEFAE0] text-[#DDA15E] hover:bg-[#DDA15E] hover:text-[#FEFAE0]">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4 transition-colors duration-300 text-[#DDA15E] group-hover:text-[#FEFAE0]" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 3l9 8h-3v9h-12v-9h-3l9-8z"/>
        </svg>
        <h3 class="text-2xl font-bold mb-2">Vender una casa</h3>
        <p class="text-lg">Encuentra el comprador ideal con nuestras amplias listas y asesoría experta.</p>
      </div>

      <div class="group flex flex-col items-start text-left border-2 rounded-2xl p-8 cursor-pointer transition duration-300 hover:shadow-lg
                  border-[#DDA15E] bg-[#FEFAE0] text-[#DDA15E] hover:bg-[#DDA15E] hover:text-[#FEFAE0]">
        <!-- Nuevo icono llave-casa -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4 transition-colors duration-300 text-[#DDA15E] group-hover:text-[#FEFAE0]" fill="currentColor" viewBox="0 0 24 24"><path d="M21.707 11.293l-9-9A1 1 0 0 0 11 2H5a3 3 0 0 0-3 3v6a1 1 0 0 0 .293.707l9 9a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414zM7.5 9.5a2 2 0 1 1 .001-4.001A2 2 0 0 1 7.5 9.5z"/></svg>

        <h3 class="text-2xl font-bold mb-2">Comprar una casa</h3>
        <p class="text-lg">Encuentra tu lugar perfecto con nuestras amplias listas y orientación experta.</p>
      </div>

    </div>
  </div>
</section>



<section id="contacto" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">

    <!-- Columna izquierda: Información -->
    <div>
      <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#DDA15E]">
        Contáctanos
      </h2>

      <p class="text-gray-700 mb-8">
        Estamos aquí para ayudarte. Si tienes dudas, necesitas asesoría o quieres más 
        información sobre nuestras propiedades, comunícate con nosotros y con gusto te atenderemos.
      </p>

      <!-- Datos de contacto -->
      <div class="space-y-6 text-[#244434]">
        <div class="flex items-center gap-4">
          <!-- Icono Teléfono -->
          <div class="text-[#DDA15E]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M6.62 10.79a15.09 15.09 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/>
            </svg>
          </div>
          <div>
            <p class="font-bold">Teléfono</p>
            <p class="text-gray-600">+569 78945612</p>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <!-- Icono Email -->
          <div class="text-[#DDA15E]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 2v.01L12 13 4 6.01V6h16zM4 18V8l8 5 8-5v10H4z"/>
            </svg>
          </div>
          <div>
            <p class="font-bold">Email</p>
            <p class="text-gray-600">ejemplo@gmail.com</p>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <!-- Icono Dirección -->
          <div class="text-[#DDA15E]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1114.5 9 2.5 2.5 0 0112 11.5z"/>
            </svg>
          </div>
          <div>
            <p class="font-bold">Dirección</p>
            <p class="text-gray-600">B/ejemplo12</p>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <!-- Icono Website -->
          <div class="text-[#DDA15E]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2a10 10 0 1010 10A10.01 10.01 0 0012 2zm6.93 6h-3.68a15.08 15.08 0 00-1.39-4.56A8.02 8.02 0 0118.93 8zM12 4a13.07 13.07 0 011.93 6H10.07A13.07 13.07 0 0112 4zM4.26 16A7.93 7.93 0 014 12a7.93 7.93 0 01.26-2h3.48a15.45 15.45 0 000 4zm1.81 2h3.68a15.08 15.08 0 001.39 4.56A8.02 8.02 0 016.07 18zM12 20a13.07 13.07 0 01-1.93-6h3.86A13.07 13.07 0 0112 20zm3.48-6a15.45 15.45 0 000-4h3.48a7.93 7.93 0 01.26 2 7.93 7.93 0 01-.26 2z"/>
            </svg>
          </div>
          <div>
            <p class="font-bold">Website</p>
            <p class="text-gray-600">homefinder.com</p>
          </div>
        </div>
      </div>

      <!-- Redes sociales -->
      <div class="mt-8">
        <p class="mb-4 font-semibold text-[#244434]">Síguenos en:</p>
        <div class="flex gap-4 text-[#DDA15E]">
          <i class="fab fa-facebook-f cursor-pointer"></i>
          <i class="fab fa-tiktok cursor-pointer"></i>
          <i class="fab fa-x-twitter cursor-pointer"></i>
          <i class="fab fa-instagram cursor-pointer"></i>
        </div>
      </div>
    </div>

    <!-- Columna derecha: Formulario -->
    <div>
      <form class="space-y-4">
        <div>
          <label class="block mb-1 font-medium text-[#244434]">Nombre</label>
          <input type="text" class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E]" />
        </div>

        <div>
          <label class="block mb-1 font-medium text-[#244434]">E-mail</label>
          <input type="email" class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E]" />
        </div>

        <div>
          <label class="block mb-1 font-medium text-[#244434]">Nombre de compañía</label>
          <input type="text" class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E]" />
        </div>

        <div>
          <label class="block mb-1 font-medium text-[#244434]">Número de teléfono</label>
          <input type="text" class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E]" />
        </div>

        <div>
          <label class="block mb-1 font-medium text-[#244434]">Mensaje</label>
          <textarea rows="4" class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E]"></textarea>
        </div>

        <button type="submit" class="bg-[#DDA15E] hover:bg-[#BC8A4B] text-white font-bold py-3 px-6 rounded-3xl shadow-md transition">
          Enviar
        </button>
      </form>
    </div>
  </div>
</section>

  <footer class="bg-[#2c351d] text-[#fdf6e3] py-12 px-8 mt-16">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
      
      <div class="flex items-center gap-3">
        <img src="image_logo.png" alt="Logo" class="max-w-full max-h-full">
      </div>

      <div>
        <h3 class="font-bold mb-4">Contenido</h3>
        <ul class="space-y-2 text-gray-200">
          <li><a href="#" class="hover:text-[#d29057]">Inicio</a></li>
          <li><a href="#" class="hover:text-[#d29057]">Sobre Nosotros</a></li>
          <li><a href="#" class="hover:text-[#d29057]">Contacto</a></li>
          <li><a href="#" class="hover:text-[#d29057]">Vender</a></li>
          <li><a href="#" class="hover:text-[#d29057]">Comprar</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-bold mb-4">Síguenos</h3>
        <ul class="space-y-2 text-gray-200">
          <li><a href="#" class="hover:text-[#d29057]">Facebook</a></li>
          <li><a href="#" class="hover:text-[#d29057]">Instagram</a></li>
          <li><a href="#" class="hover:text-[#d29057]">X</a></li>
          <li><a href="#" class="hover:text-[#d29057]">TikTok</a></li>
        </ul>
      </div>

      <div>
        <h3 class="font-bold mb-4">Contáctanos</h3>
        <ul class="space-y-2 text-gray-200">
          <li>+569 60270920</li>
          <li><a href="mailto:ejempl@gmail.com" class="hover:text-[#d29057]">ejempl@gmail.com</a></li>
          <li>B/12ejemplo</li>
        </ul>
      </div>
    </div>

    <div class="mt-10 text-center text-sm text-gray-400 border-t border-gray-600 pt-6">
      © 2025 Home Finder — Todos los derechos reservados.
    </div>
  </footer>

  
</body>
</html>