<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/mdb.min.js"></script>
    <script src="jquery-latest.js"></script>
    <script src="assets/jquery-3.4.0.min.js"></script>

    <script type="text/javascript">
        var refreshid = setInterval(function(){
            $('#responsecontainer').load('data.php');
        }, 20000);
    </script>
    <title>Sensor Grafik</title>
</head>
<body>
    <div class="div container" style="text-align : center;">
        <h3>Grafik Sensor Secara Realtime</h3>
        <p>Data yang ditampilkan</p>
    <div class = "container" id="responsecontainer" style="width: 100%"></div>
    </div>
</body>
</html>