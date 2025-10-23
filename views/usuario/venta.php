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
    .modal-enter { opacity: 0; transform: translateY(-20px); }
    .modal-enter-active { opacity: 1; transform: translateY(0); transition: all 0.3s ease-out; }
    .modal-exit { opacity: 1; transform: translateY(0); }
    .modal-exit-active { opacity: 0; transform: translateY(-20px); transition: all 0.3s ease-in; }
  </style>
</head> 
<body class="bg-gray-100">

<main class="p-4">
  <div class="max-w-[1400px] mx-auto">
    <h2 class="text-2xl font-bold mb-4" style="color: #DDA15E;">Viviendas en Venta</h2>
    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-4 gap-6">
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
<div id="propertyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div id="modalContent" class="bg-white rounded-xl max-w-5xl w-full p-16 relative grid grid-cols-1 md:grid-cols-2 gap-6 modal-enter">
    <button onclick="closeModal()" class="absolute top-3 right-3 text-[#DDA15E] hover:text-gray-700 text-3xl">&times;</button>
    <img id="modalImagen" src="" alt="Imagen propiedad" class="w-full h-[350px] object-cover rounded-lg">
    <div class="flex flex-col justify-between">
      <div>
        <h2 id="modalTitulo" class="text-2xl font-bold text-[#5B674D] mb-3"></h2>
        <p id="modalDireccion" class="text-sm text-gray-500 italic mb-3"></p>
        <div class="border border-[#DDA15E] rounded-lg p-3 mb-4 text-sm text-gray-700">
          <p id="modalDescripcion"></p>
        </div>
        <div class="border border-[#DDA15E] rounded-lg p-3 text-sm text-gray-700 space-y-1" id="modalCaracteristicas">
        </div>
      </div>
      <a href="/detalle-contacto?id=<?php echo $p['id']; ?>"
          class="mt-4 inline-block text-center bg-[#5B674D] text-white px-4 py-2 rounded-md hover:bg-[#c6924f] transition">
          Contactar
      </a>
    </div>
  </div>
</div>

<script>
function openModal(prop) {
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
  modalContent.classList.remove("modal-enter", "modal-enter-active");
  modalContent.classList.add("modal-exit");
  setTimeout(() => modalContent.classList.add("modal-exit-active"), 10);
  setTimeout(() => {
    modal.classList.add("hidden");
    modalContent.classList.remove("modal-exit", "modal-exit-active");
  }, 300);
}
</script>

</body>
</html>