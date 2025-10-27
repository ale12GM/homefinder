<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gestión de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body { 
      font-family: 'Poppins', system-ui;
      background-color: #FEFAE0;
    }

    /* Variables de diseño */
    :root {
      --accent: #535E46;
      --accent-light: #DDA15E;
    }

    /* Animaciones base */
    .transition-all {
      transition: all 200ms ease;
    }

    /* Animación para filas de tabla */
    tbody tr {
      transition: transform 180ms ease, background-color 180ms ease, box-shadow 180ms ease;
    }
    
    tbody tr:hover {
      transform: translateY(-2px);
      background-color: #fbfbf9;
      box-shadow: 0 4px 12px rgba(83,94,70,0.06);
    }

    /* Animaciones para modales */
    #modal-opciones, #modal-editar {
      transition: opacity 200ms ease;
    }

    .modal-content {
      transform: translateY(8px) scale(0.98);
      opacity: 0;
      transition: transform 300ms cubic-bezier(.2,.8,.2,1), opacity 240ms ease;
    }

    #modal-opciones:not(.hidden) .modal-content,
    #modal-editar:not(.hidden) .modal-content {
      transform: translateY(0) scale(1);
      opacity: 1;
    }

    /* Animaciones para botones */
    button, .btn {
      transition: transform 150ms ease, background-color 200ms ease, box-shadow 200ms ease;
    }

    button:not(:disabled):hover,
    .btn:not(:disabled):hover {
      transform: translateY(-1px);
    }

    button:not(:disabled):active,
    .btn:not(:disabled):active {
      transform: translateY(0) scale(0.98);
    }

    /* Animación para mensajes de feedback */
    .feedback-message {
      animation: slideIn 300ms ease-out;
    }

    @keyframes slideIn {
      from {
        transform: translateY(-10px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    /* Preferencia de reducción de movimiento */
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
      }
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-xl font-semibold">Gestión de Usuarios</h1>
    <p class="text-gray-500 text-sm mb-6">Maneja a tus usuarios y sus permisos de cuenta</p>

    <!-- Mensajes de feedback -->
    <?php if (isset($_GET['mensaje'])): ?>
      <?php 
      $mensajes = [
        'usuario_activado' => ['text' => 'Usuario activado correctamente', 'class' => 'bg-green-100 text-green-800'],
        'usuario_bloqueado' => ['text' => 'Usuario bloqueado correctamente', 'class' => 'bg-red-100 text-red-800'],
        'actualizado' => ['text' => 'Usuario actualizado correctamente', 'class' => 'bg-green-100 text-green-800']
      ];
      $mensaje = $mensajes[$_GET['mensaje']] ?? ['text' => 'Operación realizada', 'class' => 'bg-blue-100 text-blue-800'];
      ?>
      <div class="mb-4 p-3 rounded-lg feedback-message <?= $mensaje['class'] ?>">
        <?= $mensaje['text'] ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
      <?php 
      $errores = [
        'id_requerido' => 'ID de usuario requerido',
        'usuario_no_encontrado' => 'Usuario no encontrado',
        'error_actualizacion' => 'Error al actualizar el usuario',
        'metodo_no_permitido' => 'Método no permitido'
      ];
      $error = $errores[$_GET['error']] ?? 'Error desconocido';
      ?>
      <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800">
        Error: <?= $error ?>
      </div>
    <?php endif; ?>

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
                <td class="px-4 py-2"><?= htmlspecialchars($u['nombre']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($u['apellido']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($u['email']) ?></td>
                <td class="px-4 py-2"><?= $u['estado'] == 1 ? 'Activo' : 'Inactivo' ?></td>
                <td class="px-4 py-2 flex items-center gap-2">

  <!-- Botón de 3 puntitos -->
  <button 
    class="px-2 py-1 text-xl text-gray-600 hover:text-gray-900"
    title="Opciones de usuario"
    onclick="openUserModal(<?= htmlspecialchars($u['id']) ?>, <?= $u['estado'] ?>)">
    ⋮
  </button>

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

  <!-- 🔹 Modales -->
<!-- Modal opciones de usuario -->
<div id="modal-opciones" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
  <div class="modal-content bg-white rounded-xl w-72 p-5 mx-auto relative shadow-lg border border-[#535E46]/20">
    <button onclick="closeUserModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700">✖</button>
    <h3 class="text-lg font-semibold mb-4 text-[#535E46]">Opciones de Usuario</h3>

    <div class="space-y-3">
      <!-- Editar -->
      <button 
        onclick="openEditModal()" 
        class="w-full text-left px-4 py-2 rounded-lg transition 
               bg-[#DDA15E]/10 text-[#DDA15E] font-medium hover:bg-[#DDA15E]/20">
        ✏️ Editar Usuario
      </button>
      
      <!-- Bloquear / Activar -->
      <button 
        id="btn-bloquear" 
        onclick="confirmarBloqueo()" 
        class="w-full text-left px-4 py-2 rounded-lg transition">
        <!-- Se rellena dinámicamente -->
      </button>
    </div>
  </div>
</div>


<!-- Modal editar -->
<div id="modal-editar" class="modal-overlay hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
  <div class="modal-content bg-white rounded-2xl w-11/12 max-w-md p-6 mx-auto relative shadow-xl border border-[#535E46]/20">
    <div class="modal-header">
      <!-- Botón cerrar -->
      <button onclick="closeEditModal()" 
              class="absolute top-3 right-3 text-gray-400 hover:text-gray-700">
        ✖
      </button>

      <!-- Título -->
      <h3 class="text-xl font-semibold mb-6 text-[#535E46]">Editar Usuario</h3>
    </div>

    <!-- Formulario -->
    <form id="form-editar" method="POST" action="/admin/editar_usuario" class="space-y-5">
      <input type="hidden" name="id" id="edit-id">

      <!-- Nombre -->
      <div>
        <label class="block text-sm font-medium text-[#535E46] mb-1">Nombre</label>
        <input type="text" name="nombre" id="edit-nombre" 
               class="w-full border border-gray-300 p-3 rounded-2xl focus:ring-2 focus:ring-[#DDA15E] focus:outline-none">
      </div>

      <!-- Apellido -->
      <div>
        <label class="block text-sm font-medium text-[#535E46] mb-1">Apellido</label>
        <input type="text" name="apellido" id="edit-apellido" 
               class="w-full border border-gray-300 p-3 rounded-2xl focus:ring-2 focus:ring-[#DDA15E] focus:outline-none">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-sm font-medium text-[#535E46] mb-1">Email</label>
        <input type="email" name="email" id="edit-email" 
               class="w-full border border-gray-300 p-3 rounded-2xl focus:ring-2 focus:ring-[#DDA15E] focus:outline-none">
      </div>

      <!-- Contraseña -->
      <div>
        <label class="block text-sm font-medium text-[#535E46] mb-1">Nueva contraseña (opcional)</label>
        <input type="password" name="password" 
               class="w-full border border-gray-300 p-3 rounded-2xl focus:ring-2 focus:ring-[#DDA15E] focus:outline-none">
      </div>

      <!-- Botones -->
      <div class="flex justify-end gap-3 mt-6">
        <button type="button" 
                onclick="closeEditModal()" 
                class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-2xl hover:bg-gray-300 transition">
          Cancelar
        </button>
        <button type="submit" 
                class="px-5 py-2.5 bg-[#DDA15E] text-white rounded-2xl hover:bg-[#535E46] transition">
          Guardar cambios
        </button>
      </div>
    </form>
  </div>
</div>

  <script>
let currentUserId = null;
let currentUserEstado = null;

// Modal de opciones de usuario
function openUserModal(id, estado) {
  currentUserId = id;
  currentUserEstado = estado;
  const modal = document.getElementById('modal-opciones');
  const btnBloquear = document.getElementById('btn-bloquear');
  
  // Configurar botón de bloquear/desbloquear según el estado
  if (estado == 1) {
    btnBloquear.className = 'w-full text-left px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition';
    btnBloquear.innerHTML = '🚫 Bloquear Usuario';
  } else {
    btnBloquear.className = 'w-full text-left px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition';
    btnBloquear.innerHTML = '✅ Activar Usuario';
  }
  
  modal.classList.remove('hidden');
}

// Confirmar bloqueo/activación
function confirmarBloqueo() {
  const accion = currentUserEstado == 1 ? 'bloquear' : 'activar';
  const confirmacion = confirm(`¿Estás seguro de que quieres ${accion} este usuario?`);
  
  if (confirmacion) {
    window.location.href = `/usuarios/bloquear?id=${currentUserId}`;
  }
}

function closeUserModal() {
  document.getElementById('modal-opciones').classList.add('hidden');
}

// Modal de editar
async function openEditModal() {
  if (!currentUserId) return;
  
  const modal = document.getElementById('modal-editar');
  modal.classList.remove('hidden');

  try {
    const res = await fetch(`/usuarios/obtener?id=${currentUserId}`);
    const data = await res.json();

    if (data.success) {
      const u = data.usuario;
      document.getElementById('edit-id').value = u.id;
      document.getElementById('edit-nombre').value = u.nombre;
      document.getElementById('edit-apellido').value = u.apellido;
      document.getElementById('edit-email').value = u.email;
    } else {
      alert('No se pudo obtener el usuario');
    }
  } catch (err) {
    alert('Error de conexión');
  }
}

function closeEditModal() {
  document.getElementById('modal-editar').classList.add('hidden');
}
</script>

</body>
</html>
