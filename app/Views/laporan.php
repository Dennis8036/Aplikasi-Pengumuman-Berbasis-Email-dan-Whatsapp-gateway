<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Acara</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
    <style>
        .card {
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table {
            min-width: 1300px;
        }
        .filter-container {
            margin-bottom: 20px;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.21/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Form -->
<div class="filter-container">
    
    <div style="display: flex; gap: 15px; align-items: center;">
        <div class="form-group">
            <label for="startDate" style="font-weight: bold;">Tanggal Mulai</label>
            <input 
                type="date" 
                id="startDate" 
                name="startDate" 
                class="form-control" 
                style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; width: 200px;">
        </div>
        <div class="form-group">
            <label for="endDate" style="font-weight: bold;">Tanggal Akhir</label>
            <input 
                type="date" 
                id="endDate" 
                name="endDate" 
                class="form-control" 
                style="padding: 8px; border-radius: 4px; border: 1px solid #ccc; width: 200px;">
        </div>
        <button 
            onclick="filterData()" 
            class="btn btn-primary" 
            style="padding: 10px 20px; border: none; background-color: #007bff; color: white; border-radius: 5px; cursor: pointer;">
            Filter
        </button>
        <button 
            onclick="resetFilter()" 
            class="btn btn-secondary" 
            style="padding: 10px 20px; border: none; background-color: #6c757d; color: white; border-radius: 5px; cursor: pointer;">
            Reset
        </button>
    </div>

                    <button onclick="printAllColumns()" class="btn btn-success">Print Windows</button>
                    <button onclick="printPDF()" class="btn btn-danger">Print PDF</button>
                    <button onclick="downloadExcel()" class="btn btn-primary">Download Excel</button>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="laporanAcara">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Acara</th>
                                    <th>Tanggal Acara</th>
                                    <th>Status</th>
                                    <th>Waktu Dibuat</th>
                                    <th>Waktu Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($history as $event) {
                                    ?>
                                    <tr data-tanggal="<?= $event->tanggal_acara ?>">
                                        <td><?= $no++ ?></td>
                                        <td><?= $event->nama_acara ?></td>
                                        <td><?= $event->tanggal_acara ?></td>
                                        <td><?= $event->status ?></td>
                                        <td><?= $event->create_at ?></td>
                                        <td><?= $event->update_at ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to filter data based on date range
        function filterData() {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;
            var rows = document.querySelectorAll('#laporanAcara tbody tr');

            rows.forEach(function(row) {
                var tanggalAcara = row.getAttribute('data-tanggal');
                if (startDate && tanggalAcara < startDate || endDate && tanggalAcara > endDate) {
                    row.style.display = 'none';
                } else {
                    row.style.display = '';
                }
            });
        }

        // Function to print the table
        function printAllColumns() {
    var printTable = '<table class="table">';
    printTable += '<thead><tr><th>No</th><th>Nama Acara</th><th>Tanggal Acara</th><th>Status</th><th>Waktu Dibuat</th><th>Waktu Diperbarui</th></tr></thead><tbody>';

    var rows = document.querySelectorAll('table tbody tr');
    rows.forEach(function(row) {
        if (row.style.display !== 'none') { // Hanya tampilkan baris yang tidak disembunyikan
            var nomor = row.querySelector('td:nth-child(1)').textContent;
            var nama_acara = row.querySelector('td:nth-child(2)').textContent;
            var tanggal_acara = row.querySelector('td:nth-child(3)').textContent;
            var status = row.querySelector('td:nth-child(4)').textContent;
            var create_at = row.querySelector('td:nth-child(5)').textContent;
            var update_at = row.querySelector('td:nth-child(6)').textContent;

            printTable += `<tr><td>${nomor}</td><td>${nama_acara}</td><td>${tanggal_acara}</td><td>${status}</td><td>${create_at}</td><td>${update_at}</td></tr>`;
        }
    });

    printTable += '</tbody></table>';
    var newWindow = window.open('', '', 'width=800,height=600');
    newWindow.document.write('<html><head><title>Print Laporan Acara</title>');
    newWindow.document.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>');
    newWindow.document.write('</head><body>');
    newWindow.document.write(printTable);
    newWindow.document.write('</body></html>');
    newWindow.document.close();

    setTimeout(function() {
        newWindow.focus();
        newWindow.print();
        newWindow.close();
    }, 500);
}


        // Function to print the table as PDF and open in a new tab
       function printPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    var table = document.getElementById("laporanAcara");
    var rows = table.querySelectorAll("tbody tr");
    
    var tableData = [];
    rows.forEach(function(row) {
        if (row.style.display !== 'none') { // Hanya tambahkan baris yang terlihat
            var columns = row.querySelectorAll("td");
            var data = [
                columns[0].innerText,
                columns[1].innerText,
                columns[2].innerText,
                columns[3].innerText,
                columns[4].innerText,
                columns[5].innerText
            ];
            tableData.push(data);
        }
    });

    const columns = ["No", "Nama Acara", "Tanggal Acara", "Status", "Waktu Dibuat", "Waktu Diperbarui"];
    
    doc.autoTable({
        head: [columns],
        body: tableData,
        startY: 20,
    });

    var pdfOutput = doc.output('bloburl');
    window.open(pdfOutput, '_blank');
}


        // Function to download the table as Excel file
// Function to download the table as Excel file with column names
function downloadExcel() {
    var table = document.getElementById("laporanAcara");
    
    // Create a worksheet with column headers and data
    var wb = XLSX.utils.book_new();
    var ws_data = [
        ["No", "Nama Acara", "Tanggal Acara", "Status", "Waktu Dibuat", "Waktu Diperbarui"]
    ];

    // Loop through the rows of the table to add data
    var rows = table.querySelectorAll("tbody tr");
    rows.forEach(function(row) {
        var columns = row.querySelectorAll("td");
        var rowData = [
            columns[0].innerText, // No
            columns[1].innerText, // Nama Acara
            columns[2].innerText, // Tanggal Acara
            columns[3].innerText, // Status
            columns[4].innerText, // Waktu Dibuat
            columns[5].innerText  // Waktu Diperbarui
        ];
        ws_data.push(rowData);
    });

    // Add the data to the worksheet
    var ws = XLSX.utils.aoa_to_sheet(ws_data);
    XLSX.utils.book_append_sheet(wb, ws, "Laporan Acara");

    // Write the file
    XLSX.writeFile(wb, "laporan_acara.xlsx");
}
    function resetFilter() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        filterData(); // Panggil ulang fungsi filter untuk menampilkan semua data
    }

    </script>
</body>
</html>
