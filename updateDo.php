<?php

if (isset($_POST['submit'])) {
    $id_paket = $_POST['id_paket'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga']; // Tambahkan harga agar ikut terupdate

    // URL endpoint API
    $url = 'http://10.33.102.166/sait_project_api/travel_api.php?id_paket=' . $id_paket;

    // Data yang akan dikirim ke API
    $jsonData = array(
        'lokasi' => $lokasi,
        'deskripsi' => $deskripsi,
        'harga' => $harga, // Tambahkan harga ke array
    );

    // Encode data menjadi JSON
    $jsonDataEncoded = json_encode($jsonData);

    // Inisialisasi cURL
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Pastikan API mendukung metode PUT
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Eksekusi request
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Decode respons JSON
    $response = json_decode($result, true);

    // Periksa apakah respons valid
    if ($response && isset($response["status"]) && isset($response["message"])) {
        echo "<center><br>Status: {$response["status"]}";
        echo "<br>Message: {$response["message"]}";
        echo "<br>Sukses mengupdate data di server!";
    } else {
        echo "<br>Error: Gagal memperbarui data. Response API tidak valid.";
    }

    echo "<br><a href='selectView.php'>OK</a>";
}
?>
