<?php
namespace App\Controllers;

use App\Core\Controller;

class Miner extends Controller {
    public function index() {
        $data['judul'] = 'Elsevier Literature Review Analytics';
        $this->view('layouts/header', $data);
        $this->view('miner/index', $data);
        $this->view('layouts/footer');
    }

    public function analyze() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $query = $_POST['query'] ?? '';
            $count = $_POST['count'] ?? 25;
            
            if(empty($query)) {
                echo json_encode(['error' => 'Kata kunci tidak boleh kosong.']);
                return;
            }

            $model = $this->model('ElsevierModel');
            $result = $model->searchLiterature($query, $count);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'Invalid Request Method.']);
        }
    }
}
