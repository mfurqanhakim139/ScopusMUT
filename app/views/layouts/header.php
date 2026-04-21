<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        krem: '#FAF9F6',
                        teksUtama: '#1F2937',
                        aksen: '#2563EB',
                        aksenGelap: '#1D4ED8',
                        kartu: '#FFFFFF'
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #FAF9F6; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .fade-in { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="text-teksUtama font-sans antialiased min-h-screen pb-12">
    <nav class="bg-white shadow-sm py-4 px-8 sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-aksen tracking-tight">Lit<span class="text-teksUtama">Review</span><span class="text-gray-400 font-light text-xl ml-1">Analytics</span></h1>
        </div>
    </nav>
