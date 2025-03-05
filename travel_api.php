<?php
require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (!empty($_GET["id_paket"])) {
            $id = intval($_GET["id_paket"]);
            get_paket($id);
        } else {
            get_pakets();
        }
        break;
    case 'POST':
        if (!empty($_GET["id_paket"])) {
            $id = intval($_GET["id_paket"]);
            update_paket($id);
        } else {
            insert_paket();
        }
        break;
    case 'DELETE':
        if (!empty($_GET["id_paket"])) {
            $id = intval($_GET["id_paket"]);
            delete_paket($id);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(["status" => 0, "message" => "ID Paket is required for deletion."]);
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_pakets()
{
    global $mysqli;
    $query = "SELECT * FROM paket_wisata";
    $result = $mysqli->query($query);
    $data = [];

    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }

    $response = [
        'status' => 1,
        'message' => 'Get List Paket Wisata Successfully.',
        'data' => $data
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_paket($id)
{
    global $mysqli;
    $query = "SELECT * FROM paket_wisata WHERE id_paket=" . intval($id) . " LIMIT 1";
    $result = $mysqli->query($query);
    $data = mysqli_fetch_object($result);

    if ($data) {
        $response = [
            'status' => 1,
            'message' => 'Get Paket Wisata Successfully.',
            'data' => $data
        ];
    } else {
        $response = [
            'status' => 0,
            'message' => 'Paket Wisata Not Found.'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_paket()
{
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $arrcheckpost = ['lokasi' => '', 'deskripsi' => '', 'harga' => ''];

    if (count(array_intersect_key($data, $arrcheckpost)) == count($arrcheckpost)) {
        $query = "INSERT INTO paket_wisata (lokasi, deskripsi, harga) VALUES 
                 ('" . $mysqli->real_escape_string($data['lokasi']) . "', 
                  '" . $mysqli->real_escape_string($data['deskripsi']) . "', 
                  '" . $mysqli->real_escape_string($data['harga']) . "')";
        $result = mysqli_query($mysqli, $query);

        $response = $result ?
            ['status' => 1, 'message' => 'Paket Wisata Added Successfully.'] :
            ['status' => 0, 'message' => 'Paket Wisata Addition Failed.'];
    } else {
        $response = ['status' => 0, 'message' => 'Parameter Do Not Match'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_paket($id)
{
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $arrcheckpost = ['lokasi' => '', 'deskripsi' => '', 'harga' => ''];

    if (count(array_intersect_key($data, $arrcheckpost)) == count($arrcheckpost)) {
        $query = "UPDATE paket_wisata SET 
                  lokasi = '" . $mysqli->real_escape_string($data['lokasi']) . "', 
                  deskripsi = '" . $mysqli->real_escape_string($data['deskripsi']) . "', 
                  harga = '" . $mysqli->real_escape_string($data['harga']) . "' 
                  WHERE id_paket=" . intval($id);
        $result = mysqli_query($mysqli, $query);

        $response = $result ?
            ['status' => 1, 'message' => 'Paket Wisata Updated Successfully.'] :
            ['status' => 0, 'message' => 'Paket Wisata Update Failed.'];
    } else {
        $response = ['status' => 0, 'message' => 'Parameter Do Not Match'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_paket($id)
{
    global $mysqli;
    $query = "DELETE FROM paket_wisata WHERE id_paket=" . intval($id);
    $result = mysqli_query($mysqli, $query);

    $response = $result ?
        ['status' => 1, 'message' => 'Paket Wisata Deleted Successfully.'] :
        ['status' => 0, 'message' => 'Paket Wisata Deletion Failed.'];

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
