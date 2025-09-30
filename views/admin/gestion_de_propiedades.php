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

    <!-- Barra de búsqueda avanzada -->
    <div class="mb-6">
      <form action="/admin/propiedades" method="GET" class="bg-white border border-[#E2E4E0] rounded-2xl p-4 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-4 items-center">
          
          <!-- Campo de búsqueda principal -->
          <div class="flex-1 flex items-center">
            <div class="relative w-full">
              <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"/>
              </svg>
              <input type="text" name="buscar" placeholder="Buscar por título, dirección, descripción..."
                     value="<?php echo htmlspecialchars($_GET['buscar'] ?? '', ENT_QUOTES); ?>"
                     class="w-full pl-10 pr-4 py-2 border border-[#E2E4E0] rounded-full focus:outline-none focus:ring-2 focus:ring-[#535E46]/50 text-sm">
            </div>
          </div>

          <!-- Filtros -->
          <div class="flex flex-wrap gap-2">
            <!-- Filtro de precio mínimo -->
            <select name="precio_min" class="py-2 px-3 rounded-full border border-[#E2E4E0] focus:outline-none focus:ring-2 focus:ring-[#535E46]/50 text-sm">
              <option value="">Precio min</option>
              <option value="50000" <?php echo (($_GET['precio_min'] ?? '') == '50000') ? 'selected' : ''; ?>>$50,000</option>
              <option value="100000" <?php echo (($_GET['precio_min'] ?? '') == '100000') ? 'selected' : ''; ?>>$100,000</option>
              <option value="200000" <?php echo (($_GET['precio_min'] ?? '') == '200000') ? 'selected' : ''; ?>>$200,000</option>
              <option value="300000" <?php echo (($_GET['precio_min'] ?? '') == '300000') ? 'selected' : ''; ?>>$300,000</option>
            </select>
            
            <!-- Filtro de precio máximo -->
            <select name="precio_max" class="py-2 px-3 rounded-full border border-[#E2E4E0] focus:outline-none focus:ring-2 focus:ring-[#535E46]/50 text-sm">
              <option value="">Precio max</option>
              <option value="100000" <?php echo (($_GET['precio_max'] ?? '') == '100000') ? 'selected' : ''; ?>>$100,000</option>
              <option value="200000" <?php echo (($_GET['precio_max'] ?? '') == '200000') ? 'selected' : ''; ?>>$200,000</option>
              <option value="300000" <?php echo (($_GET['precio_max'] ?? '') == '300000') ? 'selected' : ''; ?>>$300,000</option>
              <option value="500000" <?php echo (($_GET['precio_max'] ?? '') == '500000') ? 'selected' : ''; ?>>$500,000</option>
            </select>

            <!-- Filtro de habitaciones -->
            <select name="habitaciones" class="py-2 px-3 rounded-full border border-[#E2E4E0] focus:outline-none focus:ring-2 focus:ring-[#535E46]/50 text-sm">
              <option value="">Habitaciones</option>
              <option value="1" <?php echo (($_GET['habitaciones'] ?? '') == '1') ? 'selected' : ''; ?>>1+</option>
              <option value="2" <?php echo (($_GET['habitaciones'] ?? '') == '2') ? 'selected' : ''; ?>>2+</option>
              <option value="3" <?php echo (($_GET['habitaciones'] ?? '') == '3') ? 'selected' : ''; ?>>3+</option>
              <option value="4" <?php echo (($_GET['habitaciones'] ?? '') == '4') ? 'selected' : ''; ?>>4+</option>
            </select>

            <!-- Filtro de estado -->
            <select name="estado" class="py-2 px-3 rounded-full border border-[#E2E4E0] focus:outline-none focus:ring-2 focus:ring-[#535E46]/50 text-sm">
              <option value="">Estado</option>
              <option value="activo" <?php echo (($_GET['estado'] ?? '') == 'activo') ? 'selected' : ''; ?>>Activo</option>
              <option value="inactivo" <?php echo (($_GET['estado'] ?? '') == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
            </select>
          </div>

          <!-- Botones de acción -->
          <div class="flex gap-2">
            <button type="submit" class="bg-[#535E46] text-white px-4 py-2 rounded-full text-sm hover:bg-[#3f4736] transition flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"/>
              </svg>
              Buscar
            </button>
            
            <a href="/admin/propiedades" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300 transition flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              Limpiar
            </a>
            
            <a href="/usuario/propiedades/publicar" class="bg-[#DDA15E] text-white px-4 py-2 rounded-full text-sm hover:bg-[#BC8A4B] transition flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
              </svg>
              Añadir
            </a>
          </div>
        </div>
      </form>
    </div>

    <!-- Información de resultados -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
      <p class="text-sm">
        <span class="font-semibold">Propiedades encontradas: <?php echo count($propiedades); ?></span>
        <?php if (!empty($filtros)): ?>
          <span class="text-gray-400 ml-2">(con filtros aplicados)</span>
        <?php endif; ?>
      </p>
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
                         Bloquear
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
