<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="Correo" class="form-label">Email</label>
                                <input type="Correo" class="form-control" id="Correo" name="Correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="Contrasena" class="form-label">Contraseña</label>
                                <input type="Contrasena
                                " class="form-control" id="Contrasena" name="Contrasena" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>