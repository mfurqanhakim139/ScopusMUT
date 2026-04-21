<?php
namespace App\Core;

class Controller {
    public function view($view, $data = []) {
        require_once '../app/views/' . $view . '.php';
    }

    public function model($model) {
        // PERBAIKAN DI SINI: Menggunakan double backslash (\\)
        $modelClass = '\\App\\Models\\' . $model;
        return new $modelClass;
    }
}