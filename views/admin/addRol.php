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
        /* Animaciones sutiles y helpers para JS */
        .animated-input {
            transition: box-shadow 180ms ease, transform 160ms cubic-bezier(.2,.8,.2,1), border-color 160ms ease;
            will-change: transform, box-shadow;
        }
        .animated-input:focus { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(11,21,12,0.06); border-color: #c6924f; outline: none; }

        .btn-primary {
            transition: transform 200ms cubic-bezier(.2,.8,.2,1), box-shadow 200ms ease, background-color 160ms ease;
            will-change: transform, box-shadow;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 14px 34px rgba(11,21,12,0.08); }
        .btn-primary:active { transform: translateY(-1px) scale(.995); }

        .ripple { position: absolute; border-radius: 50%; pointer-events: none; transform: scale(0); opacity: 0.6; background: rgba(255,255,255,0.7); }

        .animated-appear { transform: translateY(8px); opacity: 0; }
        .animated-appear.appear-animate { transform: translateY(0); opacity: 1; transition: transform 320ms cubic-bezier(.2,.8,.2,1), opacity 260ms ease; }

        @media (prefers-reduced-motion: reduce) {
            .animated-input, .btn-primary { transition: none !important; transform: none !important; box-shadow: none !important; }
            .animated-appear { transform: none !important; opacity: 1 !important; }
        }
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
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150 animated-input"
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
                    class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c6924f] transition duration-150 animated-input"
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
                           focus:outline-none focus:ring-4 focus:ring-[#c6924f] focus:ring-opacity-50 btn-primary"
                >
                    <i class="fas fa-plus mr-2"></i> Crear Rol
                </button>
                <a href="/admin/roles" class="block mt-8 text-center text-[#5B674D] hover:underline transition duration-200">← Volver a Gestion de Roles</a>
            </div>

        </form>
    </div>
</body>
</html>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        try {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // Appear stagger for inputs
            const appearEls = Array.from(document.querySelectorAll('.animated-input'));
            if (!reduceMotion) {
                appearEls.forEach((el, i) => {
                    el.classList.add('animated-appear');
                    setTimeout(() => el.classList.add('appear-animate'), 60 * i);
                });
            } else {
                appearEls.forEach(el => el.classList.add('appear-animate'));
            }

            // Ripple effect for buttons
            const buttons = document.querySelectorAll('.btn-primary');
            buttons.forEach(btn => {
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
                    ripple.style.background = 'rgba(255,255,255,0.12)';
                    btn.appendChild(ripple);
                    if (ripple.animate) {
                        ripple.animate([
                            { transform: 'scale(0)', opacity: 0.18 },
                            { transform: 'scale(1)', opacity: 0 }
                        ], { duration: 520, easing: 'cubic-bezier(.2,.8,.2,1)' });
                        setTimeout(() => ripple.remove(), 560);
                    } else {
                        ripple.style.transition = 'transform 520ms ease, opacity 520ms ease';
                        ripple.style.transform = 'scale(1)';
                        ripple.style.opacity = '0';
                        setTimeout(() => ripple.remove(), 560);
                    }
                });
            });
        } catch (err) {
            console.error('Animations init error (addRol):', err);
        }
    });
    </script>