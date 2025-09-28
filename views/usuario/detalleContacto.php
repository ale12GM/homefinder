<?php 

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
            ?>
                <?php if (isset($contactos['email'])) { ?>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-[#DDA15E]">
                        <span class="text-xl">📧</span>
                        <div>
                            <p class="font-semibold text-gray-800">Correo Electrónico:</p>
                            <a href="mailto:<?php echo $contactos['email']; ?>" class="text-[#DDA15E] hover:underline"><?php echo $contactos['email']; ?></a>
                        </div>
                    </div>
                <?php } ?>
                
                <?php if (isset($contactos['telefono'])) { ?>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg border border-[#DDA15E]">
                        <span class="text-xl">📞</span>
                        <div>
                            <p class="font-semibold text-gray-800">Teléfono:</p>
                            <a href="tel:<?php echo $contactos['telefono']; ?>" class="text-[#DDA15E] hover:underline"><?php echo $contactos['telefono']; ?></a>
                        </div>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <p class="text-red-500 font-semibold p-4 border border-red-300 bg-red-50 rounded-lg">
                    Lo sentimos, no se encontraron datos de contacto principales para esta propiedad.
                </p>
            <?php } ?>
        </div>
        
        <a href="/usuario/propiedades" class="block mt-8 text-center text-[#5B674D] hover:underline transition duration-200">← Volver a Viviendas en Venta</a>
    </div>

</body>
</html>