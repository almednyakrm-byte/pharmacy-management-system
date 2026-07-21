**list_الطاقم.php**

<?php
// Session validation
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الطاقم</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .header {
            background-color: #1a202c;
            padding: 1rem;
            text-align: center;
        }
        .header a {
            color: #fff;
            text-decoration: none;
        }
        .header a:hover {
            color: #ccc;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 1rem;
            text-align: left;
        }
        .table th {
            background-color: #f0f0f0;
        }
        .search-bar {
            width: 50%;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
        }
        .search-bar input[type="search"] {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 0.5rem;
        }
        .search-bar input[type="search"]:focus {
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(13, 130, 18, 0.25);
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">Back to Index</a>
        <span class="text-lg font-bold text-emerald-600">Welcome, <?php echo $_SESSION['username']; ?></span>
        <a href="logout.php" class="text-lg font-bold text-teal-500">Logout</a>
    </div>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-emerald-600">الطاقم</h1>
        <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='create_الطاقم.php'">Add New Item</button>
        <div class="search-bar">
            <input type="search" id="search" placeholder="Search...">
            <button class="bg-emerald-600 hover:bg-emerald-800 text-white font-bold py-2 px-4 rounded" onclick="searchRecords()">Search</button>
        </div>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="records">
                <?php
                // Fetch records from backend
                $records = json_decode(file_get_contents('../backend/الطاقم.php'), true);
                foreach ($records as $record) {
                    echo '<tr>';
                    echo '<td>' . $record['column1'] . '</td>';
                    echo '<td>' . $record['column2'] . '</td>';
                    echo '<td>';
                    echo '<a href="edit_الطاقم.php?id=' . $record['id'] . '" class="text-emerald-600 hover:text-emerald-800">Edit</a>';
                    echo '<button class="text-teal-500 hover:text-teal-700" onclick="deleteRecord(' . $record['id'] . ')">Delete</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function searchRecords() {
            const searchInput = document.getElementById('search');
            const searchQuery = searchInput.value.trim();
            if (searchQuery !== '') {
                fetch('../backend/الطاقم.php?search=' + searchQuery)
                    .then(response => response.json())
                    .then(data => {
                        const records = document.getElementById('records');
                        records.innerHTML = '';
                        data.forEach(record => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${record.column1}</td>
                                <td>${record.column2}</td>
                                <td>
                                    <a href="edit_الطاقم.php?id=${record.id}" class="text-emerald-600 hover:text-emerald-800">Edit</a>
                                    <button class="text-teal-500 hover:text-teal-700" onclick="deleteRecord(${record.id})">Delete</button>
                                </td>
                            `;
                            records.appendChild(row);
                        });
                    });
            } else {
                fetch('../backend/الطاقم.php')
                    .then(response => response.json())
                    .then(data => {
                        const records = document.getElementById('records');
                        records.innerHTML = '';
                        data.forEach(record => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${record.column1}</td>
                                <td>${record.column2}</td>
                                <td>
                                    <a href="edit_الطاقم.php?id=${record.id}" class="text-emerald-600 hover:text-emerald-800">Edit</a>
                                    <button class="text-teal-500 hover:text-teal-700" onclick="deleteRecord(${record.id})">Delete</button>
                                </td>
                            `;
                            records.appendChild(row);
                        });
                    });
            }
        }

        function deleteRecord(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                fetch('../backend/الطاقم.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Record deleted successfully!');
                        searchRecords();
                    } else {
                        alert('Error deleting record!');
                    }
                });
            }
        }
    </script>
</body>
</html>

**Note:** This code assumes that you have a backend PHP script (`../backend/الطاقم.php`) that returns a JSON array of records. The `searchRecords()` function fetches the records from the backend and updates the table accordingly. The `deleteRecord()` function sends a DELETE request to the backend to delete the record.