<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Viviendas en Venta</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
    .modal-enter { opacity: 0; transform: translateY(-20px); }
    .modal-enter-active { opacity: 1; transform: translateY(0); transition: all 0.3s ease-out; }
    .modal-exit { opacity: 1; transform: translateY(0); }
    .modal-exit-active { opacity: 0; transform: translateY(-20px); transition: all 0.3s ease-in; }
    
    /* Efectos para el botón de contactar */
    .contact-btn {
      transition: all 0.3s ease;
      transform-origin: center;
    }
    
    .contact-btn:hover {
      animation: bounce 0.6s ease;
    }
    
    @keyframes bounce {
      0%, 20%, 60%, 100% {
        transform: translateY(0);
      }
      40% {
        transform: translateY(-10px);
      }
      80% {
        transform: translateY(-5px);
      }
    }
    
    /* Estilos para la lista de contactos */
    .contactos-lista {
      display: none;
      background: #f8f9fa;
      border: 1px solid #DDA15E;
      border-radius: 8px;
      margin-top: 10px;
      padding: 15px;
    }
    
    .contacto-item {
      display: flex;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #e5e5e5;
    }
    
    .contacto-item:last-child {
      border-bottom: none;
    }
    
    .contacto-icon {
      font-size: 18px;
      margin-right: 10px;
      width: 25px;
    }
    
    .contacto-info {
      flex: 1;
    }
    
    .contacto-tipo {
      font-weight: 600;
      color: #5B674D;
      font-size: 14px;
    }
    
    .contacto-valor {
      color: #DDA15E;
      text-decoration: none;
      font-size: 13px;
    }
    
    .contacto-valor:hover {
      text-decoration: underline;
    }
    
    .contacto-principal {
      background: #e8f5e8;
      border-left: 4px solid #5B674D;
      padding-left: 10px;
    }
    
    /* Responsividad adicional para el modal */
    @media (max-width: 640px) {
      #modalContent {
        margin: 1rem;
        max-height: calc(100vh - 2rem);
      }
      
      .modal-enter {
        transform: translateY(-10px);
      }
      
      .modal-enter-active {
        transform: translateY(0);
      }
    }
    
    /* Estilos específicos para el buscador */
    #searchForm input, #searchForm select {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    #searchForm input:focus, #searchForm select:focus {
      box-shadow: 0 0 0 2px #DDA15E, 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    #searchForm select {
      background-image: none;
    }
    
    #searchForm select option {
      color: #DDA15E;
      background-color: white;
    }
    
    /* Mejoras para el buscador en móviles */
    @media (max-width: 768px) {
      .bg-\[#FEFAE0\] {
        padding: 1rem;
      }
      
      #searchForm {
        gap: 0.75rem;
      }
      
      .flex-col.sm\\:flex-row {
        gap: 0.5rem;
      }
    }
    /* Clases de animación tomadas de home.php para mantener estética */
    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
    .animate-slide-up { animation: slideUp 0.8s ease-out; }
    .animate-bounce-subtle { animation: bounceSubtle 2s ease-in-out infinite; }
    .animate-scale-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .animate-scale-hover:hover { transform: scale(1.02); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
    .animate-text-glow { transition: text-shadow 0.3s ease; }
    .animate-text-glow:hover { text-shadow: 0 0 10px rgba(221, 161, 94, 0.5); }
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(50px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes bounceSubtle { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-5px); } }
  </style>
</head>
<body class="bg-gray-100">

<main class="p-4">
  <div class="max-w-[1400px] mx-auto">
    <h2 class="text-2xl font-bold mb-6" style="color: #DDA15E;">Viviendas en Venta</h2>
    
    <!-- Buscador (copiado de home.php con ids para mantener funcionalidad JS) -->
    <div class="w-full max-w-4xl mx-auto animate-slide-up stagger-1 mb-6">
      <form id="searchForm" action="#" method="GET" class="flex items-center rounded-full shadow-lg overflow-hidden animate-scale-hover" style="background-color: #FEFAE0;">
        <!-- Icono lupa + input de búsqueda -->
        <div class="flex items-center flex-1">
          <span class="pl-4 pr-2 text-lg animate-bounce-subtle">
            <svg class="w-5 h-5" style="filter: invert(47%) sepia(21%) saturate(1478%) hue-rotate(352deg) brightness(97%) contrast(85%);" fill="currentColor" viewBox="0 0 24 24">
              <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            </svg>
          </span>
          <input type="text" id="searchLocation" name="buscar" placeholder="Buscar por ubicación, precio, características..."
                 class="flex-1 py-3 focus:outline-none transition-all duration-300 focus:scale-105" style="color: #DDA15E; background-color: #FEFAE0;">
        </div>

        <!-- Filtros desplegables -->
        <div class="flex items-center gap-2 px-2">
          <!-- Filtro de precio -->
          <select id="precioMin" name="precio_min" class="py-2 px-3 rounded-full border-0 focus:outline-none text-sm" style="color: #DDA15E; background-color: #FEFAE0;">
            <option value="">Precio min</option>
            <option value="50000">$50,000</option>
            <option value="100000">$100,000</option>
            <option value="200000">$200,000</option>
            <option value="300000">$300,000</option>
          </select>
          
          <select id="precioMax" name="precio_max" class="py-2 px-3 rounded-full border-0 focus:outline-none text-sm" style="color: #DDA15E; background-color: #FEFAE0;">
            <option value="">Precio max</option>
            <option value="100000">$100,000</option>
            <option value="200000">$200,000</option>
            <option value="300000">$300,000</option>
            <option value="500000">$500,000</option>
          </select>

          <!-- Filtro de habitaciones -->
          <select id="habitaciones" name="habitaciones" class="py-2 px-3 rounded-full border-0 focus:outline-none text-sm" style="color: #DDA15E; background-color: #FEFAE0;">
            <option value="">Habitaciones</option>
            <option value="1">1+</option>
            <option value="2">2+</option>
            <option value="3">3+</option>
            <option value="4">4+</option>
          </select>
        </div>

        <!-- Botón de búsqueda -->
        <button type="submit" class="flex items-center gap-2 px-6 py-3 text-white font-medium transition-all duration-300 bg-[#DDA15E] hover:bg-[#BC8A4B] hover:scale-105 ml-2">
          <svg class="w-4 h-4" style="filter: brightness(0) invert(1);" fill="currentColor" viewBox="0 0 24 24">
            <path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
          </svg>
          <span class="text-sm font-semibold">BUSCAR</span>
        </button>
      </form>

      <!-- Botones rápidos eliminados en venta.php por solicitud -->
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-4 gap-6" id="propiedadesContainer">
      <?php foreach($propiedades as $p) { ?>
        <div onclick='openModal(<?php echo json_encode($p, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' 
             class="bg-white rounded-xl overflow-hidden shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl flex flex-col cursor-pointer">
          <?php if (!empty($p['imagen'])) { ?>
            <img src="/img/<?php echo $p['imagen']; ?>" alt="Imagen de la propiedad" class="w-full h-[200px] object-cover">
          <?php } else { ?>
            <div class="w-full h-[200px] bg-gray-300 flex items-center justify-center text-gray-500 italic">
              Sin imagen
            </div>
          <?php } ?>
          <div class="p-3 flex-1 flex flex-col justify-between" style="background-color: #5B674D; color: #FEFAE0;">
            <div>
              <p class="text-xl font-bold"><?php echo $p['precio']; ?></p>
              <p class="text-sm mb-1">Casa en Venta</p>
              <div class="flex space-x-2 text-sm mb-2">
                <span>🛏️ <?php echo $p['num_habitaciones']; ?></span>
                <span>🚿 <?php echo $p['num_banos']; ?></span>
                <span>📐 <?php echo $p['superficie_total']; ?> m²</span>
              </div>
              <p class="text-xs truncate"><?php echo $p['descripcion']; ?></p>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</main>

<!-- Modal -->
<div id="propertyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
  <div id="modalContent" class="bg-white rounded-xl max-w-6xl w-full max-h-[90vh] overflow-y-auto relative modal-enter">
    <!-- Botón de cerrar -->
    <button onclick="closeModal()" class="absolute top-4 right-4 text-[#DDA15E] hover:text-gray-700 text-3xl z-10 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg">&times;</button>
    
    <!-- Contenido del modal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-4 lg:p-8">
      <!-- Imagen -->
      <div class="order-1">
        <img id="modalImagen" src="" alt="Imagen propiedad" class="w-full h-[250px] sm:h-[300px] lg:h-[400px] object-cover rounded-lg">
      </div>
      
      <!-- Información de la propiedad -->
      <div class="order-2 flex flex-col justify-between">
        <div>
          <h2 id="modalTitulo" class="text-xl sm:text-2xl font-bold text-[#5B674D] mb-3"></h2>
          <p id="modalDireccion" class="text-sm text-gray-500 italic mb-3"></p>
          <div class="border border-[#DDA15E] rounded-lg p-3 mb-4 text-sm text-gray-700">
            <p id="modalDescripcion"></p>
          </div>
          <div class="border border-[#DDA15E] rounded-lg p-3 text-sm text-gray-700 space-y-1" id="modalCaracteristicas">
          </div>
        </div>
        
        <!-- Botón de contactar y lista de contactos -->
        <div class="mt-4">
          <button onclick="toggleContactos()" id="btnContactar"
              class="contact-btn w-full bg-[#5B674D] text-white px-4 py-2 rounded-md hover:bg-[#c6924f] transition">
              Contactar
          </button>
          
          <!-- Lista de contactos que se mostrará/ocultará -->
          <div id="contactos-lista" class="contactos-lista">
            <div class="text-center text-gray-600 text-sm">
              <div class="animate-spin inline-block w-4 h-4 border-2 border-[#5B674D] border-t-transparent rounded-full"></div>
              <span class="ml-2">Cargando contactos...</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let currentPropertyId = null;
let allProperties = <?php echo json_encode($propiedades); ?>;

// Función para filtrar propiedades
function filterProperties() {
  const searchTerm = document.getElementById('searchLocation').value.toLowerCase();
  const precioMin = parseInt(document.getElementById('precioMin').value) || 0;
  const precioMax = parseInt(document.getElementById('precioMax').value) || Infinity;
  const habitaciones = parseInt(document.getElementById('habitaciones').value) || 0;
  
  console.log('Filtrando con:', { searchTerm, precioMin, precioMax, habitaciones });
  console.log('Total propiedades:', allProperties.length);
  
  const filteredProperties = allProperties.filter(prop => {
    // Filtro por texto de búsqueda
    const matchesSearch = !searchTerm || 
      (prop.titulo && prop.titulo.toLowerCase().includes(searchTerm)) ||
      (prop.direccion && prop.direccion.toLowerCase().includes(searchTerm)) ||
      (prop.descripcion && prop.descripcion.toLowerCase().includes(searchTerm));
    
    // Filtro por precio - limpiar el precio de caracteres no numéricos
    let precio = 0;
    if (prop.precio) {
      // Remover $ y comas, convertir a número
      precio = parseFloat(prop.precio.toString().replace(/[$,]/g, '')) || 0;
    }
    const matchesPrice = precio >= precioMin && precio <= precioMax;
    
    // Filtro por habitaciones
    const habitacionesProp = parseInt(prop.num_habitaciones) || 0;
    const matchesRooms = habitaciones === 0 || habitacionesProp >= habitaciones;
    
    const matches = matchesSearch && matchesPrice && matchesRooms;
    console.log('Propiedad:', prop.titulo, 'matches:', matches, 'precio:', precio);
    
    return matches;
  });
  
  console.log('Propiedades filtradas:', filteredProperties.length);
  displayProperties(filteredProperties);
}

// Función para mostrar las propiedades filtradas
function displayProperties(properties) {
  const container = document.getElementById('propiedadesContainer');
  
  if (properties.length === 0) {
    container.innerHTML = `
      <div class="col-span-full text-center py-12">
        <div class="text-gray-500 text-lg mb-4">No se encontraron propiedades que coincidan con los criterios de búsqueda</div>
        <button onclick="clearFilters()" class="bg-[#DDA15E] text-white px-6 py-2 rounded-lg hover:bg-[#c6924f] transition">
          Limpiar filtros
        </button>
      </div>
    `;
    return;
  }
  
  // Crear el HTML de las propiedades
  let html = '';
  properties.forEach(prop => {
    const propJson = JSON.stringify(prop).replace(/"/g, '&quot;');
    html += `
      <div onclick='openModal(${propJson})' 
           class="bg-white rounded-xl overflow-hidden shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl flex flex-col cursor-pointer">
        ${prop.imagen ? 
          `<img src="/img/${prop.imagen}" alt="Imagen de la propiedad" class="w-full h-[200px] object-cover">` :
          `<div class="w-full h-[200px] bg-gray-300 flex items-center justify-center text-gray-500 italic">Sin imagen</div>`
        }
        <div class="p-3 flex-1 flex flex-col justify-between" style="background-color: #5B674D; color: #FEFAE0;">
          <div>
            <p class="text-xl font-bold">${prop.precio || 'Precio no disponible'}</p>
            <p class="text-sm mb-1">Casa en Venta</p>
            <div class="flex space-x-2 text-sm mb-2">
              <span>🛏️ ${prop.num_habitaciones || 'N/A'}</span>
              <span>🚿 ${prop.num_banos || 'N/A'}</span>
              <span>📐 ${prop.superficie_total || 'N/A'} m²</span>
            </div>
            <p class="text-xs truncate">${prop.descripcion || 'Sin descripción'}</p>
          </div>
        </div>
      </div>
    `;
  });
  
  container.innerHTML = html;
}

// Función para limpiar filtros
function clearFilters() {
  document.getElementById('searchLocation').value = '';
  document.getElementById('precioMin').value = '';
  document.getElementById('precioMax').value = '';
  document.getElementById('habitaciones').value = '';
  filterProperties(); // Usar filterProperties en lugar de displayProperties directamente
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
  // Inicializar mostrando todas las propiedades
  displayProperties(allProperties);
  
  // Formulario de búsqueda
  document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    filterProperties();
  });
  
  // Búsqueda en tiempo real
  document.getElementById('searchLocation').addEventListener('input', filterProperties);
  document.getElementById('precioMin').addEventListener('change', filterProperties);
  document.getElementById('precioMax').addEventListener('change', filterProperties);
  document.getElementById('habitaciones').addEventListener('change', filterProperties);
});

function openModal(prop) {
  // Guardar el ID de la propiedad actual
  currentPropertyId = prop.id;
  
  document.getElementById("modalImagen").src = prop.imagen ? "/img/" + prop.imagen : "";
  document.getElementById("modalTitulo").textContent = prop.titulo ?? "Casa en Venta";
  document.getElementById("modalDireccion").textContent = prop.direccion ?? "Dirección no disponible";
  document.getElementById("modalDescripcion").textContent = prop.descripcion ?? "Sin descripción";

  // Características básicas usando los campos que ya tienes
  const caracteristicas = [
    `🛏️ Habitaciones: ${prop.num_habitaciones ?? 'N/A'}`,
    `🚿 Baños: ${prop.num_banos ?? 'N/A'}`,
    `📐 Superficie: ${prop.superficie_total ?? 'N/A'} m²`,
  ];
  document.getElementById("modalCaracteristicas").innerHTML = caracteristicas.map(c => `<p>✔️ ${c}</p>`).join("");

  // Ocultar la lista de contactos al abrir el modal
  const contactosLista = document.getElementById("contactos-lista");
  contactosLista.style.display = "none";
  contactosLista.dataset.loaded = "false";

  const modal = document.getElementById("propertyModal");
  const modalContent = document.getElementById("modalContent");
  modal.classList.remove("hidden");
  modalContent.classList.remove("modal-exit", "modal-exit-active");
  modalContent.classList.add("modal-enter");
  setTimeout(() => modalContent.classList.add("modal-enter-active"), 10);
}

function closeModal() {
  const modal = document.getElementById("propertyModal");
  const modalContent = document.getElementById("modalContent");
  
  // Ocultar la lista de contactos cuando se cierre el modal
  const contactosLista = document.getElementById("contactos-lista");
  $(contactosLista).slideUp(200);
  
  // Limpiar el ID de la propiedad actual
  currentPropertyId = null;
  
  modalContent.classList.remove("modal-enter", "modal-enter-active");
  modalContent.classList.add("modal-exit");
  setTimeout(() => modalContent.classList.add("modal-exit-active"), 10);
  setTimeout(() => {
    modal.classList.add("hidden");
    modalContent.classList.remove("modal-exit", "modal-exit-active");
  }, 300);
}

// Función para alternar la lista de contactos con efecto slideToggle
function toggleContactos() {
  if (!currentPropertyId) {
    console.error('No hay ID de propiedad disponible');
    return;
  }
  
  const contactosDiv = document.getElementById('contactos-lista');
  
  // Si ya se cargaron los contactos, solo alternar la visibilidad
  if (contactosDiv.dataset.loaded === 'true') {
    $(contactosDiv).slideToggle(300);
    return;
  }
  
  // Si no se han cargado, cargar los contactos primero
  cargarContactos(currentPropertyId);
}

// Función para cargar los contactos de una propiedad
async function cargarContactos(propiedadId) {
  const contactosDiv = document.getElementById('contactos-lista');
  
  try {
    console.log('Cargando contactos para propiedad:', propiedadId);
    const response = await fetch(`/detalle-contacto?id=${propiedadId}&ajax=1`);
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    
    const data = await response.json();
    console.log('Datos recibidos:', data);
    
    if (data.error) {
      contactosDiv.innerHTML = `<div class="text-red-500 text-center p-4">
        <strong>Error:</strong> ${data.error}
        <br><small>ID de propiedad: ${propiedadId}</small>
      </div>`;
    } else {
      let html = '';
      
      // Mostrar información de debug si está disponible
      if (data.debug) {
        console.log('Debug info:', data.debug);
      }
      
      // Mostrar contactos principales primero
      if (data.principales && data.principales.length > 0) {
        data.principales.forEach(contacto => {
          html += crearItemContacto(contacto, true);
        });
      }
      
      // Luego mostrar contactos secundarios
      if (data.secundarios && data.secundarios.length > 0) {
        data.secundarios.forEach(contacto => {
          html += crearItemContacto(contacto, false);
        });
      }
      
      if (html === '') {
        html = '<div class="text-gray-500 text-center p-4">No hay contactos disponibles para esta propiedad</div>';
      }
      
      contactosDiv.innerHTML = html;
      contactosDiv.dataset.loaded = 'true';
    }
    
    // Mostrar la lista con efecto slideToggle
    $(contactosDiv).slideDown(300);
    
  } catch (error) {
    console.error('Error al cargar contactos:', error);
    contactosDiv.innerHTML = `<div class="text-red-500 text-center p-4">
      <strong>Error al cargar los contactos</strong>
      <br><small>${error.message}</small>
      <br><small>ID de propiedad: ${propiedadId}</small>
    </div>`;
    $(contactosDiv).slideDown(300);
  }
}

// Función para crear un elemento de contacto
function crearItemContacto(contacto, esPrincipal) {
  const iconos = {
    'email': '📧',
    'telefono': '📞',
    'whatsapp': '📱',
    'facebook': '📘',
    'instagram': '📷'
  };
  
  const icono = iconos[contacto.tipo_contacto] || '📞';
  const clasePrincipal = esPrincipal ? 'contacto-principal' : '';
  const etiquetaPrincipal = esPrincipal ? ' (Principal)' : '';
  
  let enlace = '';
  if (contacto.tipo_contacto === 'email') {
    enlace = `href="mailto:${contacto.valor}"`;
  } else if (contacto.tipo_contacto === 'telefono' || contacto.tipo_contacto === 'whatsapp') {
    enlace = `href="tel:${contacto.valor}"`;
  } else {
    enlace = `href="${contacto.valor}" target="_blank"`;
  }
  
  return `
    <div class="contacto-item ${clasePrincipal}">
      <span class="contacto-icon">${icono}</span>
      <div class="contacto-info">
        <div class="contacto-tipo">${contacto.tipo_contacto.charAt(0).toUpperCase() + contacto.tipo_contacto.slice(1)}${etiquetaPrincipal}</div>
        <a ${enlace} class="contacto-valor">${contacto.valor}</a>
      </div>
    </div>
  `;
}
</script>

</body>
</html>