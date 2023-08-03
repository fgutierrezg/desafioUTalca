<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Usuario</title>
  <!-- Enlace al archivo CSS de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
    <div class="card bg-light">
      <div class="card-body">
        <h2 class="card-title text-center text-success">Perfil de Usuario</h2>
        <hr>
        <div class="row">
          <div class="col-sm-4">
            <img src="https://via.placeholder.com/150" alt="Imagen de perfil" class="img-thumbnail">
          </div>
          <div class="col-sm-8">
            <h3 class="text-info">Bienvenido {{ $name }}</h3>
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Ocupación:</strong> Desarrollador Web</p>
            <p><strong>Token:</strong> {{ $token != null ? $token : "No disponible" }}</p>
            <a href="{{ url('/api/documentation') }}" class="btn btn-primary">Ver Documentación de API</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Enlace al archivo JS de Bootstrap (jQuery y Popper.js son requeridos por Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
