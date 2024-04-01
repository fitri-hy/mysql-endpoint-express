<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <style>
        body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 20px;
		}

		h1 {
			text-align: center;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		th, td {
			border: 1px solid #000;
			padding: 8px;
		}

		th {
			background-color: #f0f0f0;
		}

		tr:nth-child(even) {
			background-color: #f9f9f9;
		}

		tr:hover {
			background-color: #e9e9e9;
		}

		form {
			margin-top: 20px;
		}

		form label {
			display: inline-block;
			width: 150px;
		}

		form input[type="text"] {
			padding: 5px;
		}

		button {
			padding: 5px 10px;
			border: none;
			background-color: #007bff;
			color: #fff;
			cursor: pointer;
		}

		.edit-form {
			display: none;
		}

		.edit-form form {
			margin-top: 10px;
		}

		.edit-form input[type="text"] {
			margin-bottom: 10px;
		}

		.edit-form button {
			padding: 5px 10px;
			background-color: #28a745;
			color: #fff;
			cursor: pointer;
		}
		
		a {
			padding: 5px 10px;
			margin: 5px 5px;;
			border: none;
			background-color: #007bff;
			color: #fff;
			text-decoration: none;
			cursor: pointer;
		}
    </style>
</head>
<body>

<h1>Product Management</h1>
<h2>Add New Product</h2>
<form method="post" action="add_product.php">
    <label for="product-name">Product Name:</label>
    <input type="text" id="product-name" name="product_name" required><br><br>
    
    <label for="product-price">Product Price:</label>
    <input type="text" id="product-price" name="product_price" required><br><br>
    
    <button type="submit">Add Product</button>
<div id="product-list">
    <?php
    $url = 'http://localhost:5000/api/product';
    $data = file_get_contents($url);
    $product_data = json_decode($data, true);

    if ($product_data) {
        echo '<table border="1">';
        echo '<tr><th>Product ID</th><th>Product Name</th><th>Product Price</th><th>Actions</th></tr>';
        foreach ($product_data as $product) {
            echo '<tr>';
            echo '<td>' . $product["product_id"] . '</td>';
            echo '<td>' . $product["product_name"] . '</td>';
            echo '<td>' . $product["product_price"] . '</td>';
            echo '<td>';
            echo '<a href="#" onclick="showEditForm('. $product["product_id"] .')">Edit </a>';
            echo '<a href="delete_product.php?product_id='. $product["product_id"] .'" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>';
            echo '</td>';
            echo '</tr>';
            echo '<tr class="edit-form" id="edit-form-' . $product["product_id"] . '">';
            echo '<td colspan="4">';
            echo '<form method="post" action="edit_product.php">';
            echo '<input type="hidden" name="product_id" value="' . $product["product_id"] . '">';
            echo 'Product Name: <input type="text" name="product-name" value="' . $product["product_name"] . '"><br>';
            echo 'Product Price: <input type="text" name="product-price" value="' . $product["product_price"] . '"><br>';
            echo '<button type="submit">Save</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'Failed to fetch data';
    }
    ?>
</div>
</form>

<script>
    function showEditForm(productId) {
        var form = document.getElementById('edit-form-' + productId);
        form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
    }
</script>

</body>
</html>