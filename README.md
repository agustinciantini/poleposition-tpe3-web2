# API de Gestión de Resultados de Carreras (pole-position)

# Integrantes:

* Martin Nicolas Larrosa.
* Agustin Ciantini.

## Descripción:

Este proyecto implementa una API REST para la gestión de **resultados de carreras** en la base de datos `poleposition`. La API proporciona acceso a los resultados existentes, permitiendo a los usuarios obtener listados completos con opciones avanzadas de filtrado, ordenamiento y paginación.

Específicamente, los usuarios podrán **filtrar** los resultados por **Piloto** o **Carrera** (usando sus respectivos IDs). La API también permite **ordenar** los resultados por campos clave como la **Posición** o el **Tiempo** registrado. Además, se incluyen funcionalidades CRUD (Crear, Leer, Actualizar, Eliminar) para la administración completa de los resultados y un sistema de autenticación por JWT para el acceso seguro.

## Endpoints:

La URL base para todas las peticiones es **`http://localhost/pole-position/api/`**

| Verbo HTTP | Endpoint | ¿Qué hace? |
| :--- | :--- | :--- |
| **GET** | `/api/token` | **Login / Autenticación.** Devuelve el JWT (JSON Web Token) usando **Basic Auth** con `username` (webadmin) y `password`. (admin) |
| **GET** | `/api/resultados` | Devuelve **todos los resultados** de carreras. |
| **GET** | `/api/resultado/:id` | Devuelve los detalles de un **resultado específico** según su `resultado_id`. |
| **POST** | `/api/resultado` | Permite **crear un nuevo resultado** (requiere JSON Body con `piloto_id`, `carrera_id`, `posicion`, `tiempo`). |
| **PUT** | `/api/resultado/:id` | **Actualiza** un resultado existente por su ID (requiere JSON Body). |
| **DELETE** | `/api/resultado/:id` | **Elimina** un resultado específico por su ID. |

## Ordenamiento:

Los resultados se pueden ordenar por varios campos clave y elegir la dirección de este orden.

| Campo de Ordenamiento (`orderBy`) | Se ordena por |
| :--- | :--- |
| `posicion` | La posición de llegada del piloto. |
| `tiempo` | El tiempo final registrado. |
| `piloto` | El apellido del piloto (`pilotos.apellido`). |
| `carrera` | La fecha de la carrera (`carreras.fecha`). |

**Ejemplos de Ordenamiento:**
* `/api/resultados?orderBy=posicion&orderDirection=ASC` (Del 1er lugar al último)
* `/api/resultados?orderBy=tiempo&orderDirection=ASC` (Del tiempo más rápido al más lento)
* `/api/resultados?orderBy=piloto&orderDirection=DESC`

## Filtros:

Los resultados se pueden filtrar por las claves foráneas (`piloto_id` y `carrera_id`).

| Parámetro de Filtro | Campo de la DB que Filtra |
| :--- | :--- |
| `filter_piloto` | Filtra resultados por el **ID del Piloto**. |
| `filter_carrera` | Filtra resultados por el **ID de la Carrera**. |

**Ejemplos:**
* **Filtrar por Piloto ID 1:** `/api/resultados?filter_piloto=1`
* **Filtrar por Carrera ID 8:** `/api/resultados?filter_carrera=8`

**--- Concatenados ---**
* **Piloto 1 en Carrera 8:** `/api/resultados?filter_piloto=1&filter_carrera=8`

## Ordenamiento y Filtros:

Permite combinar filtros y ordenamiento en una sola consulta.

* **Ejemplo:** Resultados de la **Carrera 9**, ordenados por **posición** de forma **ascendente**.
  `/api/resultados?filter_carrera=9&orderBy=posicion&orderDirection=ASC`

## Paginación:

Tanto la página (`page`) como el límite (`limit`) de los resultados a mostrar se pasan por parámetros.

* **Ejemplo:** Muestra la **Página 2**, con un máximo de **2 resultados** por página.
  `/api/resultados?page=2&limit=2`

**Nota:** Si ingresa un `limit=0` o un valor de `page` que excede los resultados disponibles, la API devolverá un estado 404.