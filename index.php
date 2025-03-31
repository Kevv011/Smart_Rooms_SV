<?php
session_start();

//Definir el nombre del directorio raíz solo una vez si no está definido aún
if (!isset($_SESSION['rootFolder'])) {
    $_SESSION['rootFolder'] = basename(getcwd());
}

//Ruta en formato controlador/metodo
$request = $_GET['url'] ?? '';

//Procesamiento de la ruta
if ($request) {
    if (strpos($request, $_SESSION['rootFolder']) === 0) {
        $request = substr($request, strlen($_SESSION['rootFolder']) + 1); 
    }

    //Divicion de la ruta en segmentos para manejarse
    $segments = explode('/', $request);
    $controller = $segments[0] ?? 'home';
    $action = $segments[1] ?? 'index';

    //Determinar el archivo del controlador
    $controllerFile = "app/controllers/" . ucfirst($controller) . "Controller.php";

    //Verificar si el archivo del controlador existe
    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        $className = ucfirst($controller) . "Controller";
        $controllerObject = new $className();

        //Verificar si la acción existe en el controlador
        if (method_exists($controllerObject, $action)) {
            $controllerObject->$action();
        } else {
            echo "Acción no encontrada.";
        }
    } else {
        echo "Controlador no encontrado.";
    }
} else {
    //Redirigir a la página principal si no se proporciona ruta
    header('Location: /' . $_SESSION['rootFolder'] . '/home/index/');
    exit();
}
