document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del envío del formulario

    // Obtener los valores de los campos de email y contraseña
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Aquí puedes realizar alguna validación de los datos ingresados antes de enviarlos al servidor
    // ...

    // Lógica para enviar los datos al servidor (puedes utilizar Fetch API o Axios)
    // Por ejemplo, utilizando Fetch API:
    fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, password })
    })
        .then(response => response.json())
        .then(data => {

            // Aquí puedes manejar la respuesta del servidor, que podría incluir el token JWT
            // por ejemplo, si recibes el token como 'data.token':
            const token = data.token;

            // Almacena el token en el almacenamiento local del navegador (LocalStorage o SessionStorage)
            localStorage.setItem('jwtToken', token);

            // Redireccionar o realizar alguna acción después del inicio de sesión exitoso
            // Por ejemplo, redireccionar a otra página:
            //window.location.href = "{{ url('api/documentation') }}";
            fetchWithToken('/api/users/list')
                .then(data => {
                    // Aquí manejas la respuesta del servidor
                    console.log(data);
                })
                .catch(error => {
                    // Manejar errores de la solicitud o autenticación
                    console.error('Error en solicitud:', error);
                });

        })
        .catch(error => {
            // Manejar cualquier error que ocurra durante el proceso de inicio de sesión
            console.error('Error en inicio de sesión:', error);
            // Puedes mostrar un mensaje de error en el formulario si lo deseas
            const errorElement = document.createElement('div');
            errorElement.textContent = 'Credenciales inválidas. Por favor, intenta de nuevo.';
            document.getElementById('loginForm').appendChild(errorElement);
        });


});

function fetchWithToken(url, method = 'GET', data = null) {
    const token = localStorage.getItem('jwtToken');

    const headers = {
        'Content-Type': 'application/json'
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const options = {
        method,
        headers
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    return fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud.');
            }
            return response.json();
        })
        .catch(error => {
            console.error('Error:', error);
            throw error;
        });
}