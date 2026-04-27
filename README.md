# Prueba Técnica PHP Jr — API de Gestión de Tareas
## Descripción
Este repositorio contiene la resolución de la prueba técnica PHP Junior de Octavio Valenzuela!

## Instalación y Uso
Bash
# 1. Instalar dependencias
composer install

# 2. Crear la base de datos (SQLite)
# Importante: Esto crea la tabla con el nuevo campo due_date
php bin/create-schema.php

# 3. Correr los tests unitarios (Nivel 5)
vendor/bin/phpunit

# 4. Levantar el servidor
php -S localhost:8081 -t public/

## Resolución de la Prueba

### Nivel 1 — Comprensión Teórica
1. ¿Qué es Mezzio y ciclo de vida HTTP?
Mezzio es un micro-framework orientado a middlewares. La petición entra por public/index.php, activa el contenedor de dependencias y pasa por un pipeline de middlewares. El Router identifica la ruta y el método (ej: POST /api/tasks), envía la petición al Handler que corresponda, y este devuelve una respuesta que viaja de vuelta por el pipeline hasta el usuario por el medio que se solicite.

Ciclo de vida de una petición:
Entrada: Todo comienza en public/index.php, que recibe la petición web, activa el contenedor de dependencias y arranca la aplicación.
Pipeline: Antes de llegar a nuestro codigo, la petición pasa por un "pipeline" de middlewares que actuan como capas de seguridad y procesamiento.
Routing: Dentro del pipeline, el middleware mira la URL y el metodo (POST, GET, etc.) para enviar la petición al lugar correcto, como el CreateTaskHandler que utilizamos en el codigo.
Handler: Recibe la petición ya procesada, valida los datos, ejecuta el codigo necesario y genera una respuesta.
Salida: La respuesta viaja de vuelta a través del pipeline de middlewares hasta que el servidor envía el JSON al usuario.

2. Patrón Repository y TaskRepository
El patrón Repository sirve para desacoplar la lógica de negocio de la base de datos. Usamos TaskRepository para que los Handlers no tengan que saber SQL ni Doctrine, solo piden datos al repositorio. Esto hace que el código sea más legible y facil de cambiar en futuras modificaciones.

3. Factory y DI Container
Un Factory es una clase encargada de crear objetos. En el contenedor de dependencias, el Factory se asegura de buscar todas las piezas necesarias y armar el objeto listo para usar, funciona como una 
especia de orquestador.
