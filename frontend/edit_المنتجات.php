**edit_المنتجات.php**

<?php
// Session validation
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Get product ID from URL
$id = $_GET['id'];

// Fetch product details via AJAX
$js = '
    $(document).ready(function() {
        $.get("../backend/المنتجات.php?id=' . $id . '")
            .done(function(data) {
                var product = JSON.parse(data);
                $("#name").val(product.name);
                $("#description").val(product.description);
                $("#price").val(product.price);
            })
            .fail(function() {
                alert("Error fetching product details");
            });
    });
';

// Include JavaScript code
echo '<script>' . $js . '</script>';

// Form HTML
?>

<div class="max-w-md mx-auto p-4 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-bold text-emerald-600 mb-4">Edit Product</h2>
    <form id="edit-product-form" class="space-y-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" name="name" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600">
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600"></textarea>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input type="number" id="price" name="price" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600">
        </div>
        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">Update Product</button>
    </form>
</div>

<?php
// AJAX PUT request to update product
$js .= '
    $(document).ready(function() {
        $("#edit-product-form").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: "PUT",
                url: "../backend/المنتجات.php",
                data: formData,
                success: function() {
                    window.location.href = "list_المنتجات.php";
                },
                error: function() {
                    alert("Error updating product");
                }
            });
        });
    });
';

// Include JavaScript code
echo '<script>' . $js . '</script>';
?>


**backend/المنتجات.php**

<?php
// Check if product ID is set
if (!isset($_GET['id'])) {
    http_response_code(400);
    exit;
}

// Get product ID
$id = $_GET['id'];

// Fetch product details from database
$product = fetchProduct($id);

// Output product details as JSON
echo json_encode($product);

// Helper function to fetch product details from database
function fetchProduct($id) {
    // Replace with your database connection and query
    $db = new PDO('mysql:host=localhost;dbname=your_database', 'your_username', 'your_password');
    $stmt = $db->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
}
?>