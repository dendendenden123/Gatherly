<!-- 
    This is a Blade template for a modern green/red themed registration form.
    It includes sections for title, subtitle, form-action, form-fields, button-text, and footer-text.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Modern Green/Red Design</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/form.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <a href="#" class="back-link btn btn-link p-0 mb-3 left-align top-2">
                <img src="{{ asset('images/icons/back.png') }}" alt="Back"
                    style="height: 20px; vertical-align: middle; margin-right: 6px;">
            </a>
            <h1 class="auth-title">@yield("title")</h1>
            <p class="auth-subtitle">@yield("subtitle")</p>

            <form class="auth-form" method="POST" action="@yield('form-action')">
                @csrf
                @yield("form-fields")
                <button type="submit" class="auth-button"> @yield("form-button-text")</button>
            </form>

            <div class="auth-footer">
                @yield("footer-text")
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const backLink = document.querySelector(".back-link");
        backLink.addEventListener("click", function (event) {
            event.preventDefault();
            window.history.back();
        });
    });
</script>

</html>