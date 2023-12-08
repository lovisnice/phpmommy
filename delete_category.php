<?php
$host = 'localhost';
$dbname = 'pv116_prorok';
$username = 'root';
$password = '';

// Connection to MySQL using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the category ID from the POST data
    $categoryId = json_decode(file_get_contents('php://input'), true)["id"];

    // Prepare the DELETE statement
    $sql = "DELETE FROM categories WHERE id = :category_id";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Return a JSON response
    echo json_encode(["message" => "Category with ID $categoryId has been deleted."]);

} catch (PDOException $e) {
    // Return a JSON error response
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
?>

