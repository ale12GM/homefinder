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
        .bg-olive-clara { background-color: #AAB59D; }
        .hover\:bg-olive-oscura:hover { background-color: #5B674D; }
        .text-color-primario { color: #5B674D; }
        .border-color-primario { border-color: #5B674D; }

        /* Animaciones y efectos */
        .slide-up {
            opacity: 0;
            transform: translateY(20px);
        }
        .slide-up.show {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Estilo moderno para selección */
        .user-select {
            position: relative;
            cursor: pointer;
            padding: 0.75rem;
            border-radius: 1rem;
            transition: all 0.2s ease;
        }
        .user-select:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }
        .user-select.selected {
            background-color: #edf2ee;
            border-left: 4px solid #5B674D;
        }

        /* Ripple effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            background-color: rgba(255, 255, 255, 0.7);
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Scroll personalizado */
        .custom-scroll::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #AAB59D;
            border-radius: 4px;
        }
        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: #5B674D;
        }

        @media (prefers-reduced-motion: reduce) {
            .slide-up, .user-select, .ripple {
                transition: none !important;
                animation: none !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="mx-auto w-full max-w-md bg-white p-8 rounded-2xl shadow-xl slide-up">
        
        <h2 class="text-2xl font-semibold text-center text-color-primario mb-8">Asignar Cuentas</h2>
        
        <div class="mb-6">
            <div class="relative">
                <input type="text" id="buscador-email" placeholder="Buscar por email" 
                        class="w-full py-3 px-4 pl-12 border-2 border-gray-300 rounded-full 
                               focus:outline-none focus:border-[#AAB59D] transition-all duration-300
                               focus:ring-2 focus:ring-[#AAB59D] focus:ring-opacity-50"
                        style="background-color: #f7f7f7;">
                <i class="fa fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div id="lista-usuarios-container" class="space-y-2 max-h-[60vh] overflow-y-auto pr-2 custom-scroll">
    
            <?php foreach ($usuarios as $usuario): ?>
            <div class="usuario-item user-select flex items-center justify-between slide-up" 
                 data-email="<?= htmlspecialchars(strtolower($usuario['email'])) ?>"
                 <?= $usuario['asignado'] ? 'data-selected="true"' : '' ?>>
        
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($usuario['email']) ?></span>
                </div>
        
                <button data-user-id="<?= $usuario['id'] ?>" 
                    class="asignar-btn text-sm py-2 px-4 rounded-full transition-all duration-200 flex items-center gap-2
                        <?= $usuario['asignado'] ? 'bg-[#5B674D] hover:bg-red-600' : 'bg-[#AAB59D] hover:bg-[#5B674D]' ?>
                        text-white">
                    <i class="fa-solid <?= $usuario['asignado'] ? 'fa-user-minus' : 'fa-user-plus' ?>"></i> 
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
            
            // Inicializar las animaciones
            function initializeAnimations() {
                const items = document.querySelectorAll('.slide-up');
                items.forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add('show');
                    }, index * 100);
                });
            }

            // Añadir efecto ripple a los botones
            function createRipple(event) {
                const button = event.currentTarget;
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                
                const size = Math.max(rect.width, rect.height);
                const x = event.clientX - rect.left - size / 2;
                const y = event.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                ripple.classList.add('ripple');
                
                button.appendChild(ripple);
                ripple.addEventListener('animationend', () => {
                    ripple.remove();
                });
            }

            // Añadir efecto ripple a todos los botones
            document.querySelectorAll('.asignar-btn').forEach(button => {
                button.addEventListener('click', createRipple);
            });

            // Inicializar las animaciones al cargar
            initializeAnimations();
            
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