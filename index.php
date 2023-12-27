<?php
require 'vendor/autoload.php'; // Pastikan Anda sudah menginstal PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    $file = $_FILES['excelFile']['tmp_name'];




    $spreadsheet = IOFactory::load($file);
    $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Koneksi ke database (ganti dengan informasi koneksi Anda)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_pendaftaran";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Loop untuk menyisipkan data ke database
    foreach ($data as $row) {
        $nama = $row['A'];
        $alamat = $row['B'];
        $status = $row['C'];

        // Gantilah 'nama_tabel' dengan nama tabel Anda
        $sql = "INSERT INTO coba (nama, alamat, status) VALUES ('$nama', '$alamat', '$status')";
        $conn->query($sql);
    }

    $conn->close();

    echo "Data berhasil diunggah ke database.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Data Excel</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        Pilih file Excel: <input type="file" name="excelFile" accept=".xlsx, .xls">
        <input type="submit" name="submit" value="Upload">
    </form>
</body>

</html>