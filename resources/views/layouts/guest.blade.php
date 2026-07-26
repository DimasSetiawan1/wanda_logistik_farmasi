<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Logistik Farmasi RS Puspa Husada</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fafb',
                            100: '#d9f2f5',
                            200: '#b4e5ec',
                            300: '#7fd3e0',
                            400: '#41b9ce',
                            500: '#04aabe',
                            600: '#03899c',
                            700: '#036e7e',
                            800: '#075967',
                            900: '#0b4a56',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 antialiased selection:bg-brand-500 selection:text-white relative overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>

    @yield('content')
</body>
</html>
