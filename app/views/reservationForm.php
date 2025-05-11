<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Crear reservación</title>

    <style>
        .reserved-day {
            background-color: #ffcccc !important;
            color: red !important;
            font-weight: bold !important;
            cursor: not-allowed !important;
            text-decoration: line-through;
        }
    </style>
</head>

<body style="font-family: 'Open Sans', serif">

    <?php require "app/views/partials/navbar.php"; ?> <!-- NAVBAR -->

    <main class="container mb-3" style="margin-top: 150px;">
        <a href="/<?= $_SESSION['rootFolder'] ?>/Alojamiento/getAlojamiento?id=<?= $infoAlojamiento['id'] ?>" class="btn btn-dark" onclick="window.history.back();">
            ← Regresar
        </a>

        <div class="container mt-1">
            <section class="container my-3">
                <div class="row">
                    <!-- Columna: Detalles del alojamiento -->
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <!-- Imagen solo visible en pantallas grandes -->
                            <img src="/<?= $_SESSION['rootFolder'] ?><?= $infoAlojamiento['imagen'] ?>"
                                class="card-img-top d-none d-lg-block"
                                alt="<?= $infoAlojamiento['nombre'] ?>">

                            <div class="card-body d-flex flex-column flex-md-row align-items-center align-items-md-start">
                                <img src="/<?= $_SESSION['rootFolder'] ?><?= $infoAlojamiento['imagen'] ?>"
                                    class="img-thumbnail me-3 d-block d-lg-none"
                                    style="width: 150px; height: auto; object-fit: cover;"
                                    alt="<?= $infoAlojamiento['nombre'] ?>">

                                <div class="flex-grow-1">
                                    <h5 class="card-title"><?= $infoAlojamiento['nombre'] ?></h5>

                                    <p class="card-text mb-1">
                                        <strong>Dirección:</strong> <?= $infoAlojamiento['direccion'] ?>
                                    </p>

                                    <p class="card-text mb-1">
                                        <strong>Precio:</strong> $<?= number_format($infoAlojamiento['precio'], 2) ?>
                                    </p>

                                    <p class="card-text mb-1">
                                        <strong>Capacidad:</strong> <?= $infoAlojamiento['minpersona'] ?> - <?= $infoAlojamiento['maxpersona'] ?> personas
                                    </p>

                                    <p class="card-text mb-0">
                                        <?php if ($infoAlojamiento['estado_reservado']) { ?>
                                            <span class="badge bg-success mt-2">Disponible</span>
                                        <?php } else { ?>
                                            <span class="badge bg-danger mt-2">Reservado</span>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna: Formulario de reservación -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Reservar este alojamiento</h4>

                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <p style="text-align: justify;">
                                        Por favor, asegúrese de que la información ingresada es correcta. Cuando envie su reservación, verificar el estado de esta desde la opción "Reservaciones" en la parte superior.
                                    </p>
                                </div>

                                <form action="/<?= $_SESSION['rootFolder'] ?>/Reservation/crear_reservacion" method="POST" class="row g-3">
                                    <!-- ID del alojamiento -->
                                    <input type="hidden" name="id_alojamiento" value="<?= htmlspecialchars($infoAlojamiento['id']) ?>">

                                    <!-- ID del anfitrion -->
                                    <input type="hidden" name="id_anfitrion" value="<?= htmlspecialchars($infoAlojamiento['id_anfitrion']) ?>">

                                    <!-- Número de huéspedes -->
                                    <div class="col-md-6">
                                        <label for="huespedes" class="form-label">Número de huéspedes</label>
                                        <select class="form-select" id="huespedes" name="huespedes" required>
                                            <option value="" disabled selected>Seleccione</option>

                                            <?php for ($i = $infoAlojamiento['minpersona']; $i <= $infoAlojamiento['maxpersona']; $i++) {
                                                echo "<option value=\"$i\">$i huésped/es</option>";
                                            } ?>
                                        </select>
                                    </div>

                                    <!-- Fecha de entrada -->
                                    <div class="col-md-6">
                                        <label for="fecha_entrada" class="form-label">Fecha de entrada</label>
                                        <input type="date" name="fecha_entrada" id="fecha_entrada" class="form-control" required>
                                    </div>

                                    <!-- Fecha de salida -->
                                    <div class="col-md-6">
                                        <label for="fecha_salida" class="form-label">Fecha de salida</label>
                                        <input type="date" name="fecha_salida" id="fecha_salida" class="form-control" required>
                                    </div>

                                    <!-- Método de pago -->
                                    <div class="col-md-6">
                                        <label for="metodo_pago" class="form-label">Método de pago</label>
                                        <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                                            <option value="" disabled selected>Seleccione</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="efectivo">Efectivo</option>
                                        </select>
                                    </div>

                                    <!-- Botón de envío -->
                                    <div class="col-12">
                                        <button type="button" id="btn-reservar" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#confirmReservation" disabled>Reservar</button>
                                    </div>

                                    <!--Modal con los detalles y confirmacion de reservacion-->
                                    <div class="modal fade" id="confirmReservation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header position-relative d-flex justify-content-center align-items-center py-2">
                                                    <p class="text-black fs-3 fw-bold m-0 text-center w-100">Confirmar reservación</p>
                                                    <button type="button" class="btn position-absolute end-0 me-3" data-bs-dismiss="modal">
                                                        <i class="fa-solid fa-xmark fs-4"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p>¿Desea confirmar su reservación en <?= $infoAlojamiento['nombre'] ?>?</p>
                                                    <p><strong>Resúmen:</strong> </p>

                                                    <!-- La información del resumen se carga aqui con JS -->
                                                    <div id="resumenReservacion"></div>

                                                    <button type="submit" class="btn btn-primary mt-2">Confirmar</button>
                                                    <button type="button" class="btn btn-danger mt-2" data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?php require "app/views/partials/footer.php"; ?> <!-- FOOTER -->

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Operacionamiento con JS para otener el resumen de la reservacion -->
    <script>
        // Variables con la información del formulario
        const btnReservar = document.getElementById('btn-reservar');
        const confirmationModal = document.querySelector('[data-bs-target="#confirmReservation"]');
        const fechaEntrada = document.getElementById('fecha_entrada');
        const fechaSalida = document.getElementById('fecha_salida');
        const cantHuespedes = document.getElementById('huespedes');
        const metodoPagoSelect = document.getElementById('metodo_pago');

        // Crea un Date local para YYYY-MM-DD para el manejo de fechas
        function parseLocalDate(yyyyMmDd) {
            const [y, m, d] = yyyyMmDd.split('-').map(Number);
            return new Date(y, m - 1, d);
        }

        // Valida que TODOS los campos estén completos y las fechas sean correctas
        function validarCampos() {
            const entradaValida = fechaEntrada.value !== '';
            const salidaValida = fechaSalida.value !== '';
            const huespedesValidos = cantHuespedes.value !== '';
            const metodoPagoValido = metodoPagoSelect.value !== '';

            // Validación de fechas
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);
            const fechaEntradaDate = parseLocalDate(fechaEntrada.value);
            const fechaSalidaDate = parseLocalDate(fechaSalida.value);
            const entradaNoPasada = fechaEntradaDate >= hoy;
            const fechasCorrectas = fechaSalidaDate > fechaEntradaDate;

            btnReservar.disabled = !(
                entradaValida && salidaValida && huespedesValidos && metodoPagoValido && entradaNoPasada && fechasCorrectas
            );
        }

        // Asigna listeners a TODOS los inputs relevantes
        fechaEntrada.addEventListener('input', validarCampos);
        fechaSalida.addEventListener('input', validarCampos);
        cantHuespedes.addEventListener('change', validarCampos);
        metodoPagoSelect.addEventListener('change', validarCampos);

        // Construccion del resumen con fechas ya parseadas localmente
        confirmationModal.addEventListener('click', function() {
            const entrada = parseLocalDate(fechaEntrada.value);
            const salida = parseLocalDate(fechaSalida.value);
            const huespedes = parseInt(cantHuespedes.value, 10);
            const metodoPago = metodoPagoSelect.value;

            const dias = (salida - entrada) / (1000 * 60 * 60 * 24);
            const precioNoche = parseFloat(<?= $infoAlojamiento['precio'] ?>);
            const total = dias * precioNoche * huespedes;

            const resumenHTML = `
            <ul class="list-group">
                <li class="list-group-item"><strong>Fecha de entrada:</strong> ${entrada.toLocaleDateString()}</li>
                <li class="list-group-item"><strong>Fecha de salida:</strong> ${salida.toLocaleDateString()}</li>
                <li class="list-group-item"><strong>Número de días:</strong> ${dias}</li>
                <li class="list-group-item"><strong>Huéspedes:</strong> ${huespedes}</li>
                <li class="list-group-item"><strong>Método de pago:</strong> ${metodoPago.charAt(0).toUpperCase() + metodoPago.slice(1)}</li>
                <li class="list-group-item"><strong>Total a pagar:</strong> $${total.toFixed(2)}</li>
            </ul>
            <input type="hidden" name="total_pago" value="${total.toFixed(2)}">
        `;
            document.getElementById('resumenReservacion').innerHTML = resumenHTML;
        });
    </script>

    <!-- Formato de fecha para inputs DATE y verificar las fechas con reservaciones en cada alojamiento -->
    <script>
        const reservedRanges = <?= json_encode($reservedRanges, JSON_UNESCAPED_SLASHES) ?>;

        // Función para verificar si una fecha está dentro de algún rango
        function isInReservedRange(date) {
            return reservedRanges.some(range => {
                const from = new Date(range.from);
                const to = new Date(range.to);
                return date >= from && date <= to;
            });
        }

        flatpickr("#fecha_entrada", {
            dateFormat: "Y-m-d",
            disable: reservedRanges,
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const date = new Date(dayElem.dateObj);
                if (isInReservedRange(date)) {
                    dayElem.classList.add("reserved-day");
                }
            },
            onChange(selectedDates, dateStr, instance) {
                salidaPicker.set('minDate', dateStr);
            }
        });

        const salidaPicker = flatpickr("#fecha_salida", {
            dateFormat: "Y-m-d",
            disable: reservedRanges,
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const date = new Date(dayElem.dateObj);
                if (isInReservedRange(date)) {
                    dayElem.classList.add("reserved-day");
                }
            },
            onReady: function(selectedDates, dateStr, instance) {
                instance.set('minDate', document.querySelector('#fecha_entrada').value || 'today');
            }
        });
    </script>

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
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/crear_reservacion?alojamiento=<?= $infoAlojamiento['id']; ?>";
                });
            } else if (alertType === "error") {
                Swal.fire({
                    title: '¡Error!',
                    text: alertMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    // Redirigir a la página principal o login después de cerrar la alerta
                    window.location.href = "/<?= $_SESSION['rootFolder'] ?>/Reservation/crear_reservacion?alojamiento=<?= $infoAlojamiento['id']; ?>";
                });
            }
        </script>
    <?php endif; ?>
</body>

</html>