<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Finder - Registro</title>
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
      <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center animate-fade-in">¡Crea una cuenta!</h2>
        
      <form method="POST" class="space-y-6 animate-fade-in">
        
        <div class="transform transition-all duration-300 hover:scale-105">
          <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre:</label>
          <input type="text" id="nombre" name="usuarios[nombre]" placeholder="Nombre"
                 class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDA15E] focus:border-[#DDA15E] transition-all duration-300 hover:border-[#DDA15E]"
                 required>
          <?php if(!empty($errores['nombre'])): ?>
            <p class="text-red-500 text-sm mt-1 animate-bounce-in"><?php echo $errores['nombre']; ?></p>
          <?php endif; ?>    
        </div>

        <div class="transform transition-all duration-300 hover:scale-105">
          <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">Apellido:</label>
          <input type="text" id="apellido" name="usuarios[apellido]" placeholder="Apellido"
                 class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDA15E] focus:border-[#DDA15E] transition-all duration-300 hover:border-[#DDA15E]"
                 required>
          <?php if(!empty($errores['apellido'])): ?>
            <p class="text-red-500 text-sm mt-1 animate-bounce-in"><?php echo $errores['apellido']; ?></p>
          <?php endif; ?> 
        </div>

        <div class="transform transition-all duration-300 hover:scale-105">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email:</label>
          <input type="email" id="email" name="usuarios[email]" placeholder="Email"
                 class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDA15E] focus:border-[#DDA15E] transition-all duration-300 hover:border-[#DDA15E]"
                 required>
          <?php if(!empty($errores['email'])): ?>
            <p class="text-red-500 text-sm mt-1 animate-bounce-in"><?php echo $errores['email']; ?></p>
          <?php endif; ?> 
        </div>

        <div class="transform transition-all duration-300 hover:scale-105">
          <label for="contraseña" class="block text-sm font-medium text-gray-700 mb-2">Contraseña:</label>
          <div class="relative">
            <input type="password" id="contraseña" name="usuarios[password]" placeholder="Contraseña"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDA15E] focus:border-[#DDA15E] pr-12 transition-all duration-300 hover:border-[#DDA15E]"
                   required>
            <i class="fas fa-lock absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
          </div>
          <?php if(!empty($errores['password'])): ?>
            <p class="text-red-500 text-sm mt-1 animate-bounce-in"><?php echo $errores['password']; ?></p>
          <?php endif; ?> 
        </div>

        <div class="transform transition-all duration-300 hover:scale-105">
          <label for="confirmar" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña:</label>
          <div class="relative">
            <input type="password" id="confirmar" name="confirmar" placeholder="Confirmar contraseña"
                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDA15E] focus:border-[#DDA15E] pr-12 transition-all duration-300 hover:border-[#DDA15E]"
                   required>
            <i class="fas fa-lock absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
          </div>
          <?php if(!empty($errores['confirmar'])): ?>
            <p class="text-red-500 text-sm mt-1 animate-bounce-in"><?php echo $errores['confirmar']; ?></p>
          <?php endif; ?> 
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-[#DDA15E] to-[#F4A261] hover:from-[#c48d4b] hover:to-[#E76F51] text-white font-semibold py-3 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg shadow-md">
          <span class="flex items-center justify-center">
            <i class="fas fa-user-plus mr-2"></i>
            Crear cuenta
          </span>
        </button>

        <p class="text-sm text-center text-gray-600 animate-fade-in">
          ¿Ya tienes una cuenta? 
          <a href="/login" class="text-[#DDA15E] hover:text-[#c48d4b] hover:underline transition-colors duration-300 font-medium">Haz clic para iniciar sesión</a>
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
        <p class="text-xl opacity-90 animate-fade-in" style="animation-delay: 0.5s;">Únete a nuestra comunidad</p>
        <div class="mt-8 flex justify-center space-x-4 animate-fade-in" style="animation-delay: 1s;">
          <div class="w-3 h-3 bg-white/30 rounded-full animate-pulse"></div>
          <div class="w-3 h-3 bg-white/30 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
          <div class="w-3 h-3 bg-white/30 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
        </div>
      </div>
    </div>

  </div>

</body>
</html>