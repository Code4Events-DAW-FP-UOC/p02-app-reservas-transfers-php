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

<?php require __DIR__ . '/../components/footer.php'; ?>