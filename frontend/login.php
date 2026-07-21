<!-- login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <style>
        body {
            background-image: linear-gradient(to bottom, #0f0f0f, #0f0f0f);
            background-size: 100% 300px;
            background-position: 0% 100%;
            transition: background-position 1s linear;
        }
        
        .glassmorphic {
            background: linear-gradient(90deg, #ffffff44, #ffffff44);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 20px;
        }
        
        .gradient {
            background: linear-gradient(90deg, #0f0f0f, #0f0f0f);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 20px;
        }
        
        .gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #ffffff44, #ffffff44);
            backdrop-filter: blur(20px);
            border-radius: 20px;
        }
        
        .gradient::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #0f0f0f, #0f0f0f);
            backdrop-filter: blur(20px);
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-emerald-600">
    <div class="container mx-auto p-4 pt-6 md:p-6 lg:p-12 xl:p-12 2xl:p-12">
        <div class="glassmorphic mx-auto p-4 pt-6 md:p-6 lg:p-12 xl:p-12 2xl:p-12 bg-white rounded-lg shadow-lg">
            <div class="text-center mb-4">
                <h1 class="text-3xl font-bold text-teal-500">Login</h1>
            </div>
            <form id="login-form" class="space-y-6">
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                    <input type="text" id="username" name="username" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-teal-500 focus:border-teal-500" pattern="[A-Za-z\u0600-\u06FF0-9\s]+" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <input type="password" id="password" name="password" class="block p-2 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-teal-500 focus:border-teal-500" required>
                </div>
                <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-teal-500 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-300">Login</button>
            </form>
            <div class="text-center mt-4">
                <p class="text-sm font-medium text-gray-900">Don't have an account? <a href="register.php" class="text-teal-500 hover:text-teal-700">Register</a></p>
            </div>
        </div>
    </div>
    
    <script>
        const form = document.getElementById('login-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            try {
                const response = await fetch('../backend/auth.php?action=login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });
                const data = await response.json();
                if (data.success) {
                    alert('Login successful!');
                    window.location.href = 'dashboard.php';
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    </script>
</body>
</html>


This code uses Tailwind CSS to create a premium-looking login page with a glassmorphic layout and gradients. The form includes input fields for username and password, with validation rules using standard HTML input pattern attributes. The form is submitted using AJAX with the Fetch API, and the response is handled dynamically using JavaScript. The code also includes a link to the register page.