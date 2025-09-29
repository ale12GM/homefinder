<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rol</title>
    <script src="https://cdn.tailwindcss.com"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJd7iP59vGgC0/QxQW5l4QO1W9zL6lA5m5v9g4/gD+8t6C/6r0x3z3q8L4+v0yA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Definir los colores personalizados para Tailwind si no están en tu config */
        .bg-color-primario { background-color: #5B674D; }
        .bg-color-secundario { background-color: #c6924f; }
        .text-color-secundario { color: #c6924f; }
        
        /* Estilos para los checkboxes de permisos */
        .permiso-checkbox:checked {
            background-color: #5B674D;
            border-color: #5B674D;
        }
        
        .permiso-item:hover {
            background-color: #f3f4f6;
        }
        
        .permiso-item.selected {
            background-color: #e5f3e5;
            border-left: 3px solid #5B674D;
        }
    </style>
</head>
<body class="bg-gray-50 p-8">

    <div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-color-primario mb-6 border-b pb-2">
            <i class="fas fa-edit mr-2"></i>Editar Rol: <?= htmlspecialchars($rol->nombre) ?>
        </h2>
        
        <form method="POST" action="/admin/roles/editar?id=<?= $rol->id ?>" class="space-y-6">

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre del Rol: 
                </label>
                <input 
                    type="text" 
                    id="nombre" 
                    name="roles[nombre]" 
                    value="<?= htmlspecialchars($rol->nombre) ?>"
                    placeholder="Ej: Administrador, Editor"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150"
                >
                <?php if(!empty($alertas['nombre'])): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo $alertas['nombre']; ?></p>
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
                    value="<?= htmlspecialchars($rol->descripcion) ?>"
                    placeholder="Detalle las responsabilidades del rol"
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150"
                >
                <?php if(!empty($alertas['descripcion'])): ?>
                    <p class="text-red-500 text-xs mt-1"><?php echo $alertas['descripcion']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    <i class="fas fa-key mr-1"></i>Permisos del Rol:
                </label>
                <div class="grid grid-cols-1 gap-3 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <?php if(!empty($permisos)): ?>
                        <?php foreach($permisos as $permiso): ?>
                            <div class="permiso-item flex items-center space-x-3 p-2 rounded-md transition-colors">
                                <input 
                                    type="checkbox" 
                                    id="permiso_<?= $permiso['id'] ?>" 
                                    name="permisos[]" 
                                    value="<?= $permiso['id'] ?>"
                                    <?= $permiso['asignado'] ? 'checked' : '' ?>
                                    class="permiso-checkbox w-4 h-4 text-[#5B674D] bg-gray-100 border-gray-300 rounded focus:ring-[#5B674D] focus:ring-2"
                                >
                                <label for="permiso_<?= $permiso['id'] ?>" class="flex-1 text-sm text-gray-700 cursor-pointer">
                                    <span class="font-medium"><?= htmlspecialchars($permiso['nombre']) ?></span>
                                    <?php if(!empty($permiso['descripcion'])): ?>
                                        <span class="text-gray-500 block text-xs"><?= htmlspecialchars($permiso['descripcion']) ?></span>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-sm text-center py-4">No hay permisos disponibles</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pt-4 flex space-x-4">
                <button 
                    type="submit"
                    class="flex-1 py-2 px-4 rounded-lg text-white bg-color-primario 
                           hover:bg-[#4a5440] transition duration-200 font-semibold shadow-md
                           focus:outline-none focus:ring-4 focus:ring-[#c6924f] focus:ring-opacity-50"
                >
                    <i class="fas fa-save mr-2"></i>Guardar Cambios
                </button>
                <a href="/admin/roles" class="flex-1 py-2 px-4 text-center text-[#5B674D] border border-[#5B674D] rounded-lg hover:bg-[#5B674D] hover:text-white transition duration-200">
                    <i class="fas fa-times mr-2"></i>Cancelar
                </a>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar funcionalidad a los checkboxes de permisos
            const checkboxes = document.querySelectorAll('.permiso-checkbox');
            const permisoItems = document.querySelectorAll('.permiso-item');
            
            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    const item = permisoItems[index];
                    if (this.checked) {
                        item.classList.add('selected');
                    } else {
                        item.classList.remove('selected');
                    }
                });
                
                // Aplicar estado inicial
                if (checkbox.checked) {
                    permisoItems[index].classList.add('selected');
                }
            });
            
            // Agregar funcionalidad de clic en toda la fila
            permisoItems.forEach((item, index) => {
                item.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = checkboxes[index];
                        checkbox.checked = !checkbox.checked;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
            });
            
            // Contador de permisos seleccionados
            function updateCounter() {
                const selectedCount = document.querySelectorAll('.permiso-checkbox:checked').length;
                const totalCount = checkboxes.length;
                
                // Crear o actualizar el contador
                let counter = document.getElementById('permisos-counter');
                if (!counter) {
                    counter = document.createElement('div');
                    counter.id = 'permisos-counter';
                    counter.className = 'text-sm text-gray-600 mt-2';
                    document.querySelector('.grid').parentNode.appendChild(counter);
                }
                
                counter.textContent = `Permisos seleccionados: ${selectedCount} de ${totalCount}`;
            }
            
            // Actualizar contador cuando cambien los checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCounter);
            });
            
            // Inicializar contador
            updateCounter();
        });
    </script>
</body>
</html>
