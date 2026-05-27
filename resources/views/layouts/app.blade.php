@php
    use Illuminate\Support\Facades\Auth;
@endphp
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Club</title>


    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Grocery Club</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <a class="nav-link d-flex align-items-center" href="{{ route('cart.index') }}">
                     Carrinho
                    @php
                        $cart = session('cart', []);
                        $totalQty = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    @if($totalQty > 0)
                        <span class="badge bg-success ms-1">{{ $totalQty }}</span>
                    @endif
                </a>
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Painel de Controlo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registar</a></li>
                @endauth
            </ul>

        </div>
    </div>
    </nav>

    

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
