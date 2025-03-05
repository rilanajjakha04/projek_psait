<?php
// Periksa apakah id_paket ada di URL
$id_paket = isset($_GET['id_paket']) ? $_GET['id_paket'] : null;

if (!$id_paket) {
    die("Error: ID Paket tidak ditemukan.");
}

// Inisialisasi cURL untuk mengambil data dari API
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'http://10.33.102.166/sait_project_api/travel_api.php?id_paket=' . $id_paket);
$res = curl_exec($curl);
curl_close($curl);

// Decode JSON dari API
$json = json_decode($res, true);

// Periksa apakah respons valid
if (!$json || !isset($json["data"]) || empty($json["data"])) {
    die("Error: Data tidak ditemukan atau API tidak merespons.");
}

// Ambil data paket wisata dari API
$paket = $json["data"] ?? '';
$lokasi = $paket["lokasi"] ?? '';
$deskripsi = $paket["deskripsi"] ?? '';
$harga = $paket["harga"] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Paket Wisata</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style>
        .wrapper { width: 500px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Paket Wisata</h2>
                    </div>
                    <p>Silakan isi formulir ini untuk memperbarui data paket wisata.</p>
                    <form action="updateDo.php" method="post">
                        <input type="hidden" name="id_paket" value="<?php echo htmlspecialchars($id_paket); ?>">
                        
                        <div class="form-group">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="<?php echo htmlspecialchars($lokasi); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" required><?php echo htmlspecialchars($deskripsi); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" step="0.01" name="harga" class="form-control" value="<?php echo htmlspecialchars($harga); ?>" required>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" name="submit" value="Update">
                    
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
