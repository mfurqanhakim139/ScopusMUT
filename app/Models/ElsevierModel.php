<?php
namespace App\Models;

class ElsevierModel {
    private $apiKey = '850da3fca45eab0590c77d3c3dc36b61';
    private $baseUrl = "https://api.elsevier.com/content";

    public function searchLiterature($query, $count = 25) {
        if(empty($this->apiKey)) {
            return ['error' => 'API Key Elsevier belum dikonfigurasi. Buka file config/config.php dan masukkan API Key Anda.'];
        }

        $url = $this->baseUrl . "/search/scopus?query=" . urlencode($query) . "&count=" . $count . "&view=STANDARD";
        return $this->request($url);
    }

   private function request($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-ELS-APIKey: " . $this->apiKey,
            // Buka komentar (hapus tanda //) pada baris di bawah ini jika Anda sudah memiliki Insttoken dari kampus
            // "X-ELS-Insttoken: MASUKKAN_INSTTOKEN_ANDA_DI_SINI", 
            "Accept: application/json"
        ]);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['error' => "cURL Error: " . $error];
        }
        
        // MODIFIKASI DEBUGGING: Menangkap pesan error asli dari Elsevier
        if ($httpcode !== 200) {
            $elsevierError = json_decode($result, true);
            $pesanAsli = "Tidak ada detail";
            
            // Mencoba mengekstrak pesan error dari struktur JSON Elsevier
            if(isset($elsevierError['service-error']['status']['statusText'])) {
                $pesanAsli = $elsevierError['service-error']['status']['statusText'];
            } elseif(is_string($result) && !empty($result)) {
                $pesanAsli = strip_tags($result); // Tangkap teks mentah jika bukan JSON
            }

            return ['error' => "HTTP Error $httpcode: $pesanAsli"];
        }

        return json_decode($result, true);
    }
}
