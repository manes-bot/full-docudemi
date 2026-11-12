<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DocuDemi</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #F6F8F7;
            color: #172B1C;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            height: 100vh;
            background: #166534;
            color: white;
            padding: 25px 15px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            padding: 0 15px 30px;
        }

        .menu {
            display: block;
            padding: 12px 15px;
            margin-bottom: 6px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .menu:hover {
            background: #15803D;
        }

        .main {
            margin-left: 240px;
            min-height: 100vh;
        }

        .navbar {
            height: 72px;
            background: white;
            border-bottom: 1px solid #E2E8E4;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .content {
            padding: 30px;
        }

        .content h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #64748B;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

    <aside class="sidebar">

        <div class="logo">
            DocuDemi
        </div>

        <a href="/alumni/dashboard" class="menu">
            Dashboard
        </a>

        <a href="/pengajuan/create" class="menu">
            Ajukan Layanan
        </a>

        <a href="/alumni/riwayat" class="menu">
            Pengajuan Saya
        </a>

        <a href="#" class="menu">
            Notifikasi
        </a>

        <a href="#" class="menu">
            Profil
        </a>

        <a href="#" class="menu">
            Logout
        </a>

    </aside>

    <main class="main">

        <nav class="navbar">
            <div>
                Sistem Layanan Dokumen Akademik
            </div>

            <div>
                Alumni
            </div>
        </nav>

        <section class="content">
            @yield('content')
        </section>

    </main>

</body>
</html>