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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    .animate-fade-in {
      animation: fadeIn 0.8s ease-out;
    }
    .animate-slide-in-left {
      animation: slideInLeft 0.8s ease-out;
    }
    .animate-slide-in-right {
      animation: slideInRight 0.8s ease-out;
    }
    .animate-bounce-in {
      animation: bounceIn 1s ease-out;
    }
    .animate-float {
      animation: float 3s ease-in-out infinite;
    }
    .animate-pulse-slow {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideInLeft {
      from { transform: translateX(-100px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideInRight {
      from { transform: translateX(100px); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes bounceIn {
      0% { transform: scale(0.3); opacity: 0; }
      50% { transform: scale(1.05); }
      70% { transform: scale(0.9); }
      100% { transform: scale(1); opacity: 1; }
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    .gradient-bg {
      background: linear-gradient(135deg, #DDA15E 0%, #F4A261 50%, #E76F51 100%);
    }
    .glass-effect {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
  </style>
</head>

<body class="bg-gradient-to-br from-[#FEFAE0] via-[#F4A261] to-[#DDA15E] min-h-screen">
  <!-- Fondo decorativo -->
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-[#DDA15E] rounded-full opacity-20 animate-float"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-[#F4A261] rounded-full opacity-20 animate-float" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-60 h-60 bg-[#E76F51] rounded-full opacity-10 animate-pulse-slow"></div>
  </div>

  <div class="relative flex w-screen h-screen shadow-2xl overflow-hidden">
    
    <!-- Formulario Izquierda -->
    <div class="w-1/2 bg-white/90 backdrop-blur-sm p-10 flex flex-col justify-center animate-slide-in-left">
      
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
          <div class="mb-4 p-4 rounded-xl bg-orange-50 text-orange-800 border border-orange-200 animate-bounce-in">
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
          <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-800 border border-red-200 animate-bounce-in">
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

      <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center animate-fade-in">¡Bienvenido de vuelta!</h2>

      <form action="" method="POST" class="space-y-6 animate-fade-in">
        
        <div class="transform transition-all duration-300 hover:scale-105">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
          <input 
            type="email" 
            id="email" 
            name="email"
            placeholder="Correo electrónico"
            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDA15E] focus:border-[#DDA15E] transition-all duration-300 hover:border-[#DDA15E]"
            required
            value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8'); ?>"
          >
        </div>

        <div class="transform transition-all duration-300 hover:scale-105">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
          <div class="relative">
            <input 
              type="password" 
              id="password" 
              name="password"
              placeholder="Contraseña"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDA15E] focus:border-[#DDA15E] pr-12 transition-all duration-300 hover:border-[#DDA15E]"
              required
              value="<?php echo htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
            >
            <i id="togglePassword" class="fa-solid fa-eye absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer hover:text-[#DDA15E] transition-colors duration-300"></i>
          </div>
        </div>

        <div class="text-sm mb-6 text-center">
          <a href="#" class="text-[#DDA15E] hover:text-[#c48d4b] hover:underline transition-colors duration-300">¿Olvidaste tu contraseña?</a>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-[#DDA15E] to-[#F4A261] hover:from-[#c48d4b] hover:to-[#E76F51] text-white font-semibold py-3 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg shadow-md">
          <span class="flex items-center justify-center">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Iniciar sesión
          </span>
        </button>

        <p class="text-sm text-center text-gray-600 animate-fade-in">
          ¿No tienes una cuenta? 
          <a href="/singUp" class="text-[#DDA15E] hover:text-[#c48d4b] hover:underline transition-colors duration-300 font-medium">Haz clic para crear una</a>
        </p>

      </form>

    </div>

    <!-- Panel Derecha -->
    <div class="w-1/2 gradient-bg flex flex-col items-center justify-center text-white animate-slide-in-right relative overflow-hidden">
      <!-- Elementos decorativos de fondo -->
      <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute bottom-20 right-10 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-12 h-12 bg-white/10 rounded-full animate-pulse-slow"></div>
      </div>
      
      <div class="relative z-10 text-center animate-bounce-in">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40 mb-8 mx-auto animate-float" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 3l8 6v12a1 1 0 01-1 1h-5v-6H10v6H5a1 1 0 01-1-1V9l8-6z" />
        </svg>
        <h1 class="text-4xl font-bold mb-4 animate-fade-in">Home Finder</h1>
        <p class="text-xl opacity-90 animate-fade-in" style="animation-delay: 0.5s;">Encuentra tu hogar ideal</p>
        <div class="mt-8 flex justify-center space-x-4 animate-fade-in" style="animation-delay: 1s;">
          <div class="w-3 h-3 bg-white/30 rounded-full animate-pulse"></div>
          <div class="w-3 h-3 bg-white/30 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
          <div class="w-3 h-3 bg-white/30 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
        </div>
      </div>
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