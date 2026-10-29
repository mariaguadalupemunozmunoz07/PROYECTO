<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Municipal de Miranda</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Figtree', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background-color: #4c1d95;
            background-image:
                linear-gradient(135deg, rgba(76, 29, 149, 0.80), rgba(190, 24, 93, 0.55)),
                url('{{ asset('img/biblioteca.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .tarjeta {
            width: 100%;
            max-width: 560px;
            text-align: center;
            padding: 48px 32px;
            border-radius: 24px;
            background: rgba(233, 213, 255, 0.92);
            border: 1px solid #c4b5fd;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        }
        .etiqueta {
            display: inline-block;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #be185d;
            margin-bottom: 14px;
        }
        h1 {
            font-size: 36px;
            line-height: 1.15;
            font-weight: 700;
            color: #4c1d95;
            margin-bottom: 14px;
        }
        p {
            font-size: 17px;
            line-height: 1.5;
            color: #6d28d9;
            margin-bottom: 32px;
        }
        .botones {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            min-width: 170px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-rosa {
            background: #fbcfe8;
            color: #be185d;
            border: 2px solid #f9a8d4;
        }
        .btn-rosa:hover {
            background: #f9a8d4;
            color: #9d174d;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(190, 24, 93, 0.25);
        }
        .btn-morado {
            background: #a855f7;
            color: #ffffff;
            border: 2px solid #a855f7;
        }
        .btn-morado:hover {
            background: #9333ea;
            border-color: #9333ea;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(124, 58, 237, 0.35);
        }
        .pie {
            margin-top: 28px;
            font-size: 13px;
            color: #7c3aed;
        }
    </style>
</head>
<body>
    <div class="tarjeta">
        <span class="etiqueta">Bienvenido</span>
        <h1>Biblioteca Municipal de Miranda</h1>
        <p>Consulta el catálogo, aparta tus libros y revisa tus préstamos desde un solo lugar.</p>

        <div class="botones">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-morado">Ir a mi panel</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-rosa">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-morado">Registrarse</a>
            @endauth
        </div>

        <div class="pie">Leer es abrir una puerta a otro mundo</div>
    </div>
</body>
</html>