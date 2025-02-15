<?php
    // Koneksi ke database
    $connect = mysqli_connect('127.0.0.1:3308', 'root', '', 'grafiksensor');

    // Periksa koneksi
    if (!$connect) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Tangkap parameter yang dikirimkan oleh NodeMCU
    $suhu = $_GET['suhu'];
    $kelembapan = $_GET['kelembapan'];

    // Atur ID selalu mulai dari 1
    mysqli_query($connect, "ALTER TABLE sensor_table AUTO_INCREMENT=1");

    // Simpan nilai suhu dan kelembapan ke sensor_table
    $simpan = mysqli_query($connect, "INSERT INTO sensor_table (suhu, kelembapan) VALUES ('$suhu', '$kelembapan')");

    // Cek apakah data berhasil disimpan
    if ($simpan) {
        echo "Berhasil Disimpan";
    } else {
        echo "Gagal Tersimpan: " . mysqli_error($connect);
    }

    // Tutup koneksi
    mysqli_close($connect);
?>
