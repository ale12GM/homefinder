<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Rol</title>
    <script src="https://cdn.tailwindcss.com"></script> 
    <style>
        /* Definir los colores personalizados para Tailwind si no están en tu config */
        /* Si usas un archivo de configuración de Tailwind, este bloque no es necesario */
        .bg-color-primario { background-color: #5B674D; }
        .bg-color-secundario { background-color: #c6924f; }
        .text-color-secundario { color: #c6924f; }
    </style>
</head>
<body class="bg-gray-50 p-8">

    <div class="max-w-md mx-auto p-6 bg-white rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-color-primario mb-6 border-b pb-2">
            Crear Nuevo Rol
        </h2>
        
        <form method="POST" action="/admin/roles/crear" class="space-y-4">

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre del Rol: 
                </label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="roles[nombre]" 
                    value="<?= $rol->nombre ?? '' ?>"
                    placeholder="Ej: Administrador, Editor"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150"
                >
                <?php if(!empty($alertas['nombre'])): ?>
                    <p class="text-gray-500 text-xs mt-1"><?php echo $alertas['nombre']; ?></p>
                <?php endif; ?> 
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción: 
                </label>
                <input 
                    type="text" 
                    id="descripcion" 
                    name="roles[descripcion]"
                    value="<?= $rol->descripcion ?? '' ?>"
                    placeholder="Detalle las responsabilidades del rol"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150"
                >
                <?php if(!empty($alertas['descripcion'])): ?>
                    <p class="text-gray-500 text-xs mt-1"><?php echo $alertas['descripcion']; ?></p>
                <?php endif; ?>
            </div>

            <div class="pt-4">
                <button 
                    type="submit"
                    class="w-full py-2 px-4 rounded-lg text-white bg-color-primario 
                           hover:bg-[#4a5440] transition duration-200 font-semibold shadow-md
                           focus:outline-none focus:ring-4 focus:ring-[#c6924f] focus:ring-opacity-50"
                >
                    <i class="fas fa-plus mr-2"></i> Crear Rol
                </button>
                <a href="/admin/roles" class="block mt-8 text-center text-[#5B674D] hover:underline transition duration-200">← Volver a Gestion de Roles</a>
            </div>

        </form>
    </div>
</body>
</html>