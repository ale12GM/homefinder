<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publicar Propiedad</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
    /* Animaciones y utilidades estéticas */
    @keyframes bounce-soft {
      0% { transform: translateY(0); }
      30% { transform: translateY(-6px); }
      50% { transform: translateY(0); }
      70% { transform: translateY(-3px); }
      100% { transform: translateY(0); }
    }

    @keyframes fade-up {
      from { opacity: 0; transform: translateY(6px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .anim-bounce {
      animation: bounce-soft 520ms ease;
    }

    .fade-up {
      animation: fade-up 420ms ease both;
    }

    /* botón con micro-interacciones */
    .btn-modern {
      transition: transform 160ms cubic-bezier(.2,.8,.2,1), box-shadow 160ms ease, background-color 120ms ease;
    }
    .btn-modern:hover { transform: translateY(-3px) scale(1.01); box-shadow: 0 8px 20px rgba(11,15,16,0.06); }
    .btn-modern:active { transform: translateY(0) scale(0.995); }

    /* inputs con leve sombreado al focus */
    .input-glow:focus {
      box-shadow: 0 8px 18px rgba(91,103,77,0.08), inset 0 0 0 1px rgba(91,103,77,0.06);
      outline: none;
      transform: translateY(-1px);
    }

    /* animación sutil para la aparición de inputs */
    @keyframes input-fade {
      from { opacity: 0; transform: translateY(8px) scale(0.995); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .input-fade {
      animation: input-fade 360ms cubic-bezier(.2,.9,.3,1) both;
    }

    /* etiqueta checkbox/card hover */
    .tag-card { transition: transform 180ms ease, box-shadow 180ms ease, background-color 180ms ease; }
    .tag-card:hover { transform: translateY(-4px); box-shadow: 0 10px 24px rgba(15,23,42,0.06); background-color: #fffaf2; }

    /* pequeña transición para los bloques de contacto */
    .contacto-item { transition: transform 220ms ease, box-shadow 220ms ease; }
    .contacto-item:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(15,23,42,0.06); }
    /* dropzone imagen */
    .dropzone {
      border-radius: 12px;
      transition: box-shadow 180ms ease, transform 180ms ease, background-color 160ms ease;
      background-color: rgba(255,255,255,0.6);
      display: flex; align-items: center; justify-content: center; flex-direction: column;
    }
    .dropzone:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(11,15,16,0.05); }
    .dropzone-active {
      box-shadow: 0 18px 46px rgba(91,103,77,0.12) !important;
      background: linear-gradient(180deg, rgba(255,250,236,0.9), rgba(255,255,255,0.95));
      border-color: rgba(91,103,77,0.25) !important;
    }
    @keyframes pulse-soft {
      0% { transform: scale(1); }
      50% { transform: scale(1.02); }
      100% { transform: scale(1); }
    }
    .pulse-once { animation: pulse-soft 420ms ease both; }
    #previewContainer img { max-width: 220px; border-radius: 8px; box-shadow: 0 8px 20px rgba(15,23,42,0.06); }
  </style>
</head>
<body class="bg-gray-100">
<div class="py-[50px]">
  <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-xl font-semibold text-[#DDA15E] mb-6">Tu Espacio de Publicación</h2>
    
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="propiedades[id_usuario]" value="<?php echo $_SESSION['id'] ?? 0; ?>">
      <input type="hidden" name="propiedades[fecha_publicacion]" value="<?php echo date('Y-m-d H:i:s'); ?>">
      <input type="hidden" name="propiedades[fecha_actualizacion]" value="">
      <input type="hidden" name="propiedades[estado]" value="activo">

      <!-- Título -->
      <div class="fade-up">
        <label class="block text-sm font-medium text-gray-700">Título:</label>
  <input type="text" name="propiedades[titulo]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade" required />
        <?php if (!empty($error_titulo)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_titulo; ?></p>
        <?php endif; ?>
      </div>

      <!-- Dirección y Superficie -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Dirección:</label>
          <input type="text" name="propiedades[direccion]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade" required />
          <?php if (!empty($error_direccion)): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $error_direccion; ?></p>
          <?php endif; ?>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Superficie:</label>
          <input type="text" name="propiedades[superficie_total]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade" required />
          <?php if (!empty($error_superficie)): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $error_superficie; ?></p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Hidden fields for latitud and longitud (set to null) -->
      <input type="hidden" name="propiedades[latitud]" value="">
      <input type="hidden" name="propiedades[longitud]" value=""> 

      <!-- Habitaciones y Baños -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Número de Habitaciones:</label>
          <input type="number" name="propiedades[num_habitaciones]" min="0" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade" />
          <?php if (!empty($error_habitaciones)): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $error_habitaciones; ?></p>
          <?php endif; ?>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Número de Baños:</label>
          <input type="number" name="propiedades[num_banos]" min="0" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade" />
          <?php if (!empty($error_banos)): ?>
            <p class="text-red-500 text-sm mt-1"><?php echo $error_banos; ?></p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Precio -->
      <div>
  <label class="block text-sm font-medium text-gray-700">Precio:</label>
  <input type="text" name="propiedades[precio]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade" required />
        <?php if (!empty($error_precio)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_precio; ?></p>
        <?php endif; ?>
      </div>

      <!-- Etiquetas (Checkboxes) -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">Etiquetas:</label>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
          <?php foreach($etiquetas as $e): ?>
            <label class="flex items-center space-x-2 p-2 border border-gray-300 rounded-md hover:bg-gray-50 cursor-pointer tag-card">
              <input type="checkbox" name="etiquetas[]" value="<?php echo $e['id']; ?>" class="rounded border-gray-300 text-[#5B674D] focus:ring-[#5B674D]">
              <span class="text-sm text-gray-700"><?php echo $e['nombre']; ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <?php if (!empty($error_etiquetas)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_etiquetas; ?></p>
        <?php endif; ?>
      </div>

      <!-- Contactos -->
      <div>
        <div class="flex justify-between items-center mb-3 fade-up">
          <label class="block text-sm font-medium text-gray-700">Contactos:</label>
          <button type="button" id="agregarContacto" class="bg-[#5B674D] text-white px-3 py-1 rounded-md text-sm hover:bg-[#4c563d] transition btn-modern">
            + Agregar Contacto
          </button>
        </div>
        <div id="contactosContainer" class="space-y-3">
          <!-- Contacto inicial -->
          <div class="contacto-item border border-gray-300 rounded-md p-4 bg-gray-50">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Contacto:</label>
                <select name="contactos[0][tipo_contacto]" class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade">
                  <option value="">Seleccionar tipo</option>
                  <option value="telefono">Teléfono</option>
                  <option value="email">Email</option>
                  <option value="whatsapp">WhatsApp</option>
                  <option value="facebook">Facebook</option>
                  <option value="instagram">Instagram</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Valor:</label>
                <input type="text" name="contactos[0][valor]" placeholder="Número o email" class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade">
              </div>
              <div class="flex items-end">
                <label class="flex items-center space-x-2">
                  <input type="checkbox" name="contactos[0][es_principal]" value="1" class="rounded border-gray-300 text-[#5B674D] focus:ring-[#5B674D]">
                  <span class="text-sm text-gray-700">Principal</span>
                </label>
                <button type="button" class="eliminarContacto ml-auto bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition btn-modern" style="display: none;">
                  Eliminar-
                </button>
              </div>
            </div>
          </div>
        </div>
        <?php if (!empty($error_contactos)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_contactos; ?></p>
        <?php endif; ?>
      </div>

      <!-- Descripción -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Descripción:</label>
  <textarea name="propiedades[descripcion]" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D] input-glow input-fade" required></textarea>
        <?php if (!empty($error_descripcion)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_descripcion; ?></p>
        <?php endif; ?>
      </div> 
      <!-- Imagen -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Imagen:</label>
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-gray-400">
          <p class="mb-2">Arrastra y suelta las fotos aquí</p>
          <p class="text-xs mb-3">o haz clic para seleccionar archivos</p>
          <div class="w-full dropzone" id="imageDropzone" style="min-height:120px;">
            <input type="file" name="propiedades[imagen]" class="hidden" id="fileInput" accept="image/*">
            <button type="button" onclick="document.getElementById('fileInput').click()" class="bg-[#DDA15E] text-white px-4 py-2 rounded-md text-sm btn-modern" id="btnSelectImage">Seleccionar una imagen</button>
            <div id="previewContainer" class="mt-3"></div>
          </div>
        </div>
        <?php if (!empty($error_imagen)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_imagen; ?></p>
        <?php endif; ?>
      </div> 

      <!-- Botón -->
      <div class="mt-4">
        <button type="submit" class="w-full bg-[#5B674D] text-[#FEFAE0] py-3 rounded-md font-semibold hover:bg-[#4c563d] transition btn-modern" id="btnSubmit">Publicar Propiedad</button>
      </div>

    </form>
  </div>
</div>

<script>
let contactoIndex = 1;

document.getElementById('agregarContacto').addEventListener('click', function() {
    const container = document.getElementById('contactosContainer');
    const nuevoContacto = document.createElement('div');
    nuevoContacto.className = 'contacto-item border border-gray-300 rounded-md p-4 bg-gray-50';
    nuevoContacto.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Contacto:</label>
                <select name="contactos[${contactoIndex}][tipo_contacto]" class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]">
                    <option value="">Seleccionar tipo</option>
                    <option value="telefono">Teléfono</option>
                    <option value="email">Email</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="facebook">Facebook</option>
                    <option value="instagram">Instagram</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Valor:</label>
                <input type="text" name="contactos[${contactoIndex}][valor]" placeholder="Número o email" class="w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]">
            </div>
            <div class="flex items-end">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="contactos[${contactoIndex}][es_principal]" value="1" class="rounded border-gray-300 text-[#5B674D] focus:ring-[#5B674D]">
                    <span class="text-sm text-gray-700">Principal</span>
                </label>
                <button type="button" class="eliminarContacto ml-auto bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600 transition">
                    Eliminar
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(nuevoContacto);
    contactoIndex++;
    
    // Mostrar botones eliminar en todos los contactos si hay más de uno
    actualizarBotonesEliminar();
});

// Función para actualizar la visibilidad de los botones eliminar
function actualizarBotonesEliminar() {
    const contactos = document.querySelectorAll('.contacto-item');
    contactos.forEach((contacto, index) => {
        const botonEliminar = contacto.querySelector('.eliminarContacto');
        if (contactos.length > 1) {
            botonEliminar.style.display = 'block';
        } else {
            botonEliminar.style.display = 'none';
        }
    });
}

// Event delegation para botones eliminar
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('eliminarContacto')) {
        e.target.closest('.contacto-item').remove();
        actualizarBotonesEliminar();
    }
});

// Validación de checkbox principal (solo uno puede ser principal)
document.addEventListener('change', function(e) {
    if (e.target.name && e.target.name.includes('[es_principal]')) {
        const contactos = document.querySelectorAll('input[name*="[es_principal]"]');
        contactos.forEach(checkbox => {
            if (checkbox !== e.target && e.target.checked) {
                checkbox.checked = false;
            }
        });
    }
});

// --- Animaciones JS (bounce al click y pequeñas entradas) ---
// Añade anim-bounce temporalmente a un elemento cuando se clickea
function triggerBounce(el) {
  if (!el) return;
  el.classList.remove('anim-bounce');
  // Force reflow para reiniciar la animación
  void el.offsetWidth;
  el.classList.add('anim-bounce');
  // Eliminar la clase después de la duración para evitar acumulación
  setTimeout(() => el.classList.remove('anim-bounce'), 600);
}

// Delegación para todos los botones con la clase btn-modern
document.addEventListener('click', function(e) {
  const btn = e.target.closest && e.target.closest('button');
  if (!btn) return;
  if (btn.classList.contains('btn-modern') || btn.id === 'btnSubmit' || btn.id === 'btnSelectImage' || btn.id === 'agregarContacto') {
    triggerBounce(btn);
  }
});

// Aplicar fade-up a los campos importantes al cargar
window.addEventListener('DOMContentLoaded', function() {
  const toFade = document.querySelectorAll('.fade-up');
  toFade.forEach((el, i) => {
    el.style.animationDelay = (i * 60) + 'ms';
  });
});

// Asegurar que los contactos añadidos dinámicamente tengan input-glow y btn-modern en botones internos
const originalAgregar = document.getElementById('agregarContacto');
if (originalAgregar) {
  // ya tiene btn-modern; nada más a hacer aquí
}

// Al insertar nuevo contacto, aseguramos aplicar las clases a los elementos recién creados
const observer = new MutationObserver(mutations => {
  for (const m of mutations) {
    for (const node of m.addedNodes) {
      if (node.nodeType === 1) {
        // inputs y selects/textarea: aplicar glow y animación de entrada
        node.querySelectorAll('input, select, textarea').forEach(i => {
          i.classList.add('input-glow');
          i.classList.add('input-fade');
          // añadir listener para bounce al focus/click
          i.addEventListener('focus', () => triggerBounce(i));
          i.addEventListener('click', () => triggerBounce(i));
        });
        // botones eliminar y otros botones internos
        node.querySelectorAll('button').forEach(b => b.classList.add('btn-modern'));
      }
    }
  }
});
const contactosContainer = document.getElementById('contactosContainer');
if (contactosContainer) observer.observe(contactosContainer, { childList: true });

// Dropzone: drag & drop y previsualización
const dropzone = document.getElementById('imageDropzone');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');

if (dropzone && fileInput) {
  ['dragenter','dragover'].forEach(evt => {
    dropzone.addEventListener(evt, e => {
      e.preventDefault(); e.stopPropagation();
      dropzone.classList.add('dropzone-active');
    });
  });
  ['dragleave','drop'].forEach(evt => {
    dropzone.addEventListener(evt, e => {
      e.preventDefault(); e.stopPropagation();
      dropzone.classList.remove('dropzone-active');
    });
  });

  dropzone.addEventListener('drop', e => {
    const dt = e.dataTransfer;
    if (dt && dt.files && dt.files.length) {
      fileInput.files = dt.files;
      handleFileSelect(fileInput.files[0]);
    }
  });

  fileInput.addEventListener('change', () => {
    if (fileInput.files && fileInput.files[0]) {
      // pulso y previsualización
      dropzone.classList.add('pulse-once');
      setTimeout(() => dropzone.classList.remove('pulse-once'), 600);
      handleFileSelect(fileInput.files[0]);
    }
  });
}

function handleFileSelect(file) {
  if (!file) return;
  if (!file.type.startsWith('image/')) return;
  const reader = new FileReader();
  reader.onload = function(ev) {
    previewContainer.innerHTML = '';
    const img = document.createElement('img');
    img.src = ev.target.result;
    previewContainer.appendChild(img);
  };
  reader.readAsDataURL(file);
}

// Añadir bounce a inputs existentes (text, number, textarea, select)
document.querySelectorAll('input, textarea, select').forEach(i => {
  // evitar añadir al tipo file (ya tiene otras animaciones)
  if (i.type === 'file') return;
  i.addEventListener('focus', () => triggerBounce(i));
  i.addEventListener('click', () => triggerBounce(i));
});

</script>

</body>
</html>