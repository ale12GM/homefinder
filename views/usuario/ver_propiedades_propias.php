<?php

$permisos = $_SESSION['permisos'] ?? [];
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
    /* Animaciones sutiles y no invasivas acordes al diseño */
    :root{
      --accent:#535E46;
    }

    /* Transiciones generales */
    input[type="text"], select, button {
      transition: box-shadow 200ms ease, transform 150ms ease, background-color 200ms ease;
    }

    /* Filas principales: ligero levantamiento al hover */
    table tbody tr:not(.detail-row) {
      transition: transform 180ms ease, background-color 180ms ease, box-shadow 180ms ease;
    }
    table tbody tr:not(.detail-row):hover {
      transform: translateY(-3px);
      background-color: #fbfbf9;
      box-shadow: 0 6px 16px rgba(83,94,70,0.06);
    }

    /* Estilo sutil para botones (consistencia con diseño) */
    .toggle-detail {
      transition: color 150ms ease, transform 120ms ease;
    }
    .toggle-detail:focus, .toggle-detail:hover {
      transform: translateY(-1px);
      outline: none;
      text-decoration: none;
    }

    /* Respetar preferencia de reducir movimiento */
    @media (prefers-reduced-motion: reduce) {
      * {
        transition: none !important;
        animation: none !important;
      }
    }

    /* Modal de detalle */
    .modal-backdrop {
      position: fixed;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      background: rgba(0,0,0,0.35);
      z-index: 60;
      padding: 24px;
    }
    .modal-backdrop.open {
      display: flex;
    }
    .modal-content {
      background: #fff;
      border-radius: 12px;
      max-width: 900px;
      width: 100%;
      box-shadow: 0 12px 40px rgba(15,23,42,0.15);
      transform: translateY(6px) scale(.99);
      opacity: 0;
      transition: transform 300ms cubic-bezier(.2,.8,.2,1), opacity 240ms ease;
      overflow: hidden;
    }
    .modal-backdrop.open .modal-content {
      transform: translateY(0) scale(1);
      opacity: 1;
    }
    .modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 20px;
      border-bottom: 1px solid #eef2e7;
    }
    .modal-body {
      padding: 18px 20px 24px;
    }
    .modal-close {
      background: transparent;
      border: none;
      font-size: 18px;
      padding: 6px;
      cursor: pointer;
    }

    @media (prefers-reduced-motion: reduce) {
      .modal-content { transition: none !important; }
    }

    /* Estilos para el buscador mejorado */
    .search-form {
      background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%);
      border: 1px solid #E2E4E0;
      border-radius: 16px;
      padding: 16px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
      transition: all 0.3s ease;
    }

    .search-form:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      border-color: #535E46;
    }

    .search-input {
      background: #ffffff;
      border: 1px solid #E2E4E0;
      border-radius: 25px;
      padding: 12px 16px 12px 44px;
      font-size: 14px;
      transition: all 0.2s ease;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .search-input:focus {
      outline: none;
      border-color: #535E46;
      box-shadow: 0 0 0 3px rgba(83, 94, 70, 0.1), 0 2px 8px rgba(0, 0, 0, 0.1);
      transform: translateY(-1px);
    }

    .search-input:hover {
      border-color: #535E46;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .search-icon {
      color: #9CA3AF;
      transition: color 0.2s ease;
    }

    .search-input:focus + .search-icon {
      color: #535E46;
    }

    .action-button {
      border-radius: 25px;
      padding: 10px 20px;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
      border: none;
      cursor: pointer;
    }

    .action-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .action-button:active {
      transform: translateY(0);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background: linear-gradient(135deg, #535E46 0%, #3f4736 100%);
      color: white;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #3f4736 0%, #2d3326 100%);
    }

    .btn-secondary {
      background: #f8f9fa;
      color: #6b7280;
      border: 1px solid #e5e7eb;
    }

    .btn-secondary:hover {
      background: #e5e7eb;
      color: #374151;
    }

    .btn-accent {
      background: linear-gradient(135deg, #DDA15E 0%, #BC8A4B 100%);
      color: white;
    }

    .btn-accent:hover {
      background: linear-gradient(135deg, #BC8A4B 0%, #a67c42 100%);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .search-form {
        padding: 12px;
      }
      
      .action-button {
        padding: 8px 16px;
        font-size: 13px;
      }
    }
  </style>
</head>
<body class="text-gray-800">

<main class="container mx-auto my-12 px-4 max-w-6xl">
  <div class="bg-white shadow-md rounded-2xl p-6">
    
    <!-- Encabezado -->
    <div class="mb-6">
      <h1 class="text-xl font-semibold">Mis propiedades</h1><br>
      <p class="text-sm text-gray-500">Maneja a tus propiedades y edita o eliminalas</p>
    </div>

    <!-- Barra de búsqueda mejorada -->
    <div class="mb-6">
      <form action="/usuario/mispropiedades" method="GET" class="search-form">
        <div class="flex flex-col lg:flex-row gap-4 items-center">
          
          <!-- Campo de búsqueda principal -->
          <div class="flex-1 flex items-center">
            <div class="relative w-full">
              <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"/>
              </svg>
              <input type="text" name="buscar" placeholder="Buscar por título, dirección, descripción..."
                     value="<?php echo htmlspecialchars($_GET['buscar'] ?? '', ENT_QUOTES); ?>"
                     class="search-input w-full">
            </div>
          </div>

          <!-- Botones de acción -->
          <div class="flex gap-2">
            <button type="submit" class="action-button btn-primary">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"/>
              </svg>
              Buscar
            </button>
            
            <a href="/usuario/mispropiedades" class="action-button btn-secondary">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              Limpiar
            </a>
            
            <a href="/usuario/propiedades/publicar" class="action-button btn-accent">
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
        <?php if (!empty($_GET['buscar'])): ?>
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
              <?php
                // Verificar permisos para acciones
                $puedeEditar = in_array('editar_todas_propiedades', $permisos) ||
                              (in_array('editar_propiedad_propia', $permisos) && $p['id_usuario'] == $_SESSION['id']);
                $puedeEliminar = in_array('eliminar_todas_propiedades', $permisos) ||
                                (in_array('eliminar_propiedad_propia', $permisos) && $p['id_usuario'] == $_SESSION['id']);

                // Preparar datos esenciales para el modal (escapados)
                $data_prop = htmlspecialchars(json_encode([
                  'id' => $uid,
                  'titulo' => $p['titulo'] ?? '',
                  'descripcion' => $p['descripcion'] ?? '',
                  'direccion' => $p['direccion'] ?? '',
                  'precio' => round($p['precio'] ?? 0),
                  'superficie' => round($p['superficie_total'] ?? 0),
                  'habitaciones' => $p['num_habitaciones'] ?? '',
                  'banos' => $p['num_banos'] ?? '',
                  'latitud' => $p['latitud'] ?? '',
                  'longitud' => $p['longitud'] ?? '',
                  'imagen' => $p['imagen'] ?? '',
                  'puedeEditar' => $puedeEditar,
                  'puedeEliminar' => $puedeEliminar,
                  'editUrl' => '/usuario/propiedades/editar?id=' . $uid,
                  'deleteUrl' => '/usuario/mispropiedades/eliminar?id=' . $uid
                ]), ENT_QUOTES);
              ?>
              <button type="button"
                      class="open-modal toggle-detail text-[#535E46] hover:underline"
                      aria-expanded="false"
                      data-prop='<?php echo $data_prop; ?>'>
                👁 Ver Detalle
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Modal global para mostrar detalle -->
    <div id="prop-modal" class="modal-backdrop" role="dialog" aria-modal="true" aria-hidden="true">
      <div class="modal-content" role="document">
        <div class="modal-header">
          <h3 id="modal-title" class="text-lg font-semibold text-[#535E46]">Detalle</h3>
          <button class="modal-close" aria-label="Cerrar">✖</button>
        </div>
        <div class="modal-body">
          <div class="flex gap-4">
            <div class="w-48 h-32 bg-gray-100 rounded overflow-hidden flex-shrink-0" id="modal-image-wrap">
              <img id="modal-image" src="" alt="Imagen" class="w-full h-full object-cover hidden">
              <div id="modal-no-image" class="w-full h-full flex items-center justify-center text-xs text-gray-400">Sin imagen</div>
            </div>
            <div class="flex-1">
              <p id="modal-direccion" class="text-xs text-gray-400"></p>
              <p id="modal-descripcion" class="mt-2 text-sm text-gray-700"></p>
              <p class="mt-3 font-bold">Precio: <span id="modal-precio" class="text-[#535E46]"></span> $</p>
              <div class="mt-2 text-sm text-gray-600">
                <span id="modal-superficie"></span>
                <span id="modal-habitaciones" class="ml-4"></span>
                <span id="modal-banos" class="ml-4"></span>
              </div>
              <div class="mt-3 text-sm text-gray-500">
                <span id="modal-latitud"></span>
                <span id="modal-longitud" class="ml-4"></span>
              </div>
              <div id="modal-actions" class="mt-4 flex gap-2"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Script para manejar el modal -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Detectar si el usuario prefiere reducir movimiento
      const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      // Modal global: abrir/llenar/cerrar
      const modal = document.getElementById('prop-modal');
      const modalTitle = document.getElementById('modal-title');
      const modalImage = document.getElementById('modal-image');
      const modalImageWrap = document.getElementById('modal-image-wrap');
      const modalNoImage = document.getElementById('modal-no-image');
      const modalDireccion = document.getElementById('modal-direccion');
      const modalDescripcion = document.getElementById('modal-descripcion');
      const modalPrecio = document.getElementById('modal-precio');
      const modalSuperficie = document.getElementById('modal-superficie');
      const modalHabitaciones = document.getElementById('modal-habitaciones');
      const modalBanos = document.getElementById('modal-banos');
      const modalCloseBtn = modal.querySelector('.modal-close');
      let lastFocused = null;

      function openModal(data, openerBtn){
        // llenar campos
        modalTitle.textContent = data.titulo || 'Detalle';
        if (data.imagen) {
          modalImage.src = '/img/' + data.imagen;
          modalImage.classList.remove('hidden');
          modalNoImage.classList.add('hidden');
        } else {
          modalImage.classList.add('hidden');
          modalNoImage.classList.remove('hidden');
        }
        modalDireccion.textContent = data.direccion || '';
        modalDescripcion.textContent = data.descripcion || '';
        modalPrecio.textContent = data.precio || '';
        modalSuperficie.textContent = data.superficie ? ('Superficie: ' + data.superficie) : '';
        modalHabitaciones.textContent = data.habitaciones ? (data.habitaciones + ' habitaciones') : '';
        modalBanos.textContent = data.banos ? (data.banos + ' baños') : '';
        document.getElementById('modal-latitud').textContent = data.latitud ? ('Latitud: ' + data.latitud) : '';
        document.getElementById('modal-longitud').textContent = data.longitud ? ('Longitud: ' + data.longitud) : '';

        // acciones
        const actionsWrap = document.getElementById('modal-actions');
        actionsWrap.innerHTML = '';
        if (data.puedeEditar) {
          const a = document.createElement('a');
          a.href = data.editUrl || '#';
          a.className = 'px-3 py-1 rounded-full border text-sm hover:bg-gray-100 transition-transform transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#535E46]/30';
          a.textContent = '✏️ Editar';
          actionsWrap.appendChild(a);
        }
        if (data.puedeEliminar) {
          const b = document.createElement('a');
          b.href = data.deleteUrl || '#';
          b.className = 'px-3 py-1 rounded-full border text-sm text-red-600 hover:bg-red-100 transition-transform transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-200';
          b.textContent = '🗑 Eliminar';
          actionsWrap.appendChild(b);
        }

        // accesibilidad y mostrar
        lastFocused = openerBtn || document.activeElement;
        modal.setAttribute('aria-hidden', 'false');
        modal.classList.add('open');
        // poner foco en el modal close
        modalCloseBtn.focus();
      }

      function closeModal(){
        modal.setAttribute('aria-hidden', 'true');
        modal.classList.remove('open');
        if (lastFocused) lastFocused.focus();
      }

      // Abrir modal al click en botones .open-modal
      document.querySelectorAll('.open-modal').forEach(function(btn){
        btn.addEventListener('click', function(e){
          e.preventDefault();
          let raw = this.getAttribute('data-prop');
          if (!raw) return;
          try {
            const data = JSON.parse(raw);
            openModal(data, this);
          } catch(err){
            console.error('JSON parse error for prop data:', err);
          }
        });
      });

      // Cerrar modal por boton
      modalCloseBtn.addEventListener('click', function(){ closeModal(); });

      // Cerrar por click en overlay (si click fuera del contenido)
      modal.addEventListener('click', function(e){
        if (e.target === modal) closeModal();
      });

      // Cerrar con ESC
      document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') {
          if (modal.classList.contains('open')) {
            closeModal();
          }
        }
      });
    });
    </script>

</main>

</body>
</html>
