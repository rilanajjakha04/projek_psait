<?php

if(isset($_POST['submit']))
{    
$lokasi = $_POST['lokasi'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];


//Pastikan sesuai dengan deskripsi endpoint dari REST API di ubuntu
$url='http://10.33.102.166/sait_project_api/travel_api.php';
$ch = curl_init($url);
// data yang akan dikirim ke REST api, dengan format json
$jsonData = array(
    'lokasi' =>  $lokasi,
    'deskripsi' =>  $deskripsi,
    'harga' =>  $harga,

);

//Encode the array into JSON.
$jsonDataEncoded = json_encode($jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//pastikan mengirim dengan method POST
curl_setopt($ch, CURLOPT_POST, true);

//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

//Execute the request
$result = curl_exec($ch);
$result = json_decode($result, true);

curl_close($ch);

//var_dump($result);
// tampilkan return statusnya, apakah sukses atau tidak
print("<center><br>status :  {$result["status"]} "); 
print("<br>");
print("message :  {$result["message"]} "); 
echo "<br>Sukses terkirim ke ubuntu server !";
echo "<br><a href=selectView.php> OK </a>";
}
?>