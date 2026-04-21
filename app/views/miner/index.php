<div class="container mx-auto mt-8 px-4 max-w-6xl">
    <div class="bg-kartu rounded-2xl shadow-sm p-8 mb-8 border border-gray-200 fade-in">
        <h2 class="text-3xl font-extrabold mb-2 text-teksUtama">Pemetaan Literatur Terstruktur</h2>
        <p class="text-gray-500 mb-6 text-sm md:text-base">Gunakan <i>advanced query</i> Elsevier (misal: <code class="bg-gray-100 px-2 py-1 rounded text-pink-600">TITLE-ABS-KEY(artificial intelligence) AND PUBYEAR > 2020</code>).</p>
        
        <form id="formSearch" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Kueri Pencarian Scopus:</label>
                <input type="text" id="query" name="query" placeholder="Contoh: TITLE-ABS-KEY(machine learning) AND SUBJAREA(COMP)" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-aksen" required>
            </div>
            <div class="w-full md:w-32">
                <label class="block text-sm font-semibold text-gray-600 mb-1">Max Hasil:</label>
                <input type="number" id="count" name="count" min="5" max="200" value="50" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-aksen">
            </div>
            <div class="flex items-end">
                <button type="submit" id="btnSearch" class="w-full md:w-auto bg-aksen hover:bg-aksenGelap text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    Ekstrak Data 🚀
                </button>
            </div>
        </form>
    </div>

    <div id="loading" class="hidden flex flex-col justify-center items-center py-16 fade-in">
        <div class="animate-spin rounded-full h-14 w-14 border-4 border-gray-200 border-t-aksen mb-4"></div>
        <p class="text-gray-600 font-medium">Memproses jaringan kata kunci...</p>
    </div>

    <div id="dashboardArea" class="hidden fade-in">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 bg-white p-4 rounded-xl shadow-sm border border-gray-200">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3 md:mb-0">Export Data (<span id="countResult">0</span> Dokumen)</h3>
            <div class="flex flex-wrap gap-2">
                <button id="btnExportRIS" class="flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold py-2 px-4 rounded shadow transition-colors">📄 Download RIS</button>
                <button id="btnExportCSV" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded shadow transition-colors">📊 Download CSV</button>
                <button id="btnExportJSON" class="flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold py-2 px-4 rounded shadow transition-colors">{ } JSON</button>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
            <h3 class="text-xl font-bold mb-4 flex items-center text-gray-800">Tren Kata Kunci Terpopuler</h3>
            <div id="keywordCloud" class="flex flex-wrap gap-2"></div>
        </div>

        <h3 class="text-xl font-bold mb-4 flex items-center text-gray-800">Katalog Literatur</h3>
        <div id="resultsArea" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </div>
</div>
