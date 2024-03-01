<?php
header("Content-Type: application/json");

// Koneksi ke database (gantilah dengan informasi koneksi Anda)
$host = "localhost: 8111";
$username = "root";
$password = "";
$database = "db_tiket film";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Mendapatkan daftar tiket film
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $koneksi->query("SELECT * FROM tiket_film");

    $tiket_film = array();
    while ($row = $result->fetch_assoc()) {
        $tiket_film[] = $row;
    }

    echo json_encode($tiket_film, JSON_PRETTY_PRINT);
}

// Menambah tiket film baru
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $judul_film = isset($data['judul_film']) ? $data['judul_film'] : '';
    $harga_tiket = isset($data['harga_tiket']) ? $data['harga_tiket'] : '';
    $tanggal_tayang = isset($data['tanggal_tayang']) ? $data['tanggal_tayang'] : '';

    $sql = "INSERT INTO tiket_film (judul_film, harga_tiket, tanggal_tayang) VALUES ('$judul_film', '$harga_tiket', '$tanggal_tayang')";

    if ($koneksi->query($sql) === TRUE) {
        echo json_encode(array("status" => "Sukses", "pesan" => "Tiket film berhasil ditambahkan"), JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array("status" => "Gagal", "pesan" => "Error: " . $sql . "<br>" . $koneksi->error), JSON_PRETTY_PRINT);
    }
}

// Menutup koneksi database
$koneksi->close();
?>