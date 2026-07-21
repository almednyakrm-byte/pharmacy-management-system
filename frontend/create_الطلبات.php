**create_الطلبات.php**

<?php
// Session validation
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Include header and navigation
include 'header.php';
include 'navigation.php';
?>

<div class="container mx-auto p-4 pt-6 md:p-6 lg:px-12">
    <div class="bg-white rounded-lg shadow-md p-4">
        <h2 class="text-lg font-bold text-emerald-600 mb-4">إضافة طلب جديد</h2>
        <form id="create-request-form">
            <div class="mb-4">
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">اسم الطلب</label>
                <input type="text" id="name" name="name" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">وصف الطلب</label>
                <textarea id="description" name="description" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600" required></textarea>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-bold text-gray-700 mb-2">حالة الطلب</label>
                <select id="status" name="status" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600">
                    <option value="">اختر حالة الطلب</option>
                    <option value="pending">قيد الانتظار</option>
                    <option value="in_progress">في طور التنفيذ</option>
                    <option value="completed">مكتمل</option>
                </select>
            </div>
            <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-lg">حفظ</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#create-request-form').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '../backend/الطلبات.php',
                data: formData,
                success: function(response) {
                    if (response === 'success') {
                        window.location.href = 'list_الطلبات.php';
                    } else {
                        alert('حدث خطأ أثناء الحفظ');
                    }
                }
            });
        });
    });
</script>

<?php
// Include footer
include 'footer.php';
?>

**Note:** Make sure to replace `header.php`, `navigation.php`, and `footer.php` with your actual header, navigation, and footer files. Also, ensure that the `../backend/الطلبات.php` file exists and is properly configured to handle the form data.