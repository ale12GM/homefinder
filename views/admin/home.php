<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestión de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Importamos la fuente -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
  
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-xl font-semibold">Gestión de Usuarios</h1>
    <p class="text-gray-500 text-sm mb-6">Maneja a tus usuarios y sus permisos de cuenta</p>

    <!-- Nueva sección de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <!-- Cuadro de Usuarios -->
      <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between border-b-4" style="border-color: #DDA15E; height: 120px;">
        <div class="text-5xl font-bold text-gray-800">
          <?php echo count($usuarios); ?>
        </div>
        <div class="text-right">
          <p class="text-base text-gray-500">Total de</p>
          <p class="text-xl font-semibold text-gray-700">Usuarios Registrados</p>
        </div>
      </div>

      <!-- Cuadro de Propiedades -->
      <div class="bg-white rounded-xl shadow p-5 flex items-center justify-between border-b-4" style="border-color: #244434; height: 120px;">
        <div class="text-5xl font-bold text-gray-800">
          <?php echo count($propiedades); ?>
        </div>
        <div class="text-right">
          <p class="text-base text-gray-500">Total de</p>
          <p class="text-xl font-semibold text-gray-700">Propiedades Registradas</p>
        </div>
      </div>
    </div>
    <!-- Fin de la nueva sección de estadísticas -->

    <!-- Sección de Últimos Usuarios Registrados -->
    <h2 class="text-xl font-semibold mb-4">Recientemente Registrados</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <?php if (!empty($ultimosUsuarios)): ?>
        <?php foreach ($ultimosUsuarios as $u): ?>
          <div class="bg-white rounded-xl shadow p-4 flex items-center justify-between">
            <div class="flex items-center">
              <div class="w-10 h-10 bg-gray-200 rounded-full mr-3 flex items-center justify-center overflow-hidden">
                <img src="https://via.placeholder.com/40" alt="Avatar" class="w-full h-full object-cover">
              </div>
              <div>
                <p class="font-medium"><?= htmlspecialchars($u->nombre); ?></p>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($u->email); ?></p>
              </div>
            </div>
            <div class="text-sm text-gray-500">
              <?= ($u->estado == 1) ? 'Activo' : 'Inactivo'; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-gray-500 col-span-2">No hay usuarios registrados recientemente.</p>
      <?php endif; ?>

    </div>
    <!-- Fin de la sección de Últimos Usuarios Registrados -->

    <div class="overflow-x-auto bg-white rounded-xl shadow">
      <table class="w-full text-left border-separate border-spacing-y-2">
        <thead>
          <tr class="text-gray-600 text-sm">
            <th class="px-4 py-2 border-b border-gray-200">Nombre</th>
            <th class="px-4 py-2 border-b border-gray-200">Apellido</th>
            <th class="px-4 py-2 border-b border-gray-200">Email</th>
            <th class="px-4 py-2 border-b border-gray-200">Estado</th>
            <th class="px-4 py-2 border-b border-gray-200">Acciones</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($usuarios)): ?>
            <?php foreach ($usuarios as $u): ?>
              <tr class="text-sm border-b">
                <!-- celdas con id para actualizarlas desde JS -->
                <td id="nombre-<?= htmlspecialchars($u['id']) ?>" class="px-4 py-2"><?php echo htmlspecialchars($u['nombre']); ?></td>
                <td id="apellido-<?= htmlspecialchars($u['id']) ?>" class="px-4 py-2"><?php echo htmlspecialchars($u['apellido']); ?></td>
                <td id="email-<?= htmlspecialchars($u['id']) ?>" class="px-4 py-2"><?php echo htmlspecialchars($u['email']); ?></td>

                <?php if($u['estado'] == 1): ?>
                  <td class="px-4 py-2">Activo</td>
                <?php else: ?>
                  <td class="px-4 py-2">Inactivo</td>
                <?php endif; ?>

                <td class="px-4 py-2 flex items-center gap-2 relative">
                  <!-- Botón directo para restaurar contraseña -->
                  <a href="/usuarios/resetear?id=<?= htmlspecialchars($u['id']) ?>"
                     class="px-2 py-1 text-sm bg-[#E2E4E0] border border-[#283618] rounded hover:bg-gray-200">
                    🔑 Restaurar contraseña
                  </a>

                  <!-- Botón menú -->
                  <button onclick="toggleMenu(<?= htmlspecialchars($u['id']) ?>)"
                          class="p-2 rounded-full hover:bg-gray-200">⋮</button>

                  <!-- Menú desplegable -->
                  <div id="menu-<?= htmlspecialchars($u['id']) ?>"
                       class="hidden absolute right-0 mt-10 w-40 bg-white border rounded-md shadow-lg z-10">
                    <ul class="py-1 text-sm">
                      <li>
                        <!-- EDITAR ahora abre modal -->
                        <button onclick="openEditModal(<?= htmlspecialchars($u['id']) ?>)"
                                class="w-full text-left px-4 py-2 hover:bg-gray-100">✏️ Editar</button>
                      </li>
                      <li>
                        <a href="/usuarios/bloquear?id=<?= htmlspecialchars($u['id']) ?>"
                           class="block px-4 py-2 text-red-600 hover:bg-gray-100">🚫 Bloquear</a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="px-4 py-2 text-center text-gray-500">No hay usuarios registrados.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal editar (oculto por defecto) -->
  <div id="modal-editar" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
    <div class="bg-white rounded-xl w-11/12 max-w-md p-6 mx-auto">
      <h3 class="text-lg font-semibold mb-4">Editar Usuario</h3>

      <form id="form-editar" class="space-y-3">
        <input type="hidden" name="id" id="editar-id">

        <div>
          <label class="block text-sm">Nombre</label>
          <input id="editar-nombre" name="nombre" type="text" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block text-sm">Apellido</label>
          <input id="editar-apellido" name="apellido" type="text" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
          <label class="block text-sm">Email</label>
          <input id="editar-email" name="email" type="email" class="w-full border rounded px-3 py-2" required>
        </div>

        <div id="editar-errores" class="text-red-600 text-sm"></div>

        <div class="flex justify-end gap-2 mt-4">
          <button type="button" onclick="closeModal()" class="px-4 py-2 rounded border">Cancelar</button>
          <button type="submit" class="px-4 py-2 rounded bg-[#E2E4E0]">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Abre/cierra menú desplegable (solo uno abierto a la vez)
    function toggleMenu(id) {
      document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add("hidden"));
      const menu = document.getElementById(`menu-${id}`);
      if (menu) menu.classList.toggle("hidden");
    }

    // Cerrar menús al hacer clic fuera
    document.addEventListener("click", (e) => {
      // si el clic no está dentro de un td que contiene el menú, cerramos todos
      if (!e.target.closest("td")) {
        document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add("hidden"));
      }
    });

    // Abre modal y carga datos del usuario desde backend
    function openEditModal(userId) {
      fetch(`/usuarios/obtener?id=${userId}`)
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            alert(data.error || 'No se pudo obtener el usuario');
            return;
          }
          const u = data.usuario;
          document.getElementById('editar-id').value = u.id || '';
          document.getElementById('editar-nombre').value = u.nombre || '';
          document.getElementById('editar-apellido').value = u.apellido || '';
          document.getElementById('editar-email').value = u.email || '';

          // mostrar modal
          document.getElementById('modal-editar').classList.remove('hidden');
        })
        .catch(err => {
          console.error(err);
          alert('Error al obtener datos del usuario');
        });
    }

    function closeModal() {
      document.getElementById('modal-editar').classList.add('hidden');
      document.getElementById('editar-errores').textContent = '';
    }

    // Envío del formulario por AJAX con validación simple
    document.getElementById('form-editar').addEventListener('submit', function(e) {
      e.preventDefault();

      const id = document.getElementById('editar-id').value;
      const nombre = document.getElementById('editar-nombre').value.trim();
      const apellido = document.getElementById('editar-apellido').value.trim();
      const email = document.getElementById('editar-email').value.trim();

      const errores = [];
      if (!nombre) errores.push('El nombre no puede estar vacío');
      if (!apellido) errores.push('El apellido no puede estar vacío');
      if (!email) errores.push('El email no puede estar vacío');
      // comprobación básica del email
      if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) errores.push('El email no es válido');

      const erroresDiv = document.getElementById('editar-errores');
      if (errores.length) {
        erroresDiv.innerHTML = errores.map(x => `<div>• ${x}</div>`).join('');
        return;
      } else {
        erroresDiv.textContent = '';
      }

      const formData = new FormData();
      formData.append('id', id);
      formData.append('nombre', nombre);
      formData.append('apellido', apellido);
      formData.append('email', email);

      fetch('/usuarios/actualizar', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(json => {
        if (json.success) {
          // actualizar la fila en la tabla sin recargar
          const nombreTd = document.getElementById(`nombre-${id}`);
          const apellidoTd = document.getElementById(`apellido-${id}`);
          const emailTd = document.getElementById(`email-${id}`);
          if (nombreTd) nombreTd.textContent = nombre;
          if (apellidoTd) apellidoTd.textContent = apellido;
          if (emailTd) emailTd.textContent = email;

          closeModal();
          // pequeño aviso
          alert('Usuario actualizado correctamente');
        } else {
          // mostrar errores del servidor
          if (json.errors) {
            erroresDiv.innerHTML = json.errors.map(x => `<div>• ${x}</div>`).join('');
          } else if (json.error) {
            erroresDiv.textContent = json.error;
          } else {
            erroresDiv.textContent = 'Error desconocido';
          }
        }
      })
      .catch(err => {
        console.error(err);
        erroresDiv.textContent = 'Error al conectarse con el servidor';
      });
    });
  </script>

</body>
</html>