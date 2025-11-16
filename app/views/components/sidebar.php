<aside class="bg-light p-3 vh-100" style="width: 260px; min-width: 220px;">
    <!-- Dashboard -->
    <div>
        <a href="/userAdmin/dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <span class="fs-5 fw-bold">Dashboard</span>
        </a>
        <hr>
    </div>
    <div class="accordion" id="adminSidebar">

        <!-- Reservas -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingReservas">
                <button class="accordion-button py-3 custom-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReservas" aria-expanded="false" aria-controls="collapseReservas">
                    <i class="bi bi-calendar2-week me-2"></i> Reservas
                </button>
            </h2>
            <div id="collapseReservas" class="accordion-collapse collapse" aria-labelledby="headingReservas" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0 d-flex flex-column gap-2">
                    <a href="/userAdmin/listadoReservas" class="nav-link ps-5">Listado</a>
                    <a href="/userAdmin/nuevaReserva" class="nav-link ps-5">Nueva</a>
                    <a href="/userAdmin/calendario" class="nav-link ps-5">Calendario</a>
                </div>
            </div>
        </div>

        <!-- Usuarios -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingUsuarios">
                <button class="accordion-button py-3 custom-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" aria-expanded="false" aria-controls="collapseUsuarios">
                    <i class="bi bi-person-badge me-2"></i> Usuarios
                </button>
            </h2>
            <div id="collapseUsuarios" class="accordion-collapse collapse" aria-labelledby="headingUsuarios" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0 d-flex flex-column gap-2">
                    <a href="/userAdmin/listadoUsuarios" class="nav-link ps-5">Listado</a>
                    <a href="/userAdmin/nuevoUsuario" class="nav-link ps-5">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Hoteles -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingHoteles">
                <button class="accordion-button py-3 custom-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHoteles" aria-expanded="false" aria-controls="collapseHoteles">
                    <i class="bi bi-building me-2"></i> Hoteles
                </button>
            </h2>
            <div id="collapseHoteles" class="accordion-collapse collapse" aria-labelledby="headingHoteles" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0 d-flex flex-column gap-2">
                    <a href="/userAdmin/listadoHoteles" class="nav-link ps-5">Listado</a>
                    <a href="/userAdmin/nuevoHotel" class="nav-link ps-5">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Vehículos -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingVehiculos">
                <button class="accordion-button py-3 custom-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVehiculos" aria-expanded="false" aria-controls="collapseVehiculos">
                    <i class="bi bi-truck-front me-2"></i> Vehículos
                </button>
            </h2>
            <div id="collapseVehiculos" class="accordion-collapse collapse" aria-labelledby="headingVehiculos" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0 d-flex flex-column gap-2">
                    <a href="/userAdmin/listadoVehiculos" class="nav-link ps-5">Listado</a>
                    <a href="/userAdmin/nuevoVehiculo" class="nav-link ps-5">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Tipo de reserva -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingTipoReserva">
                <button class="accordion-button py-3 custom-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTipoReserva" aria-expanded="false" aria-controls="collapseTipoReserva">
                    <i class="bi bi-bookmark-check me-2"></i> Tipo de reserva
                </button>
            </h2>
            <div id="collapseTipoReserva" class="accordion-collapse collapse" aria-labelledby="headingTipoReserva" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0 d-flex flex-column gap-2">
                    <a href="/userAdmin/listadoTiposReservas" class="nav-link ps-5">Listado</a>
                    <a href="/userAdmin/nuevoTipoReserva" class="nav-link ps-5">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Precios -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingPrecios">
                <button class="accordion-button py-3 custom-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrecios" aria-expanded="false" aria-controls="collapsePrecios">
                    <i class="bi bi-currency-euro me-2"></i> Precios
                </button>
            </h2>
            <div id="collapsePrecios" class="accordion-collapse collapse" aria-labelledby="headingPrecios" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0 d-flex flex-column gap-2">
                    <a href="/userAdmin/listadoPrecios" class="nav-link ps-5">Listado</a>
                    <a href="/userAdmin/nuevoPrecio" class="nav-link ps-5">Nuevo</a>
                </div>
            </div>
        </div>

        <!-- Zonas -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingZonas">
                <button class="accordion-button py-3 custom-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZonas" aria-expanded="false" aria-controls="collapseZonas">
                    <i class="bi bi-geo-alt me-2"></i> Zonas
                </button>
            </h2>
            <div id="collapseZonas" class="accordion-collapse collapse" aria-labelledby="headingZonas" data-bs-parent="#sidebarAccordion">
                <div class="accordion-body p-0 d-flex flex-column gap-2">
                    <a href="/userAdmin/listadoZonas" class="nav-link ps-5">Listado</a>
                    <a href="/userAdmin/nuevaZona" class="nav-link ps-5">Nueva</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos siempre visibles (fuera del accordion) -->
    <div class="mt-4">
        <a href="/" class="btn btn-primary w-100 mb-2"><i class="bi bi-arrow-left-circle me-2"></i>Volver a la web</a>
        <a href="/auth/logout" class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a>
    </div>
</aside>