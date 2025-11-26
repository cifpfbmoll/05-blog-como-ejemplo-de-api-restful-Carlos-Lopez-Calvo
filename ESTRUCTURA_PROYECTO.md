# Estructura del Proyecto

## 📁 Árbol de Directorios

```
api-blog/
├── app/
│   ├── Config/
│   │   ├── Routes.php              # ⭐ Definición de rutas de la API
│   │   ├── Database.php            # Configuración de BD (usa .env)
│   │   └── ...
│   │
│   ├── Controllers/
│   │   ├── Posts.php               # ⭐ Controlador principal de la API
│   │   ├── Home.php                # Controlador por defecto
│   │   └── BaseController.php
│   │
│   ├── Models/
│   │   └── PostModel.php           # ⭐ Modelo de datos para posts
│   │
│   ├── Database/
│   │   └── Migrations/
│   │       └── 2025-11-05-122918_CreatePostsTable.php  # ⭐ Migración
│   │
│   └── Views/                      # No usado (API solo devuelve JSON)
│
├── writable/
│   ├── database/
│   │   └── blog.db                 # ⭐ Base de datos SQLite
│   ├── logs/                       # Logs de la aplicación
│   ├── cache/                      # Cache
│   └── session/                    # Sesiones
│
├── public/
│   ├── index.php                   # Punto de entrada de la aplicación
│   └── .htaccess                   # Configuración Apache
│
├── vendor/                         # Dependencias de Composer
│   └── codeigniter4/               # Framework CI4
│
├── tests/                          # Tests automatizados (PHPUnit)
│
├── .env                            # ⭐ Configuración del entorno
├── composer.json                   # Dependencias del proyecto
├── spark                           # ⭐ CLI de CodeIgniter
│
├── DOCUMENTACION_PROYECTO.md       # ⭐ Documentación completa
├── README_API.md                   # ⭐ Guía de uso de la API
├── POSTMAN_TESTS.md                # ⭐ Guía de pruebas con Postman
├── ESTRUCTURA_PROYECTO.md          # ⭐ Este archivo
└── test_api.sh                     # ⭐ Script de pruebas rápidas
```

**Leyenda**: ⭐ = Archivos clave del proyecto

---

## 🎯 Archivos Principales

### 1. Controlador: `app/Controllers/Posts.php`

**Responsabilidad**: Manejar peticiones HTTP y coordinar respuestas

**Métodos implementados**:
- `index()` → GET /posts
- `show($id)` → GET /posts/{id}
- `create()` → POST /posts
- `update($id)` → PUT /posts/{id}
- `delete($id)` → DELETE /posts/{id}
- `search()` → GET /posts/search

**Características**:
- Extiende `ResourceController` para APIs REST
- Validación de datos
- Manejo de errores con códigos HTTP apropiados
- Respuestas JSON consistentes

---

### 2. Modelo: `app/Models/PostModel.php`

**Responsabilidad**: Interactuar con la base de datos

**Configuración clave**:
```php
protected $table = 'posts';
protected $allowedFields = ['title', 'content', 'category', 'tags'];
protected $useTimestamps = true;
```

**Características**:
- Protección contra Mass Assignment
- Timestamps automáticos
- Métodos heredados: `find()`, `findAll()`, `insert()`, `update()`, `delete()`

---

### 3. Rutas: `app/Config/Routes.php`

**Responsabilidad**: Mapear URLs a métodos del controlador

**Rutas definidas**:
```php
$routes->get('posts/search', 'Posts::search');
$routes->resource('posts');
```

**Resultado**:
- GET /posts → Posts::index()
- GET /posts/1 → Posts::show(1)
- POST /posts → Posts::create()
- PUT /posts/1 → Posts::update(1)
- DELETE /posts/1 → Posts::delete(1)
- GET /posts/search → Posts::search()

---

### 4. Migración: `app/Database/Migrations/..._CreatePostsTable.php`

**Responsabilidad**: Definir estructura de la tabla

**Tabla creada**: `posts`

**Campos**:
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT | Clave primaria, autoincremental |
| title | VARCHAR(255) | Título del post |
| content | TEXT | Contenido completo |
| category | VARCHAR(100) | Categoría |
| tags | TEXT | Tags en formato JSON |
| created_at | DATETIME | Fecha de creación |
| updated_at | DATETIME | Fecha de actualización |

---

### 5. Configuración: `.env`

**Responsabilidad**: Variables de entorno

**Configuración clave**:
```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.DBDriver = SQLite3
database.default.database = /ruta/absoluta/writable/database/blog.db
```

---

## 🔄 Flujo de una Petición

### Ejemplo: GET /posts/1

```
1. Usuario hace petición
   ↓
2. public/index.php (punto de entrada)
   ↓
3. Routes.php identifica la ruta
   ↓
4. Posts::show(1) es llamado
   ↓
5. Controlador usa PostModel
   ↓
6. Modelo consulta base de datos SQLite
   ↓
7. Datos retornan al controlador
   ↓
8. Controlador formatea respuesta JSON
   ↓
9. Usuario recibe respuesta HTTP
```

---

## 📊 Patrón MVC en el Proyecto

### Model (Modelo)
- **Archivo**: `app/Models/PostModel.php`
- **Responsabilidad**: Lógica de datos
- **Interactúa con**: Base de datos SQLite

### View (Vista)
- **En este proyecto**: No hay vistas HTML
- **Alternativa**: Respuestas JSON
- **Responsabilidad**: Presentación de datos

### Controller (Controlador)
- **Archivo**: `app/Controllers/Posts.php`
- **Responsabilidad**: Lógica de aplicación
- **Interactúa con**: Modelo y genera respuestas

---

## 🗄️ Base de Datos

### Ubicación
```
writable/database/blog.db
```

### Características de SQLite
- ✅ Archivo único, fácil de respaldar
- ✅ No requiere servidor
- ✅ Transaccional (ACID)
- ✅ Perfecto para desarrollo

### Comandos útiles

**Ver estructura de la tabla**:
```bash
sqlite3 writable/database/blog.db ".schema posts"
```

**Ver datos**:
```bash
sqlite3 writable/database/blog.db "SELECT * FROM posts;"
```

**Contar posts**:
```bash
sqlite3 writable/database/blog.db "SELECT COUNT(*) FROM posts;"
```

---

## 🛠️ Comandos Spark Útiles

### Migraciones
```bash
# Ejecutar migraciones
php spark migrate

# Revertir última migración
php spark migrate:rollback

# Ver estado de migraciones
php spark migrate:status

# Crear nueva migración
php spark make:migration NombreMigracion
```

### Generadores
```bash
# Crear modelo
php spark make:model NombreModelo --suffix

# Crear controlador
php spark make:controller NombreControlador

# Crear controlador RESTful
php spark make:controller NombreControlador --restful
```

### Servidor
```bash
# Iniciar servidor en puerto 8080
php spark serve

# Iniciar en puerto específico
php spark serve --port=3000

# Iniciar en host específico
php spark serve --host=0.0.0.0
```

### Rutas
```bash
# Ver todas las rutas
php spark routes

# Buscar ruta específica
php spark routes | grep posts
```

---

## 📦 Dependencias (composer.json)

### Dependencias de Producción
- `codeigniter4/framework`: ^4.6 - El framework principal

### Dependencias de Desarrollo
- `phpunit/phpunit`: ^10.5 - Testing
- `fakerphp/faker`: ^1.24 - Datos de prueba
- `mikey179/vfsstream`: ^1.6 - Sistema de archivos virtual para tests

---

## 🔐 Seguridad Implementada

### 1. Mass Assignment Protection
```php
protected $allowedFields = ['title', 'content', 'category', 'tags'];
```
Solo estos campos pueden ser asignados masivamente.

### 2. Validación de Datos
```php
$rules = [
    'title' => 'required|min_length[5]',
    'content' => 'required|min_length[10]',
    'category' => 'required'
];
```

### 3. Archivo .env en .gitignore
Las credenciales no se suben al repositorio.

### 4. Sanitización Automática
CI4 sanitiza automáticamente los datos de entrada.

---

## 📝 Convenciones del Proyecto

### Nombres de Archivos
- **Controladores**: PascalCase, plural → `Posts.php`
- **Modelos**: PascalCase, singular + "Model" → `PostModel.php`
- **Migraciones**: fecha + descripción → `2025-11-05-122918_CreatePostsTable.php`

### Nombres de Métodos
- **Controladores**: camelCase → `index()`, `show()`, `create()`
- **Modelos**: camelCase → `findAll()`, `insert()`

### Nombres de Rutas
- **URLs**: kebab-case, plural → `/posts`, `/posts/search`

### Nombres de Tablas
- **Base de datos**: snake_case, plural → `posts`

### Nombres de Campos
- **Base de datos**: snake_case → `created_at`, `updated_at`

---

## 🚀 Despliegue

### Preparación para Producción

1. **Cambiar entorno**:
```ini
CI_ENVIRONMENT = production
```

2. **Configurar base de datos real**:
```ini
database.default.DBDriver = MySQLi
database.default.hostname = tu-servidor
database.default.database = nombre_bd
database.default.username = usuario
database.default.password = contraseña
```

3. **Ejecutar migraciones**:
```bash
php spark migrate
```

4. **Configurar servidor web** (Apache/Nginx)
- Document root: `/public`
- Rewrite rules para URLs limpias

5. **Optimizar**:
```bash
composer install --no-dev --optimize-autoloader
```

---

## 📚 Recursos Adicionales

### Documentación Oficial
- **CodeIgniter 4**: https://codeigniter.com/user_guide/
- **SQLite**: https://www.sqlite.org/docs.html

### Archivos de Documentación del Proyecto
- `DOCUMENTACION_PROYECTO.md` - Guía completa paso a paso
- `README_API.md` - Referencia rápida de la API
- `POSTMAN_TESTS.md` - Guía de pruebas

### Herramientas Recomendadas
- **Postman**: Pruebas de API
- **SQLite Browser**: Visualizar base de datos
- **VS Code**: Editor con extensiones PHP

---

## 🎓 Conceptos Aprendidos

### Framework
- ✅ Patrón MVC
- ✅ Routing
- ✅ ORM básico
- ✅ Migraciones

### API REST
- ✅ Métodos HTTP
- ✅ Códigos de estado
- ✅ Estructura de URLs
- ✅ Respuestas JSON

### Base de Datos
- ✅ SQLite
- ✅ Migraciones
- ✅ Query Builder
- ✅ Timestamps automáticos

### Seguridad
- ✅ Validación
- ✅ Mass Assignment Protection
- ✅ Variables de entorno

---

## 🔄 Próximos Pasos

Si quieres extender este proyecto:

1. **Autenticación**: JWT o API Keys
2. **Paginación**: Limitar resultados
3. **Filtros**: Por categoría, fecha, etc.
4. **Relaciones**: Agregar tabla de usuarios/autores
5. **Tests**: PHPUnit para endpoints
6. **Documentación**: Swagger/OpenAPI
7. **Rate Limiting**: Limitar peticiones
8. **CORS**: Para frontend
9. **Logging**: Registrar peticiones
10. **Cache**: Redis/Memcached

---

## ✅ Checklist de Implementación

- [x] Instalación de CodeIgniter 4
- [x] Configuración de SQLite
- [x] Creación de migración
- [x] Creación de modelo
- [x] Creación de controlador RESTful
- [x] Configuración de rutas
- [x] Implementación de CRUD completo
- [x] Validación de datos
- [x] Manejo de errores
- [x] Búsqueda de posts
- [x] Documentación completa
- [x] Guías de pruebas

---

Este proyecto está completo y listo para usar como base de aprendizaje o punto de partida para proyectos más complejos.
