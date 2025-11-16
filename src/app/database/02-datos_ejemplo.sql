-- __________________________________________________
--
-- DATOS DE EJEMPLO PARA BBDD 'isla_transfers'
-- __________________________________________________

-- Desactivar temporalmente la comprobación de claves foráneas
-- para permitir la inserción en cualquier orden si fuera necesario,
-- aunque este script está ordenado.
SET FOREIGN_KEY_CHECKS=0;

SET NAMES 'utf8mb4';

USE `isla_transfers`;


START TRANSACTION;

-- _________________________________
-- Variable para la contraseña
-- _________________________________
-- Definimos una variable con el HASH de '1234' (generado con Bcrypt).
-- Todas las cuentas usarán este hash por seguridad.
SET @hashed_pass = '$2y$10$N43xOSKr72e.5L8EH9/IuOs1BF/9gpMMn00p1kI7yX6KbsUaazQOC';

-- _________________________________
-- 1. Tablas sin dependencias
-- _________________________________

-- Insertar Zonas
-- NOTA: Tu schema define 'descripcion' como INT(11), así que insertamos números.
INSERT INTO `transfer_zona` (`id_zona`, `descripcion`) VALUES
(1, 10), -- Zona 10 (ej. Norte)
(2, 20), -- Zona 20 (ej. Sur)
(3, 30); -- Zona 30 (ej. Centro)

-- Insertar Vehículos
INSERT INTO `transfer_vehiculo` (`id_vehiculo`, `Descripción`, `email_conductor`, `password`) VALUES
(1, 'Standard Sedan', 'conductor.sedan@transfer.com', @hashed_pass),
(2, 'Minivan', 'conductor.minivan@transfer.com', @hashed_pass),
(3, 'Autobús', 'conductor.bus@transfer.com', @hashed_pass);

-- Insertar Tipos de Reserva
-- NOTA: Tu schema define 'Descripción' como INT(11), así que insertamos números.
INSERT INTO `transfer_tipo_reserva` (`id_tipo_reserva`, `Descripción`) VALUES
(1, 'Ida'), -- 1 = Solo Entrada (Aeropuerto -> Hotel)
(2, 'Vuelta'), -- 2 = Solo Salida (Hotel -> Aeropuerto)
(3, 'Ida y vuelta'); -- 3 = Entrada y Salida

-- Insertar Viajeros (Usuarios)
-- Aquí cumplimos tu requisito de 3 roles.
INSERT INTO `transfer_viajeros` (`id_viajero`, `nombre`, `apellido1`, `apellido2`, `direccion`, `codigoPostal`, `ciudad`, `pais`, `email`, `password`, `rol`) VALUES
(
    1, 'Admin', 'Global', 'UOC', 'Calle Falsa 123', '08001', 'Barcelona', 'España', 
    'admin@uoc.edu', @hashed_pass, 'administrador'
),
(
    2, 'Ana', 'Pérez', 'Gómez', 'Gran Vía 45', '28013', 'Madrid', 'España', 
    'ana.perez@email.com', @hashed_pass, 'particular'
),
(
    3, 'Carlos', 'Sánchez', 'Ruiz', 'Av. Diagonal 200', '08018', 'Barcelona', 'España', 
    'carlos.sanchez@empresa.com', @hashed_pass, 'corporativo'
),
(
    4, 'Lucía', 'Martín', 'Díaz', 'Calle Larios 10', '29005', 'Málaga', 'España', 
    'lucia.martin@email.com', @hashed_pass, 'particular'
);

-- _________________________________
-- 2. Tablas con dependencias
-- _________________________________

-- Insertar Hoteles (Depende de 'transfer_zona')
-- El campo 'usuario' es un INT, no un email.
INSERT INTO `tranfer_hotel` (`id_hotel`, `id_zona`, `nombre_hotel`, `Comision`, `usuario`, `password`) VALUES
(1, 1, 'Hotel UOC Beach', 15, 1001, @hashed_pass),
(2, 1, 'Hotel Sol Costa', 20, 1002, @hashed_pass),
(3, 2, 'Hotel Marítimo Centro', 15, 1003, @hashed_pass),
(4, 3, 'Pensión Montaña', 10, 1004, @hashed_pass);

-- Insertar Precios (Depende de 'tranfer_hotel' y 'transfer_vehiculo')
INSERT INTO `transfer_precios` (`id_precios`, `id_vehiculo`, `id_hotel`, `Precio`) VALUES
-- Precios para Hotel UOC Beach (id 1)
(1, 1, 1, 50), -- Sedan a Hotel 1
(2, 2, 1, 80), -- Minivan a Hotel 1

-- Precios para Hotel Sol Costa (id 2)
(3, 1, 2, 55), -- Sedan a Hotel 2

-- Precios para Hotel Marítimo Centro (id 3)
(4, 1, 3, 70), -- Sedan a Hotel 3
(5, 2, 3, 110),-- Minivan a Hotel 3
(6, 3, 3, 200);-- Bus a Hotel 3

-- Insertar Reservas (Depende de hotel, tipo_reserva, vehiculo)
-- NOTA: Tu schema define 'email_cliente' como INT(11).
-- Asumiré que es un error y que debería ser 'id_viajero'.
-- Usaré los IDs 2 y 3 (Ana y Carlos) de 'transfer_viajeros'.
INSERT INTO `transfer_reservas` (
    `id_reserva`, `localizador`, `id_hotel`, `id_tipo_reserva`, `email_cliente`, 
    `fecha_reserva`, `fecha_modificacion`, `id_destino`, 
    `fecha_entrada`, `hora_entrada`, `numero_vuelo_entrada`, `origen_vuelo_entrada`, 
    `hora_vuelo_salida`, `fecha_vuelo_salida`, `num_viajeros`, `id_vehiculo`
) VALUES
(
    1, 
    'UOC-ABC123', 
    1, -- 'id_hotel' (quién reserva) = Hotel UOC Beach
    3, -- 'id_tipo_reserva' = Entrada y Salida
    2, -- 'email_cliente' (viajero) = Ana Pérez (ID 2)
    '2024-02-20 10:30:00', '2024-02-20 10:30:00', 
    1, -- 'id_destino' (dónde va) = Hotel UOC Beach
    '2024-03-10', '14:30:00', 'VY1234', 'Londres (LGW)', 
    '2024-03-17 18:00:00', '2024-03-17', 
    4, 2 -- 4 viajeros, Vehículo 2 (Minivan)
),
(
    2, 
    'UOC-DEF456', 
    4, -- 'id_hotel' (quién reserva) = Hotel UOC Beach
    2, -- 'id_tipo_reserva' = Entrada y Salida
    1, -- 'email_cliente' (viajero) = Ana Pérez (ID 2)
    '2025-02-23 06:13:00', '2025-02-23 06:15:00', 
    4, -- 'id_destino' (dónde va) = Hotel UOC Beach
    '2025-12-25', '22:30:00', 'MS2323', 'Barcelona (BCN)', 
    '2026-01-05 06:00:00', '2026-01-05', 
    4, 2 -- 4 viajeros, Vehículo 2 (Minivan)
),
(
    3, 
    'UOC-GHI789', 
    3, -- 'id_hotel' (quién reserva) = Hotel Marítimo Centro
    1, -- 'id_tipo_reserva' = Solo Entrada
    3, -- 'email_cliente' (viajero) = Carlos Sánchez (ID 3)
    '2024-02-21 15:00:00', '2024-02-21 15:00:00', 
    3, -- 'id_destino' (dónde va) = Hotel Marítimo Centro
    '2024-03-12', '09:15:00', 'IB5678', 'Madrid (MAD)', 
    '2024-03-15 12:00:00', '2024-03-15', -- Fechas de salida (aunque sea solo entrada, el vuelo de vuelta se puede registrar)
    2, 1 -- 2 viajeros, Vehículo 1 (Sedan)
);

-- Reactivar la comprobación de claves foráneas
SET FOREIGN_KEY_CHECKS=1;
COMMIT;