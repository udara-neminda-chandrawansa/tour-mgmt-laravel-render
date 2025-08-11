<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Management System | Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="max-w-lg mx-auto p-4 flex flex-col items-center justify-center min-h-screen">

        <h1 class="text-3xl mb-4">Login</h1>
        
        <form id="apiLoginForm" class="w-full space-y-4 bg-base-100 p-6 rounded-lg shadow-lg">
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Email</legend>
                <input type="email" class="input w-full" name="email" :value="old('email')" required autocomplete="username" placeholder="Type here" />
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Password</legend>
                <input type="password" class="input w-full" name="password" required autocomplete="new-password" placeholder="Type here" />
            </fieldset>
            <button class="btn w-full">
                Login
            </button>
        </form>
    </div>

    <script>
        // Handle the login form submission
        document.getElementById('apiLoginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const response = await fetch('/api/auth/login', {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                }, 
                body: JSON.stringify({
                    email: form.email.value, 
                    password: form.password.value
                })
            });

            const data = await response.json();
            console.log(data);

            if (data.token) {
                alert(data.message);
                localStorage.setItem('api_token', data.token); // for logging out later
                window.location.href = '/my-dashboard';
            } else {
                alert("Login failed: " + (data.message || 'Unknown error'));
            }
        });

    </script>

</body>

</html>
