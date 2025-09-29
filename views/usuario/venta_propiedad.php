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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gray-100">

<main class="p-4">
  <div class="max-w-[1400px] mx-auto">
    <h2 class="text-2xl font-bold mb-4" style="color: #DDA15E;">Viviendas en Venta</h2>
    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-4 gap-6">
      <?php foreach($propiedades as $p) { ?>
        <div class="bg-white rounded-xl overflow-hidden shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl flex flex-col cursor-pointer">
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

</body>
</html>
