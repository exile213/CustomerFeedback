<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <link rel="stylesheet" href="../Styles/inventory.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="layout">
        <nav class="sidebar">
            <div class="sidebar-header">
                <h2>Inventory System</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fas fa-home"></i>Inventory</a></li>
                <li><a href="#"><i class="fas fa-box"></i> POS</a></li>
                <li><a href="#"><i class="far fa-address-card"></i>Customer Feedback</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </nav>
        <div class="main-content">
            <header class="navbar">
                <button id="sidebarToggle" class="sidebar-toggle"><i class="fas fa-bars"></i></button>
                <h1>Inventory</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                    <a href="inventoryapi.php?action=logout" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </header>
            <main>
                <div class="actions">
                    <div class="action-buttons">
                        <button id="addProductBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Product</button>
                        <button id="exportBtn" class="btn btn-secondary"><i class="fas fa-file-export"></i> Export Data</button>
                    </div>
                    <div class="search-filter">
                        <div class="search-wrapper">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Search products...">
                        </div>
                        <select id="categoryFilter">
                            <option value="">All Categories</option>
                            <option value="Short / Pants">Short / Pants</option>
                            <option value="Sandals">Sandals</option>
                            <option value="Shirts">Shirts</option>
                            <option value="Accessories">Accessories</option>
                            <option value="Perfumes / Cosmetics">Perfumes / Cosmetics</option>
                        </select>
                    </div>
                </div>

                <div class="card table-container">
                    <table id="inventoryTable">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Reorder Level</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryBody"></tbody>
                    </table>
                </div>

                <div class="card change-log">
                    <h2>Change Log</h2>
                    <ul id="changeLog"></ul>
                </div>
            </main>
        </div>
    </div>

    <div id="addProductForm" class="modal">
        <div class="modal-content card">
            <h2>Add New Product</h2>
            <input type="text" id="productName" placeholder="Product Name" required>
            <select id="productCategory" required>
                <option value="">Select Category</option>
                <option value="Short / Pants">Short / Pants</option>
                <option value="Sandals">Sandals</option>
                <option value="Shirts">Shirts</option>
                <option value="Accessories">Accessories</option>
                <option value="Perfumes / Cosmetics">Perfumes / Cosmetics</option>
            </select>
            <input type="number" id="productQuantity" placeholder="Quantity" required>
            <input type="number" id="productPrice" placeholder="Price" step="0.01" required>
            <input type="number" id="productReorderLevel" placeholder="Reorder Level" required>
            <div class="modal-actions">
                <button id="saveProductBtn" class="btn btn-primary">Save Product</button>
                <button id="cancelAddBtn" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>

    <div id="editProductForm" class="modal">
        <div class="modal-content card">
            <h2>Edit Product</h2>
            <input type="text" id="editProductName" placeholder="Product Name" required>
            <select id="editProductCategory" required>
                <option value="">Select Category</option>
                <option value="Short / Pants">Short / Pants</option>
                <option value="Sandals">Sandals</option>
                <option value="Shirts">Shirts</option>
                <option value="Accessories">Accessories</option>
                <option value="Perfumes / Cosmetics">Perfumes / Cosmetics</option>
            </select>
            <input type="number" id="editProductQuantity" placeholder="Quantity" required>
            <input type="number" id="editProductPrice" placeholder="Price" step="0.01" required>
            <input type="number" id="editProductReorderLevel" placeholder="Reorder Level" required>
            <div class="modal-actions">
                <button id="updateProductBtn" class="btn btn-primary">Update Product</button>
                <button id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </div>

    <script src="../Script/inventory.js"></script>
</body>
</html>

