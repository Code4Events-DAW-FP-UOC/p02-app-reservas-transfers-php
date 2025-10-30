# Producto 2 (PHP puro + MVC) - Isla Transfers

## Descripción

Aplicación web para **reserva y gestión de transfers** (Producto 2 de la asignatura FP.064 - Desarrollo back-end con PHP).  
Desarrollada en **PHP puro** (sin frameworks) siguiendo el patrón de arquitectura **MVC** y preparada para ejecutarse en contenedores Docker.

- Proyecto para la asignatura FP.064 - Desarrollo back-end con PHP, UOC.
- **Repositorio:** https://github.com/Code4Events-DAW-FP-UOC/p02-app-reservas-transfers-php
- **Rama actual:** `feature/mvc-estructura-base-xavi`
- **Autor:** Xavi Miró
- **Colaboración:** Grupo de trabajo FP.064 - Code4Events

## Estructura de carpetas y archivos

/islatransfers/
├── docker-compose.yml # Orquestador de contenedores Docker
├── .gitignore # Exclusiones del repositorio Git
├── README.md # Documentación del proyecto
└── src/ # Código fuente (MVC)
├── index.php
├── config/
│ └── config.php
├── controllers/
│ └── ReservasController.php
├── models/
│ └── Reserva.php
├── views/
│ └── reservas_listado.php
├── helpers/
│ └── utils.php
└── public/
└── css/
└── style.css

**Notas:**

- Todo el código de la aplicación está dentro de la carpeta `/src`.
- `/public` contiene recursos estáticos (CSS, imágenes…).
- El punto de entrada de la aplicación es `/src/index.php`.

---

## Puesta en marcha con Docker

### Requisitos previos

- Tener instalado [Docker Desktop](https://www.docker.com/) (incluye Docker Compose).

### Primeros pasos

```bash
# Clona el repositorio y accede a la carpeta
git clone https://github.com/TU_ORG/islatransfers.git
cd islatransfers

# Levanta los contenedores (web, BBDD y phpMyAdmin)
docker-compose up -d
```

- Acceso a la web: http://localhost:8080
- Acceso a phpMyAdmin: http://localhost:8081
  Usuario: islatransfers | Contraseña: islatransfers
  (La base de datos por defecto se llama islatransfers)

```bash
# Parar los contenedores
docker-compose down
```

## ¿Qué se ha realizado hasta ahora?

- Estructura base del proyecto creada siguiendo el patrón MVC, sin frameworks dentro de /src.
- Configuración del entorno Docker: PHP 8.2 + Apache, MySQL 8, phpMyAdmin.
- Configuración básica de Git y .gitignore (con comentarios explicativos).
- README.md actualizado con estructura, instrucciones y notas para el equipo.
- Test de funcionamiento:
  - La web muestra el mensaje desde index.php.
  - Se puede acceder a la base de datos MySQL y gestionarla desde phpMyAdmin.
- Rama creada siguiendo convención: `feature/mvc-estructura-base-xavi`.

## Siguientes pasos

- Implementar la conexión a la base de datos en `/src/config/config.php`.
- Desarrollar el primer flujo MVC (mostrar listado de reservas).
- Ir añadiendo funcionalidad paso a paso (login, paneles, etc.).
- Añadir autenticación (login) y paneles para usuarios y administradores.
- Documentar el avance y seguir buenas prácticas en Git (nombres de ramas, mensajes de commit, pull requests).

---

_Este proyecto utiliza buenas prácticas en la gestión de versiones (ramas, mensajes de commit claros, etc.) y documentación desde el inicio._
