<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Usuarios</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Importamos la fuente -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins';
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-xl font-semibold">Gestión de Usuarios</h1>
    <p class="text-gray-500 text-sm mb-6">Maneja a tus usuarios y sus permisos de cuenta</p>

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
                <td class="px-4 py-2"><?php echo $u['nombre'];?></td>
                <td class="px-4 py-2"><?php echo $u ['apellido'];?></td>
                <td class="px-4 py-2"><?php echo $u ['email'];?></td>
                <?php if($u['estado'] == 1): ?>
                  <td class="px-4 py-2"> Activo </td>
                <?php else: ?>
                  <td class="px-4 py-2"> Inactivo </td>
                <?php endif; ?>
                <td class="px-4 py-2 flex items-center gap-2 relative">
                  <!-- Botón directo para restaurar contraseña -->
                  <a href="/usuarios/resetear?id=<?= $u['id'] ?>" 
                      class="px-2 py-1 text-sm bg-[#E2E4E0] border border-[#283618] rounded hover:bg-gray-200">
                      🔑 Restaurar contraseña
                  </a>

                  <!-- Botón menú -->
                  <button onclick="toggleMenu(<?= $u['id'] ?>)" 
                          class="p-2 rounded-full hover:bg-gray-200">⋮</button>

                  <!-- Menú desplegable -->
                  <div id="menu-<?= $u['id'] ?>" 
                        class="hidden absolute right-0 mt-10 w-40 bg-white border rounded-md shadow-lg z-10">
                    <ul class="py-1 text-sm">
                      <li>
                        <a href="/usuarios/editar?id=<?= $u['id'] ?>" 
                            class="block px-4 py-2 hover:bg-gray-100">✏️ Editar</a>
                      </li>
                      <li>
                        <a href="/usuarios/bloquear?id=<?= $u['id'] ?>" 
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

  <script>
    const usuariosPorPagina = 10;
    let paginaActual = 1;

    function mostrarUsuarios(pagina) {
      const inicio = (pagina - 1) * usuariosPorPagina;
      const fin = inicio + usuariosPorPagina;
      const usuariosPagina = usuarios.slice(inicio, fin);

      const tabla = document.getElementById("tablaUsuarios");
      tabla.innerHTML = "";

      usuariosPagina.forEach((u, idx) => {
        const fila = `
          <tr class="text-sm border-b">
            <td class="px-4 py-2 flex items-center gap-2">
              <input type="checkbox" class="w-4 h-4">
              <span>${u.nombre}</span>
            </td>
            <td class="px-4 py-2">${u.rol}</td>
            <td class="px-4 py-2">${u.estado}</td>
            <td class="px-4 py-2 flex items-center gap-2 relative">
              <!-- Botón directo para resetear contraseña -->
              <button class="px-2 py-1 text-sm bg-[#E2E4E0] border border-[#283618] rounded hover:bg-gray-200">🔑 Restaurar contraseña</button>
              
              <!-- Botón menú -->
              <button onclick="toggleMenu(${idx})" class="p-1 rounded-full hover:bg-gray-200">⋮</button>
              <!-- Menú desplegable -->
              <div id="menu-${idx}" class="hidden absolute right-0 mt-8 w-40 bg-white border rounded-md shadow-lg z-10">
                <ul class="py-1 text-sm">
                  <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">✏️ Editar</a></li>
                  <li><a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-100">🚫 Bloquear</a></li>
                </ul>
              </div>
            </td>
          </tr>`;
        tabla.insertAdjacentHTML("beforeend", fila);
      });

      document.getElementById("totalUsuarios").textContent = usuarios.length;
      actualizarPaginacion();
    }

    function toggleMenu(id) {
      // Cierra otros menús
      document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add("hidden"));
      // Abre el correspondiente
      document.getElementById(`menu-${id}`).classList.toggle("hidden");
    }

    // Cerrar menús al hacer clic fuera
    document.addEventListener("click", (e) => {
      if (!e.target.closest("td")) {
        document.querySelectorAll('[id^="menu-"]').forEach(el => el.classList.add("hidden"));
      }
    });


    function actualizarPaginacion() {
      const totalPaginas = Math.ceil(usuarios.length / usuariosPorPagina);
      const paginacion = document.getElementById("paginacion");
      paginacion.innerHTML = "";

      if (totalPaginas <= 1) return;

      for (let i = 1; i <= totalPaginas; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = `px-3 py-1 rounded-full ${i === paginaActual ? "bg-[#E2E4E0] text-black" : "bg-gray-100 hover:bg-gray-200"}`;
        btn.onclick = () => {
          paginaActual = i;
          mostrarUsuarios(paginaActual);
        };
        paginacion.appendChild(btn);
      }
    }

    // Inicialización
    mostrarUsuarios(paginaActual);

  </script>

</body>
</html>
