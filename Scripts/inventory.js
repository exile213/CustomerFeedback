let inventory = [];

document.addEventListener('DOMContentLoaded', function() {
    loadInventory();

    document.getElementById('addProductBtn').addEventListener('click', showAddProductForm);
    document.getElementById('exportBtn').addEventListener('click', exportData);
    document.getElementById('saveProductBtn').addEventListener('click', addProduct);
    document.getElementById('cancelAddBtn').addEventListener('click', hideAddProductForm);
    document.getElementById('updateProductBtn').addEventListener('click', updateProduct);
    document.getElementById('cancelEditBtn').addEventListener('click', hideEditProductForm);
    document.getElementById('searchInput').addEventListener('input', filterInventory);
    document.getElementById('categoryFilter').addEventListener('change', filterInventory);

    window.addEventListener('click', function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    });
});

function loadInventory() {
    fetch('inventoryapi.php')
        .then(response => response.json())
        .then(data => {
            inventory = data;
            renderInventoryTable();
            loadChangeLog();
        })
        .catch(error => console.error('Error:', error));
}

function renderInventoryTable() {
    const tbody = document.getElementById('inventoryBody');
    tbody.innerHTML = '';
    inventory.forEach(item => {
        const row = `
            <tr>
                <td>${item.name}</td>
                <td>${item.category}</td>
                <td>${item.quantity}</td>
                <td>$${parseFloat(item.price).toFixed(2)}</td>
                <td>${item.reorder_level}</td>
                <td>
                    <button onclick="showEditProductForm(${item.id})">Edit</button>
                    <button onclick="deleteProduct(${item.id})">Delete</button>
                </td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

function showAddProductForm() {
    document.getElementById('addProductForm').style.display = 'block';
}

function hideAddProductForm() {
    document.getElementById('addProductForm').style.display = 'none';
}

function addProduct() {
    const product = {
        name: document.getElementById('productName').value,
        category: document.getElementById('productCategory').value,
        quantity: parseInt(document.getElementById('productQuantity').value),
        price: parseFloat(document.getElementById('productPrice').value),
        reorder_level: parseInt(document.getElementById('productReorderLevel').value)
    };

    fetch('controller/sinventoryapi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(product),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadInventory(); // Reload the inventory to update the table
            hideAddProductForm();
        } else {
            alert('Failed to add product. Please try again.');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

function showEditProductForm(id) {
    const product = inventory.find(item => item.id === id);
    if (product) {
        document.getElementById('editProductName').value = product.name;
        document.getElementById('editProductCategory').value = product.category;
        document.getElementById('editProductQuantity').value = product.quantity;
        document.getElementById('editProductPrice').value = product.price;
        document.getElementById('editProductReorderLevel').value = product.reorder_level;
        document.getElementById('updateProductBtn').setAttribute('data-id', id);
        document.getElementById('editProductForm').style.display = 'block';
    }
}

function hideEditProductForm() {
    document.getElementById('editProductForm').style.display = 'none';
}

function updateProduct() {
    const id = parseInt(document.getElementById('updateProductBtn').getAttribute('data-id'));
    const product = {
        name: document.getElementById('editProductName').value,
        category: document.getElementById('editProductCategory').value,
        quantity: parseInt(document.getElementById('editProductQuantity').value),
        price: parseFloat(document.getElementById('editProductPrice').value),
        reorder_level: parseInt(document.getElementById('editProductReorderLevel').value)
    };

    fetch(`controllers/inventoryapi.php?id=${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(product),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadInventory(); // Reload the inventory to update the table
            hideEditProductForm();
        } else {
            alert('Failed to update product. Please try again.');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
        fetch(`inventoryapi.php?id=${id}`, {
            method: 'DELETE',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadInventory(); // Reload the inventory to update the table
            } else {
                alert('Failed to delete product. Please try again.');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}

function filterInventory() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;

    const filteredInventory = inventory.filter(item => {
        const matchesSearch = item.name.toLowerCase().includes(searchTerm) || 
                              item.category.toLowerCase().includes(searchTerm);
        const matchesCategory = categoryFilter === '' || item.category === categoryFilter;
        return matchesSearch && matchesCategory;
    });

    renderFilteredInventory(filteredInventory);
}

function renderFilteredInventory(filteredInventory) {
    const tbody = document.getElementById('inventoryBody');
    tbody.innerHTML = '';
    filteredInventory.forEach(item => {
        const row = `
            <tr>
                <td>${item.name}</td>
                <td>${item.category}</td>
                <td>${item.quantity}</td>
                <td>$${parseFloat(item.price).toFixed(2)}</td>
                <td>${item.reorder_level}</td>
                <td>
                    <button onclick="showEditProductForm(${item.id})">Edit</button>
                    <button onclick="deleteProduct(${item.id})">Delete</button>
                </td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

function exportData() {
    fetch('controllers/inventoryapi.php?action=export')
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'inventory_export.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => console.error('Error:', error));
}

function loadChangeLog() {
    fetch('controllers/inventoryapi.php?action=changelog')
        .then(response => response.json())
        .then(data => {
            const changeLog = document.getElementById('changeLog');
            changeLog.innerHTML = '';
            data.forEach(log => {
                const logEntry = document.createElement('li');
                logEntry.textContent = `${log.timestamp}: ${log.action} - ${log.details}`;
                changeLog.appendChild(logEntry);
            });
        })
        .catch(error => console.error('Error:', error));
}