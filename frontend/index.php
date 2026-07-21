<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة صيدليات</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(7.5px);
            -webkit-backdrop-filter: blur(7.5px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body class="bg-emerald-600 h-screen">
    <div class="container mx-auto p-4 pt-6 md:p-6 lg:p-12 xl:p-24">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl text-white">نظام إدارة صيدليات</h1>
            <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='logout.php'">تسجيل الخروج</button>
        </div>
        <div class="mt-12">
            <h2 class="text-2xl text-white">مرحباً!</h2>
            <p class="text-lg text-white">مرحباً بك في نظام إدارة صيدليات</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-12">
            <div class="glass p-4 rounded">
                <h3 class="text-lg text-white">إجمالي المنتجات</h3>
                <p id="total-products" class="text-2xl text-white"></p>
            </div>
            <div class="glass p-4 rounded">
                <h3 class="text-lg text-white">إجمالي الطاقم</h3>
                <p id="total-staff" class="text-2xl text-white"></p>
            </div>
            <div class="glass p-4 rounded">
                <h3 class="text-lg text-white">إجمالي الطلبات</h3>
                <p id="total-orders" class="text-2xl text-white"></p>
            </div>
            <div class="glass p-4 rounded">
                <h3 class="text-lg text-white">إجمالي الإيرادات</h3>
                <p id="total-revenue" class="text-2xl text-white"></p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-12">
            <div class="glass p-4 rounded">
                <h3 class="text-lg text-white">إدارة المنتجات</h3>
                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='products.php'">إدارة</button>
            </div>
            <div class="glass p-4 rounded">
                <h3 class="text-lg text-white">إدارة الطاقم</h3>
                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='staff.php'">إدارة</button>
            </div>
            <div class="glass p-4 rounded">
                <h3 class="text-lg text-white">إدارة الطلبات</h3>
                <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded" onclick="location.href='orders.php'">إدارة</button>
            </div>
        </div>
    </div>

    <script>
        fetch('api/stats.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-products').innerText = data.totalProducts;
                document.getElementById('total-staff').innerText = data.totalStaff;
                document.getElementById('total-orders').innerText = data.totalOrders;
                document.getElementById('total-revenue').innerText = data.totalRevenue;
            });
    </script>
</body>
</html>