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
          <svg class="h-10 w-10 text-[#a66933]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
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
    
    <?php if (isset($_SESSION['roles']) && in_array("Administrador", $_SESSION['roles'])): ?>
      <!-- Menú para usuarios normales -->
      <li><a href="/admin/gestion_de_usuarios" class="hover:text-[#a66933]">Usuarios</a></li>
      <li><a href="/admin/roles" class="hover:text-[#a66933]">Roles</a></li>
      <li><a href="/admin/propiedades" class="hover:text-[#a66933]">Propiedades</a></li>
      <?php else: ?>
        <li><a href="/usuario/home#sobre-nosotros" class="hover:text-[#a66933]">Sobre Nosotros</a></li>
        <li><a href="/usuario/home#contacto" class="hover:text-[#a66933]">Contacto</a></li>
        <!-- Menú para administradores -->
    <?php endif; ?>
    
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
    <svg class="w-full h-full object-cover bg-gray-200" fill="currentColor" viewBox="0 0 24 24">
      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
    </svg>
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
      <div class="w-20 h-20 rounded-full border-4 border-gray-200 shadow bg-gray-200 flex items-center justify-center">
        <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
      <h2 class="mt-2 text-lg font-bold text-[#DDA15E]">
        <?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Invitado'); ?>
        <?php if (isset($_SESSION['roles']) && in_array('admin', $_SESSION['roles'])): ?>
          <span class="ml-2 text-xs bg-[#DDA15E] text-white px-2 py-1 rounded-full">ADMIN</span>
        <?php endif; ?>
      </h2>
    </div>

    <!-- Opciones -->
    <div class="flex flex-col gap-3">
      
      <button id="btnEditar"
         class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full ">
         Editar
      </button>
      <a href="/seguridad" 
         class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full ">
         Seguridad
      </a>
      <a href="/usuario/mispropiedades" 
         class="block text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full ">
         Ver Propiedades
      </a>
     <form action="" method="post">
    <input type="hidden" name="cerrar">
    <button type="submit" class="block w-full text-center bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full hover:bg-green-700 transition mt-4">
      Cerrar Sesión
    </button>
  </form>
    </div>
  </div>
</div>

<!-- Overlay del modal editar perfil -->
<!-- Overlay del modal editar perfil -->
<div id="overlayEditar" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40">
  <div id="modalEditar" class="absolute right-4 top-5 w-[340px] bg-white rounded-2xl shadow-2xl p-6 z-50">
    
    <!-- Botón cerrar -->
    <button id="closeModal" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-lg">✕</button>
    
    <!-- Título -->
    <h2 class="text-xl font-bold text-left text-[#DDA15E] mb-4">Editar Perfil</h2>

    <!-- Foto y nombre -->
    <div class="flex flex-col items-center mb-5">
      <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-[#FEFAE0] shadow bg-gray-200 flex items-center justify-center">
        <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
      </div>
      <h2 class="mt-2 text-lg font-semibold text-[#5B674D]">
        <?php echo htmlspecialchars($_SESSION['usuario']); ?>
      </h2>
    </div>

    <!-- Formulario -->
    <form id="form-editar-perfil" class="flex flex-col gap-3 text-sm" onsubmit="return validarFormulario()">
      <input type="hidden" id="editar-id" name="id" value="<?php echo $_SESSION['id']; ?>">

      <input class="w-full border border-[#5B674D] rounded-full px-4 py-2 " 
             name="nombre" id="editar-nombre" type="text" placeholder="Nombre" required>

      <input class="w-full border border-[#5B674D] rounded-full px-4 py-2 " 
             name="apellido" id="editar-apellido" type="text" placeholder="Apellido" required>

      <input class="w-full border border-[#5B674D] rounded-full px-4 py-2 " 
             name="email" id="editar-email" type="email" placeholder="Email" required>

      <!-- Contraseñas con icono -->
      <div class="relative">
        <input class="w-full border border-[#5B674D] rounded-full px-4 py-2 pr-10" 
               type="password" name="actual" id="actual" placeholder="Contraseña actual">
        <button type="button" onclick="togglePassword('actual')" class="absolute right-3 top-2.5 text-gray-500">👁</button>
      </div>

      <div class="relative">
        <input class="w-full border border-[#5B674D] rounded-full px-4 py-2 pr-10 " 
               type="password" name="nueva" id="nueva" placeholder="Nueva contraseña">
        <button type="button" onclick="togglePassword('nueva')" class="absolute right-3 top-2.5 text-gray-500">👁</button>
      </div>

      <div class="relative">
        <input class="w-full border border-[#5B674D] rounded-full px-4 py-2 pr-10 " 
               type="password" name="confirmar" id="confirmar" placeholder="Confirmar nueva contraseña">
        <button type="button" onclick="togglePassword('confirmar')" class="absolute right-3 top-2.5 text-gray-500">👁</button>
      </div>

      <!-- Botones -->
      <div class="flex gap-2 mt-4">
        <button type="button" onclick="cerrarModal()" 
                class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-full ">
          Cancelar
        </button>
        <button type="submit" 
                class="flex-1 bg-[#5B674D] text-[#FEFAE0] py-2 rounded-full">
          Guardar
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  // Mostrar / ocultar contraseña
  function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
  }
</script>


<script>
  // Función para cerrar modal
function cerrarModal() {
  document.getElementById('overlayEditar').classList.add('hidden');
}

// Cerrar modal al hacer click en la X
document.getElementById('closeModal')?.addEventListener('click', cerrarModal);

// Cerrar modal al hacer click fuera del modal (en el overlay)
document.getElementById('overlayEditar')?.addEventListener('click', (e) => {
  if (e.target === document.getElementById('overlayEditar')) cerrarModal();
});

// Cerrar modal al presionar botón "Cancelar" dentro del form
document.querySelector('#form-editar-perfil button[onclick="cerrarModal()"]')?.addEventListener('click', cerrarModal);

// Avatar menu
document.getElementById('avatarBtn')?.addEventListener('click', () => document.getElementById('overlayPerfil').classList.remove('hidden'));
document.getElementById('closeMenu')?.addEventListener('click', () => document.getElementById('overlayPerfil').classList.add('hidden'));

// Editar perfil
document.getElementById('btnEditar')?.addEventListener('click', async () => {
  document.getElementById('overlayEditar').classList.remove('hidden');
  try {
    const response = await fetch(`/usuarios/obtener?id=${document.getElementById('editar-id').value}`);
    const data = await response.json();
    if (data.success) {
      document.getElementById('editar-nombre').value = data.usuario.nombre || '';
      document.getElementById('editar-apellido').value = data.usuario.apellido || '';
      document.getElementById('editar-email').value = data.usuario.email || '';
    }
  } catch (error) {
    console.error("Error:", error);
  }
});

// Cerrar modales
function cerrarModal() {
  document.getElementById('overlayEditar').classList.add('hidden');
}

// Validación de contraseñas
function validarFormulario() {
  const nueva = document.querySelector('input[name="nueva"]').value;
  const confirmar = document.querySelector('input[name="confirmar"]').value;
  const actual = document.querySelector('input[name="actual"]').value;
  
  if (nueva && nueva !== confirmar) {
    alert('Las contraseñas nuevas no coinciden');
    return false;
  }
  if (nueva && !actual) {
    alert('Debes ingresar tu contraseña actual para cambiarla');
    return false;
  }
  return true;
}

// Enviar formulario
document.getElementById('form-editar-perfil')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  try {
    const response = await fetch('/usuarios/actualizarPerfil', { method: 'POST', body: formData });
    const data = await response.json();
    if (data.success) {
      alert("Perfil actualizado correctamente");
      cerrarModal();
    } else {
      alert(data.message || "Error al actualizar el perfil");
    }
  } catch (error) {
    alert("Error de conexión");
  }
});
</script>

<?php endif; ?>




  </div>
</nav>
    </div>
  </header>

    <main class="">
        <?php echo $contenido; ?>
    </main>

    <?php 
    // No mostrar footer en páginas de autenticación
    $currentUrl = $_SERVER['REQUEST_URI'] ?? '';
    $isAuthPage = strpos($currentUrl, '/login') !== false || strpos($currentUrl, '/singUp') !== false;
    ?>
    
    <?php if (!$isAuthPage): ?>
    <!-- Footer -->
<footer class="bg-[#535E46] text-[#FEFAE0] py-12 px-8 mt-16 font-[Poppins]">
  <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
    
    <!-- Logo -->
    <div class="flex items-center justify-center md:justify-start gap-3">
      <svg class="w-16 h-16 text-[#FEFAE0]" fill="currentColor" viewBox="0 0 24 24">
        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
      </svg>
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
    <?php endif; ?>

    <script>
        // Toggle the menu visibility when the hamburger button is clicked
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('menu-btn');
            const menu = document.getElementById('menu');
            
            if (menuBtn && menu) {
                menuBtn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
