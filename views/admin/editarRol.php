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
        /* Animaciones sutiles para inputs y botones */
        .animated-input {
            transition: box-shadow 180ms ease, transform 160ms cubic-bezier(.2,.8,.2,1), border-color 160ms ease;
            will-change: transform, box-shadow;
        }
        .animated-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(11,21,12,0.06);
            border-color: #c6924f;
            outline: none;
        }

        .btn-primary {
            transition: transform 200ms cubic-bezier(.2,.8,.2,1), box-shadow 200ms ease, background-color 160ms ease;
            will-change: transform, box-shadow;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 34px rgba(11,21,12,0.08);
        }
        .btn-primary:active { transform: translateY(-1px) scale(.995); }

        .btn-secondary {
            transition: transform 180ms cubic-bezier(.2,.8,.2,1), background-color 140ms ease, color 140ms ease, box-shadow 160ms ease;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(11,21,12,0.04);
        }

        @media (prefers-reduced-motion: reduce) {
            .animated-input, .btn-primary, .btn-secondary {
                transition: none !important;
                transform: none !important;
                box-shadow: none !important;
            }
        }
        /* JS-driven helpers */
        .animated-appear { transform: translateY(8px); opacity: 0; }
        .animated-appear.appear-animate { transform: translateY(0); opacity: 1; transition: transform 320ms cubic-bezier(.2,.8,.2,1), opacity 260ms ease; }

        .ripple {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            transform: scale(0);
            opacity: 0.6;
            background: rgba(255,255,255,0.7);
        }

        .pulse {
            animation: pulseAnim 420ms ease;
        }
        @keyframes pulseAnim {
            0% { transform: scale(1); }
            50% { transform: scale(1.06); }
            100% { transform: scale(1); }
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
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150 animated-input"
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
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150 animated-input"
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
                           focus:outline-none focus:ring-4 focus:ring-[#c6924f] focus:ring-opacity-50 btn-primary"
                >
                    <i class="fas fa-save mr-2"></i>Guardar Cambios
                </button>
                <a href="/admin/roles" class="flex-1 py-2 px-4 text-center text-[#5B674D] border border-[#5B674D] rounded-lg hover:bg-[#5B674D] hover:text-white transition duration-200 btn-secondary">
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
                // pulso suave cuando cambia el contador (respetar prefers-reduced-motion)
                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (!reduceMotion) {
                    try {
                        // usar Web Animations si está disponible
                        if (counter.animate) {
                            counter.animate([
                                { transform: 'scale(1)' },
                                { transform: 'scale(1.06)' },
                                { transform: 'scale(1)' }
                            ], { duration: 420, easing: 'ease' });
                        } else {
                            counter.classList.add('pulse');
                            setTimeout(() => counter.classList.remove('pulse'), 420);
                        }
                    } catch (err) {
                        // no hacer nada si falla la animación
                        console.error('Counter animation error', err);
                    }
                }
            }
            
            // Actualizar contador cuando cambien los checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateCounter);
            });
            
            // Inicializar contador
            updateCounter();
            
            // -------- JS-driven animations: ripple en botones y appear stagger --------
            (function addJsAnimations(){
                try {
                    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                    // Ripple effect for buttons
                    const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');
                    buttons.forEach(btn => {
                        // ensure positioning for absolute ripple
                        btn.style.position = btn.style.position || 'relative';
                        btn.style.overflow = 'hidden';

                        btn.addEventListener('click', function(e){
                            if (reduceMotion) return;
                            const rect = btn.getBoundingClientRect();
                            const size = Math.max(rect.width, rect.height) * 1.2;
                            const ripple = document.createElement('span');
                            ripple.className = 'ripple';
                            ripple.style.width = ripple.style.height = size + 'px';
                            ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
                            ripple.style.top = (e.clientY - rect.top - size/2) + 'px';
                            ripple.style.background = getComputedStyle(btn).backgroundColor || 'rgba(255,255,255,0.7)';
                            ripple.style.opacity = 0.18;
                            btn.appendChild(ripple);

                            if (ripple.animate) {
                                ripple.animate([
                                    { transform: 'scale(0)', opacity: 0.18 },
                                    { transform: 'scale(1)', opacity: 0 }
                                ], { duration: 520, easing: 'cubic-bezier(.2,.8,.2,1)' });
                                setTimeout(() => ripple.remove(), 560);
                            } else {
                                // fallback: simple fade
                                ripple.style.transition = 'transform 520ms ease, opacity 520ms ease';
                                ripple.style.transform = 'scale(1)';
                                ripple.style.opacity = '0';
                                setTimeout(() => ripple.remove(), 560);
                            }
                        });
                    });

                    // Appear stagger for inputs and permiso items
                    if (!reduceMotion) {
                        const appearEls = [];
                        document.querySelectorAll('.animated-input').forEach(el => appearEls.push(el));
                        document.querySelectorAll('.permiso-item').forEach(el => appearEls.push(el));
                        appearEls.forEach((el, i) => {
                            el.classList.add('animated-appear');
                            setTimeout(() => el.classList.add('appear-animate'), 60 * i);
                        });
                    } else {
                        // show immediately
                        document.querySelectorAll('.animated-input, .permiso-item').forEach(el => el.classList.add('appear-animate'));
                    }
                } catch (err) {
                    console.error('JS animations init error', err);
                }
            })();
        });
    </script>
</body>
</html>
