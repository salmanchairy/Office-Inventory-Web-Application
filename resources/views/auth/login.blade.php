
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Pelindo Regional 1</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        :root {
            --pelindo-blue: #0876b9;
            --pelindo-blue-dark: #07558b;
            --pelindo-light: #32b7df;
            --navy: #061b35;
            --text-dark: #123453;
            --text-muted: #71849a;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
            margin: 0;
        }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #edf4fa;
        }

        /* Layout utama */
        .login-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(440px, 0.92fr);
        }

        /* Panel kiri: ruang server */
        .visual-panel {
            position: relative;
            display: flex;
            align-items: center;
            padding: clamp(35px, 5vw, 76px);
            overflow: hidden;
            color: #ffffff;

            background-color: var(--navy);
            background-image:
                linear-gradient(
                    90deg,
                    rgba(4, 21, 42, 0.88) 0%,
                    rgba(4, 21, 42, 0.69) 55%,
                    rgba(4, 21, 42, 0.54) 100%
                ),
                linear-gradient(
                    0deg,
                    rgba(3, 19, 39, 0.50),
                    transparent 65%
                ),
                url("https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1800&q=85");

            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        /* Aksen biru halus, bukan garis pemisah */
        .visual-panel::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(
                180deg,
                rgba(50, 183, 223, 0.15),
                rgba(50, 183, 223, 0.75),
                rgba(8, 118, 185, 0.20)
            );
        }

        .visual-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 620px;
            margin: 0 auto;
        }

        .system-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            margin-bottom: 28px;

            color: #e7f7ff;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 30px;

            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.3px;
            text-transform: uppercase;
            backdrop-filter: blur(8px);
        }

        .system-label i {
            color: var(--pelindo-light);
            font-size: 15px;
        }

        .visual-content h1 {
            margin: 0 0 22px;
            font-size: clamp(34px, 3.6vw, 54px);
            font-weight: 750;
            line-height: 1.15;
            letter-spacing: -1.3px;
        }

        .visual-content h1 span {
            color: var(--pelindo-light);
        }

        .visual-description {
            max-width: 490px;
            margin: 0;
            color: #d8e5f1;
            font-size: 15px;
            line-height: 1.9;
        }

        .visual-features {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 30px;
        }

        .feature-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;

            color: #e1edf7;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 9px;

            font-size: 12px;
        }

        .feature-item i {
            color: var(--pelindo-light);
        }

        .visual-footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.20);

            color: #bdcede;
            font-size: 11px;
            letter-spacing: 0.8px;
        }

        /* Panel kanan */
        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;

            min-width: 0;
            padding: 48px clamp(25px, 4vw, 65px);

            background: linear-gradient(
                145deg,
                #eaf2f9 0%,
                #f5f8fc 48%,
                #e7f1f8 100%
            );
        }

        /* Kartu login */
        .login-card {
            width: 100%;
            max-width: 440px;
            padding: 44px 40px 32px;

            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(8, 118, 185, 0.09);
            border-radius: 22px;

            box-shadow:
                0 25px 70px rgba(10, 46, 79, 0.09),
                0 3px 12px rgba(10, 46, 79, 0.025);
        }

        .brand-logo {
            display: block;
            width: min(100%, 285px);
            max-height: 95px;
            height: auto;
            object-fit: contain;

            margin: 0 auto 31px;
        }

        .welcome-title {
            margin-bottom: 9px;
            color: var(--text-dark);
            font-size: 27px;
            font-weight: 750;
            letter-spacing: -0.5px;
        }

        .welcome-subtitle {
            margin-bottom: 30px;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.85;
        }

        .welcome-subtitle strong {
            color: #48647f;
            font-weight: 650;
        }

        .form-label {
            margin-bottom: 8px;
            color: #29445e;
            font-size: 13px;
            font-weight: 650;
        }

        .input-group {
            flex-wrap: nowrap;
        }

        .input-group-text {
            display: flex;
            justify-content: center;
            align-items: center;

            width: 48px;
            color: #69849c;
            background: #f5f9fd;
            border-color: #dce7f1;
            border-radius: 11px 0 0 11px;
        }

        .input-group-text i {
            font-size: 16px;
        }

        .form-control {
            min-width: 0;
            height: 49px;
            padding: 10px 13px;

            color: #183650;
            background: #ffffff;
            border-color: #dce7f1;
            border-radius: 0 11px 11px 0;

            font-size: 14px;
            box-shadow: none;
        }

        .form-control::placeholder {
            color: #9aaabd;
        }

        .form-control:focus {
            color: #183650;
            background: #ffffff;
            border-color: var(--pelindo-blue);
            box-shadow: 0 0 0 3px rgba(8, 118, 185, 0.12);
        }

        .login-btn {
            display: flex;
            justify-content: center;
            align-items: center;

            width: 100%;
            height: 51px;
            margin-top: 5px;

            color: #ffffff;
            background: linear-gradient(
                110deg,
                var(--pelindo-blue),
                var(--pelindo-blue-dark)
            );

            border: 0;
            border-radius: 11px;

            font-size: 14px;
            font-weight: 650;

            box-shadow: 0 9px 20px rgba(8, 118, 185, 0.18);
            transition: background 0.2s ease, transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .login-btn:hover {
            color: #ffffff;
            background: #064b7c;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(8, 118, 185, 0.23);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #e9eff5;

            text-align: center;
            color: #8b9bad;
            font-size: 11px;
            line-height: 1.9;
        }

        .login-footer strong {
            color: #55718a;
            font-weight: 650;
        }

        .alert {
            border-radius: 10px;
            font-size: 13px;
        }

        /* Tablet */
        @media (max-width: 1050px) {
            .login-page {
                grid-template-columns: minmax(0, 1fr) minmax(390px, 0.9fr);
            }

            .visual-panel {
                padding: 38px;
            }

            .form-panel {
                padding: 35px 25px;
            }

            .login-card {
                padding: 38px 30px 29px;
            }
        }

        /* HP dan layar sempit */
        @media (max-width: 760px) {
            .login-page {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            .visual-panel {
                min-height: 235px;
                padding: 30px 24px;
                background-position: center 43%;
            }

            .visual-panel::after {
                top: auto;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                height: 2px;
            }

            .system-label {
                margin-bottom: 15px;
                padding: 8px 12px;
                font-size: 10px;
            }

            .visual-content h1 {
                margin-bottom: 12px;
                font-size: clamp(26px, 6vw, 34px);
                letter-spacing: -0.5px;
            }

            .visual-description {
                max-width: 550px;
                font-size: 12px;
                line-height: 1.7;
            }

            .visual-features {
                gap: 7px;
                margin-top: 16px;
            }

            .feature-item {
                padding: 7px 9px;
                font-size: 10px;
            }

            .visual-footer {
                display: none;
            }

            .form-panel {
                flex: 1;
                align-items: flex-start;
                padding: 28px 18px 32px;
            }

            .login-card {
                max-width: 460px;
                margin: 0 auto;
                padding: 30px 25px 24px;
                border-radius: 18px;
            }

            .brand-logo {
                width: min(100%, 240px);
                max-height: 78px;
                margin-bottom: 24px;
            }

            .welcome-title {
                font-size: 24px;
            }

            .welcome-subtitle {
                margin-bottom: 24px;
            }

            .login-footer {
                margin-top: 23px;
                padding-top: 16px;
            }
        }

        @media (max-width: 380px) {
            .visual-panel {
                min-height: 215px;
                padding: 24px 19px;
            }

            .visual-content h1 {
                font-size: 25px;
            }

            .visual-description {
                font-size: 11px;
            }

            .form-panel {
                padding: 22px 13px 26px;
            }

            .login-card {
                padding: 27px 19px 22px;
            }
        }

        /* Laptop dengan tinggi layar rendah */
        @media (min-width: 761px) and (max-height: 760px) {
            .form-panel {
                padding-top: 25px;
                padding-bottom: 25px;
            }

            .login-card {
                padding-top: 30px;
                padding-bottom: 25px;
            }

            .brand-logo {
                max-height: 72px;
                margin-bottom: 20px;
            }

            .welcome-subtitle {
                margin-bottom: 22px;
            }

            .visual-footer {
                margin-top: 30px;
            }
        }
    </style>
</head>

<body>

<div class="login-page">

    <!-- Panel kiri: identitas teknologi Pelindo -->
    <section class="visual-panel">
        <div class="visual-content">

            <div class="system-label">
                <i class="bi bi-shield-check"></i>
                Sistem Internal Pelindo
            </div>

            <h1>
                Kelola Aset IT<br>
                <span>Lebih Terintegrasi.</span>
            </h1>

            <p class="visual-description">
                Sistem inventaris dan pemeriksaan perangkat IT
                untuk mendukung pengelolaan aset server room
                Pelindo Regional 1 secara terstruktur.
            </p>

            <div class="visual-features">
                <div class="feature-item">
                    <i class="bi bi-qr-code-scan"></i>
                    QR Code Aset
                </div>

                <div class="feature-item">
                    <i class="bi bi-clipboard-check"></i>
                    Pemeriksaan Aset
                </div>

                <div class="feature-item">
                    <i class="bi bi-camera"></i>
                    Dokumentasi Foto
                </div>
            </div>

            <div class="visual-footer">
                <i class="bi bi-server me-2"></i>
                INVENTORY MANAGEMENT SYSTEM
            </div>

        </div>
    </section>

    <!-- Panel kanan: form login -->
    <main class="form-panel">
        <div class="login-card">

            <!-- Logo Pelindo -->
            <img
                src="{{ asset('images/Pelindo Logo.png') }}"
                alt="Logo Pelindo"
                class="brand-logo"
            >

            <div class="text-center">
                <h2 class="welcome-title">
                    Selamat Datang
                </h2>

                <p class="welcome-subtitle">
                    Masuk untuk mengakses<br>
                    <strong>Sistem Inventaris IT Server Room</strong><br>
                    Pelindo Regional 1
                </p>
            </div>

            <!-- Pesan kesalahan autentikasi -->
            @if ($errors->any())
                <div class="alert alert-danger py-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form login: route dan field tetap dipertahankan -->
            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">
                        Username
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control"
                            placeholder="Masukkan username"
                            value="{{ old('username') }}"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        class="form-check-input"
                        @checked(old('remember'))
                    >
                    <label class="form-check-label text-muted small" for="remember">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <button type="submit" class="btn login-btn">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Masuk ke Sistem
                </button>
            </form>

            <div class="login-footer">
                <strong>© {{ date('Y') }} Pelindo Regional 1</strong><br>
                Sistem Inventaris IT Server Room
            </div>

        </div>
    </main>

</div>

</body>
</html>
