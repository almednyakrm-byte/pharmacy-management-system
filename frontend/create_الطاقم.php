**create_الطاقم.php**

<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
require_once '../config/db.php';

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $name = trim($_POST['name']);
    $position = trim($_POST['position']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validate form data
    if (empty($name) || empty($position) || empty($email) || empty($phone)) {
        $error = 'Please fill in all fields';
    } else {
        // Insert data into database
        $sql = "INSERT INTO الطاقم (name, position, email, phone) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $position, $email, $phone);
        $stmt->execute();

        // Redirect back to list page
        header('Location: list_الطاقم.php');
        exit;
    }
}

// Include header
require_once '../includes/header.php';

// Include form
?>

<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <h1 class="text-3xl font-bold text-emerald-600">Create New الطاقم</h1>
    <form action="" method="post" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" name="name" class="block w-full p-2 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-600 focus:border-emerald-600" required>
        </div>
        <div>
            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
            <input type="text" id="position" name="position" class="block w-full p-2 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-600 focus:border-emerald-600" required>
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="block w-full p-2 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-600 focus:border-emerald-600" required>
        </div>
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="tel" id="phone" name="phone" class="block w-full p-2 mt-1 border-gray-300 rounded-md shadow-sm focus:ring-emerald-600 focus:border-emerald-600" required>
        </div>
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600">Create</button>
    </form>
</div>

<?php
// Include footer
require_once '../includes/footer.php';
?>


**create_الطاقم.js**
javascript
$(document).ready(function() {
    // Submit form via AJAX
    $('form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../backend/الطاقم.php',
            data: $(this).serialize(),
            success: function(response) {
                if (response === 'success') {
                    window.location.href = 'list_الطاقم.php';
                } else {
                    alert('Error creating new record');
                }
            }
        });
    });
});


**Note:** Make sure to replace `../backend/الطاقم.php` with the actual URL of your backend script that handles the form submission. Also, ensure that the `list_الطاقم.php` page exists and is accessible.