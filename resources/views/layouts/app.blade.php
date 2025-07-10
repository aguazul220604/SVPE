<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incubadora UPT - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(to bottom, #2c2c2c, #1a1a1a);
            color: white;
            padding: 20px 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-header {
            text-align: center;
            padding: 0 20px;
        }

        .sidebar-header img {
            max-width: 100px;
            margin: 0 auto 15px auto;
            display: block;
        }

        .sidebar-header h6 {
            margin-bottom: 10px;
        }

        .separator {
            border-bottom: 1px solid #ffffff55;
            margin: 30px 20px 50px 20px; /* 80px total separation */
        }

        .nav-links {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            transition: background 0.3s;
            width: 100%;
            text-align: center;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #f73878;
            border-radius: 5px;
            padding-left: 2rem;
            padding-right: 2rem;
          
         
        }

        .logout-container {
            margin-top: 50px; /* Espacio entre botones de navegación y logout */
            padding: 0 20px 20px;
            text-align: center;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

    <!-- Barra lateral izquierda -->
    <div class="sidebar">
        <div>
            <div class="sidebar-header">
             
                <h6>Incubadora UPT</h6>
            </div>

            <div class="separator"></div>

            <div class="nav-links">
                <a class="nav-link {{ request()->is('proyectos') ? 'active' : '' }}" 
                   href="{{ route('proyectos.index') }}">Proyectos</a>

                <a class="nav-link {{ request()->is('monitoreo') ? 'active' : '' }}" 
                   href="{{ route('monitoreo.index') }}">Monitoreo</a>
            </div>
        </div>

        <div class="logout-container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        @yield('content')
    </div>

</body>
</html>
