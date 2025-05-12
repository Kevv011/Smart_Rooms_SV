<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/<?= $_SESSION['rootFolder'] ?>/public/css/about-us.css">
    <title>¿Quiénes somos?</title>
</head>

<body>
    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->
    <main class="container mb-3" style="margin-top: 150px;">
        <!-- Titulo -->
        <h2 class="mb-4 text-center text-capitalize">Sobre nosotros</h2>

        <!-- Contenido -->
        <section class="row">
            <article class="col-12  d-flex justify-content-center">
                <img src="/<?= $_SESSION['rootFolder'] ?>/public/img/img-background.png" class="img-fluid img-background" alt="Background Image - Sobre Nosotros" width="700px">
            </article>
            <article class="col-12">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6 g-5">
                        <p class="p-about">
                            Smart Rooms SV nació con una visión clara: transformar la manera en que las personas
                            viven la experiencia de hospedarse en El Salvador. Fundada en el corazón de Antiguo
                            Cuscatlán, nuestra historia comienza en el año 2010,
                            cuando un pequeño grupo de emprendedores salvadoreños decidió apostar por un nuevo
                            concepto de alojamiento: moderno, inteligente y accesible tanto para turistas como
                            para nacionales.
                            Lo que inició como un negocio de alojamientos con un par de habitaciones acondicionadas con las necesidades básicas y una
                            fuerte vocación de servicio, pronto comenzó a captar la atención de viajeros que buscaban
                            comodidad, seguridad y una atención cercana. Nuestra propuesta innovadora que, en un inicio
                            solía ser un servicio singular, fue creciendo exponencialmente
                            hacia diferentes rumbos del país, basándonos en ofrecer atención personalizada para adquirir reservas en lugares con
                            sistemas inteligentes para el control de accesos e iluminación. Adicionalmente, nuestra gestión de reservas
                            en línea y atención al cliente nos permitió posicionarnos rápidamente como una alternativa
                            fresca y confiable en el mercado.</p>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6 g-5">
                        <p class="p-about">
                            A lo largo de los años, hemos crecido con nuestros huéspedes. Hemos expandido nuestras operaciones,
                            mejorado nuestros medios de comunicación y sistemas, y fortalecido alianzas con comunidades locales,
                            operadores turísticos y proveedores de servicios, para ofrecer experiencias completas e íntegras.
                            Cada espacio que administramos está diseñado para brindar tranquilidad, confort y eficiencia,
                            sin perder ese toque humano y salvadoreño que nos distingue.
                            Hoy, Smart Rooms SV es mucho más que un servicio de alojamiento. Somos una plataforma de conexión entre
                            culturas, un punto de encuentro entre la tradición y la innovación, y un aliado confiable para quienes desean
                            descubrir lo mejor de El Salvador. Nuestro compromiso sigue siendo el mismo desde el primer día: ofrecer
                            una experiencia de hospedaje inteligente, cálida y segura, a la altura de un país que tiene tanto por ofrecer.
                        <p class="p-about"><b>Bienvenidos a Smart Rooms SV: Tu espacio, tu experiencia, tu El Salvador.</b></p>
                        </p>
                    </div>
                </div>
            </article>
        </section>
    </main>
    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->
</body>

</html>