-- Zonas
INSERT INTO transfer_zonas (descripcion) VALUES
  ('Norte'),
  ('Sur'),
  ('Este'),
  ('Oeste'),
  ('Centro');

-- Tipos de reserva
INSERT INTO transfer_tipo_reservas (descripcion) VALUES
  ('Aeropuerto-Hotel'),
  ('Hotel-Aeropuerto'),
  ('Ida y vuelta');

-- Vehículos
INSERT INTO transfer_vehiculos (descripcion, email_conductor, password) VALUES
  ('Minivan 7 plazas', 'minivan@transfers.com', '$2y$10$0fgYy4uRPt6Q4mkhtwHtOevKOGy1eoA6nrhZnBz3w68cH/XV8pv1K'), -- pass: minivan
  ('Sedán', 'sedan@transfers.com', '$2y$10$aHbKhXTafUC8ivz8rp1eJu70NCrLSecyNNXYkwoAg6dB6SQ4IoIUa'), -- pass: sedan
  ('SUV', 'suv@transfers.com', '$2y$10$sA4TYgFBbH11zE6zA3sW7OYVAKLDDz4OKVgj6vM0ZZz2Db4a3ZkTC'), -- pass: suv
  ('Microbus 15 plazas', 'microbus@transfers.com', '$2y$10$MDTTaSrZYi/Sm7JZp1HvAexzshioi8wCLlVKe1Q6idD3PQKrsqbb6'), -- pass: microbus
  ('Coche eléctrico', 'electrico@transfers.com', '$2y$10$e2mlAifXQOPhvLBPy7gId.T7ULQK2GxwSGL2SgElvLMc3m9KMBh.6'); -- pass: electrico

-- Viajeros (usuarios particulares y admin)
INSERT INTO transfer_viajeros (nombre, apellido1, apellido2, direccion, codigoPostal, ciudad, pais, email, password, rol) VALUES
  ('Joan', 'García', 'Soler', 'Cami Vell 10', '07001', 'Ciutadella', 'España', 'joan@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Marta', 'Serra', 'Llorens', 'Av. Principal 22', '07002', 'Maó', 'España', 'marta@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Pau', 'Ribas', 'Ortega', 'Pl. Major 3', '07003', 'Alaior', 'España', 'pau@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Eva', 'Moreno', 'Puig', 'Carrer Nou 4', '07004', 'Ferreries', 'España', 'eva@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Carles', 'Camps', 'Torras', 'Cami en Kane 12', '07005', 'Es Castell', 'España', 'carles@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Laura', 'Pons', 'Juaneda', 'Av. Menorca 8', '07006', 'Es Mercadal', 'España', 'laura@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Albert', 'Pérez', 'Gelabert', 'Carrer Gran 2', '07007', 'Sant Lluís', 'España', 'albert@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Maria', 'Vinent', 'Ferrer', 'Ronda Sud 18', '07008', 'Ciutadella', 'España', 'maria@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Toni', 'Salord', 'Pons', 'Cami Reial 7', '07009', 'Maó', 'España', 'toni@demo.com', '$2y$10$YV3UR72JC04zo3mbVo4qEO0xZQTVyvRbD68.OztNcdLPsaNHRHS.a', 'particular'),
  ('Administrador', 'Isla', '', 'Pl. Ajuntament 1', '07010', 'Maó', 'España', 'admin@demo.com', '$2y$10$7ZMAJhIzEbMKoK2wwtU8U.BjCS0dKtRSOylqvfJJHPEVmUI.5n3GC', 'admin');
-- pass: particulares -> part123
-- pass: adminstradores -> admin123


-- Hoteles
INSERT INTO transfer_hoteles (nombre, id_zona, comision, usuario, email, password) VALUES
  ('Hotel Norte', 1, 12, '1001', 'hotelnorte@demo.com', '$2y$10$REOGonazF7OlrLS7vRfutearpT/nWhflquudchbPDn.bC4dvYCZU2'),    -- pass: hotel
  ('Hotel Sur', 2, 10, '1002', 'hotelsur@demo.com','$2y$10$REOGonazF7OlrLS7vRfutearpT/nWhflquudchbPDn.bC4dvYCZU2'),      -- pass: hotel
  ('Hotel Este', 3, 11, '1003', 'hoteleste@demo.com', '$2y$10$REOGonazF7OlrLS7vRfutearpT/nWhflquudchbPDn.bC4dvYCZU2'),     -- pass: hotel
  ('Hotel Oeste', 4, 9, '1004', 'hoteloeste@demo.com','$2y$10$REOGonazF7OlrLS7vRfutearpT/nWhflquudchbPDn.bC4dvYCZU2'),     -- pass: hotel
  ('Hotel Centro', 5, 13, '1005', 'hotelcentro@demo.com','$2y$10$REOGonazF7OlrLS7vRfutearpT/nWhflquudchbPDn.bC4dvYCZU2');    -- pass: hotel

-- Reservas (10 de muestra)
INSERT INTO transfer_reservas (localizador, id_hotel, id_tipo_reserva, id_viajero, fecha_reserva, fecha_modificacion, id_destino, fecha_entrada, hora_entrada, numero_vuelo_entrada, origen_vuelo_entrada, hora_vuelo_salida, fecha_vuelo_salida, num_viajeros, id_vehiculo) VALUES
('LOC001', 1, 1, 1, NOW(), NOW(), 1, '2024-11-01', '12:00:00', 'VY101', 'Madrid', '14:00:00', '2024-11-02', 2, 1),
('LOC002', 2, 2, 2, NOW(), NOW(), 2, '2024-11-03', '10:00:00', 'VY102', 'Barcelona', '12:00:00', '2024-11-04', 1, 2),
('LOC003', 3, 3, 3, NOW(), NOW(), 3, '2024-11-05', '11:30:00', 'VY103', 'Valencia', '13:30:00', '2024-11-06', 4, 3),
('LOC004', 4, 1, 4, NOW(), NOW(), 4, '2024-11-07', '13:15:00', 'VY104', 'Sevilla', '15:15:00', '2024-11-08', 2, 4),
('LOC005', 5, 2, 5, NOW(), NOW(), 5, '2024-11-09', '09:45:00', 'VY105', 'Bilbao', '11:45:00', '2024-11-10', 3, 5),
('LOC006', 1, 3, 6, NOW(), NOW(), 2, '2024-11-11', '08:20:00', 'VY106', 'Zaragoza', '10:20:00', '2024-11-12', 1, 1),
('LOC007', 2, 1, 7, NOW(), NOW(), 3, '2024-11-13', '14:40:00', 'VY107', 'Granada', '16:40:00', '2024-11-14', 2, 2),
('LOC008', 3, 2, 8, NOW(), NOW(), 4, '2024-11-15', '07:55:00', 'VY108', 'Murcia', '09:55:00', '2024-11-16', 3, 3),
('LOC009', 4, 3, 9, NOW(), NOW(), 5, '2024-11-17', '16:30:00', 'VY109', 'Alicante', '18:30:00', '2024-11-18', 4, 4),
('LOC010', 5, 1, 10, NOW(), NOW(), 1, '2024-11-19', '18:10:00', 'VY110', 'Valladolid', '20:10:00', '2024-11-20', 1, 5);
