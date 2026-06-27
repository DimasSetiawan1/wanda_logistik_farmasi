<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Logistik Farmasi RSPH</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 440px;
            width: 100%;
        }

        .auth-header {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            padding: 2rem;
            text-align: center;
            color: #fff;
        }

        .auth-header h3 {
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .auth-header p {
            font-size: 0.85rem;
            opacity: 0.85;
            margin: 0;
        }

        .auth-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border-color: #cbd5e1;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
        }

        .btn-auth {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            border: none;
            border-radius: 8px;
            padding: 0.65rem;
            font-weight: 600;
            width: 100%;
            color: #fff;
            transition: opacity 0.2s ease;
        }

        .btn-auth:hover {
            opacity: 0.9;
            color: #fff;
        }

        .auth-footer {
            text-align: center;
            font-size: 0.8rem;
            color: #64748b;
        }

        .auth-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    @yield('content')

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
