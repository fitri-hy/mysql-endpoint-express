<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product-name'];
    $product_price = $_POST['product-price'];

    $url = 'http://localhost:5000/api/product/' . $product_id;

    $data = array(
        'product_name' => $product_name,
        'product_price' => $product_price
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/json",
            'method' => 'PUT',
            'content' => json_encode($data)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result) {
        header("Location: index.php");
        exit;
    } else {
        echo 'Failed to edit product';
    }
} else {
    echo 'Invalid request';
}
?>