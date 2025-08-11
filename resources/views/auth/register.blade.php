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

        <h1 class="text-3xl mb-4">Register</h1>

        <form id="apiRegisterForm" class="w-full space-y-4 bg-base-100 p-6 rounded-lg shadow-lg">
            <fieldset class="fieldset w-full">
                <legend class="fieldset-legend">Username</legend>
                <input type="text" class="input w-full" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Type here" />
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Email</legend>
                <input type="email" class="input w-full" name="email" :value="old('email')" required autocomplete="username" placeholder="Type here" />
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Password</legend>
                <input type="password" class="input w-full" name="password" required autocomplete="new-password" placeholder="Type here" />
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Confirm Password</legend>
                <input type="password" class="input w-full" name="password_confirmation" required autocomplete="new-password" placeholder="Type here" />
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend">Role</legend>
                <select name="role" id="role" class="select w-full">
                    <option value="admin">Admin</option>
                    <option value="agent">Agent</option>
                </select>
            </fieldset>
            <button class="btn w-full">
                Register
            </button>
        </form>
    </div>

    <script>
        // Handle the register form submission
        document.getElementById('apiRegisterForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const response = await fetch('/api/auth/register', {
                method: 'POST'
                , headers: {
                    'Content-Type': 'application/json'
                    , 'Accept': 'application/json'
                , }
                , body: JSON.stringify({
                    name: form.name.value
                    , email: form.email.value
                    , password: form.password.value
                    , password_confirmation: form.password_confirmation.value
                    , role: form.role.value
                })
            });

            const data = await response.json();
            console.log(data);

            if (data.token) {
                alert(data.message + " | Token: " + data.token);
                localStorage.setItem('api_token', data.token); // for logging out later
                window.location.href = '/my-dashboard';
            } else {
                alert("Registration failed: " + (data.message || 'Unknown error'));
            }
        });

    </script>

</body>

</html>
