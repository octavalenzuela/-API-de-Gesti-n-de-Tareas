# Prueba Técnica PHP Jr — API de Gestión de Tareas

## Descripción

Esta es una API REST construida con **Mezzio** (Laminas) y **Doctrine ORM** que gestiona una lista de tareas (To-Do).
El proyecto ya tiene una estructura base funcional. Tu trabajo es entenderla, completarla y extenderla.

## Tecnologías

- PHP 8.1+
- [Mezzio](https://docs.mezzio.dev/) (framework PSR-15 de Laminas)
- [Doctrine ORM](https://www.doctrine-project.org/projects/orm.html)
- SQLite (base de datos local, sin necesidad de servidor)
- PHPUnit 10

## Instalación

```bash
# 1. Instalar dependencias
composer install

# 2. Crear la base de datos
php bin/create-schema.php

# 3. Levantar el servidor de desarrollo
composer serve
# La API estará disponible en http://localhost:8080
```

## Endpoints disponibles

| Método | Ruta               | Descripción                  |
|--------|--------------------|------------------------------|
| GET    | /api/tasks         | Listar todas las tareas      |
| POST   | /api/tasks         | Crear una tarea              |
| GET    | /api/tasks/{id}    | Obtener una tarea por ID     |
| PUT    | /api/tasks/{id}    | Actualizar una tarea         |
| DELETE | /api/tasks/{id}    | Eliminar una tarea           |

### Ejemplo: crear una tarea

```bash
curl -X POST http://localhost:8080/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title": "Mi primera tarea", "description": "Descripción opcional"}'
```

### Ejemplo: cambiar estado

```bash
curl -X PUT http://localhost:8080/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"status": "in_progress"}'
```

Los estados válidos son: `pending`, `in_progress`, `done`.

---

## Estructura del proyecto

```
├── bin/
│   └── create-schema.php        # Script para crear las tablas en la BD
├── config/
│   ├── autoload/
│   │   ├── app.global.php       # Registro de dependencias (DI Container)
│   │   └── doctrine.global.php  # Configuración de Doctrine
│   ├── container.php            # Bootstrap del contenedor de servicios
│   ├── pipeline.php             # Cadena de middlewares
│   └── routes.php               # Definición de rutas
├── public/
│   └── index.php                # Punto de entrada HTTP
├── src/App/
│   ├── Infrastructure/
│   │   └── Doctrine/
│   │       └── EntityManagerFactory.php
│   └── Task/
│       ├── Entity/
│       │   └── Task.php         # Entidad Doctrine
│       ├── Handler/             # Controladores HTTP (PSR-15)
│       │   ├── ListTasksHandler.php
│       │   ├── CreateTaskHandler.php
│       │   ├── GetTaskHandler.php
│       │   ├── UpdateTaskHandler.php
│       │   └── DeleteTaskHandler.php
│       └── Repository/
│           └── TaskRepository.php
└── test/
    └── Task/
        └── Entity/
            └── TaskTest.php     # Tests unitarios de la entidad
```

---

## Consignas de la prueba

Completá y/o extendé el proyecto resolviendo los siguientes puntos. **Leé todo antes de empezar.**

### Nivel 1 — Comprensión (obligatorio)

1. Explicá con tus palabras qué es **Mezzio** y cómo funciona el ciclo de vida de una petición HTTP en este proyecto (desde `public/index.php` hasta que se devuelve la respuesta).
2. Explicá qué es el **patrón Repository** y por qué se usa `TaskRepository` en lugar de acceder directamente al `EntityManager` desde los handlers.
3. Explicá qué es un **Factory** en el contexto del contenedor de dependencias (DI Container) de Laminas.

### Nivel 2 — Corrección de bug (obligatorio)

Al hacer un `PUT /api/tasks/{id}` con un body JSON, el handler recibe `$request->getParsedBody()` como `null`.

- Identificá por qué ocurre este problema.
- Corregilo de la manera correcta (tip: buscá sobre `BodyParams` middleware en Mezzio).

### Nivel 3 — Nueva funcionalidad (obligatorio)

Agregá un campo `due_date` (fecha límite) a la entidad `Task`:

- Tipo: `DateTimeImmutable`, nullable.
- Debe poder setearse al crear (`POST`) y actualizar (`PUT`) una tarea.
- Formato de entrada/salida: `YYYY-MM-DD`.
- Si se envía un formato de fecha inválido, devolver un error `422` con un mensaje descriptivo.
- Recordá actualizar el esquema de la base de datos (`php bin/create-schema.php` o con el SchemaTool de Doctrine).

### Nivel 4 — Filtrado (opcional, suma puntos)

Agregá soporte para filtrar tareas por estado en el endpoint `GET /api/tasks`:

```
GET /api/tasks?status=pending
GET /api/tasks?status=done
```

Si no se pasa el parámetro `status`, devuelve todas las tareas (comportamiento actual).

### Nivel 5 — Tests (opcional, suma puntos)

Escribí al menos **2 tests unitarios nuevos** para cubrir la funcionalidad agregada en el Nivel 3 (`due_date`).

---

## Criterios de evaluación

| Criterio                          | Peso  |
|-----------------------------------|-------|
| Comprensión del framework         | 20%   |
| Corrección del bug                | 20%   |
| Implementación de due_date        | 30%   |
| Calidad del código (clean code)   | 15%   |
| Tests                             | 15%   |

## Notas

- No modifiques los tests existentes (podés agregar nuevos).
- Podés usar cualquier recurso online, pero el código debe ser tuyo.
- Si algo no te queda claro, preguntá — la comunicación también se evalúa.
