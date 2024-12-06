<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Konfigurasi database
$host = 'localhost'; // Nama host
$db_name = 'fashion_claary'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database (kosong jika default XAMPP/WAMP)

// Koneksi ke database menggunakan PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["status" => "error", "message" => $e->getMessage()]));
}

// Periksa metode HTTP
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Mendapatkan semua data dari tabel reviews
        try {
            $stmt = $conn->prepare("SELECT * FROM reviews");
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Kembalikan data dalam format JSON
            echo json_encode(["status" => "success", "data" => $reviews]);
        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
        break;

    case 'POST':
        // Menambahkan data baru ke tabel reviews
        $input = json_decode(file_get_contents('php://input'), true);

        if (!empty($input['name']) && !empty($input['email']) && !empty($input['message'])) {
            try {
                $stmt = $conn->prepare("INSERT INTO reviews (name, email, message) VALUES (:name, :email, :message)");
                $stmt->bindParam(':name', $input['name']);
                $stmt->bindParam(':email', $input['email']);
                $stmt->bindParam(':message', $input['message']);
                $stmt->execute();

                echo json_encode(["status" => "success", "message" => "Review added successfully."]);
            } catch (PDOException $e) {
                echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "All fields are required."]);
        }
        break;

    case 'DELETE':
        // Menghapus data berdasarkan ID
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            try {
                $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo json_encode(["status" => "success", "message" => "Review deleted successfully."]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Review not found."]);
                }
            } catch (PDOException $e) {
                echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "ID is required."]);
        }
        break;

    default:
        // Jika metode HTTP tidak valid
        echo json_encode(["status" => "error", "message" => "Invalid HTTP method."]);
        break;
}
?>n 