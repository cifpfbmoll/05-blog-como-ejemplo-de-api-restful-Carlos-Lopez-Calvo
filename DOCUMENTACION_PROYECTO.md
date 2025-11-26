# Documentación del Proyecto: API RESTful para Restaurante con CodeIgniter 4

## Índice
1. [Introducción](#introducción)
2. [Stack Tecnológico](#stack-tecnológico)
3. [Proceso de Desarrollo](#proceso-de-desarrollo)
4. [Modelado de Recursos del Restaurante](#modelado-de-recursos-del-restaurante)
5. [Endpoints de la API](#endpoints-de-la-api)
6. [Pruebas](#pruebas)
7. [Reflexión Final](#reflexión-final)

---

## Introducción

Este proyecto consiste en la creación de una **API RESTful** para gestionar la operativa básica de un restaurante.  
El objetivo principal es aprender los fundamentos de **CodeIgniter 4**, el manejo de bases de datos con **SQLite** y los principios de las APIs REST, aplicados a un dominio real de negocio.

La API permite gestionar cuatro recursos principales:
- **Dishes (Platos)**: Elementos del menú del restaurante.
- **Tables (Mesas)**: Mesas físicas del local.
- **Reservations (Reservas)**: Reservas de clientes para una fecha y hora.
- **Orders (Pedidos)**: Pedidos realizados por los clientes (asociados a una mesa y/o reserva).

### Objetivos del Proyecto
- ✅ Construir endpoints CRUD (Create, Read, Update, Delete) para:
  - Platos (`dishes`)
  - Mesas (`tables`)
  - Reservas (`reservations`)
  - Pedidos (`orders`)
- ✅ Implementar validación de datos en el servidor
- ✅ Manejar respuestas HTTP apropiadas
- ✅ Implementar funcionalidad de búsqueda para platos
- ✅ Documentar todo el proceso de desarrollo

---

## Stack Tecnológico

- **Framework**: CodeIgniter 4 (v4.6.3)
- **Base de Datos**: SQLite 3
- **Lenguaje**: PHP 8.3.6
- **Gestor de Dependencias**: Composer

### ¿Por qué este stack?

**CodeIgniter 4**: Es un framework PHP moderno, ligero y con excelente documentación. Perfecto para aprender los conceptos de MVC y desarrollo de APIs.

**SQLite**: Es una base de datos que se almacena en un solo archivo, no requiere un servidor de BD separado, lo que la hace ideal para desarrollo y proyectos pequeños como la gestión de un restaurante.

---

## Proceso de Desarrollo

### Paso 0: Configuración Inicial del Entorno

#### ¿Qué es Composer?
**Composer** es el gestor de dependencias estándar para PHP. Nos permite:
- Instalar librerías y frameworks de forma automática
- Gestionar versiones de dependencias
- Autocargar clases automáticamente

Para instalar CodeIgniter 4, ejecutamos:
```bash
composer create-project codeigniter4/appstarter .
```

#### ¿Qué es Spark?
**Spark** es la herramienta de línea de comandos de CodeIgniter 4. Nos permite:
- Generar código automáticamente (controladores, modelos, migraciones)
- Ejecutar migraciones de base de datos
- Iniciar el servidor de desarrollo
- Ejecutar tareas personalizadas

#### ¿Qué hace `spark serve`?
Este comando inicia un servidor de desarrollo local en `http://localhost:8080`. Es perfecto para desarrollo, pero NO debe usarse en producción.

```bash
php spark serve
```

---

### Paso 1: Configurar la Base de Datos (SQLite)

#### ¿Qué es el archivo .env?
El archivo `.env` (environment) almacena configuraciones sensibles y específicas del entorno:
- Credenciales de base de datos
- Claves API
- Configuraciones de desarrollo/producción

**¿Por qué usar .env?**
- **Seguridad**: Las credenciales no se suben al repositorio (está en .gitignore)
- **Portabilidad**: Cada desarrollador puede tener su propia configuración
- **Flexibilidad**: Fácil cambiar entre entornos (desarrollo, pruebas, producción)

#### Configuración SQLite

Creamos el archivo `.env` desde `env`:
```bash
cp env .env
```

Configuración en `.env`:
```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = /ruta/absoluta/writable/database/restaurant.db
database.default.DBDriver = SQLite3
```

**¿Por qué SQLite?**
- ✅ Un solo archivo, fácil de respaldar
- ✅ No requiere instalación de servidor
- ✅ Perfecto para desarrollo y prototipos
- ✅ Suficiente para aplicaciones pequeñas/medianas

---

### Paso 2: Crear la Estructura de la Base de Datos (Migraciones)

#### ¿Qué es una Migración?
Una **migración** es un archivo PHP que describe cambios en la estructura de la base de datos. Es como un "control de versiones" para tu BD.

**Ventajas de las migraciones:**
- 📝 Historial de cambios en la BD
- 🔄 Fácil revertir cambios (rollback)
- 👥 Compartir estructura con el equipo
- 🚀 Desplegar cambios en producción de forma controlada

#### Crear las migraciones

Generamos una migración para cada recurso principal:
```bash
php spark make:migration CreateDishesTable
php spark make:migration CreateTablesTable
php spark make:migration CreateReservationsTable
php spark make:migration CreateOrdersTable
```

#### Diseño básico de tablas

- **Tabla `dishes`** (platos):
  - `id`: INT, autoincremental, clave primaria
  - `name`: VARCHAR(255)
  - `description`: TEXT
  - `price`: DECIMAL(10,2)
  - `category`: VARCHAR(100)
  - `is_available`: TINYINT(1) (1 = disponible, 0 = no disponible)
  - `created_at`: DATETIME
  - `updated_at`: DATETIME

- **Tabla `tables`** (mesas):
  - `id`: INT, autoincremental, clave primaria
  - `name`: VARCHAR(50) (ej: "Mesa 1", "Terraza A")
  - `capacity`: INT (número de personas)
  - `is_active`: TINYINT(1) (mesa utilizable o fuera de servicio)
  - `created_at`: DATETIME
  - `updated_at`: DATETIME

- **Tabla `reservations`** (reservas):
  - `id`: INT, autoincremental, clave primaria
  - `customer_name`: VARCHAR(255)
  - `customer_phone`: VARCHAR(50)
  - `table_id`: INT (FK a `tables`)
  - `reservation_datetime`: DATETIME
  - `people_count`: INT
  - `status`: VARCHAR(50) (ej: "pending", "confirmed", "cancelled")
  - `created_at`: DATETIME
  - `updated_at`: DATETIME

- **Tabla `orders`** (pedidos):
  - `id`: INT, autoincremental, clave primaria
  - `table_id`: INT (FK a `tables`, opcional si es delivery)
  - `reservation_id`: INT (FK a `reservations`, opcional)
  - `items`: TEXT (almacenamos JSON con los platos del pedido)
  - `total_amount`: DECIMAL(10,2)
  - `status`: VARCHAR(50) (ej: "pending", "in_progress", "served", "paid", "cancelled")
  - `created_at`: DATETIME
  - `updated_at`: DATETIME

#### Ejecutar las migraciones
```bash
php spark migrate
```

---

## Modelado de Recursos del Restaurante

### Paso 3: Crear los Modelos

#### ¿Qué es un Modelo en MVC?
El **Modelo** es la capa que interactúa con la base de datos. Su responsabilidad es:
- 📊 Consultar datos
- ✏️ Insertar/actualizar/eliminar registros
- ✅ Validar datos (junto con las reglas de validación de CI4)
- 🔄 Transformar datos

**Patrón MVC:**
- **Model**: Maneja datos y lógica de negocio
- **View**: Presenta datos al usuario (en APIs, JSON)
- **Controller**: Coordina Model y View

#### Crear los modelos

Para cada recurso creamos un modelo:
```bash
php spark make:model Dish --suffix
php spark make:model Table --suffix
php spark make:model Reservation --suffix
php spark make:model Order --suffix
```

#### Propiedades importantes del modelo

**`$allowedFields`**: ¡MUY IMPORTANTE para seguridad!
- Define qué campos pueden ser asignados masivamente
- Previene **Mass Assignment Vulnerability**
- Sin esto, un atacante podría modificar campos sensibles

**Ejemplo de vulnerabilidad:**
```php
// Sin $allowedFields protegido
$model->insert($request->getJSON(true));
// Un atacante podría enviar: {"name": "Mesa VIP", "is_admin": true}
```

**`$useTimestamps = true`**: 
- CI4 automáticamente actualiza `created_at` y `updated_at`
- No hace falta gestionarlos manualmente

---

### Paso 4: Crear los Controladores RESTful

#### ¿Qué es un Controlador?
El **Controlador** es el intermediario entre el usuario (peticiones HTTP) y el modelo (datos). Su trabajo es:
- 📥 Recibir peticiones
- ✅ Validar datos
- 🔄 Llamar al modelo
- 📤 Devolver respuestas

#### Crear los controladores
```bash
php spark make:controller Dishes --restful
php spark make:controller Tables --restful
php spark make:controller Reservations --restful
php spark make:controller Orders --restful
```

#### Controller vs ResourceController

**`Controller`**: Controlador básico de CI4  
**`ResourceController`**: Controlador especializado para APIs REST

**Ventajas de ResourceController:**
- ✅ Métodos helper para respuestas JSON: `respond()`, `respondCreated()`, `fail()`
- ✅ Manejo automático de códigos HTTP
- ✅ Métodos predefinidos: `index()`, `show()`, `create()`, `update()`, `delete()`
- ✅ Propiedad `$format` para especificar formato de respuesta

**`$modelName`**: Especifica qué modelo usar. Accesible como `$this->model`  
**`$format = 'json'`**: Define el formato de respuesta

---

### Paso 5: Configurar las Rutas

Las rutas conectan URLs con métodos de controladores.

Archivo: `app/Config/Routes.php`

```php
// API Routes
$routes->get('dishes/search', 'Dishes::search');

$routes->resource('dishes');
$routes->resource('tables');
$routes->resource('reservations');
$routes->resource('orders');
```

#### ¿Qué hace `$routes->resource('dishes')`?

Esta línea crea automáticamente todas las rutas RESTful:

| Método HTTP | URL           | Controlador::Método  | Acción              |
|------------|---------------|----------------------|---------------------|
| GET        | /dishes       | Dishes::index()      | Listar todos        |
| GET        | /dishes/1     | Dishes::show(1)      | Ver uno             |
| POST       | /dishes       | Dishes::create()     | Crear nuevo         |
| PUT/PATCH  | /dishes/1     | Dishes::update(1)    | Actualizar          |
| DELETE     | /dishes/1     | Dishes::delete(1)    | Eliminar            |

Lo mismo aplica para `tables`, `reservations` y `orders`.

**¿Por qué `dishes/search` va antes?**  
Las rutas se evalúan en orden. Si `resource('dishes')` va primero, `dishes/search` sería interpretado como `dishes/{id}` con `id='search'`.

---

### Paso 6: Implementar la Lógica de los Controladores

A continuación se resumen los comportamientos típicos de los métodos más importantes.

#### DishesController

- **index() - GET /dishes**
  ```php
  return $this->respond($this->model->findAll());
  ```
  Devuelve todos los platos.

- **show($id) - GET /dishes/{id}**
  ```php
  $dish = $this->model->find($id);
  if ($dish === null) {
      return $this->failNotFound('Plato no encontrado');
  }
  return $this->respond($dish);
  ```

- **create() - POST /dishes**
  - Obtiene datos JSON
  - Valida con reglas (nombre, precio, categoría, etc.)
  - Inserta en BD
  - Devuelve código 201 con el plato creado

- **update($id) - PUT /dishes/{id}**
  - Valida datos (reglas menos estrictas)
  - Verifica que el plato existe
  - Actualiza
  - Devuelve el plato actualizado

- **delete($id) - DELETE /dishes/{id}**
  - Verifica que el plato existe
  - Elimina (o marca como no disponible)
  - Devuelve confirmación

- **search() - GET /dishes/search?term={palabra}**
  ```php
  $dishes = $this->model
      ->like('name', $term)
      ->orLike('description', $term)
      ->orLike('category', $term)
      ->findAll();
  ```

#### TablesController

- Gestiona las mesas del restaurante:
  - `index()`: listar mesas
  - `show($id)`: ver una mesa
  - `create()`: crear mesa (nombre, capacidad)
  - `update($id)`: actualizar datos
  - `delete($id)`: desactivar/eliminar mesa

#### ReservationsController

- Gestiona reservas de clientes:
  - `index()`: listar reservas
  - `show($id)`: ver una reserva
  - `create()`: crear reserva (cliente, fecha/hora, mesa, número de personas)
  - `update($id)`: actualizar (por ejemplo, cambiar estado a "confirmed" o "cancelled")
  - `delete($id)`: cancelar/eliminar reserva

#### OrdersController

- Gestiona pedidos:
  - `index()`: listar pedidos
  - `show($id)`: ver un pedido
  - `create()`: crear pedido (mesa, reserva, items, total)
  - `update($id)`: actualizar estado (ej: "in_progress", "served", "paid")
  - `delete($id)`: cancelar pedido

---

### Paso 7: Validar los Datos

#### ¿Por qué validar en el servidor?
**Nunca confíes en el cliente.**

Razones:
- 🔒 **Seguridad**: El cliente puede ser manipulado
- 🛡️ **Integridad**: Garantizar datos correctos en la BD
- 🚫 **Prevención**: Evitar inyecciones SQL, XSS, etc.

#### Reglas de validación (ejemplos)

**En `Dishes::create()`:**
```php
$rules = [
    'name'        => 'required|min_length[3]',
    'description' => 'required|min_length[10]',
    'price'       => 'required|decimal',
    'category'    => 'required',
];
```

**En `Reservations::create()`:**
```php
$rules = [
    'customer_name'       => 'required|min_length[3]',
    'customer_phone'      => 'required',
    'table_id'            => 'required|integer',
    'reservation_datetime'=> 'required|valid_date',
    'people_count'        => 'required|integer',
];
```

**En `Orders::create()`:**
```php
$rules = [
    'items'        => 'required',
    'total_amount' => 'required|decimal',
];
```

---

## Endpoints de la API

### Resumen de Endpoints Principales

#### Dishes (Platos)

| Método | Endpoint                         | Descripción                  | Código Éxito | Código Error        |
|--------|----------------------------------|------------------------------|--------------|---------------------|
| GET    | /dishes                          | Listar todos los platos      | 200          | -                   |
| GET    | /dishes/{id}                     | Obtener un plato             | 200          | 404                 |
| POST   | /dishes                          | Crear un plato               | 201          | 400                 |
| PUT    | /dishes/{id}                     | Actualizar un plato          | 200          | 400, 404            |
| DELETE | /dishes/{id}                     | Eliminar/ocultar un plato    | 200          | 404                 |
| GET    | /dishes/search?term={palabra}    | Buscar platos                | 200          | 400                 |

#### Tables (Mesas)

| Método | Endpoint     | Descripción               | Código Éxito | Código Error |
|--------|--------------|---------------------------|--------------|--------------|
| GET    | /tables      | Listar mesas              | 200          | -            |
| GET    | /tables/{id} | Obtener una mesa          | 200          | 404          |
| POST   | /tables      | Crear una mesa            | 201          | 400          |
| PUT    | /tables/{id} | Actualizar una mesa       | 200          | 400, 404     |
| DELETE | /tables/{id} | Eliminar/desactivar mesa  | 200          | 404          |

#### Reservations (Reservas)

| Método | Endpoint            | Descripción                | Código Éxito | Código Error |
|--------|---------------------|----------------------------|--------------|--------------|
| GET    | /reservations       | Listar reservas            | 200          | -            |
| GET    | /reservations/{id}  | Obtener una reserva        | 200          | 404          |
| POST   | /reservations       | Crear una reserva          | 201          | 400          |
| PUT    | /reservations/{id}  | Actualizar una reserva     | 200          | 400, 404     |
| DELETE | /reservations/{id}  | Cancelar/eliminar reserva  | 200          | 404          |

#### Orders (Pedidos)

| Método | Endpoint     | Descripción                 | Código Éxito | Código Error |
|--------|--------------|-----------------------------|--------------|--------------|
| GET    | /orders      | Listar pedidos              | 200          | -            |
| GET    | /orders/{id} | Obtener un pedido           | 200          | 404          |
| POST   | /orders      | Crear un pedido             | 201          | 400          |
| PUT    | /orders/{id} | Actualizar un pedido        | 200          | 400, 404     |
| DELETE | /orders/{id} | Cancelar un pedido          | 200          | 404          |

---

### Códigos de Estado HTTP

#### Códigos de Éxito (2xx)
- **200 OK**: Petición exitosa
- **201 Created**: Recurso creado exitosamente

#### Códigos de Error del Cliente (4xx)
- **400 Bad Request**: Datos inválidos
- **404 Not Found**: Recurso no encontrado

---

## Pruebas

### Configuración
1. Descargar Postman: https://www.postman.com/downloads/
2. Servidor corriendo: `php spark serve`
3. URL base: `http://localhost:8080`

### Ejemplos de Pruebas

#### 1. Crear Plato (POST /dishes)
```json
{
  "name": "Pizza Margarita",
  "description": "Pizza clásica con tomate, mozzarella y albahaca fresca.",
  "price": 9.99,
  "category": "Pizzas",
  "is_available": true
}
```

#### 2. Listar Platos (GET /dishes)
Devuelve un array con todos los platos del menú.

#### 3. Crear Mesa (POST /tables)
```json
{
  "name": "Mesa Terraza 1",
  "capacity": 4,
  "is_active": true
}
```

#### 4. Crear Reserva (POST /reservations)
```json
{
  "customer_name": "Juan Pérez",
  "customer_phone": "+34 600 000 000",
  "table_id": 1,
  "reservation_datetime": "2025-11-26 21:00:00",
  "people_count": 4
}
```

#### 5. Crear Pedido (POST /orders)
```json
{
  "table_id": 1,
  "reservation_id": 1,
  "items": [
    { "dish_id": 1, "quantity": 2 },
    { "dish_id": 3, "quantity": 1 }
  ],
  "total_amount": 29.97,
  "status": "pending"
}
```

#### 6. Buscar Platos (GET /dishes/search?term=pizza)
Busca en `name`, `description` y `category`.

---

## Reflexión Final

### ¿Qué fue lo más fácil?
La **configuración inicial** del proyecto y la **creación de rutas con `resource()`**. CodeIgniter 4 proporciona herramientas CLI que agilizan enormemente la creación de APIs REST.

### ¿Qué fue lo más difícil?
1. **Diseñar el modelo de datos** para cubrir platos, mesas, reservas y pedidos sin complicar demasiado el esquema.
2. **Gestionar relaciones** entre tablas (por ejemplo, pedidos asociados a reservas y mesas).
3. **Definir estados** claros para reservas y pedidos (pending, confirmed, cancelled, served, paid…).

### ¿Qué aprendí?

**Sobre CodeIgniter 4:**
- ✅ Framework bien estructurado con separación clara de responsabilidades
- ✅ Sistema de migraciones poderoso
- ✅ Modelos con características de seguridad integradas
- ✅ Spark es muy útil para generar código y ejecutar tareas

**Sobre APIs REST aplicadas a un restaurante:**
- ✅ Importancia de diseñar bien los recursos (dishes, tables, reservations, orders)
- ✅ Códigos de estado HTTP correctos facilitan la integración con otros sistemas
- ✅ URLs RESTful claras hacen la API predecible
- ✅ Validación en el servidor es crítica para mantener integridad de la información

**Conceptos clave:**
1. **Patrón MVC**: Separación clara de responsabilidades
2. **Mass Assignment Protection**: `$allowedFields` es crucial
3. **Migraciones**: Control de versiones para la base de datos
4. **RESTful Design**: APIs predecibles y fáciles de usar
5. **Validación**: Nunca confiar en el cliente

### Próximos pasos
- 🔐 Autenticación con JWT para empleados o camareros
- 📄 Paginación de listados (platos, reservas, pedidos)
- 🔍 Filtros avanzados (por fecha, estado, rango de precio)
- 📝 Documentación interactiva con Swagger / OpenAPI
- ✅ Tests automatizados (unitarios y de integración)
- 🚀 Rate limiting para proteger la API en producción

---

## Conclusión

Este proyecto fue una excelente introducción a CodeIgniter 4 y al desarrollo de APIs RESTful aplicadas a un caso real como la gestión de un restaurante.  
La combinación de CI4 con SQLite resultó perfecta para aprendizaje y desarrollo rápido de una solución completa que cubre platos, mesas, reservas y pedidos.


