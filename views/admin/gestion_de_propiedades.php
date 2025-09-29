<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Propiedades</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #FEFAE0;
    }
  </style>
</head>
<body class="text-gray-800">

<main class="container mx-auto my-12 px-4 max-w-6xl">
  <div class="bg-white shadow-md rounded-2xl p-6">
    
    <!-- Encabezado -->
    <div class="mb-6">
      <h1 class="text-xl font-semibold">Gestión de propiedades</h1><br>
      <p class="text-sm text-gray-500">Maneja las propiedades y edita o desactivalas.</p>
    </div>

    <!-- Barra superior -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
      <p class="text-sm">
        <span class="font-semibold">Todas las propiedades</span> 
        <span class="text-gray-400 ml-2"></span>
      </p>

      <div class="flex items-center gap-2 mt-2 sm:mt-0">
        <!-- Buscar -->
        <div class="relative">
          <input type="text" placeholder="Buscar" class="pl-8 pr-3 py-1 rounded-full border border-[#E2E4E0] focus:outline-none focus:ring-2 focus:ring-[#535E46]/50 text-sm">
          <svg class="w-4 h-4 absolute left-2 top-2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"/>
          </svg>
        </div>
        <!-- Filtros -->
        <button class="flex items-center gap-1 border border-[#E2E4E0] px-3 py-1 rounded-full text-sm hover:bg-[#E2E4E0] transition">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M4 9h16M5 14h14M6 19h12"/>
          </svg>
          Filtros
        </button>
        <!-- Añadir -->
        <a href="/usuario/propiedades/publicar" 
          class="bg-[#535E46] text-white px-4 py-1 rounded-full text-sm hover:bg-[#3f4736] transition">
          + Añadir
        </a>
      </div>
    </div>

    <!-- Tabla con filas expandibles -->
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left border-collapse">
        <thead class="border-b border-[#E2E4E0] text-[#535E46]">
          <tr>
            <th class="py-2 px-3">Título</th>
            <th class="py-2 px-3">Descripción</th>
            <th class="py-2 px-3">Precio</th>
            <th class="py-2 px-3">Acciones</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-[#E2E4E0]">
          <?php foreach($propiedades as $index => $p): 
             $uid = isset($p['id']) ? $p['id'] : $index;
          ?>
          <!-- fila principal -->
          <tr class="align-top">
            <td class="px-3 py-2">
              <?php echo htmlspecialchars($p['titulo'], ENT_QUOTES) ?>
            </td>
            <td class="px-3 py-2 truncate max-w-[200px]">
              <?php echo htmlspecialchars($p['descripcion'], ENT_QUOTES); ?>
            </td>
            <td class="px-3 py-2 font-medium">
              <?php echo round($p['precio'])?> $
            </td>
            <td class="px-3 py-2 flex items-center gap-2">
              <button type="button" 
                      class="toggle-detail text-[#535E46] hover:underline" 
                      aria-expanded="false">
                👁 Ver Detalle
              </button>
            </td>
          </tr>

          <!-- fila de detalle (inicialmente oculta) -->
          <tr class="detail-row hidden bg-gray-50">
            <td colspan="4" class="px-4 py-4">
              <div class="flex gap-4">
                <!-- imagen -->
                <div class="w-32 h-24 bg-gray-200 rounded overflow-hidden flex-shrink-0">
                  <?php if(!empty($p['imagen'])): ?>
                    <img src="/img/<?= $p['imagen'] ?>" 
                         alt="Imagen propiedad" 
                         class="w-full h-full object-cover">
                  <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">Sin imagen</div>
                  <?php endif; ?>
                </div>

                <!-- info -->
                <div class="flex-1">
                  <h3 class="text-sm font-semibold text-[#535E46]">
                    <?php echo htmlspecialchars($p['titulo'], ENT_QUOTES) ?>
                  </h3>
                  <p class="text-xs text-gray-400 mt-1">
                    <?php echo nl2br(htmlspecialchars($p['direccion'], ENT_QUOTES)) ?>
                  </p>
                  <p class="text-sm text-gray-600 mt-1">
                    <?php echo nl2br(htmlspecialchars($p['descripcion'], ENT_QUOTES)) ?>
                  </p>
                  <p class="mt-3 font-bold">
                    Precio: <span class="text-[#535E46]"><?php echo round($p['precio']) ?></span> $
                  </p>
                  <p class="mt-3 font-bold">
                    Superficie: <span class="text-[#535E46]"><?php echo round($p['superficie_total']) ?></span> 
                  </p>
                  <p class="mt-3 font-bold">
                    Latitud: <span class="text-[#535E46]"><?php echo round($p['latitud']) ?></span> 
                  </p>
                  <p class="mt-3 font-bold">
                    Longitud: <span class="text-[#535E46]"><?php echo round($p['longitud']) ?></span> 
                  </p>
                  <div class="flex items-center gap-4 mt-2 text-gray-600 text-sm">
                    <span>🛏️ <?php echo $p['num_habitaciones'] ?> Habitaciones</span>
                    <span>🚿 <?php echo $p['num_banos'] ?> Baños</span>
                  </div>

                  <div class="mt-4 flex gap-2">
                    <?php 
                    // Verificar permisos para editar
                    $puedeEditar = in_array('editar_todas_propiedades', $permisos) || 
                                  (in_array('editar_propiedad_propia', $permisos) && $p['id_usuario'] == $_SESSION['id']);
                    
                    // Verificar permisos para eliminar
                    $puedeEliminar = in_array('eliminar_todas_propiedades', $permisos) || 
                                    (in_array('eliminar_propiedad_propia', $permisos) && $p['id_usuario'] == $_SESSION['id']);
                    ?>
                    
                    <?php if ($puedeEditar): ?>
                      <a href="/admin/propiedades/editar?id=<?php echo $uid ?>" 
                         class="px-3 py-1 rounded-full border text-sm hover:bg-gray-100 transition">
                         ✏️ Editar
                      </a>
                    <?php endif; ?>

                    <?php if ($puedeEliminar): ?>
                      <a href="/usuario/mispropiedades/eliminar?id=<?= $uid ?>" 
                         class="px-3 py-1 rounded-full border text-sm text-red-600 hover:bg-red-100 transition">
                         🗑 Eliminar
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Script para expandir/ocultar detalle -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.toggle-detail').forEach(function(btn){
        btn.addEventListener('click', function(){
          const tr = this.closest('tr');
          const detail = tr.nextElementSibling;
          if (!detail) return;

          detail.classList.toggle('hidden');

          // Accesibilidad
          const expanded = this.getAttribute('aria-expanded') === 'true';
          this.setAttribute('aria-expanded', (!expanded).toString());

          // Cambiar texto
          this.textContent = expanded ? "👁 Ver Detalle" : "✖ Ocultar";
        });
      });
    });
    </script>

</main>

</body>
</html>
