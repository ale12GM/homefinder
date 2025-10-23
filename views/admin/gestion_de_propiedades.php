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

    /* (detalle inline removido — ahora usamos modal para mostrar la información) */

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
      .detail-row .detail-inner {
        max-height: none;
        opacity: 1;
        padding-top: 16px;
        padding-bottom: 16px;
      }
    }

    /* Estilo personalizado para selects */
    .custom-select-wrapper {
      position: relative;
      user-select: none;
    }
    
    .custom-select {
      position: relative;
      display: flex;
      flex-direction: column;
    }
    
    .custom-select-trigger {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      line-height: 1.25rem;
      background: white;
      cursor: pointer;
      border: 1px solid #E2E4E0;
      border-radius: 9999px;
      transition: all 200ms ease;
    }
    
    .custom-select-trigger:hover {
      border-color: #535E46;
    }
    
    .custom-select.open .custom-select-trigger {
      border-color: #535E46;
      box-shadow: 0 0 0 2px rgba(83,94,70,0.2);
    }
    
    .custom-options {
      position: absolute;
      display: block;
      top: 100%;
      left: 0;
      right: 0;
      border: 1px solid #E2E4E0;
      border-radius: 1rem;
      background: white;
      transition: all 200ms ease;
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
      transform: translateY(5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin-top: 0.5rem;
      z-index: 50;
    }
    
    .custom-select.open .custom-options {
      opacity: 1;
      visibility: visible;
      pointer-events: all;
      transform: translateY(0);
    }
    
    .custom-option {
      position: relative;
      display: block;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      color: #374151;
      cursor: pointer;
      transition: all 120ms ease;
    }
    
    .custom-option:first-child {
      border-radius: 1rem 1rem 0 0;
    }
    
    .custom-option:last-child {
      border-radius: 0 0 1rem 1rem;
    }
    
    .custom-option:hover {
      background: #F3F4F6;
      color: #535E46;
    }
    
    .custom-option.selected {
      color: #535E46;
      background: #F3F4F6;
    }

    @media (prefers-reduced-motion: reduce) {
      .custom-select-trigger,
      .custom-options,
      .custom-option {
        transition: none !important;
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
            <div class="custom-select-wrapper">
              <div class="custom-select" data-value="<?php echo $_GET['precio_min'] ?? ''; ?>">
                <input type="hidden" name="precio_min" value="<?php echo $_GET['precio_min'] ?? ''; ?>">
                <div class="custom-select-trigger">
                  <span class="text-sm">
                    <?php 
                      $precio_min = $_GET['precio_min'] ?? '';
                      echo $precio_min ? '$'.number_format($precio_min) : 'Precio min';
                    ?>
                  </span>
                  <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                    <path d="M6 8l4 4 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                <div class="custom-options">
                  <span class="custom-option" data-value="">Precio min</span>
                  <span class="custom-option" data-value="50000">$50,000</span>
                  <span class="custom-option" data-value="100000">$100,000</span>
                  <span class="custom-option" data-value="200000">$200,000</span>
                  <span class="custom-option" data-value="300000">$300,000</span>
                </div>
              </div>
            </div>
            
            <!-- Filtro de precio máximo -->
            <div class="custom-select-wrapper">
              <div class="custom-select" data-value="<?php echo $_GET['precio_max'] ?? ''; ?>">
                <input type="hidden" name="precio_max" value="<?php echo $_GET['precio_max'] ?? ''; ?>">
                <div class="custom-select-trigger">
                  <span class="text-sm">
                    <?php 
                      $precio_max = $_GET['precio_max'] ?? '';
                      echo $precio_max ? '$'.number_format($precio_max) : 'Precio max';
                    ?>
                  </span>
                  <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                    <path d="M6 8l4 4 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                <div class="custom-options">
                  <span class="custom-option" data-value="">Precio max</span>
                  <span class="custom-option" data-value="100000">$100,000</span>
                  <span class="custom-option" data-value="200000">$200,000</span>
                  <span class="custom-option" data-value="300000">$300,000</span>
                  <span class="custom-option" data-value="500000">$500,000</span>
                </div>
              </div>
            </div>

            <!-- Filtro de habitaciones -->
            <div class="custom-select-wrapper">
              <div class="custom-select" data-value="<?php echo $_GET['habitaciones'] ?? ''; ?>">
                <input type="hidden" name="habitaciones" value="<?php echo $_GET['habitaciones'] ?? ''; ?>">
                <div class="custom-select-trigger">
                  <span class="text-sm">
                    <?php 
                      $habitaciones = $_GET['habitaciones'] ?? '';
                      echo $habitaciones ? $habitaciones . '+' : 'Habitaciones';
                    ?>
                  </span>
                  <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                    <path d="M6 8l4 4 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                <div class="custom-options">
                  <span class="custom-option" data-value="">Habitaciones</span>
                  <span class="custom-option" data-value="1">1+</span>
                  <span class="custom-option" data-value="2">2+</span>
                  <span class="custom-option" data-value="3">3+</span>
                  <span class="custom-option" data-value="4">4+</span>
                </div>
              </div>
            </div>

            <!-- Filtro de estado -->
            <div class="custom-select-wrapper">
              <div class="custom-select" data-value="<?php echo $_GET['estado'] ?? ''; ?>">
                <input type="hidden" name="estado" value="<?php echo $_GET['estado'] ?? ''; ?>">
                <div class="custom-select-trigger">
                  <span class="text-sm">
                    <?php 
                      $estado = $_GET['estado'] ?? '';
                      echo $estado ? ucfirst($estado) : 'Estado';
                    ?>
                  </span>
                  <svg class="w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                    <path d="M6 8l4 4 4-4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </div>
                <div class="custom-options">
                  <span class="custom-option" data-value="">Estado</span>
                  <span class="custom-option" data-value="activo">Activo</span>
                  <span class="custom-option" data-value="inactivo">Inactivo</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Botones de acción -->
          <div class="flex gap-2">
            <button type="submit" class="bg-[#535E46] text-white px-4 py-2 rounded-full text-sm hover:bg-[#3f4736] transition-transform transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#535E46]/30 flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"/>
              </svg>
              Buscar
            </button>
            
            <a href="/admin/propiedades" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm hover:bg-gray-300 transition-transform transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-gray-300/40 flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              Limpiar
            </a>
            
            <a href="/usuario/propiedades/publicar" class="bg-[#DDA15E] text-white px-4 py-2 rounded-full text-sm hover:bg-[#BC8A4B] transition-transform transform hover:-translate-y-0.5 active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#DDA15E]/30 flex items-center gap-2">
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
              <?php
                // Verificar permisos para acciones (mismo criterio que antes)
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
                  'editUrl' => '/admin/propiedades/editar?id=' . $uid,
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

            <!-- detalle ahora mostrado en modal; eliminada la fila expandible -->
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

    <!-- Script para expandir/ocultar detalle -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Detectar si el usuario prefiere reducir movimiento
      const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      // Los botones de detalle ahora abren un modal; no usamos la fila inline.

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
          b.textContent = 'Bloquear';
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
          // Cerrar cualquier select abierto
          document.querySelectorAll('.custom-select.open').forEach(select => {
            select.classList.remove('open');
          });
        }
      });

      // Inicializar Custom Selects
      document.querySelectorAll('.custom-select-wrapper').forEach(wrapper => {
        const select = wrapper.querySelector('.custom-select');
        const trigger = wrapper.querySelector('.custom-select-trigger');
        const hiddenInput = wrapper.querySelector('input[type="hidden"]');
        const options = wrapper.querySelectorAll('.custom-option');
        const triggerText = trigger.querySelector('span');

        // Marcar opción seleccionada inicialmente
        const currentValue = select.getAttribute('data-value');
        options.forEach(option => {
          if (option.getAttribute('data-value') === currentValue) {
            option.classList.add('selected');
          }
        });

        // Toggle del select
        trigger.addEventListener('click', (e) => {
          e.stopPropagation();
          
          // Cerrar otros selects abiertos
          document.querySelectorAll('.custom-select.open').forEach(otherSelect => {
            if (otherSelect !== select) otherSelect.classList.remove('open');
          });
          
          select.classList.toggle('open');
        });

        // Selección de opción
        options.forEach(option => {
          option.addEventListener('click', () => {
            // Actualizar valor seleccionado
            const value = option.getAttribute('data-value');
            const text = option.textContent;
            
            // Actualizar input oculto
            if (hiddenInput) hiddenInput.value = value;
            
            // Actualizar texto visible
            triggerText.textContent = text;
            
            // Actualizar clases
            options.forEach(opt => opt.classList.remove('selected'));
            option.classList.add('selected');
            
            // Cerrar dropdown
            select.classList.remove('open');
            
            // Disparar evento change para compatibilidad con forms
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
          });
        });

        // Soporte de teclado
        trigger.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            select.classList.toggle('open');
          }
        });
      });

      // Cerrar dropdowns al hacer click fuera
      document.addEventListener('click', () => {
        document.querySelectorAll('.custom-select.open').forEach(select => {
          select.classList.remove('open');
        });
      });
    });
    </script>

</main>

</body>
</html>
