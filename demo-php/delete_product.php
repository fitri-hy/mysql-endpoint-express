<?php
function checkRole($allowedRoles) {
  $role = $_SERVER['HTTP_ROLE'] ?? 'admin'; //change 'admin' empty for read only
  if (!in_array($role, $allowedRoles)) {
    http_response_code(403);
    echo 'You do not have this access.';
    exit;
  }
}

$allowedRole = 'admin';
checkRole([$allowedRole]);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $url = 'http://localhost:5000/api/product/' . $product_id;
    $options = array(
        'http' => array(
            'method' => 'DELETE'
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result) {
        header("Location: index.php");
        exit;
    } else {
        echo 'Failed to delete product';
    }
} else {
    echo 'Invalid request';
}
?>