<?php
    $connect = mysqli_connect('127.0.0.1:3308', 'root', '', 'grafiksensor');

    $query = "SELECT tanggal, suhu, kelembapan FROM sensor_table ORDER BY ID DESC LIMIT 5";
    $result = mysqli_query($connect, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Urutkan data dari ID terkecil ke terbesar
    usort($data, function($a, $b) use ($connect) {
        $idA = mysqli_fetch_assoc(mysqli_query($connect, "SELECT ID FROM sensor_table WHERE tanggal = '{$a['tanggal']}' AND suhu = '{$a['suhu']}' AND kelembapan = '{$a['kelembapan']}'"))['ID'];
        $idB = mysqli_fetch_assoc(mysqli_query($connect, "SELECT ID FROM sensor_table WHERE tanggal = '{$b['tanggal']}' AND suhu = '{$b['suhu']}' AND kelembapan = '{$b['kelembapan']}'"))['ID'];
        return $idA <=> $idB; // Urutkan berdasarkan ID
    });
    $tanggal_data = [];
    $suhu_data = [];
    $kelembapan_data = [];

    foreach ($data as $row) {
        $tanggal_data[] = $row['tanggal'];
        $suhu_data[] = $row['suhu'];
        $kelembapan_data[] = $row['kelembapan'];
    }
?>

<!-- Tampilan Grafik -->
<div class="panel panel-danger">
    <div class="panel-heading">
        Data Grafik Sensor
    </div>

    <div class="panel-body">
        <canvas id="Chart"></canvas>

        <!-- Gambar Grafik -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script type="text/javascript">
            var canvas = document.getElementById('Chart');

            var data = {
                labels: <?php echo json_encode($tanggal_data); ?>,
                datasets: [{
                    label: "Suhu",
                    data: <?php echo json_encode($suhu_data); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                }, {
                    label: "Kelembapan",
                    data: <?php echo json_encode($kelembapan_data); ?>,
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    fill: true
                }]
            };

            var options = {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                },
                scales: {
                    y: {
                        suggestedMin: 20,
                        suggestedMax: 65
                    }
                }
            };

            var LineChart = new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: data,
                options: options
            });
        </script>
    </div>
</div>