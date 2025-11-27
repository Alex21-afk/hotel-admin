<?php

class Controller {

    public function model($model) {
    $path = __DIR__ . "/../app/models/$model.php";
    
    if (!file_exists($path)) {
        die("Modelo no encontrado: $path");
    }

    require_once $path;
    return new $model();
}

    public function view($view, $data = []) {
        extract($data);
        require_once "../app/views/$view.php";
    }

   
}
