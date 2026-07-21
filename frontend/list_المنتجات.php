**list_المنتجات.php**

<?php
// Session validation
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المنتجات</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .emerald-600 {
            color: #008000;
        }
        .teal-500 {
            color: #0097a7;
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md p-4">
        <nav class="flex justify-between items-center">
            <a href="index.php" class="text-lg font-bold">الصفحة الرئيسية</a>
            <div class="flex items-center">
                <span class="mr-2">مرحباً, <?= $_SESSION['username'] ?></span>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='logout.php'">تسجيل الخروج</button>
            </div>
        </nav>
    </header>
    <main class="max-w-7xl mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">المنتجات</h1>
        <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='create_المنتجات.php'">إضافة منتج جديد</button>
        <div class="flex justify-between items-center mb-4">
            <input type="search" class="w-full p-2 pl-10 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder="بحث...">
            <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">بحث</button>
        </div>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="p-2 border border-gray-300">الاسم</th>
                    <th class="p-2 border border-gray-300">الوصف</th>
                    <th class="p-2 border border-gray-300">الإجراءات</th>
                </tr>
            </thead>
            <tbody id="products-list">
                <!-- products will be loaded here -->
            </tbody>
        </table>
    </main>

    <script>
        const searchInput = document.querySelector('input[type="search"]');
        const searchButton = document.querySelector('button:last-child');
        const productsList = document.getElementById('products-list');

        searchButton.addEventListener('click', () => {
            const searchQuery = searchInput.value.trim();
            fetch('../backend/المنتجات.php?search=' + searchQuery)
                .then(response => response.json())
                .then(data => {
                    productsList.innerHTML = '';
                    data.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="p-2 border border-gray-300">${product.name}</td>
                            <td class="p-2 border border-gray-300">${product.description}</td>
                            <td class="p-2 border border-gray-300">
                                <a href="edit_المنتجات.php?id=${product.id}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mr-2">تعديل</a>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteProduct(${product.id})">حذف</button>
                            </td>
                        `;
                        productsList.appendChild(row);
                    });
                });
        });

        function deleteProduct(id) {
            if (confirm('هل أنت متأكد من حذف المنتج؟')) {
                fetch('../backend/المنتجات.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('تم حذف المنتج بنجاح');
                        location.reload();
                    } else {
                        alert('حدث خطأ أثناء حذف المنتج');
                    }
                });
            }
        }

        fetch('../backend/المنتجات.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(product => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="p-2 border border-gray-300">${product.name}</td>
                        <td class="p-2 border border-gray-300">${product.description}</td>
                        <td class="p-2 border border-gray-300">
                            <a href="edit_المنتجات.php?id=${product.id}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mr-2">تعديل</a>
                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteProduct(${product.id})">حذف</button>
                        </td>
                    `;
                    productsList.appendChild(row);
                });
            });
    </script>
</body>
</html>

This code includes a premium Tailwind UI design with a specific color palette matching the theme. It also includes session validation, a search bar, and AJAX calls to fetch and delete products. The `deleteProduct` function is used to delete a product with a confirmation prompt.