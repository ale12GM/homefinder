
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
        <h1 class="text-xl font-semibold">Mis propiedades</h1><br>
        <p class="text-sm text-gray-500">Maneja a tus propiedades y edita o eliminalas</p>
      </div>

      <!-- Barra superior -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <p class="text-sm">
          <span class="font-semibold">Todas las propiedades</span> 
          <span class="text-gray-400 ml-2"><?php echo count($propiedades)?></span>
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

      <!-- Tabla -->
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
          <thead class="border-b border-[#E2E4E0] text-[#535E46]">
            <tr>
              <th class="py-2 px-3"></th>
              <th class="py-2 px-3">Título</th>
              <th class="py-2 px-3">Descripción</th>
              <th class="py-2 px-3">Precio</th>
              <th class="py-2 px-3">Denuncias</th>
              <th class="py-2 px-3">Acciones</th>
            </tr>
          </thead>
          <?php foreach($propiedades as $p): ?>
          <tbody class="divide-y divide-[#E2E4E0]">
            <tr>
              <td class="px-3 py-2"><input type="checkbox" class="accent-[#535E46]"></td>
              <td class="px-3 py-2"><?php echo $p['titulo'] ?></td>
              <td class="px-3 py-2"><?php echo $p['descripcion']; ?></td>
              <td class="px-3 py-2 font-medium"><?php echo round($p['precio']   )?></td>
              <td class="px-3 py-2">10</td>
              <td class="px-3 py-2 flex items-center gap-2">
                <button class="flex items-center gap-1 text-[#535E46] hover:underline">
                  👁 Ver Detalle
                </button>
                <button class="ml-auto">⋮</button>
              </td>
            </tr>                    
          </tbody>
          <?php endforeach;?>
        </table>
      </div>

      <!-- Paginación -->
      <div class="flex justify-center mt-4 space-x-2">
        <button class="w-8 h-8 flex items-center justify-center rounded-full bg-[#535E46] text-white">1</button>
        
      </div>

    </div>
  </main>

</body>
</html>
