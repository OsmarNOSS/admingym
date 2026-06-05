<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminGym</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(135deg, #F4F8F5 0%, #EAF2F1 100%);
            color: #001F27;
        }

        .page {
            width: 100%;
            height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
            padding: 24px 32px;
        }

        header {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 88px;
            padding: 9px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            color: #001F27;
            border: 1px solid transparent;
            transition: 0.2s ease;
            white-space: nowrap;
        }

        .nav-link:hover {
            border-color: #719A73;
            background: rgba(255, 255, 255, 0.7);
        }

        .nav-link-primary {
            border-color: #003A35;
            color: #003A35;
            background: white;
        }

        .nav-link-primary:hover {
            background: #003A35;
            color: white;
        }

        main {
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 16px;
        }

        .content {
            width: 100%;
            max-width: 760px;
            transform: translateY(-10px);
        }

        .logo {
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            border-radius: 20px;
            background: linear-gradient(135deg, #001F27, #003A35);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 30px;
            box-shadow: 0 14px 30px rgba(0, 31, 39, 0.22);
        }

        h1 {
            margin: 0 0 16px;
            font-size: clamp(38px, 5vw, 64px);
            line-height: 1;
            letter-spacing: -0.055em;
            font-weight: 800;
        }

        h1 span {
            color: #003A35;
        }

        p {
            margin: 0 auto;
            max-width: 640px;
            color: #66736F;
            font-size: 18px;
            line-height: 1.65;
        }

        footer {
            text-align: center;
            color: #66736F;
            font-size: 14px;
            padding-bottom: 4px;
        }

        @media (max-width: 640px) {
            .page {
                padding: 18px;
            }

            header {
                justify-content: center;
            }

            nav {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .nav-link {
                flex: 1;
                min-width: 120px;
            }

            .logo {
                width: 64px;
                height: 64px;
                font-size: 26px;
                margin-bottom: 20px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="page">
        @if (Route::has('login'))
            <header>
                <nav>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link nav-link-primary">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link nav-link-primary">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            </header>
        @endif

        <main>
            <div class="content">
                <div class="logo">
                    AG
                </div>

                <h1>
                    Bienvenido a <span>AdminGym</span>
                </h1>

                <p>
                    Sistema para la gestión de clientes, membresías, pagos, asistencias,
                    entrenadores y rutinas dentro del gimnasio.
                </p>
            </div>
        </main>

        <footer>
            AdminGym — Sistema de administración para gimnasio.
        </footer>
    </div>
</body>
</html>