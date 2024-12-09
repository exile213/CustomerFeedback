<?php
// pos.php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categories = $conn->query("SELECT * FROM categories");
$products_query = $conn->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY c.name, p.name");

$products_by_category = [];
while ($product = $products_query->fetch_assoc()) {
    $products_by_category[$product['category_name']][] = $product;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    } elseif (isset($_POST['remove_from_cart'])) {
        $product_id = $_POST['product_id'];
        unset($_SESSION['cart'][$product_id]);
    } elseif (isset($_POST['process_transaction'])) {
        $cash_received = $_POST['cash_received'];
        $total_amount = $_POST['total_amount'];
        $tax_amount = $_POST['tax_amount'];
        $change = $cash_received - $total_amount;
        
        // Insert transaction into database
        $stmt = $conn->prepare("INSERT INTO transactions (total_amount, tax_amount, cash_received, change_amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("dddd", $total_amount, $tax_amount, $cash_received, $change);
        $stmt->execute();
        $transaction_id = $stmt->insert_id;
        $stmt->close();
        
        // Insert transaction items
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $conn->prepare("INSERT INTO transaction_items (transaction_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $transaction_id, $product_id, $quantity);
            $stmt->execute();
            $stmt->close();
        }
        
        // Clear the cart
        $_SESSION['cart'] = array();
        
        // Generate receipt
        $receipt = generateReceipt($transaction_id, $conn);
        
        // Offer save/print options
        echo "<script>
            var receipt = " . json_encode($receipt) . ";
            var saveReceipt = confirm('Transaction completed. Save receipt?');
            if (saveReceipt) {
                // Save receipt (you might want to implement an AJAX call here)
                alert('Receipt saved.');
            }
            var printReceipt = confirm('Print receipt?');
            if (printReceipt) {
                var win = window.open('', 'Print Receipt', 'height=600,width=800');
                win.document.write('<html><head><title>Receipt</title></head><body>');
                win.document.write('<pre>' + receipt + '</pre>');
                win.document.write('</body></html>');
                win.document.close();
                win.print();
            }
        </script>";
    }
}

function generateReceipt($transaction_id, $conn) {
    $transaction = $conn->query("SELECT * FROM transactions WHERE id = $transaction_id")->fetch_assoc();
    $items = $conn->query("SELECT p.name, p.price, ti.quantity FROM transaction_items ti JOIN products p ON ti.product_id = p.id WHERE ti.transaction_id = $transaction_id");
    
    $receipt = "Receipt for Transaction #$transaction_id\n";
    $receipt .= "Date: " . date('Y-m-d H:i:s') . "\n\n";
    $receipt .= "Items:\n";
    
    $subtotal = 0;
    while ($item = $items->fetch_assoc()) {
        $total = $item['price'] * $item['quantity'];
        $subtotal += $total;
        $receipt .= sprintf("%-30s %2d x %8.2f = %8.2f\n", $item['name'], $item['quantity'], $item['price'], $total);
    }
    
    $receipt .= "\n";
    $receipt .= sprintf("Subtotal: %8.2f\n", $subtotal);
    $receipt .= sprintf("Tax (12%%): %8.2f\n", $transaction['tax_amount']);
    $receipt .= sprintf("Total: %8.2f\n", $transaction['total_amount']);
    $receipt .= sprintf("Cash Received: %8.2f\n", $transaction['cash_received']);
    $receipt .= sprintf("Change: %8.2f\n", $transaction['change_amount']);
    
    return $receipt;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dry Goods POS System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --dark-green: #16423C;
            --medium-green: #6A9C89;
            --light-green: #C4DAD2;
            --off-white: #E9EFEC;
        }
        body {
            background-color: var(--off-white);
            color: var(--dark-green);
        }
        .navbar {
            background-color: var(--dark-green);
        }
        .card {
            background-color: white;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .btn-primary {
            background-color: var(--medium-green);
            border-color: var(--medium-green);
        }
        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }
        .list-group-item {
            background-color: var(--light-green);
            border-color: var(--medium-green);
        }
        .form-control:focus {
            border-color: var(--medium-green);
            box-shadow: 0 0 0 0.2rem rgba(106, 156, 137, 0.25);
        }
    </style>
</head>
<body>
    <nav class="navbar bg-indigo-500 flex justify-between items-center px-6 py-4 ">
                    <h1 class="text-xl font-semibold text-white">Dry Goods POS system</h1>
                    <div class="flex items-center gap-4">
                        <form method="post" class="inline">
                            <button type="submit" name="logout" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Sign out</button>
                        </form>
                    </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Products</h2>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select id="category" class="form-select">
                                <option value="">All Categories</option>
                                <?php foreach ($products_by_category as $category => $products): ?>
                                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <?php foreach ($products_by_category as $category => $products): ?>
                            <div class="category-products" data-category="<?php echo $category; ?>">
                                <h3><?php echo $category; ?></h3>
                                <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                                    <?php foreach ($products as $product): ?>
                                        <div class="col">
                                            <div class="card h-100 product-card" data-product-id="<?php echo $product['id']; ?>" data-product-name="<?php echo $product['name']; ?>" data-product-price="<?php echo $product['price']; ?>">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                                    <p class="card-text">₱<?php echo number_format($product['price'], 2); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Cart</h2>
                        <form method="post" id="cart-form">
                            <ul class="list-group mb-3" id="cart-items">
                                <?php
                                $total = 0;
                                foreach ($_SESSION['cart'] as $product_id => $quantity):
                                    $product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();
                                    $item_total = $product['price'] * $quantity;
                                    $total += $item_total;
                                ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo $product['name']; ?> (<?php echo $quantity; ?>)
                                        <span>₱<?php echo number_format($item_total, 2); ?></span>
                                        <button type="submit" name="remove_from_cart" value="<?php echo $product_id; ?>" class="btn btn-sm btn-danger">Remove</button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            
                            <?php
                            $tax = $total * 0.12;
                            $total_with_tax = $total + $tax;
                            ?>
                            
                            <div class="mb-3">
                                <strong>Subtotal: ₱<span id="subtotal"><?php echo number_format($total, 2); ?></span></strong>
                            </div>
                            <div class="mb-3">
                                <strong>Tax (12%): ₱<span id="tax"><?php echo number_format($tax, 2); ?></span></strong>
                            </div>
                            <div class="mb-3">
                                <strong>Total: ₱<span id="total"><?php echo number_format($total_with_tax, 2); ?></span></strong>
                            </div>
                            
                            <div class="mb-3">
                                <label for="cash_received" class="form-label">Cash Received</label>
                                <input type="number" name="cash_received" id="cash_received" class="form-control" min="<?php echo $total_with_tax; ?>" step="0.01" required>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Change: ₱<span id="change">0.00</span></strong>
                            </div>
                            
                            <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $total_with_tax; ?>">
                            <input type="hidden" name="tax_amount" id="tax_amount" value="<?php echo $tax; ?>">
                            
                            <button type="submit" name="process_transaction" class="btn btn-primary w-100" <?php echo empty($_SESSION['cart']) ? 'disabled' : ''; ?>>Process Transaction</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('category').addEventListener('change', function() {
            var selectedCategory = this.value;
            var categoryProducts = document.getElementsByClassName('category-products');
            
            for (var i = 0; i < categoryProducts.length; i++) {
                if (selectedCategory === "" || categoryProducts[i].getAttribute('data-category') === selectedCategory) {
                    categoryProducts[i].style.display = '';
                } else {
                    categoryProducts[i].style.display = 'none';
                }
            }
        });

        document.getElementById('cash_received').addEventListener('input', function() {
            var cashReceived = parseFloat(this.value) || 0;
            var totalAmount = parseFloat(document.getElementById('total_amount').value);
            var change = cashReceived - totalAmount;
            document.getElementById('change').textContent = change.toFixed(2);
        });

        // Add event listeners to all product cards
        var productCards = document.getElementsByClassName('product-card');
        for (var i = 0; i < productCards.length; i++) {
            productCards[i].addEventListener('click', function() {
                var productId = this.getAttribute('data-product-id');
                var productName = this.getAttribute('data-product-name');
                var productPrice = parseFloat(this.getAttribute('data-product-price'));
                
                // Add the product to the cart
                addToCart(productId, productName, productPrice);
            });
        }

        function addToCart(productId, productName, productPrice) {
            var cartItems = document.getElementById('cart-items');
            var existingItem = cartItems.querySelector('[data-product-id="' + productId + '"]');
            
            if (existingItem) {
                // Update existing item quantity
                var quantityElement = existingItem.querySelector('.quantity');
                var quantity = parseInt(quantityElement.textContent) + 1;
                quantityElement.textContent = quantity;
                
                var totalElement = existingItem.querySelector('.item-total');
                totalElement.textContent = '₱' + (productPrice * quantity).toFixed(2);
            } else {
                // Add new item to cart
                var li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.setAttribute('data-product-id', productId);
                li.innerHTML = productName + ' (<span class="quantity">1</span>) ' +
                               '<span class="item-total">₱' + productPrice.toFixed(2) + '</span>' +
                               '<button type="button" class="btn btn-sm btn-danger remove-item">Remove</button>';
                cartItems.appendChild(li);
                
                // Add event listener to remove button
                li.querySelector('.remove-item').addEventListener('click', function() {
                    cartItems.removeChild(li);
                    updateTotals();
                });
            }
            
            updateTotals();
        }

        function updateTotals() {
            var cartItems = document.getElementById('cart-items').children;
            var subtotal = 0;
            
            for (var i = 0; i < cartItems.length; i++) {
                var itemTotal = parseFloat(cartItems[i].querySelector('.item-total').textContent.replace('₱', ''));
                subtotal += itemTotal;
            }
            
            var tax = subtotal * 0.12;
            var total = subtotal + tax;
            
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('tax').textContent = tax.toFixed(2);
            document.getElementById('total').textContent = total.toFixed(2);
            document.getElementById('total_amount').value = total.toFixed(2);
            document.getElementById('tax_amount').value = tax.toFixed(2);
            
            // Update cash received min value
            document.getElementById('cash_received').min = total;
            
            // Enable/disable process transaction button
            document.querySelector('button[name="process_transaction"]').disabled = (cartItems.length === 0);
        }
    </script>
</body>
</html>