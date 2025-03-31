<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Rooms SV | Alojamientos de El Salvador</title>

    <!-- Link de archivo de estilos home.css -->
    <link href="/<?= $_SESSION['rootFolder'] ?>/public/css/home.css" rel="stylesheet">
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main>
        <div class="central-container d-flex flex-column justify-content-center align-items-center">

            <!--SECTION de contenido-->
            <section class="container d-flex flex-column">
                <div>
                    <p class="title-text text-white text-center">Encuentra el descanso que mereces</p>
                    <p class="subtitle-text text-white text-center">Escoge entre alojamientos en lugares únicos, ideales
                        para desconectar del día a día.</p>
                </div>
                <div class="line-separator my-4 text-black">.</div>
                <div class="text-center">
                    <button class="btn btn-dark border" type="button" onclick="location.href='#cards-presentation'">Ver
                        alojamientos</button>
                </div>
            </section>
        </div>

        <?php include "app/views/partials/card-container-decoration.php"; ?> <!--CONTENEDOR de cards de decoracion-->

        <div class="container d-flex justify-content-center my-5">
            <div class="text-white bg-dark" style="height:1px; width:100%;">.</div>
        </div>

        <!-- Sección de alojamientos ingresados -->
        <section class="my-4">
            <!-- Barra de búsqueda -->
            <div class="text-center">
                <h1>Explora casas y hoteles, encuentra el lugar ideal</h1>
                <form class="container form-buscar d-flex gap-2 mt-4" action="">
                    <input type="search" name="buscarAlojamiento" class="form-control rounded-pill"
                        placeholder="Busca un alojamiento...">
                    <button class="btn btn-light rounded-circle" type="submit" style="background:orange;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            <!--Cards de Alojamientos-->
        </section>

    </main>

    <!-- Manejo de alertas -->
    <?php if (isset($_GET['alert'])): ?>
        <script>
            let alertType = "<?php echo $_GET['alert']; ?>";
            let alertMessage = "<?php echo urldecode($_GET['message']); ?>";

            // Mostrar la alerta con SweetAlert
            if (alertType === "success") {
                Swal.fire({
                    title: '¡Éxito!',
                    text: alertMessage,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Home/index/";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Home/index/";
                });
            }
        </script>
    <?php endif; ?>

    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <!--BOOTSTRAP JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!--Nombre Alojamiento-->
    <script src="../../public/js/home.js"></script>

</body>

</html>