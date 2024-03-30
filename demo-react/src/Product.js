import React, { useState, useEffect } from 'react';

const ProductCrud = () => {
  const apiUrl = 'http://localhost:5000/api';
  
  const [products, setProducts] = useState([]);
  const [newProduct, setNewProduct] = useState({ product_id: '', product_name: '', product_price: '' });
  const [editProduct, setEditProduct] = useState(null);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setNewProduct({ ...newProduct, [name]: value });
  };

  const handleEditClick = (product) => {
    setEditProduct(product);
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setEditProduct({ ...editProduct, [name]: value });
  };

  const handleEdit = (productId, newProductData) => {
    fetch(`${apiUrl}/product/${productId}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(newProductData)
    })
      .then(response => response.json())
      .then(updatedProduct => {
        const updatedProducts = products.map(product =>
          product.product_id === updatedProduct.product_id ? updatedProduct : product
        );
        setProducts(updatedProducts);
      })
      .catch(error => console.error(error));
  };

  const handleEditSubmit = () => {
    handleEdit(editProduct.product_id, editProduct);
    setEditProduct(null);
  };

  const handleSubmit = () => {
    fetch(`${apiUrl}/product`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(newProduct)
    })
      .then(response => response.json())
      .then(data => {
        setProducts([...products, data]);
        setNewProduct({ product_id: '', product_name: '', product_price: '' });
      })
      .catch(error => console.error(error));
  };

  const handleDelete = (productId, event) => {
    event.preventDefault();
    fetch(`${apiUrl}/product/${productId}`, {
      method: 'DELETE'
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to delete product');
        }
        return response.json();
      })
      .then(() => {
        const updatedProducts = products.filter(product => product.product_id !== productId);
        setProducts(updatedProducts);
      })
      .catch(error => console.error(error));
  };

  useEffect(() => {
    fetch(`${apiUrl}/product`)
      .then(response => response.json())
      .then(data => setProducts(data))
      .catch(error => console.error(error));
  }, []);

  return (
    <div>
      <h1>Product List</h1>
		<div>
			<input type="text" name="product_name" value={newProduct.product_name} onChange={handleChange} placeholder="Product Name" />
			<input type="text" name="product_price" value={newProduct.product_price} onChange={handleChange} placeholder="Product Price" />
			<button onClick={handleSubmit}>Add Product</button>
		  <table>
			<thead>
			  <tr>
				<th>Product Name</th>
				<th>Product Price</th>
				<th>Actions</th>
			  </tr>
			</thead>
			<tbody>
			  {products.map(product => (
				<tr key={product.product_id}>
				  <td>
					{editProduct && editProduct.product_id === product.product_id ? (
					  <input type="text" name="product_name" value={editProduct.product_name} onChange={handleInputChange} />
					) : (
					  <span>{product.product_name}</span>
					)}
				  </td>
				  <td>
					{editProduct && editProduct.product_id === product.product_id ? (
					  <input type="text" name="product_price" value={editProduct.product_price} onChange={handleInputChange} />
					) : (
					  <span>{product.product_price}</span>
					)}
				  </td>
				  <td>
					{editProduct && editProduct.product_id === product.product_id ? (
					  <button onClick={handleEditSubmit}>Save</button>
					) : (
					  <>
						<button onClick={() => handleEditClick(product)}>Edit</button>
						<button onClick={(e) => handleDelete(product.product_id, e)}>Delete</button>
					  </>
					)}
				  </td>
				</tr>
			  ))}
			</tbody>
		  </table>
		</div>
    </div>
  );
};

export default ProductCrud;