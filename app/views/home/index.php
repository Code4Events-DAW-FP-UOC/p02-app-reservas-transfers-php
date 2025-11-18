<?php require __DIR__ . '/../components/header.php'; ?>
<?php require __DIR__ . '/../components/navbar.php'; ?>

<!-- Hero Section con carrusel -->
<div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="hero-bg" style="background-image: url('img/img_bg_business-couple-near-minivan-taxi-with-a-suitcases.JPG');"></div>
        </div>
        <div class="carousel-item">
            <div class="hero-bg" style="background-image: url('img/img_bg_chauffeur-greets-a-businessman-near-luxury-taxi.JPG');"></div>
        </div>
        <div class="carousel-item">
            <div class="hero-bg" style="background-image: url('img/img_bg_chauffeur-helps-a-businessman-to-get-out-of-the-ca.JPG');"></div>
        </div>
        <div class="carousel-item">
            <div class="hero-bg" style="background-image: url('img/img_bg_female-chauffeur-helps-a-business-people-to-get-ou.JPG');"></div>
        </div>
        <div class="carousel-item">
            <div class="hero-bg" style="background-image: url('img/img_bg_transfer-aeropuerto_primavera.jpg');"></div>
        </div>
        <div class="carousel-item">
            <div class="hero-bg" style="background-image: url('img/img_bg_transfer-madri-aeroporto.png');"></div>
        </div>
    </div>

    <div class="hero-content d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="mb-4">Bienvenido/a a Isla Transfers</h1>
        <p class="lead mb-4">Tu servicio de traslados de confianza a la isla.<br>
            Reserva fácilmente tu trayecto del aeropuerto al hotel y viceversa.</p>
        <a href="/user/nuevaReserva" class="btn btn-primary btn-lg">Haz tu reserva ahora</a>
    </div>
</div>
<div class="container">
    <!-- SECCIÓN -->
    <section class="bg-light p-4 rounded mt-5 mb-4">
        <p>
            Aplicación desarrollada como proyecto académico. Todos los datos personales son ficticios y las contraseñas de prueba para el acceso son:
        <ul>
            <li>Administrador: admin@demo.com - admin123</li>
            <li>Usuario particular: joan@demo.com - part123</li>

        </ul>
        <p>
            Las contraseñas se almacenan cifradas y todos los datos cumplen las normas de seguridad y privacidad del proyecto.
        </p>
    </section>
    <!-- SECCIÓN 1: Acceso y gestión -->
    <section class="bg-light p-4 rounded mt-5 mb-4">
        <h4 class="fw-bold mb-3">Acceso y gestión de la aplicación</h4>
        <p>
            El sistema diferencia accesos y permisos según el tipo de usuario (particular, hotel o administrador) y también permite identificar quién ha creado cada reserva. Los administradores pueden gestionar todo el sistema, mientras que los usuarios particulares sólo pueden ver, crear, modificar o cancelar sus propias reservas (con las limitaciones indicadas). Todas las acciones quedan reflejadas en la base de datos para un mejor control y trazabilidad.
        </p>
        <ul>
            <li>Acceso adaptado al perfil de cada usuario.</li>
            <li>Paneles y menús personalizados según rol.</li>
            <li>Las reservas muestran quién las ha creado: <b>TÚ</b> (usuario) o <b>ADMINISTRADOR</b>.</li>
        </ul>
    </section>

    <!-- SECCIÓN 2: Guía rápida de uso (desplegable) -->
    <div class="accordion mb-4" id="accordionGuiaRapida">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingGuia">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGuia" aria-expanded="false" aria-controls="collapseGuia">
                    Guía rápida de usuario
                </button>
            </h2>
            <div id="collapseGuia" class="accordion-collapse collapse" aria-labelledby="headingGuia" data-bs-parent="#accordionGuiaRapida">
                <div class="accordion-body">
                    <ul>
                        <li>El menú de navegación muestra las secciones disponibles según tu rol: usuario o administrador.</li>
                        <li>Puedes consultar, crear, editar o cancelar tus reservas desde la sección <b>Mis reservas</b>.</li>
                        <li>Accede a tu perfil para modificar tus datos personales y contraseña.</li>
                        <li>En cada reserva puedes ver todos los detalles y saber quién la ha creado.</li>
                        <li>El calendario en adminstrador permite ver las reservas por mes, semana o día, y acceder directamente al detalle de cada trayecto.</li>
                        <li>Los administradores pueden gestionar todo el sistema: usuarios, hoteles, tipos de reserva, vehículos, zonas y precios.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN 3: Cambios y estructura de la base de datos (desplegable) -->
    <div class="accordion" id="accordionCambiosBD">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCambiosBD">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCambiosBD" aria-expanded="false" aria-controls="collapseCambiosBD">
                    Cambios y estructura de la base de datos
                </button>
            </h2>
            <div id="collapseCambiosBD" class="accordion-collapse collapse" aria-labelledby="headingCambiosBD" data-bs-parent="#accordionCambiosBD">
                <div class="accordion-body">
                    <ul>
                        <li><strong>Nombres unificados:</strong> Tablas y campos en minúsculas y en plural para una gestión más clara.</li>
                        <li><strong>Campos nuevos:</strong>
                            <ul>
                                <li><code>id_creador</code> en reservas, para saber quién creó cada reserva (usuario o administrador).</li>
                                <li><code>rol</code> en viajeros, para distinguir entre particulares y administradores.</li>
                                <li><code>email</code> añadido en hoteles.</li>
                            </ul>
                        </li>
                        <li><strong>Ajustes en tipos de datos:</strong>
                            <ul>
                                <li>El campo <code>email_cliente</code> ha sido sustituido por <code>id_viajero</code> en reservas para mejorar la relación entre tablas.</li>
                                <li>La columna <code>password</code> permite hashes largos y seguros.</li>
                            </ul>
                        </li>
                    </ul>
                    <div>
                        <strong>Contraseñas por defecto:</strong>
                        <ul>
                            <li>Administrador: <code>admin123</code></li>
                            <li>Usuario particular: <code>part123</code></li>
                        </ul>
                    </div>
                    <div class="alert alert-info mt-3">
                        <strong>Nota:</strong> Todos los datos y contraseñas son ficticios y las contraseñas reales se almacenan siempre cifradas.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php require __DIR__ . '/../components/footer.php'; ?>