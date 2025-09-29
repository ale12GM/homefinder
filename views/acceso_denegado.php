<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado - Home Finder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-[#FEFAE0] min-h-screen" style="font-family: 'Poppins', sans-serif;">
    
    
    

    <!-- Main Content -->
    <main class="flex items-center justify-center min-h-[calc(100vh-200px)] px-4">
        <div class="max-w-2xl mx-auto text-center">
            
            <!-- Error Icon -->
            <div class="mb-8">
                <div class="mx-auto w-32 h-32 bg-[#DDA15E] rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-lock text-white text-5xl"></i>
                </div>
            </div>

            <!-- Error Code -->
            <div class="mb-6">
                <h1 class="text-8xl font-bold text-[#DDA15E] mb-4">403</h1>
                <h2 class="text-3xl font-bold text-[#244434] mb-4">Acceso Denegado</h2>
            </div>

            <!-- Error Message -->
            <div class="mb-8">
                <p class="text-xl text-gray-700 mb-4">
                    Lo sentimos, no tienes permisos para acceder a esta página.
                </p>
                <p class="text-lg text-gray-600">
                    Si crees que esto es un error, por favor contacta al administrador del sistema.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/usuario/home" 
                   class="flex items-center gap-2 px-6 py-3 bg-[#DDA15E] text-white font-semibold rounded-full hover:bg-[#c48d4b] transition-all duration-300 shadow-md hover:shadow-lg">
                    <i class="fas fa-home"></i>
                    Ir al Inicio
                </a>
                
                <a href="/usuario/propiedades" 
                   class="flex items-center gap-2 px-6 py-3 border-2 border-[#DDA15E] text-[#DDA15E] font-semibold rounded-full hover:bg-[#DDA15E] hover:text-white transition-all duration-300">
                    <i class="fas fa-search"></i>
                    Ver Propiedades
                </a>
            </div>

            <!-- Additional Help -->
            <div class="mt-12 p-6 bg-white rounded-2xl shadow-md border border-gray-200">
                <h3 class="text-lg font-semibold text-[#244434] mb-3">¿Necesitas ayuda?</h3>
                <p class="text-gray-600 mb-4">
                    Si necesitas acceso a esta sección, contacta con el administrador o verifica tus permisos.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    
                    <a href="/usuario/mispropiedades" 
                       class="flex items-center justify-center gap-2 px-4 py-2 text-[#DDA15E] hover:text-[#a66933] transition">
                        <i class="fas fa-user"></i>
                        Mi Perfil
                    </a>
                </div>
            </div>

        </div>
    </main>


</body>
</html>