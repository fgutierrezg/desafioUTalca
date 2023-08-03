<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard de Control Asistencia</title>
    <meta name="theme-color" content="#555a5f">
    <!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Custom fonts for this template-->
    <!--<link href="https://bioalba.controlasistencia.cl/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="https://bioalba.controlasistencia.cl/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt-5">

            <div class="card-body">

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade  show active " id="form-admin" role="tabpanel"
                        aria-labelledby="nav-contact-tab">


                        <form action="{{ url('api/login') }}" method="POST">
                            @csrf
                            <div class="form-group ">
                                <label for="exampleInputEmail1"><strong>Email</strong></label>
                                <input name="email" value="" type="email" required class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Ingrese Email">

                            </div>
                            <div class="form-group ">
                                <label for="exampleInputEmail1"><strong>Contraseña</strong></label>
                                <input name="password" type="password" value="" required class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Ingrese contraseña">

                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                Iniciar sesión
                            </button>
                        </form>

                    </div>


                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- Core plugin JavaScript-->
    <script src="https://bioalba.controlasistencia.cl/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>