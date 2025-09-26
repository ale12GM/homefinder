<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex">

    <div class="w-full md:w-1/2 flex flex-col justify-center items-center bg-white p-8">
        <h1 class="text-2xl font-bold text-[#DDA15E] mb-6">¡Crea una cuenta!</h1>
        
        <form method="POST" class="w-full max-w-sm space-y-4">
        
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input type="text" id="nombre" name="usuarios[nombre]"  placeholder="Nombre"
                class="w-full mt-1 px-3 py-2 border rounded-full focus:ring-2 focus:ring-[#DDA15E] outline-none">
            <?php if(!empty($errores['nombre'])): ?>
                <p class="text-gray-500 text-xs mt-1"><?php echo $errores['nombre']; ?></p>
            <?php endif; ?>    
    </div>

    
    <div>
        <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido:</label>
        <input type="text" id="apellido" name="usuarios[apellido]" placeholder="Apellido"
        class="w-full mt-1 px-3 py-2 border rounded-full focus:ring-2 focus:ring-[#DDA15E] outline-none">
            <?php if(!empty($errores['apellido'])): ?>
                <p class="text-gray-500 text-xs mt-1"><?php echo $errores['apellido']; ?></p>
            <?php endif; ?> 
    </div>

    
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
        <input type="email" id="email" name="usuarios[email]" placeholder="Email"
            class="w-full mt-1 px-3 py-2 border rounded-full focus:ring-2 focus:ring-[#DDA15E] outline-none">
            <?php if(!empty($errores['email'])): ?>
                <p class="text-gray-500 text-xs mt-1"><?php echo $errores['email']; ?></p>
            <?php endif; ?> 
    </div>

    
    <div>
        <label for="contraseña" class="block text-sm font-medium text-gray-700">Contraseña:</label>
        <input type="password" id="contraseña" name="usuarios[password]" placeholder="Contraseña"
            class="w-full mt-1 px-3 py-2 border rounded-full focus:ring-2 focus:ring-[#DDA15E] outline-none">
            <?php if(!empty($errores['password'])): ?>
                <p class="text-gray-500 text-xs mt-1"><?php echo $errores['password']; ?></p>
            <?php endif; ?> 
    </div>

    <div>
        <label for="confirmar" class="block text-sm font-medium text-gray-700">Confirmar Contraseña:</label>
        <input type="password" id="confirmar" name="confirmar" placeholder="Contraseña"
            class="w-full mt-1 px-3 py-2 border rounded-full focus:ring-2 focus:ring-[#DDA15E] outline-none">
            <?php if(!empty($errores['confirmar'])): ?>
                <p class="text-gray-500 text-xs mt-1"><?php echo $errores['confirmar']; ?></p>
            <?php endif; ?> 
    </div>

    <div class="flex justify-center">
        <button type="submit" 
                class="bg-[#DDA15E] text-white font-semibold px-6 py-2 rounded-full shadow hover:bg-[#c4843e] transition">
        Crear
        </button>
    </div>

        
        <p class="text-sm text-gray-600 text-center mt-4">
            ¿Ya tienes una cuenta? 
            <a href="/login" class="text-[#DDA15E] font-semibold hover:underline">Haz clic para iniciar sesión</a>
        </p>
        </form>
        
    </div>


    <div class="hidden md:flex w-1/2 bg-[#FEFAE0] flex-col justify-center items-center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mb-2 text-[#DDA15E]" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 3l8 6v12a1 1 0 01-1 1h-5v-6H10v6H5a1 1 0 01-1-1V9l8-6z" />
    </svg>
    <h2 class="text-2xl font-bold text-[#DDA15E]">Home Finder</h2>
</div>

</body>
</html>