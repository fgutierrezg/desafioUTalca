<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido!</h1>

    <p>Has iniciado sesión correctamente.</p>

    <form method="POST" action="{{ url('api/logout') }}">
        @csrf
        <input type="submit" value="Cerrar sesión">
    </form>
</body>
</html>