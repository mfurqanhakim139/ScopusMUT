$(document).ready(function() {
    const baseUrl = window.location.origin + window.location.pathname.replace('/public/', '/public');
    let currentLiteratureData = [];

    function downloadBlob(content, filename, contentType) {
        const blob = new Blob([content], { type: contentType });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    $('#formSearch').on('submit', function(e) {
        e.preventDefault();
        const query = $('#query').val();
        const count = $('#count').val();
        
        $('#dashboardArea').addClass('hidden');
        $('#loading').removeClass('hidden');
        const btnSearch = $('#btnSearch');
        const btnOriginalText = btnSearch.html();
        btnSearch.prop('disabled', true).addClass('opacity-50 cursor-not-allowed').text('Memproses...');

        $.ajax({
            url: baseUrl + '/miner/analyze',
            type: 'POST',
            data: { query: query, count: count },
            dataType: 'json',
            success: function(response) {
                $('#loading').addClass('hidden');
                btnSearch.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed').html(btnOriginalText);
                
                if(response.error) return alert("Gagal: " + response.error);

                const entries = response['search-results']?.entry || [];
                if(entries.length === 0) return alert("Tidak ada dokumen yang cocok.");

                currentLiteratureData = entries;
                $('#countResult').text(entries.length);

                let keywordFrequency = {};
                entries.forEach(doc => {
                    let keywords = doc['authkeywords']; 
                    if(keywords) {
                        let kwArray = keywords.split('|');
                        kwArray.forEach(k => {
                            let cleanK = k.trim().toLowerCase();
                            if(cleanK.length > 2) keywordFrequency[cleanK] = (keywordFrequency[cleanK] || 0) + 1;
                        });
                    }
                });

                let sortedKeywords = Object.keys(keywordFrequency).map(function(key) {
                    return { term: key, count: keywordFrequency[key] };
                }).sort((a, b) => b.count - a.count);

                let kwHtml = '';
                if(sortedKeywords.length > 0) {
                    sortedKeywords.slice(0, 30).forEach(kw => {
                        let bgClass = kw.count > 5 ? 'bg-blue-600 text-white font-bold' : (kw.count > 2 ? 'bg-blue-200 text-blue-900 font-semibold' : 'bg-gray-100 text-gray-600');
                        kwHtml += `<span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm shadow-sm ${bgClass} border border-gray-200 transition hover:scale-105 cursor-default">${kw.term} <span class="ml-2 px-1.5 py-0.5 rounded-full bg-white/20 text-xs">${kw.count}</span></span>`;
                    });
                } else {
                    kwHtml = '<span class="text-gray-500 italic">Metadata kata kunci tidak tersedia.</span>';
                }
                $('#keywordCloud').html(kwHtml);

                let html = '';
                entries.forEach((doc) => {
                    const title = doc['dc:title'] || 'Judul Tidak Tersedia';
                    const pubName = doc['prism:publicationName'] || 'Jurnal Tidak Diketahui';
                    const creator = doc['dc:creator'] || 'Penulis anonim';
                    const dateRaw = doc['prism:coverDisplayDate'] || doc['prism:coverDate'] || '';
                    const year = dateRaw ? dateRaw.substring(0, 4) : 'N/A';
                    const doi = doc['prism:doi'] || '';
                    const rawKeywords = doc['authkeywords'] || '';
                    const displayKeywords = rawKeywords ? rawKeywords.replace(/\|/g, ', ') : '<span class="text-gray-400 italic">Tidak ada keyword</span>';
                    const linkUrl = doi ? `https://doi.org/${doi}` : (doc['prism:url'] || '#');

                    html += `<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:border-blue-400 transition-all duration-300 hover:shadow-md flex flex-col h-full"><div class="flex justify-between items-start mb-3"><span class="px-2.5 py-1 bg-gray-100 text-xs font-bold text-gray-700 rounded-md">${year}</span>${doi ? `<span class="text-[10px] text-gray-400 font-mono tracking-tighter">DOI: ${doi}</span>` : ''}</div><h4 class="text-base font-bold mb-2 leading-snug text-gray-900 line-clamp-3" title="${title}">${title}</h4><div class="mb-4 flex-grow"><p class="text-sm text-blue-600 font-semibold mb-1 line-clamp-1">${pubName}</p><p class="text-xs text-gray-500 font-medium line-clamp-1">${creator}</p></div><div class="pt-3 border-t border-gray-100 mb-4"><p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Author Keywords</p><p class="text-xs text-gray-700 italic line-clamp-2">${displayKeywords}</p></div><div class="mt-auto pt-2"><a href="${linkUrl}" target="_blank" class="block text-center w-full text-sm bg-gray-50 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded border border-gray-200">Lihat Jurnal Asli &rarr;</a></div></div>`;
                });
                
                $('#resultsArea').html(html);
                $('#dashboardArea').removeClass('hidden');
                $('html, body').animate({ scrollTop: $("#dashboardArea").offset().top - 100 }, 800);
            },
            error: function(xhr, status, error) {
                $('#loading').addClass('hidden');
                btnSearch.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed').html(btnOriginalText);
                alert("Kesalahan koneksi: " + error);
            }
        });
    });

    $('#btnExportRIS').on('click', function() {
        if(currentLiteratureData.length === 0) return alert('Tidak ada data.');
        let risContent = '';
        currentLiteratureData.forEach(doc => {
            risContent += "TY  - JOUR\n";
            if(doc['dc:title']) risContent += "TI  - " + doc['dc:title'] + "\n";
            if(doc['dc:creator']) risContent += "AU  - " + doc['dc:creator'] + "\n";
            if(doc['prism:publicationName']) risContent += "JO  - " + doc['prism:publicationName'] + "\n";
            let date = doc['prism:coverDisplayDate'] || doc['prism:coverDate'] || '';
            if(date) risContent += "PY  - " + date.substring(0, 4) + "\n";
            if(doc['prism:doi']) risContent += "DO  - " + doc['prism:doi'] + "\n";
            if(doc['authkeywords']) {
                let keywords = doc['authkeywords'].split('|');
                keywords.forEach(kw => { risContent += "KW  - " + kw.trim() + "\n"; });
            }
            if(doc['dc:description']) risContent += "AB  - " + doc['dc:description'] + "\n";
            if(doc['prism:url']) risContent += "UR  - " + doc['prism:url'] + "\n";
            risContent += "ER  - \n\n";
        });
        downloadBlob(risContent, 'Scopus_Literature.ris', 'application/x-research-info-systems');
    });

    $('#btnExportCSV').on('click', function() {
        if(currentLiteratureData.length === 0) return alert('Tidak ada data.');
        let csvContent = "\uFEFFJudul,Penulis,Jurnal,Tahun,DOI,Kata_Kunci\n";
        currentLiteratureData.forEach(doc => {
            const escapeCSV = (str) => {
                if(!str) return '""';
                return '"' + String(str).replace(/"/g, '""') + '"';
            };
            let title = escapeCSV(doc['dc:title']);
            let author = escapeCSV(doc['dc:creator']);
            let journal = escapeCSV(doc['prism:publicationName']);
            let date = doc['prism:coverDisplayDate'] || doc['prism:coverDate'] || '';
            let year = date ? escapeCSV(date.substring(0, 4)) : '""';
            let doi = escapeCSV(doc['prism:doi']);
            let keywords = escapeCSV(doc['authkeywords'] ? doc['authkeywords'].replace(/\|/g, ', ') : '');
            csvContent += `${title},${author},${journal},${year},${doi},${keywords}\n`;
        });
        downloadBlob(csvContent, 'Scopus_Literature.csv', 'text/csv;charset=utf-8;');
    });

    $('#btnExportJSON').on('click', function() {
        if(currentLiteratureData.length === 0) return alert('Tidak ada data.');
        downloadBlob(JSON.stringify(currentLiteratureData, null, 4), 'Scopus_Literature.json', 'application/json');
    });
});
