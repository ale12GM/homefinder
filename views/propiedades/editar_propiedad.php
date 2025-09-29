<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Propiedad</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #FEFAE0; }
  </style>
</head>
<body class="text-gray-800">

<main class="container mx-auto my-12 px-4 max-w-3xl">
  <div class="bg-white p-6 rounded-2xl shadow-md">
    
    <h1 class="text-xl font-semibold mb-4">Editar Propiedad</h1>
    <p class="text-sm text-gray-500 mb-6">Modifica los datos de tu propiedad y guarda los cambios.</p>

    <form method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
        <label for="titulo">Título</label>
        <input type="text" name="propiedades[titulo]" placeholder="Título" 
               value="<?php echo htmlspecialchars($propiedades->titulo, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">
        
        <label for="direccion">Dirección</label>
        <input type="text" name="propiedades[direccion]" placeholder="Dirección" 
               value="<?php echo htmlspecialchars($propiedades->direccion, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">

        <label for="superficie">Superficie</label>
        <input type="number" name="propiedades[superficie_total]" placeholder="Superficie" 
               value="<?php echo htmlspecialchars($propiedades->superficie_total, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">

        

        
        <label for="numero_habitaciones">Número de habitaciones</label>
        <input type="number" name="propiedades[num_habitaciones]" placeholder="Habitaciones" 
               value="<?php echo htmlspecialchars($propiedades->num_habitaciones, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">

        <label for="numero_banos">Número de baños</label>
        <input type="number" name="propiedades[num_banos]" placeholder="Baños" 
               value="<?php echo htmlspecialchars($propiedades->num_banos, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">

        <label for="Latitud">Latitud</label>
        <input type="number" name="propiedades[latitud]" placeholder="Latitud" 
               value="<?php echo htmlspecialchars($propiedades->latitud, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">

        <label for="longitud">Longitud</label>
        <input type="number" name="propiedades[longitud]" placeholder="Longitud" 
               value="<?php echo htmlspecialchars($propiedades->longitud, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">

        <label for="precio">Precio</label>
        <input type="number" name="propiedades[precio]" placeholder="Precio" 
               value="<?php echo htmlspecialchars($propiedades->precio, ENT_QUOTES); ?>" 
               class="border p-2 w-full rounded text-gray-400">

        <div>
          <label class="block text-sm font-medium text-gray-700">Etiquetas:</label>
          <select name="etiquetas" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-[#5B674D] focus:border-[#5B674D]" required>
            <?php foreach($etiquetas as $e): ?>
              <option value="<?php echo $e['id']; ?>"><?php echo $e['nombre']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <label for="descripcion">Descripción</label>
        <textarea name="propiedades[descripcion]" placeholder="Descripción" 
                  class="border p-2 w-full rounded text-gray-400"><?php echo htmlspecialchars($propiedades->descripcion, ENT_QUOTES); ?></textarea>
        <input type="file" name="propiedades[imagen]" class="mb-2">

        <!-- Fecha de actualización -->
        <input type="hidden" name="propiedades[fecha_actualizacion]" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <div class="flex justify-between mt-4">
            <a href="<?php echo $volver; ?>" 
               class="px-4 py-2 rounded-full bg-gray-300 hover:bg-gray-400">Cancelar</a>
            <button type="submit" 
               class="px-4 py-2 rounded-full bg-[#535E46] text-white hover:bg-[#3f4736]">Guardar</button>
        </div>
    </form>

  </div>
</main>

</body>
</html>
