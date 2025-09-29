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
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-xl font-semibold">Gestión de Roles</h1>
    <p class="text-gray-500 text-sm mb-6">Maneja los roles de tu aplicación</p>
    <a href="/admin/roles/crear"
      class="mt-4 inline-block text-center bg-[#5B674D] text-white px-4 py-2 rounded-md hover:bg-[#c6924f] transition flex items-center justify-center gap-2">
    
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
                <tr class="text-sm border-b border-gray-100">
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
                            <button onclick="toggleMenu(<?= htmlspecialchars($r['id']) ?>)"
                                    class="p-2 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4zm0 6a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </button>
                            <div id="menu-<?= htmlspecialchars($r['id']) ?>"
                                class="hidden origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                                <ul class="py-1 text-sm">
                                    <li>
                                      <a href="/admin/roles/asignar-usuarios?id=<?= htmlspecialchars($r['id']) ?>"
                                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Añadir Usuario
                                      </a>
                                    </li>
                                    <li>
                                        <a href="/admin/roles/editar?id=<?= htmlspecialchars($r['id']) ?>"
                                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.827-2.828z"></path></svg>
                                            Editar
                                        </a>
                                    </li>
                                </ul>
                            </div>
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

  <script>
    const rolesStatic = <?php echo json_encode($roles); ?>;
    // permisosDisponiblesStatic ya no es necesario

    function toggleMenu(id) {
      document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add("hidden"));
      const menu = document.getElementById(`menu-${id}`);
      if (menu) menu.classList.toggle("hidden");
    }

    document.addEventListener("click", (e) => {
      if (!e.target.closest('[id^="menu-"]') && !e.target.closest('[onclick^="toggleMenu"]')) {
        document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add("hidden"));
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

  </script>

</body>
</html>