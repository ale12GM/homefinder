<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Cuentas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJd7iP59vGgC0/QxQW5l4QO1W9zL6lA5m5v9g4/gD+8t6C/6r0x3z3q8L4+v0yA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body {
            font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        /* Definimos el color claro para los botones 'Añadir' */
        .bg-olive-clara { background-color: #AAB59D; }
        .hover\:bg-olive-oscura:hover { background-color: #5B674D; }
        .text-color-primario { color: #5B674D; }
        .border-color-primario { border-color: #5B674D; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-sm bg-white p-6 rounded-2xl shadow-xl">
        
        <h2 class="text-xl font-semibold text-center text-color-primario mb-6">Cuentas</h2>
        
        <div class="mb-6">
            <div class="relative">
                <input type="text" id="buscador-email" placeholder="Buscar por email" 
                        class="w-full py-2 px-4 pl-10 border-2 border-gray-300 rounded-full 
                            focus:outline-none focus:border-[#AAB59D] transition-colors"
                        style="background-color: #f7f7f7;">
                <i class="fa fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div id="lista-usuarios-container" class="space-y-4 max-h-80 overflow-y-auto pr-2">
    
            <?php foreach ($usuarios as $usuario): ?>
            <div class="usuario-item flex items-center justify-between" data-email="<?= htmlspecialchars(strtolower($usuario['email'])) ?>">
        
                <div class="flex items-center space-x-3">
                <input type="checkbox" name="usuario_id[]" value="<?= $usuario['id'] ?>"
                    <?= $usuario['asignado'] ? 'checked' : '' ?>
                    class="w-5 h-5 border-gray-400 focus:ring-0" style="color: #AAB59D;">
            
                    <span class="text-sm text-gray-700"><?= htmlspecialchars($usuario['email']) ?></span>
            </div>
        
            <button data-user-id="<?= $usuario['id'] ?>" 
                class="asignar-btn text-xs py-1.5 px-3 rounded-full transition-colors duration-200 flex items-center gap-1
                        <?= $usuario['asignado'] ? 'bg-[#5B674D] hover:bg-red-600' : 'bg-[#AAB59D] hover:bg-[#5B674D]' ?>
                        text-white">
            <i class="fa-solid <?= $usuario['asignado'] ? 'fa-user-minus' : 'fa-user-plus' ?> text-sm"></i> 
            <?= $usuario['asignado'] ? 'Quitar' : 'Añadir' ?>
        </button>
    </div>
    <?php endforeach; ?>
    
    </div>
    
        <script>
        // 1. FUNCIÓN PRINCIPAL DE GESTIÓN DE EVENTOS (Tu código proporcionado)
        document.addEventListener('DOMContentLoaded', () => {
            const listContainer = document.getElementById('lista-usuarios-container'); 
            const buscador = document.getElementById('buscador-email');
            
            // Función de búsqueda
            buscador.addEventListener('input', (e) => {
                const termino = e.target.value.toLowerCase().trim();
                const usuarios = document.querySelectorAll('.usuario-item');
                
                usuarios.forEach(usuario => {
                    const email = usuario.getAttribute('data-email');
                    if (email.includes(termino)) {
                        usuario.style.display = 'flex';
                    } else {
                        usuario.style.display = 'none';
                    }
                });
            });
            
            listContainer.addEventListener('click', async (e) => {
                if (e.target.closest('.asignar-btn')) {
                    const btn = e.target.closest('.asignar-btn');
                    const userId = btn.dataset.userId;
                    // El ID del rol se inyecta desde PHP
                    const roleId = <?= json_encode($id_rol); ?>; 
                    
                    const isCurrentlyAddButton = btn.textContent.trim() === 'Añadir';
                    const accion = isCurrentlyAddButton ? 'añadir' : 'quitar';

                    // Lógica para deshabilitar el botón mientras carga (MEJORA DE UX)
                    btn.disabled = true;
                    btn.textContent = '...';

                    const formData = new URLSearchParams();
                    formData.append('id_usuario', userId);
                    formData.append('id_rol', roleId);
                    formData.append('accion', accion);

                    try {
                        console.log('Enviando petición a:', '/admin/roles/asignar');
                        console.log('Datos:', formData.toString());
                        
                        const response = await fetch('/admin/roles/asignar', { 
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: formData
                        });
                        
                        console.log('Respuesta recibida:', response.status, response.statusText);
                        
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        
                        let data;
                        try {
                            data = await response.json();
                            console.log('Datos de respuesta:', data);
                        } catch (jsonError) {
                            console.error('Error al parsear JSON:', jsonError);
                            const textResponse = await response.text();
                            console.log('Respuesta como texto:', textResponse);
                            throw new Error('Respuesta del servidor no es JSON válido');
                        }

                        if (data.success) {
                            // Invertimos la acción para la UI: si hicimos 'añadir', la nueva acción es 'quitar'
                            const newActionIsAdd = (accion === 'quitar'); 
                            updateButtonUI(btn, newActionIsAdd); 
                            
                        } else {
                            alert(data.mensaje || 'Error al procesar la solicitud.');
                            // Si falla, volvemos al estado original
                            btn.disabled = false;
                            btn.textContent = isCurrentlyAddButton ? 'Añadir' : 'Quitar';
                        }

                    } catch (error) {
                        console.error("Error de conexión:", error);
                        alert(`Error de conexión con el servidor: ${error.message}`);
                        // Si falla, volvemos al estado original
                        btn.disabled = false;
                        btn.textContent = isCurrentlyAddButton ? 'Añadir' : 'Quitar';
                    }
                }
            });
        });

        // 2. FUNCIÓN AUXILIAR DE LA INTERFAZ DE USUARIO (La parte que cambia el look)
        function updateButtonUI(btn, newActionIsAdd) {
            
            if (newActionIsAdd) { // Usuario degradado (mostramos "Añadir")
                btn.textContent = 'Añadir';
                btn.classList.remove('bg-[#5B674D]', 'hover:bg-red-600');
                btn.classList.add('bg-[#AAB59D]', 'hover:bg-[#5B674D]');
                btn.querySelector('i').classList.remove('fa-user-minus');
                btn.querySelector('i').classList.add('fa-user-plus');
            } else { // Usuario asignado al rol actual (mostramos "Quitar")
                btn.textContent = 'Quitar';
                btn.classList.remove('bg-[#AAB59D]', 'hover:bg-[#5B674D]');
                btn.classList.add('bg-[#5B674D]', 'hover:bg-red-600');
                btn.querySelector('i').classList.remove('fa-user-plus');
                btn.querySelector('i').classList.add('fa-user-minus');
            }
            btn.disabled = false; // Habilitamos de nuevo el botón
        }
    </script>
        <div class="mt-8 text-center">
            <button onclick="window.location.href='/admin/roles'" class="py-2 px-6 border-2 border-gray-300 text-gray-700 rounded-full 
                            hover:bg-gray-100 transition-colors duration-200">
                Cancelar
            </button>
        </div>

    </div>

</body>
</html>