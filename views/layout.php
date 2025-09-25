<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <header>
        <nav class="bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="text-white font-bold text-xl">
                        <a href="#">Logo</a>
                    </div>
                    <div class="block lg:hidden">
                        <button id="menuButton" class="text-white focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <ul id="menu" class="lg:flex space-x-8 hidden">
                        <li><a href="#home" class="text-white hover:text-yellow-400 transition duration-300">Home</a></li>
                        <li><a href="#about" class="text-white hover:text-yellow-400 transition duration-300">About</a></li>
                        <li><a href="#services" class="text-white hover:text-yellow-400 transition duration-300">Services</a></li>
                        <li><a href="#contact" class="text-white hover:text-yellow-400 transition duration-300">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mx-auto p-4 flex-grow">
        <?php echo $contenido; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <p>&copy; 2025 Mi Empresa. Todos los derechos reservados.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-yellow-400 transition duration-300">Facebook</a>
                    <a href="#" class="hover:text-yellow-400 transition duration-300">Twitter</a>
                    <a href="#" class="hover:text-yellow-400 transition duration-300">Instagram</a>
                    <a href="#" class="hover:text-yellow-400 transition duration-300">LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Toggle the menu visibility when the hamburger button is clicked
        document.getElementById('menuButton').addEventListener('click', () => {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
