<?php 

// Función para crear un elemento de contacto
function crearItemContacto($contacto, $esPrincipal) {
    $iconos = [
        'email' => '📧',
        'telefono' => '📞',
        'whatsapp' => '📱',
        'facebook' => '📘',
        'instagram' => '📷'
    ];
    
    $icono = $iconos[$contacto['tipo_contacto']] ?? '📞';
    $clasePrincipal = $esPrincipal ? 'bg-green-50 border-l-4 border-[#5B674D] pl-4' : 'bg-gray-50';
    $etiquetaPrincipal = $esPrincipal ? ' (Principal)' : '';
    
    $enlace = '';
    if ($contacto['tipo_contacto'] === 'email') {
        $enlace = 'href="mailto:' . htmlspecialchars($contacto['valor']) . '"';
    } else if ($contacto['tipo_contacto'] === 'telefono' || $contacto['tipo_contacto'] === 'whatsapp') {
        $enlace = 'href="tel:' . htmlspecialchars($contacto['valor']) . '"';
    } else {
        $enlace = 'href="' . htmlspecialchars($contacto['valor']) . '" target="_blank"';
    }
    
    return '
        <div class="flex items-center space-x-3 p-3 rounded-lg border border-[#DDA15E] ' . $clasePrincipal . '">
            <span class="text-xl">' . $icono . '</span>
            <div>
                <p class="font-semibold text-gray-800">' . ucfirst($contacto['tipo_contacto']) . $etiquetaPrincipal . ':</p>
                <a ' . $enlace . ' class="text-[#DDA15E] hover:underline">' . htmlspecialchars($contacto['valor']) . '</a>
            </div>
        </div>
    ';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto para Propiedad #<?php echo $id_propiedad ?? ''; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg mt-10">
        <h1 class="text-3xl font-bold mb-6 text-[#5B674D]">Detalles de Contacto</h1>
        <p class="mb-4 text-gray-700">Información para la propiedad #<?php echo $id_propiedad ?? 'Desconocida'; ?>:</p>

        <div class="space-y-4">
            <?php 
            if (isset($contactos) && !empty($contactos) && !isset($contactos['error'])) { 
                // Mostrar contactos principales primero
                if (isset($contactos['principales']) && !empty($contactos['principales'])) {
                    echo '<h3 class="text-lg font-semibold text-[#5B674D] mb-3">Contactos Principales</h3>';
                    foreach($contactos['principales'] as $contacto) {
                        echo crearItemContacto($contacto, true);
                    }
                }
                
                // Luego mostrar contactos secundarios
                if (isset($contactos['secundarios']) && !empty($contactos['secundarios'])) {
                    echo '<h3 class="text-lg font-semibold text-[#5B674D] mb-3 mt-6">Otros Contactos</h3>';
                    foreach($contactos['secundarios'] as $contacto) {
                        echo crearItemContacto($contacto, false);
                    }
                }
                
                // Si no hay contactos en ninguna categoría
                if ((!isset($contactos['principales']) || empty($contactos['principales'])) && 
                    (!isset($contactos['secundarios']) || empty($contactos['secundarios']))) {
                    echo '<p class="text-red-500 font-semibold p-4 border border-red-300 bg-red-50 rounded-lg">
                        Lo sentimos, no se encontraron datos de contacto para esta propiedad.
                    </p>';
                }
            } else { 
            ?>
                <p class="text-red-500 font-semibold p-4 border border-red-300 bg-red-50 rounded-lg">
                    Lo sentimos, no se encontraron datos de contacto para esta propiedad.
                </p>
            <?php } ?>
        </div>
        
        <a href="/usuario/propiedades" class="block mt-8 text-center text-[#5B674D] hover:underline transition duration-200">← Volver a Viviendas en Venta</a>
    </div>

</body>
</html>