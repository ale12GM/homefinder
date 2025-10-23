<?php
namespace MVC;
class Router{
    public function __construct(){
        
    }
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get(string $url, $fn): void
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post(string $url, $fn): void
    {
        $this->postRoutes[$url] = $fn;
    }
  
    public function ComprobarRutas(): void
    {
        $urlActual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        $fn = $metodo === 'GET'
        ? ($this->getRoutes[$urlActual] ?? null)
        : ($this->postRoutes[$urlActual] ?? null);

        if($fn){
            if (is_array($fn)) {
                call_user_func($fn, $this);
            } else {
                $fn($this);
            }
        } else{
            http_response_code(404);
            echo "<h3>Página no encontrada</h3>";
        }
    }
    public function render(string $ubicacion, array $datos = []): void{
        ob_start();
        foreach($datos as $key => $value){
            $$key = $value;
        }
        include __DIR__ ."/views/{$ubicacion}.php";
        $contenido=ob_get_clean();
        include_once __DIR__ ."/views/layout.php";
    }
    
    public function renderAuth(string $ubicacion, array $datos = []): void{
        foreach($datos as $key => $value){
            $$key = $value;
        }
        include __DIR__ ."/views/{$ubicacion}.php";
    }
}

?>