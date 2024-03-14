<?php

include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = mysqli_query($connection, "SELECT * FROM tiket_film");
    $count = $query->num_rows;
    $result = array();
    while ($row = $query->fetch_assoc()) {
        array_push($result, array(
            'nomor_id' => $row['nomor_id'],
            'judul_film' => $row['judul_film'],
            'harga_film' => $row['harga_film'],
            'tanggal_tayang' => $row['tanggal_tayang']
        ));
    }

    if ($count == 0) {
        echo 'Tidak ada data';
    }else {
        echo json_encode(
            array($result)
        );
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_film = $_POST['judul_film'];
    $harga_film = $_POST['harga_film'];
    $tanggal_tayang = $_POST['tanggal_tayang'];
    $query = mysqli_query($connection, "INSERT INTO tiket_film (judul_film, harga_film, tanggal_tayang) VALUES ('$judul_film', '$harga_film', '$tanggal_tayang')");

    if ($query) {
        $data = [
            'status' => 'data berhasil disimpan'
        ];

        echo json_encode([$data]);
    }else {
        $data = [
            'status' => 'data gagal disimpan'
        ];

        echo json_encode([$data]);
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $nomor_id = $_GET['nomor_id'];
    $query = mysqli_query($connection, "DELETE FROM tiket_film WHERE nomor_id = '$nomor_id' ");

    if ($query) {
        $data = [
            'status' => 'data berhasil dihapus'
        ];

        echo json_encode([$data]);
    }else {
        $data = [
            'status' => 'data gagal dihapus'
        ];

        echo json_encode([$data]);
    }

}elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $nomor_id = $_GET['nomor_id'];
    $judul_film = $_GET['judul_film'];
    $harga_film = $_GET['harga_film'];
    $tanggal_tayang = $_GET['tanggal_tayang'];

    $query = mysqli_query($connection, "UPDATE tiket_film SET 
                            nomor_id = '$nomor_id',
                            judul_film = '$judul_film',
                            harga_film = '$harga_film',
                            tanggal_tayang = '$tanggal_tayang'
                            WHERE nomor_id = '$nomor_id'
                        ");
    
    if ($query) {
        $data = [
            'status' => 'data berhasil diedit'
        ];

        echo json_encode([$data]);
    }else {
        $data = [
            'status' => 'data gagal diedit'
        ];

        echo json_encode([$data]);
    }
}

?>