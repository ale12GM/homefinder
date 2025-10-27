<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestión de Roles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Importamos la fuente Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    /* Estilos para el estado activo */
    .estado-activo {
        background-color: #d1fae5; /* green-100 */
        color: #065f46; /* green-800 */
    }
    /* Animaciones no invasivas */
    .btn-add {
      transition: transform 200ms cubic-bezier(.2,.8,.2,1), box-shadow 200ms ease, background-color 160ms ease;
      will-change: transform;
    }
    .btn-add:hover {
      transform: translateY(-3px) scale(1.01);
      box-shadow: 0 10px 30px rgba(11,21,12,0.10);
    }
    .btn-add:active {
      transform: translateY(-1px) scale(.995);
    }

    .role-row {
      transition: transform 260ms cubic-bezier(.2,.8,.2,1), box-shadow 220ms ease, background-color 180ms ease, opacity 260ms ease;
      transform: translateY(8px);
      opacity: 0;
    }
    .role-row.animate {
      transform: translateY(0);
      opacity: 1;
    }
    .role-row:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 30px rgba(15,23,42,0.06);
      background-color: #ffffff;
    }

    @media (prefers-reduced-motion: reduce) {
      .btn-add, .role-row {
        transition: none !important;
        animation: none !important;
      }
      .role-row { transform: none !important; opacity: 1 !important; }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-xl font-semibold">Gestión de Roles</h1>
    <p class="text-gray-500 text-sm mb-6">Maneja los roles de tu aplicación</p>
    <a href="/admin/roles/crear"
      class="mt-4 inline-block text-center bg-[#5B674D] text-white px-4 py-2 rounded-md hover:bg-[#c6924f] transition flex items-center justify-center gap-2 btn-add">
    
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
      </svg>
      Añadir
    </a>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
      <table class="min-w-full text-left border-separate border-spacing-y-2">
        <thead>
          <tr class="text-gray-600 text-sm">
            <th class="px-4 py-2 border-b border-gray-200">Nombre Rol</th>
            <th class="px-4 py-2 border-b border-gray-200">Descripción</th>
            <th class="px-4 py-2 border-b border-gray-200">Cuentas</th>
            <th class="px-4 py-2 border-b border-gray-200">Acciones</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($roles)): ?>
            <?php foreach ($roles as $r): ?>
                <tr class="text-sm border-b border-gray-100 role-row">
                    <td id="nombre-rol-<?= htmlspecialchars($r['id']) ?>" class="px-4 py-2">
                        <?= htmlspecialchars($r['nombre_rol'] ?? $r['nombre']); ?>
                    </td>
                    <td id="descripcion-rol-<?= htmlspecialchars($r['id']) ?>" class="px-4 py-2 text-gray-600">
                        <?= htmlspecialchars($r['descripcion']); ?>
                    </td>
                    <td class="px-4 py-2 text-center font-medium text-gray-700">
                        <?= htmlspecialchars($r['total_usuarios'] ?? 0); ?>
                    </td>
                    
          <td class="px-4 py-2 relative">
            <div class="relative inline-block text-left">
              <button onclick="openActionModal(<?= htmlspecialchars($r['id']) ?>)"
                  class="p-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z"></path></svg>
              </button>
            </div>
          </td>
                </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="px-4 py-2 text-center text-gray-500">No hay roles registrados.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal editar (oculto por defecto) -->
  <div id="modal-editar" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
    <div class="bg-white rounded-xl w-11/12 max-w-md p-6 mx-auto">
      <h3 class="text-lg font-semibold mb-4">Editar Rol</h3>

      <form id="form-editar" class="space-y-4">
        <input type="hidden" name="id" id="editar-id">

        <div>
          <label for="editar-nombre-rol" class="block text-sm font-medium text-gray-700">Nombre Rol</label>
          <input id="editar-nombre-rol" name="nombre_rol" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div>
          <label for="editar-descripcion-rol" class="block text-sm font-medium text-gray-700">Descripción</label>
          <textarea id="editar-descripcion-rol" name="descripcion" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
        </div>

        <div id="editar-errores" class="text-red-600 text-sm"></div>

        <div class="flex justify-end gap-2 mt-4">
          <button type="button" onclick="closeModal()" class="inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancelar</button>
          <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal de acciones (abre al pulsar los 3 puntos) -->
  <div id="action-modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
    <div class="bg-white rounded-xl w-11/12 max-w-sm p-6 mx-auto shadow-lg">
      <div class="flex items-start justify-between">
        <h3 id="action-modal-title" class="text-lg font-semibold">Acciones</h3>
        <button id="action-modal-close" class="text-gray-500 hover:text-gray-700">✖</button>
      </div>
      <p id="action-modal-sub" class="text-sm text-gray-500 mt-1">Elige una acción para este rol</p>

      <div class="mt-4 grid grid-cols-1 gap-3">
        <a id="action-assign" href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
          <!-- emoji usuarios -->
          <div class="text-2xl">👥</div>
          <div>
            <div class="text-sm font-medium text-gray-900">Añadir Usuario</div>
            <div class="text-xs text-gray-500">Asignar cuentas a este rol</div>
          </div>
        </a>

        <button id="action-edit" type="button" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-200">
          <!-- emoji editar -->
          <div class="text-2xl">✏️</div>
          <div>
            <div class="text-sm font-medium text-gray-900">Editar</div>
            <div class="text-xs text-gray-500">Modificar nombre o permisos</div>
          </div>
        </button>
      </div>
    </div>
  </div>

  <script>
    const rolesStatic = <?php echo json_encode($roles); ?>;
    // permisosDisponiblesStatic ya no es necesario

    // Abre el modal de acciones para un rol (sustituye el antiguo menú desplegable)
    function openActionModal(roleId) {
      const role = rolesStatic.find(r => r.id == roleId);
      const modal = document.getElementById('action-modal');
      const title = document.getElementById('action-modal-title');
      const sub = document.getElementById('action-modal-sub');
      const assignLink = document.getElementById('action-assign');
      const editBtn = document.getElementById('action-edit');

      if (!role) {
        title.textContent = 'Acciones';
        sub.textContent = 'Rol no disponible';
      } else {
        title.textContent = role.nombre_rol || role.nombre || 'Acciones';
        sub.textContent = role.descripcion || '';
        // actualizar links/handlers
        assignLink.href = '/admin/roles/asignar-usuarios?id=' + encodeURIComponent(role.id);
        // editar: navegar a la página de edición (editarRol.php / ruta existente)
        editBtn.onclick = function(){
          // navegar a la ruta de edición del rol
          window.location.href = '/admin/roles/editar?id=' + encodeURIComponent(role.id);
        };
      }

      modal.classList.remove('hidden');
      // foco accesible
      document.getElementById('action-modal-close').focus();
    }

    function closeActionModal(){
      const modal = document.getElementById('action-modal');
      if (modal) modal.classList.add('hidden');
    }

    // Cerrar modal acciones al hacer click en close o fuera del contenido
    document.getElementById('action-modal-close').addEventListener('click', closeActionModal);
    document.getElementById('action-modal').addEventListener('click', function(e){
      if (e.target === this) closeActionModal();
    });

    // Cerrar con ESC (añadimos al handler existente para editar modal)
    document.addEventListener('keydown', function(e){
      if (e.key === 'Escape') {
        // cerrar modal de acciones si está abierto
        const am = document.getElementById('action-modal');
        if (am && !am.classList.contains('hidden')) closeActionModal();
      }
    });

    function openEditModal(roleId) {
      const role = rolesStatic.find(r => r.id === roleId);

      if (!role) {
        alert('No se pudo obtener el rol.');
        return;
      }
      
      document.getElementById('editar-id').value = role.id || '';
      document.getElementById('editar-nombre-rol').value = role.nombre_rol || role.nombre || '';
      document.getElementById('editar-descripcion-rol').value = role.descripcion || '';

      // El contenedor de permisos ya no es necesario ni su lógica de renderizado
      // const permisosContainer = document.getElementById('permisos-checkboxes');
      // permisosContainer.innerHTML = '';


      document.getElementById('modal-editar').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('modal-editar').classList.add('hidden');
      document.getElementById('editar-errores').textContent = '';
    }

        document.getElementById('form-editar').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch('/roles/actualizar', {
        method: 'POST',
        body: formData
        });

        const data = await response.json();

        if (data.success) {
        // Actualizar DOM
        const id = formData.get('id');
        document.getElementById(`nombre-rol-${id}`).textContent = formData.get('nombre_rol');
        document.getElementById(`descripcion-rol-${id}`).textContent = formData.get('descripcion');

        closeModal();
        alert(data.mensaje);
        } else {
        document.getElementById('editar-errores').innerHTML = data.error || 'Error al actualizar rol';
        }
    } catch (err) {
        console.error(err);
        document.getElementById('editar-errores').innerHTML = 'Error de conexión con el servidor';
    }
    });

    // Animar filas al cargar (stagger ligero). Respetamos prefers-reduced-motion.
    (function animateRowsOnLoad(){
      try {
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const rows = Array.from(document.querySelectorAll('tbody tr.role-row'));
        if (!rows.length) return;
        if (reduceMotion) {
          rows.forEach(r => r.classList.add('animate'));
          return;
        }
        rows.forEach((r, i) => {
          // ligero stagger
          setTimeout(() => r.classList.add('animate'), i * 40);
        });
      } catch (err) {
        // no interrumpir la ejecución por errores de animación
        console.error('Row animation error', err);
      }
    })();

  </script>

</body>
</html>