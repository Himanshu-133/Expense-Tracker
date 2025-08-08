<?php
header('Content-Type: application/json');
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

// CREATE transaction
if ($method === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $type = $input['type'];
    $amount = floatval($input['amount']);
    $category = $input['category'];
    $date = $input['date'];
    $description = $input['description'];

    $stmt = $conn->prepare("INSERT INTO transactions (type, amount, category, date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $type, $amount, $category, $date, $description);

    if($stmt->execute()) {
        echo json_encode(['status'=>'success', 'id'=>$stmt->insert_id]);
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Insert failed']);
    }
    $stmt->close();
}

// READ transactions
elseif ($method === "GET") {
    $result = $conn->query("SELECT * FROM transactions ORDER BY date DESC, id DESC");
    $transactions = [];
    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    echo json_encode(['status'=>'success', 'transactions'=>$transactions]);
}

// DELETE transaction
elseif ($method === "DELETE") {
    parse_str(file_get_contents("php://input"), $del_vars);
    $id = intval($del_vars['id']);
    $stmt = $conn->prepare("DELETE FROM transactions WHERE id=?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Delete failed']);
    }
    $stmt->close();
}

$conn->close();
?>
