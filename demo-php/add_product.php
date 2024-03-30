<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $url = 'http://localhost:5000/api/product';

    $data = array(
        'product_name' => $_POST['product-name'],
        'product_price' => $_POST['product-price']
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/json",
            'method' => 'POST',
            'content' => json_encode($data)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result) {
        header("Location: index.php");
        exit;
    } else {
        echo 'Failed to add product';
    }
} else {
    echo 'Invalid request';
}
?>