<?php
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