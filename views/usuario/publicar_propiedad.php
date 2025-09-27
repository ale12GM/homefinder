<?php
session_start();
// Variables de error inicializadas vacías
$error_titulo        = "";
$error_n_catastral   = "";
$error_direccion     = "";
$error_superficie    = "";
$error_latitud       = "";
$error_longitud      = "";
$error_habitaciones  = "";
$error_banos         = "";
$error_precio        = "";
$error_descripcion   = "";
$error_estado        = "";
$error_imagen        = "";
$error_etiquetas     = "";

// Inicializar variables de formulario
$id_usuario    = $_POST['propiedades']['id_usuario'] ?? 0; 
$titulo        = trim($_POST['propiedades']['titulo'] ?? '');
$n_catastral   = trim($_POST['n_catastral'] ?? ''); // este no va a la BD
$direccion     = trim($_POST['propiedades']['direccion'] ?? '');
$superficie    = trim($_POST['propiedades']['superficie_total'] ?? '');
$latitud       = trim($_POST['propiedades']['latitud'] ?? '');
$longitud      = trim($_POST['propiedades']['longitud'] ?? '');
$habitaciones  = $_POST['propiedades']['num_habitaciones'] ?? null;
$banos         = $_POST['propiedades']['num_banos'] ?? null;
$precio        = trim($_POST['propiedades']['precio'] ?? '');
$descripcion   = trim($_POST['descripcion'] ?? '');
$estado        = trim($_POST['propiedades']['estado'] ?? ''); 
$etiqueta_id   = $_POST['etiquetas'] ?? null;  
$imagen_file   = $_FILES['imagen'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- Validaciones obligatorias ---

    // Título
    if ($titulo === '') {
        $error_titulo = "El título es obligatorio.";
    } elseif (mb_strlen($titulo) > 50) {
        $error_titulo = "El título no puede exceder 50 caracteres.";
    }

    // Nº Catastral (opcional, solo longitud)
    if ($n_catastral === '') {
    $error_n_catastral = "El Nº Catastral es obligatorio.";
} elseif (mb_strlen($n_catastral) > 100) {
    $error_n_catastral = "Número catastral muy largo.";
}
    // Dirección
    if ($direccion === '') {
        $error_direccion = "La dirección es obligatoria.";
    } elseif (mb_strlen($direccion) > 255) {
        $error_direccion = "La dirección no puede exceder 255 caracteres.";
    }

    // Superficie
    if ($superficie === '') {
        $error_superficie = "La superficie es obligatoria.";
    } elseif (!is_numeric($superficie)) {
        $error_superficie = "La superficie debe ser un número.";
    } else {
        $superficie = number_format((float)$superficie, 2, '.', '');
    }

    // Latitud
    if ($latitud !== '') {
        if (!is_numeric($latitud)) {
            $error_latitud = "La latitud debe ser numérica.";
        } else {
            $latitud = number_format((float)$latitud, 6, '.', '');
        }
    }

    // Longitud
    if ($longitud !== '') {
        if (!is_numeric($longitud)) {
            $error_longitud = "La longitud debe ser numérica.";
        } else {
            $longitud = number_format((float)$longitud, 6, '.', '');
        }
    }

    // Habitaciones
    if ($habitaciones !== null && $habitaciones !== '') {
        if (filter_var($habitaciones, FILTER_VALIDATE_INT) === false || (int)$habitaciones < 0) {
            $error_habitaciones = "Número de habitaciones inválido.";
        } else {
            $habitaciones = (int)$habitaciones;
        }
    } else {
        $habitaciones = null;
    }

    // Baños
    if ($banos !== null && $banos !== '') {
        if (filter_var($banos, FILTER_VALIDATE_INT) === false || (int)$banos < 0) {
            $error_banos = "Número de baños inválido.";
        } else {
            $banos = (int)$banos;
        }
    } else {
        $banos = null;
    }

    // Precio
    if ($precio === '') {
        $error_precio = "El precio es obligatorio.";
    } elseif (!is_numeric($precio)) {
        $error_precio = "El precio debe ser un número.";
    } else {
        $precio = number_format((float)$precio, 2, '.', '');
    }

    // Descripción
    if ($descripcion === '') {
        $error_descripcion = "La descripción es obligatoria.";
    } elseif (mb_strlen($descripcion) > 500) {
        $error_descripcion = "La descripción no puede exceder 500 caracteres.";
    }

    // Estado (opcional)
    if ($estado !== '' && mb_strlen($estado) > 15) {
        $error_estado = "El estado no puede exceder 15 caracteres.";
    }

    // Etiquetas (opcional)
    if ($etiqueta_id !== null && $etiqueta_id !== '') {
        if (!ctype_digit(strval($etiqueta_id))) {
            $error_etiquetas = "Etiqueta inválida.";
        }
    } else {
        $etiqueta_id = null;
    }

    // Imagen (obligatoria)
    if (!$imagen_file || $imagen_file['error'] !== UPLOAD_ERR_OK) {
        $error_imagen = "Debes subir una imagen.";
    } 
}
?>


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

      <!-- Primera fila: Título y Nº Catastral -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Título:</label>
          <input type="text" name="propiedades[titulo]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required />
        </div>
  <?php if (!empty($error_titulo)): ?>
    <p class="text-red-500 text-sm mt-1"><?php echo $error_titulo; ?></p>
  <?php endif; ?>        
      <div>
          <label class="block text-sm font-medium text-gray-700">Nº Catastral:</label>
          <input type="text" name="n_catastral" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required />
        </div>
      </div>

      <!-- Dirección y Superficie -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Dirección:</label>
          <input type="text" name="propiedades[direccion]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required />
        </div>
        
        <?php if (!empty($error_direccion)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_direccion; ?></p>
        <?php endif; ?> 
        <div>
          <label class="block text-sm font-medium text-gray-700">Superficie:</label>
          <input type="text" name="propiedades[superficie_total]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required />
        </div>
        <?php if (!empty($error_superficie)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_superficie; ?></p>
        <?php endif; ?> 
      </div>

      <!-- Latitud y Longitud -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Latitud:</label>
          <input type="text" name="propiedades[latitud]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" />
        </div>
        <?php if (!empty($error_latitud)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_latitud; ?></p>
        <?php endif; ?> 
        <div>
          <label class="block text-sm font-medium text-gray-700">Longitud:</label>
          <input type="text" name="propiedades[longitud]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" />
        </div>
      </div>
      <?php if (!empty($error_longitud)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_longitud; ?></p>
        <?php endif; ?> 

      <!-- Habitaciones y Baños -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Número de Habitaciones:</label>
          <input type="number" name="propiedades[num_habitaciones]" min="0" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" />
        </div>
        <?php if (!empty($error_habitaciones)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_latitud; ?></p>
        <?php endif; ?> 
        <div>
          <label class="block text-sm font-medium text-gray-700">Número de Baños:</label>
          <input type="number" name="propiedades[num_banos]" min="0" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" />
        </div>
        <?php if (!empty($error_banos)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_banos; ?></p>
        <?php endif; ?> 
      </div>

      <!-- Precio y Etiquetas -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Precio:</label>
          <input type="text" name="propiedades[precio]" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required />
        </div>
        <?php if (!empty($error_precio)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_precio; ?></p>
        <?php endif; ?> 
        <div>
          <label class="block text-sm font-medium text-gray-700">Etiquetas:</label>
          <select name="etiquetas" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required>
            
            <?php foreach($etiquetas as $e): ?>
              <option value="<?php echo $e['id']; ?>"><?php echo $e['nombre']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <?php if (!empty($error_etiquetas)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_etiquetas; ?></p>
        <?php endif; ?> 
      </div>

      <!-- Descripción -->
      <div>
        <label class="block text-sm font-medium text-gray-700">Descripción:</label>
        <textarea name="propiedades[descripcion]" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required></textarea>
      </div>
        <?php if (!empty($error_descripcion)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_descripcion; ?></p>
        <?php endif; ?> 
      <!-- Imagen -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Imagen:</label>
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center text-gray-400">
          <p class="mb-2">Arrastra y suelta las fotos aquí</p>
          <p class="text-xs mb-3">o haz clic para seleccionar archivos</p>
          <input type="file" name="propiedades[imagen]" class="hidden" id="fileInput">
          <button type="button" onclick="document.getElementById('fileInput').click()" class="bg-[#DDA15E] text-white px-4 py-2 rounded-md text-sm">Seleccionar una imagen</button>
        </div>
      </div>
      <?php if (!empty($error_imagen)): ?>
          <p class="text-red-500 text-sm mt-1"><?php echo $error_imagen; ?></p>
      <?php endif; ?> 

      <!-- Botón -->
      <div class="mt-4">
        <button type="submit" class="w-full bg-[#5B674D] text-[#FEFAE0] py-3 rounded-md font-semibold hover:bg-[#4c563d] transition">Publicar Propiedad</button>
      </div>

    </form>
  </div>
</div>
</body>
</html>