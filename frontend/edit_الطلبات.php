**edit_الطلبات.php**

<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Get id from URL
$id = $_GET['id'];

// Fetch existing record details
$existingRecord = json_decode(file_get_contents('../backend/الطلبات.php?id=' . $id), true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-md mx-auto p-4 bg-white rounded-md shadow-md">
        <h2 class="text-lg font-bold text-emerald-600 mb-4">Edit Record</h2>
        <form id="edit-form">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="block w-full p-2 text-sm text-gray-700 border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500" value="<?= $existingRecord['name'] ?>">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="block w-full p-2 text-sm text-gray-700 border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500"><?= $existingRecord['description'] ?></textarea>
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-md">Update Record</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#edit-form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'PUT',
                    url: '../backend/الطلبات.php',
                    data: formData,
                    success: function(response) {
                        window.location.href = 'list_الطلبات.php';
                    }
                });
            });
        });
    </script>
</body>
</html>


**backend/الطلبات.php**

<?php
// Check if id is set
if (!isset($_GET['id'])) {
    die('Invalid request');
}

// Get id from URL
$id = $_GET['id'];

// Fetch existing record details
$existingRecord = array(
    'id' => $id,
    'name' => 'Record Name',
    'description' => 'Record Description'
);

// Return existing record details as JSON
echo json_encode($existingRecord);
?>


**Note:** This code assumes that the `list_الطلبات.php` page is already created and functional. Also, the `backend/الطلبات.php` file is assumed to be a simple API endpoint that returns the existing record details as JSON. You may need to modify the code to fit your specific requirements.