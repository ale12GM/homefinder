  <?php
  session_start();
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
      
      /* Animaciones sutiles */
      .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
      }
      
      .animate-slide-up {
        animation: slideUp 0.8s ease-out;
      }
      
      .animate-bounce-subtle {
        animation: bounceSubtle 2s ease-in-out infinite;
      }
      
      .animate-float {
        animation: float 3s ease-in-out infinite;
      }
      
      .animate-scale-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      
      .animate-scale-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      }
      
      .animate-text-glow {
        transition: text-shadow 0.3s ease;
      }
      
      .animate-text-glow:hover {
        text-shadow: 0 0 10px rgba(221, 161, 94, 0.5);
      }
      
      /* Animaciones de scroll */
      .scroll-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease, transform 0.6s ease;
      }
      
      .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
      }
      
      /* Keyframes */
      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }
      
      @keyframes slideUp {
        from { 
          opacity: 0; 
          transform: translateY(50px); 
        }
        to { 
          opacity: 1; 
          transform: translateY(0); 
        }
      }
      
      @keyframes bounceSubtle {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
      }
      
      @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
      }
      
      /* Animación de entrada escalonada */
      .stagger-1 { animation-delay: 0.1s; }
      .stagger-2 { animation-delay: 0.2s; }
      .stagger-3 { animation-delay: 0.3s; }
      .stagger-4 { animation-delay: 0.4s; }
      
      /* Efecto de partículas sutiles */
      .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(221, 161, 94, 0.3);
        border-radius: 50%;
        animation: particleFloat 6s linear infinite;
      }
      
      @keyframes particleFloat {
        0% {
          transform: translateY(100vh) rotate(0deg);
          opacity: 0;
        }
        10% {
          opacity: 1;
        }
        90% {
          opacity: 1;
        }
        100% {
          transform: translateY(-100px) rotate(360deg);
          opacity: 0;
        }
      }
    </style>
  </head>
  <body class="h-screen w-full bg-white" style="font-family: 'Poppins', sans-serif;">

        


  <section id="hero" class="relative h-screen w-full bg-cover bg-center overflow-hidden"
          style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1350&q=80');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    
    <!-- Partículas sutiles -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
      <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
      <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
      <div class="particle" style="left: 40%; animation-delay: 3s;"></div>
      <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
      <div class="particle" style="left: 60%; animation-delay: 5s;"></div>
      <div class="particle" style="left: 70%; animation-delay: 1.5s;"></div>
      <div class="particle" style="left: 80%; animation-delay: 2.5s;"></div>
      <div class="particle" style="left: 90%; animation-delay: 3.5s;"></div>
    </div>

    <!-- Contenido -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">

      <!-- Título -->
      <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-8 animate-fade-in animate-text-glow" style="color: #FEFAE0;">HOME FINDER</h1>

      <!-- Barra de búsqueda -->
      <div class="w-full max-w-4xl animate-slide-up stagger-1">
        <form action="/usuario/propiedades" method="GET" class="flex items-center rounded-full shadow-lg overflow-hidden animate-scale-hover" style="background-color: #FEFAE0;">
          
          <!-- Icono lupa + input de búsqueda -->
          <div class="flex items-center flex-1">
            <span class="pl-4 pr-2 text-lg animate-bounce-subtle">
              <svg class="w-5 h-5" style="filter: invert(47%) sepia(21%) saturate(1478%) hue-rotate(352deg) brightness(97%) contrast(85%);" fill="currentColor" viewBox="0 0 24 24">
                <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
              </svg>
            </span>
            <input type="text" name="buscar" placeholder="Buscar por ubicación, precio, características..."
                   class="flex-1 py-3 focus:outline-none transition-all duration-300 focus:scale-105" style="color: #DDA15E; background-color: #FEFAE0;">
          </div>

          <!-- Filtros desplegables -->
          <div class="flex items-center gap-2 px-2">
            <!-- Filtro de precio -->
            <select name="precio_min" class="py-2 px-3 rounded-full border-0 focus:outline-none text-sm" style="color: #DDA15E; background-color: #FEFAE0;">
              <option value="">Precio min</option>
              <option value="50000">$50,000</option>
              <option value="100000">$100,000</option>
              <option value="200000">$200,000</option>
              <option value="300000">$300,000</option>
            </select>
            
            <select name="precio_max" class="py-2 px-3 rounded-full border-0 focus:outline-none text-sm" style="color: #DDA15E; background-color: #FEFAE0;">
              <option value="">Precio max</option>
              <option value="100000">$100,000</option>
              <option value="200000">$200,000</option>
              <option value="300000">$300,000</option>
              <option value="500000">$500,000</option>
            </select>

            <!-- Filtro de habitaciones -->
            <select name="habitaciones" class="py-2 px-3 rounded-full border-0 focus:outline-none text-sm" style="color: #DDA15E; background-color: #FEFAE0;">
              <option value="">Habitaciones</option>
              <option value="1">1+</option>
              <option value="2">2+</option>
              <option value="3">3+</option>
              <option value="4">4+</option>
            </select>
          </div>

          <!-- Botón de búsqueda -->
          <button type="submit" class="flex items-center gap-2 px-6 py-3 text-white font-medium transition-all duration-300 bg-[#DDA15E] hover:bg-[#BC8A4B] hover:scale-105 ml-2">
            <svg class="w-4 h-4" style="filter: brightness(0) invert(1);" fill="currentColor" viewBox="0 0 24 24">
              <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            </svg>
            <span class="text-sm font-semibold">BUSCAR</span>
          </button>
        </form>

        <!-- Botones de acción rápida -->
        <div class="flex justify-center gap-4 mt-4 animate-slide-up stagger-2">
          <a href="/usuario/propiedades" class="flex items-center gap-2 px-4 py-2 text-white font-medium transition-all duration-500 bg-[#DDA15E] hover:bg-[#BC8A4B] rounded-full animate-scale-hover">
            <svg class="w-4 h-4" style="filter: brightness(0) invert(1);" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
            <span class="text-sm font-semibold">VER TODAS</span>
          </a>
          <a href="/usuario/propiedades/publicar" class="flex items-center gap-2 px-4 py-2 text-white font-medium transition-all duration-500 bg-[#DDA15E] hover:bg-[#BC8A4B] rounded-full animate-scale-hover">
            <svg class="w-4 h-4" style="filter: brightness(0) invert(1);" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"/>
            </svg>
            <span class="text-sm font-semibold">VENDER</span>
          </a>
        </div>
      </div>

      <!-- Subtítulo -->
      <p class="mt-6 text-base sm:text-lg md:text-xl font-light px-2 animate-fade-in stagger-3" style="color: #FEFAE0;">
        "Encuentra tu próximo hogar con nosotros: fácil, rápido y seguro."
      </p>
    </div>
  </section>

    <!-- ================= SOBRE NOSOTROS ================= -->
  <section id="sobre-nosotros" class="py-12 bg-white">
    <!-- Contenido de Sobre Nosotros -->
    <h2 class="text-center text-4xl md:text-5xl font-bold text-orange-400 mb-10 scroll-reveal animate-text-glow">
      Sobre Nosotros
    </h2>

    <!-- Contenedor -->
    <div class="bg-[#535E46] grid grid-cols-1 md:grid-cols-2 items-center gap-8 mx-auto py-12 px-10 relative overflow-hidden min-h-[66vh]">

      <!-- Texto -->
      <div class="text-[#FEFAE0] p-8 flex flex-col justify-center ml-8 md:ml-20 scroll-reveal">
        
        <h3 class="text-4xl md:text-5xl font-bold mb-8 text-left leading-snug animate-fade-in">
          Construimos más que espacios, creamos hogares
        </h3>
        
        <p class="mb-10 text-lg md:text-xl leading-relaxed text-left animate-slide-up stagger-1">
          Creemos que cada hogar cuenta una historia.  
          Por eso, nos enfocamos en acompañar a cada persona en la búsqueda de un espacio donde pueda crecer, disfrutar y sentirse en paz.
        </p>

        <!-- Botón centrado dentro de su mitad -->
        <div class="flex justify-center">
          <a href="#contacto" class="flex items-center gap-3 px-7 py-3.5 bg-[#B1BCA4] text-[#FEFAE0] text-lg font-semibold rounded-full hover:bg-[#9FA88F] transition-all duration-300 hover:scale-105 animate-scale-hover">
            <svg class="w-6 h-6 animate-bounce-subtle" fill="currentColor" viewBox="0 0 24 24">
              <path d="M6.62 10.79a15.09 15.09 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/>
            </svg>
            CONTÁCTANOS
          </a>
        </div>
      </div>

      <!-- Imagen alta centrada -->
      <div class="flex justify-center relative scroll-reveal">
        <img src="https://images.pexels.com/photos/7642004/pexels-photo-7642004.jpeg?auto=compress&cs=tinysrgb&w=600&h=900&dpr=1" 
            alt="Entrega de llaves contrato inmobiliaria" 
            class="h-[550px] md:h-[700px] w-auto rounded-2xl shadow-lg relative z-10 object-cover animate-scale-hover animate-float">
      </div>
    </div>
  </section>


  <section class="py-20 bg-white">
    <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-20 px-4">

      <!-- Columna izquierda -->
      <div class="flex flex-col scroll-reveal">
        <!-- Título -->
        <h2 class="text-4xl md:text-5xl font-bold text-[#2E3B1F] mb-10 animate-fade-in animate-text-glow">Nuestro trabajo</h2>
        
        <!-- Imagen -->
        <img src="https://ventramelidecor.com.br/wp-content/uploads/2024/05/casa-moderna-linhas-retas-1024x512.jpg"
            alt="Casa moderna"
            class="w-full h-96 rounded-2xl shadow-lg mb-10 object-cover animate-scale-hover animate-float">
        
        <!-- Info de la casa -->
        <div class="text-left text-gray-700 space-y-4 text-xl animate-slide-up stagger-1">
          <p class="animate-fade-in stagger-1"><strong>Ubicación:</strong> Av. Los Pinos 123, Lima</p>
          <p class="animate-fade-in stagger-2"><strong>Habitaciones:</strong> 3 dormitorios, 2 baños</p>
          <p class="animate-fade-in stagger-3"><strong>Área:</strong> 150 m²</p>
          <p class="animate-fade-in stagger-4"><strong>Precio:</strong> $120,000</p>
        </div>
      </div>

      <!-- Columna derecha -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-20 gap-y-16 items-start text-center">

        <!-- Elemento 1 -->
        <div class="flex flex-col items-center space-y-4 p-4 scroll-reveal animate-scale-hover">
          <svg class="w-24 h-24 mb-2 animate-bounce-subtle" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L2 7L12 12L22 7L12 2Z"/>
            <path d="M2 17L12 22L22 17"/>
            <path d="M2 12L12 17L22 12"/>
          </svg>
          <p class="text-xl text-gray-800 font-medium animate-text-glow">Propiedades cómodas para tu bienestar</p>
        </div>

        <!-- Elemento 2 -->
        <div class="flex flex-col items-center space-y-4 p-4 scroll-reveal animate-scale-hover">
          <svg class="w-24 h-24 mb-2 animate-bounce-subtle" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C6.48 2 2 6.48 2 12S6.48 22 12 22 22 17.52 22 12 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12S7.59 4 12 4 20 7.59 20 12 16.41 20 12 20Z"/>
            <path d="M12.5 7H11V13L16.25 16.15L17 14.92L12.5 12.25V7Z"/>
          </svg>
          <p class="text-xl text-gray-800 font-medium animate-text-glow">Opciones accesibles para que ahorres</p>
        </div>

        <!-- Elemento 3 -->
        <div class="flex flex-col items-center space-y-4 p-4 scroll-reveal animate-scale-hover">
          <svg class="w-24 h-24 mb-2 animate-bounce-subtle" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM20 16H5.17L4 17.17V4H20V16Z"/>
            <path d="M7 9H17V11H7V9ZM7 12H15V14H7V12Z"/>
          </svg>
          <p class="text-xl text-gray-800 font-medium animate-text-glow">Comunicación clara y constante</p>
        </div>

        <!-- Elemento 4 -->
        <div class="flex flex-col items-center space-y-4 p-4 scroll-reveal animate-scale-hover">
          <svg class="w-24 h-24 mb-2 animate-bounce-subtle" style="filter: invert(17%) sepia(14%) saturate(1097%) hue-rotate(51deg) brightness(90%) contrast(90%);" fill="currentColor" viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
          <p class="text-xl text-gray-800 font-medium animate-text-glow">Casas de calidad garantizada</p>
        </div>

      </div>
    </div>
  </section>



  <section class="py-12" style="background-color: #F5F5F5;">
    <div class="max-w-6xl mx-auto px-6 text-center">
      <!-- Título -->
      <h2 class="text-2xl md:text-3xl font-bold text-[#244434] mb-8 scroll-reveal animate-text-glow">
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
        <div class="flex animate-scroll space-x-12 scroll-reveal">
          
          <!-- Logos (primer set) -->
          <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg" alt="IBM" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg" alt="Samsung" class="h-16 object-contain animate-scale-hover">
          
          <!-- Logos (duplicados para loop continuo) -->
          <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg" alt="Amazon" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg" alt="IBM" class="h-16 object-contain animate-scale-hover">
          <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg" alt="Samsung" class="h-16 object-contain animate-scale-hover">
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

      <h2 class="text-4xl md:text-5xl font-bold mb-4 text-[#244434] scroll-reveal animate-text-glow">
        Tu viaje inmobiliario comienza aquí
      </h2>
      <p class="text-xl md:text-2xl mb-12 text-[#244434] scroll-reveal animate-fade-in">
        Ya sea que esté comprando, vendiendo o alquilando, brindamos las herramientas y los recursos para que su experiencia sea fluida y exitosa.
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <a href="/usuario/propiedades/publicar" class="group flex flex-col items-start text-left border-2 rounded-2xl p-8 cursor-pointer transition duration-300 hover:shadow-lg scroll-reveal animate-scale-hover
                    border-[#DDA15E] bg-[#FEFAE0] text-[#DDA15E] hover:bg-[#DDA15E] hover:text-[#FEFAE0]">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4 transition-colors duration-300 text-[#DDA15E] group-hover:text-[#FEFAE0] animate-bounce-subtle" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 3l9 8h-3v9h-12v-9h-3l9-8z"/>
          </svg>
          <h3 class="text-2xl font-bold mb-2 animate-text-glow">Vender una casa</h3>
          <p class="text-lg">Encuentra el comprador ideal con nuestras amplias listas y asesoría experta.</p>
        </a>

        <a href="/usuario/propiedades" class="group flex flex-col items-start text-left border-2 rounded-2xl p-8 cursor-pointer transition duration-300 hover:shadow-lg scroll-reveal animate-scale-hover
                    border-[#DDA15E] bg-[#FEFAE0] text-[#DDA15E] hover:bg-[#DDA15E] hover:text-[#FEFAE0]">
          <!-- Nuevo icono llave-casa -->
          <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-4 transition-colors duration-300 text-[#DDA15E] group-hover:text-[#FEFAE0] animate-bounce-subtle" fill="currentColor" viewBox="0 0 24 24"><path d="M21.707 11.293l-9-9A1 1 0 0 0 11 2H5a3 3 0 0 0-3 3v6a1 1 0 0 0 .293.707l9 9a1 1 0 0 0 1.414 0l8-8a1 1 0 0 0 0-1.414zM7.5 9.5a2 2 0 1 1 .001-4.001A2 2 0 0 1 7.5 9.5z"/></svg>

          <h3 class="text-2xl font-bold mb-2 animate-text-glow">Comprar una casa</h3>
          <p class="text-lg">Encuentra tu lugar perfecto con nuestras amplias listas y orientación experta.</p>
        </a>

      </div>
    </div>
  </section>



  <section id="contacto" class="py-20 bg-white">
      <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">

      <!-- Columna izquierda: Información -->
      <div class="scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 text-[#DDA15E] animate-fade-in animate-text-glow">
          Contáctanos
        </h2>

        <p class="text-gray-700 mb-8 animate-slide-up stagger-1">
          Estamos aquí para ayudarte. Si tienes dudas, necesitas asesoría o quieres más 
          información sobre nuestras propiedades, comunícate con nosotros y con gusto te atenderemos.
        </p>

        <!-- Datos de contacto -->
        <div class="space-y-6 text-[#244434]">
          <div class="flex items-center gap-4 animate-fade-in stagger-1 animate-scale-hover">
            <!-- Icono Teléfono -->
            <div class="text-[#DDA15E] animate-bounce-subtle">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6.62 10.79a15.09 15.09 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24c1.12.37 2.33.57 3.58.57a1 1 0 011 1V20a1 1 0 01-1 1C10.61 21 3 13.39 3 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.25.2 2.46.57 3.58a1 1 0 01-.25 1.01l-2.2 2.2z"/>
              </svg>
            </div>
            <div>
              <p class="font-bold animate-text-glow">Teléfono</p>
              <p class="text-gray-600">+569 78945612</p>
            </div>
          </div>

          <div class="flex items-center gap-4 animate-fade-in stagger-2 animate-scale-hover">
            <!-- Icono Email -->
            <div class="text-[#DDA15E] animate-bounce-subtle">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 2v.01L12 13 4 6.01V6h16zM4 18V8l8 5 8-5v10H4z"/>
              </svg>
            </div>
            <div>
              <p class="font-bold animate-text-glow">Email</p>
              <p class="text-gray-600">ejemplo@gmail.com</p>
            </div>
          </div>

          <div class="flex items-center gap-4 animate-fade-in stagger-3 animate-scale-hover">
            <!-- Icono Dirección -->
            <div class="text-[#DDA15E] animate-bounce-subtle">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1114.5 9 2.5 2.5 0 0112 11.5z"/>
              </svg>
            </div>
            <div>
              <p class="font-bold animate-text-glow">Dirección</p>
              <p class="text-gray-600">B/ejemplo12</p>
            </div>
          </div>

          <div class="flex items-center gap-4 animate-fade-in stagger-4 animate-scale-hover">
            <!-- Icono Website -->
            <div class="text-[#DDA15E] animate-bounce-subtle">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 1010 10A10.01 10.01 0 0012 2zm6.93 6h-3.68a15.08 15.08 0 00-1.39-4.56A8.02 8.02 0 0118.93 8zM12 4a13.07 13.07 0 011.93 6H10.07A13.07 13.07 0 0112 4zM4.26 16A7.93 7.93 0 014 12a7.93 7.93 0 01.26-2h3.48a15.45 15.45 0 000 4zm1.81 2h3.68a15.08 15.08 0 001.39 4.56A8.02 8.02 0 016.07 18zM12 20a13.07 13.07 0 01-1.93-6h3.86A13.07 13.07 0 0112 20zm3.48-6a15.45 15.45 0 000-4h3.48a7.93 7.93 0 01.26 2 7.93 7.93 0 01-.26 2z"/>
              </svg>
            </div>
            <div>
              <p class="font-bold animate-text-glow">Website</p>
              <p class="text-gray-600">homefinder.com</p>
            </div>
          </div>
        </div>

        <!-- Redes sociales -->
        <div class="mt-8 animate-slide-up stagger-2">
          <p class="mb-4 font-semibold text-[#244434] animate-text-glow">Síguenos en:</p>
          <div class="flex gap-4 text-[#DDA15E]">
            <i class="fab fa-facebook-f cursor-pointer animate-bounce-subtle hover:scale-125 transition-transform"></i>
            <i class="fab fa-tiktok cursor-pointer animate-bounce-subtle hover:scale-125 transition-transform"></i>
            <i class="fab fa-x-twitter cursor-pointer animate-bounce-subtle hover:scale-125 transition-transform"></i>
            <i class="fab fa-instagram cursor-pointer animate-bounce-subtle hover:scale-125 transition-transform"></i>
          </div>
        </div>
      </div>

      <!-- Columna derecha: Formulario -->
      <div class="scroll-reveal">
        <form id="formulario-contacto" class="space-y-4">
          <div class="animate-fade-in stagger-1">
            <label class="block mb-1 font-medium text-[#244434] animate-text-glow">Nombre</label>
            <input type="text" name="nombre" required class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E] transition-all duration-300 focus:scale-105" />
          </div>

          <div class="animate-fade-in stagger-2">
            <label class="block mb-1 font-medium text-[#244434] animate-text-glow">E-mail</label>
            <input type="email" name="email" required class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E] transition-all duration-300 focus:scale-105" />
          </div>

          <div class="animate-fade-in stagger-3">
            <label class="block mb-1 font-medium text-[#244434] animate-text-glow">Nombre de compañía</label>
            <input type="text" name="empresa" class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E] transition-all duration-300 focus:scale-105" />
          </div>

          <div class="animate-fade-in stagger-4">
            <label class="block mb-1 font-medium text-[#244434] animate-text-glow">Número de teléfono</label>
            <input type="text" name="telefono" class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E] transition-all duration-300 focus:scale-105" />
          </div>

          <div class="animate-fade-in stagger-1">
            <label class="block mb-1 font-medium text-[#244434] animate-text-glow">Mensaje</label>
            <textarea name="mensaje" rows="4" required class="w-full border rounded-3xl p-3 focus:outline-none focus:ring-2 focus:ring-[#DDA15E] transition-all duration-300 focus:scale-105"></textarea>
          </div>

          <button type="submit" class="bg-[#DDA15E] hover:bg-[#BC8A4B] text-white font-bold py-3 px-6 rounded-3xl shadow-md transition-all duration-300 hover:scale-105 animate-scale-hover animate-bounce-subtle">
            Enviar
          </button>
        </form>
        
        <!-- Mensaje de respuesta -->
        <div id="mensaje-respuesta" class="mt-4 hidden">
          <div class="p-4 rounded-3xl text-center font-medium"></div>
        </div>
      </div>
    </div>
  </section>

    
    <!-- JavaScript para animaciones de scroll -->
    <script>
      // Animaciones de scroll
      function revealOnScroll() {
        const reveals = document.querySelectorAll('.scroll-reveal');
        
        for (let i = 0; i < reveals.length; i++) {
          const windowHeight = window.innerHeight;
          const elementTop = reveals[i].getBoundingClientRect().top;
          const elementVisible = 150;
          
          if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add('revealed');
          }
        }
      }
      
      // Ejecutar al cargar y al hacer scroll
      window.addEventListener('scroll', revealOnScroll);
      window.addEventListener('load', revealOnScroll);
      
      // Animación de partículas
      function createParticle() {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 6 + 's';
        particle.style.animationDuration = (Math.random() * 3 + 4) + 's';
        
        const hero = document.querySelector('#hero');
        if (hero) {
          hero.appendChild(particle);
          
          // Remover partícula después de la animación
          setTimeout(() => {
            if (particle.parentNode) {
              particle.parentNode.removeChild(particle);
            }
          }, 8000);
        }
      }
      
      // Crear partículas cada 2 segundos
      setInterval(createParticle, 2000);
      
      // Efectos de hover mejorados
      document.addEventListener('DOMContentLoaded', function() {
        // Agregar efectos de hover a elementos con animate-scale-hover
        const hoverElements = document.querySelectorAll('.animate-scale-hover');
        hoverElements.forEach(element => {
          element.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
          });
          
          element.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
          });
        });

        // Manejar formulario de contacto
        const formularioContacto = document.getElementById('formulario-contacto');
        if (formularioContacto) {
          formularioContacto.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const botonEnviar = this.querySelector('button[type="submit"]');
            const mensajeRespuesta = document.getElementById('mensaje-respuesta');
            const mensajeDiv = mensajeRespuesta.querySelector('div');
            
            // Deshabilitar botón y mostrar loading
            botonEnviar.disabled = true;
            botonEnviar.textContent = 'Enviando...';
            
            try {
              const response = await fetch('/contacto/enviar', {
                method: 'POST',
                body: formData,
                headers: {
                  'X-Requested-With': 'XMLHttpRequest'
                }
              });
              
              const data = await response.json();
              
              if (data.success) {
                // Éxito
                mensajeDiv.className = 'p-4 rounded-3xl text-center font-medium bg-green-100 text-green-800 border border-green-200';
                mensajeDiv.textContent = data.mensaje;
                formularioContacto.reset();
                
                // Mostrar datos del lead en consola para copiar
                if (data.datos) {
                  console.log('=== NUEVO LEAD RECIBIDO ===');
                  console.log('Nombre:', data.datos.nombre);
                  console.log('Email:', data.datos.email);
                  if (data.datos.empresa) console.log('Empresa:', data.datos.empresa);
                  if (data.datos.telefono) console.log('Teléfono:', data.datos.telefono);
                  console.log('Mensaje:', data.datos.mensaje);
                  console.log('========================');
                  
                  // También mostrar en pantalla temporalmente
                  const leadInfo = document.createElement('div');
                  leadInfo.className = 'mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm';
                  leadInfo.innerHTML = `
                    <strong>Lead recibido:</strong><br>
                    <strong>Nombre:</strong> ${data.datos.nombre}<br>
                    <strong>Email:</strong> ${data.datos.email}<br>
                    ${data.datos.empresa ? `<strong>Empresa:</strong> ${data.datos.empresa}<br>` : ''}
                    ${data.datos.telefono ? `<strong>Teléfono:</strong> ${data.datos.telefono}<br>` : ''}
                    <strong>Mensaje:</strong> ${data.datos.mensaje}
                  `;
                  mensajeRespuesta.appendChild(leadInfo);
                  
                  // Remover después de 10 segundos
                  setTimeout(() => {
                    if (leadInfo.parentNode) {
                      leadInfo.parentNode.removeChild(leadInfo);
                    }
                  }, 10000);
                }
              } else {
                // Error
                mensajeDiv.className = 'p-4 rounded-3xl text-center font-medium bg-red-100 text-red-800 border border-red-200';
                mensajeDiv.textContent = data.errores ? data.errores.join(', ') : 'Error al enviar el mensaje';
              }
              
              mensajeRespuesta.classList.remove('hidden');
              
              // Scroll suave al mensaje
              mensajeRespuesta.scrollIntoView({ behavior: 'smooth', block: 'center' });
              
            } catch (error) {
              mensajeDiv.className = 'p-4 rounded-3xl text-center font-medium bg-red-100 text-red-800 border border-red-200';
              mensajeDiv.textContent = 'Error de conexión. Inténtalo de nuevo.';
              mensajeRespuesta.classList.remove('hidden');
            } finally {
              // Rehabilitar botón
              botonEnviar.disabled = false;
              botonEnviar.textContent = 'Enviar';
            }
          });
        }
      });
    </script>
  </body>
  </html>