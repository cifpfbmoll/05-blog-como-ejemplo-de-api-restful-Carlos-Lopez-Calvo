# API RESTful para Blog - CodeIgniter 4

API REST completa para gestionar posts de un blog construida con CodeIgniter 4 y SQLite.

## 🚀 Inicio Rápido

### Requisitos
- PHP 8.1 o superior
- Composer
- SQLite3

### Instalación

1. **Clonar/Descargar el proyecto**
```bash
cd api-blog
```

2. **Instalar dependencias** (si es necesario)
```bash
composer install
```

3. **Configurar base de datos**
El archivo `.env` ya está configurado para SQLite. La base de datos se creará automáticamente.

4. **Ejecutar migraciones**
```bash
php spark migrate
```

5. **Iniciar servidor**
```bash
php spark serve
```

La API estará disponible en: `http://localhost:8080`

---

## 📚 Documentación de Endpoints

### Base URL
```
http://localhost:8080
```

### 1. Listar todos los posts
```http
GET /posts
```

**Respuesta (200 OK):**
```json
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "title": "Título del post",
            "content": "Contenido...",
            "category": "Categoría",
            "tags": "[\"tag1\",\"tag2\"]",
            "created_at": "2025-11-05 12:00:00",
            "updated_at": "2025-11-05 12:00:00"
        }
    ]
}
```

---

### 2. Obtener un post específico
```http
GET /posts/{id}
```

**Parámetros:**
- `id` (integer): ID del post

**Respuesta (200 OK):**
```json
{
    "status": 200,
    "data": {
        "id": 1,
        "title": "Título del post",
        "content": "Contenido...",
        "category": "Categoría",
        "tags": "[\"tag1\",\"tag2\"]",
        "created_at": "2025-11-05 12:00:00",
        "updated_at": "2025-11-05 12:00:00"
    }
}
```

**Respuesta (404 Not Found):**
```json
{
    "status": 404,
    "error": "Post no encontrado"
}
```

---

### 3. Crear un nuevo post
```http
POST /posts
Content-Type: application/json
```

**Body:**
```json
{
    "title": "Mi Nuevo Post",
    "content": "Este es el contenido del post...",
    "category": "Tecnología",
    "tags": ["php", "api", "rest"]
}
```

**Validación:**
- `title`: Requerido, mínimo 5 caracteres
- `content`: Requerido, mínimo 10 caracteres
- `category`: Requerido
- `tags`: Opcional, array de strings

**Respuesta (201 Created):**
```json
{
    "status": 201,
    "messages": {
        "success": "Post creado exitosamente"
    },
    "data": {
        "id": 2,
        "title": "Mi Nuevo Post",
        "content": "Este es el contenido del post...",
        "category": "Tecnología",
        "tags": "[\"php\",\"api\",\"rest\"]",
        "created_at": "2025-11-05 13:00:00",
        "updated_at": "2025-11-05 13:00:00"
    }
}
```

**Respuesta (400 Bad Request):**
```json
{
    "status": 400,
    "messages": {
        "error": {
            "title": "El campo title es requerido.",
            "content": "El campo content debe tener al menos 10 caracteres."
        }
    }
}
```

---

### 4. Actualizar un post
```http
PUT /posts/{id}
Content-Type: application/json
```

**Parámetros:**
- `id` (integer): ID del post a actualizar

**Body (todos los campos son opcionales):**
```json
{
    "title": "Título Actualizado",
    "content": "Contenido actualizado...",
    "category": "Nueva Categoría",
    "tags": ["nuevo", "tag"]
}
```

**Respuesta (200 OK):**
```json
{
    "status": 200,
    "messages": {
        "success": "Post actualizado exitosamente"
    },
    "data": {
        "id": 1,
        "title": "Título Actualizado",
        "content": "Contenido actualizado...",
        "category": "Nueva Categoría",
        "tags": "[\"nuevo\",\"tag\"]",
        "created_at": "2025-11-05 12:00:00",
        "updated_at": "2025-11-05 14:00:00"
    }
}
```

**Respuesta (404 Not Found):**
```json
{
    "status": 404,
    "error": "Post no encontrado"
}
```

---

### 5. Eliminar un post
```http
DELETE /posts/{id}
```

**Parámetros:**
- `id` (integer): ID del post a eliminar

**Respuesta (200 OK):**
```json
{
    "status": 200,
    "messages": {
        "success": "Post eliminado exitosamente"
    },
    "data": {
        "id": 1,
        "title": "Título del post eliminado",
        "content": "...",
        "category": "...",
        "tags": "...",
        "created_at": "2025-11-05 12:00:00",
        "updated_at": "2025-11-05 12:00:00"
    }
}
```

**Respuesta (404 Not Found):**
```json
{
    "status": 404,
    "error": "Post no encontrado"
}
```

---

### 6. Buscar posts
```http
GET /posts/search?term={término}
```

**Parámetros de Query:**
- `term` (string): Término de búsqueda

**Descripción:**
Busca el término en los campos `title`, `content` y `category`.

**Ejemplo:**
```
GET /posts/search?term=php
```

**Respuesta (200 OK):**
```json
{
    "status": 200,
    "data": [
        {
            "id": 1,
            "title": "Introducción a PHP",
            "content": "PHP es un lenguaje...",
            "category": "Programación",
            "tags": "[\"php\",\"web\"]",
            "created_at": "2025-11-05 12:00:00",
            "updated_at": "2025-11-05 12:00:00"
        }
    ]
}
```

**Respuesta (400 Bad Request):**
```json
{
    "status": 400,
    "error": "Debes proveer un término de búsqueda"
}
```

---

## 🧪 Probar con cURL

### Crear un post
```bash
curl -X POST http://localhost:8080/posts \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Post desde cURL",
    "content": "Este es un post de prueba creado con cURL",
    "category": "Testing",
    "tags": ["curl", "test"]
  }'
```

### Listar posts
```bash
curl http://localhost:8080/posts
```

### Obtener un post
```bash
curl http://localhost:8080/posts/1
```

### Actualizar un post
```bash
curl -X PUT http://localhost:8080/posts/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Título actualizado desde cURL"
  }'
```

### Buscar posts
```bash
curl "http://localhost:8080/posts/search?term=curl"
```

### Eliminar un post
```bash
curl -X DELETE http://localhost:8080/posts/1
```

---

## 📊 Códigos de Estado HTTP

| Código | Significado | Cuándo se usa |
|--------|-------------|---------------|
| 200 | OK | Operación exitosa (GET, PUT, DELETE) |
| 201 | Created | Recurso creado exitosamente (POST) |
| 400 | Bad Request | Datos inválidos o falta información |
| 404 | Not Found | Recurso no encontrado |
| 500 | Internal Server Error | Error del servidor |

---

## 🗂️ Estructura del Proyecto

```
api-blog/
├── app/
│   ├── Controllers/
│   │   └── Posts.php          # Controlador de la API
│   ├── Models/
│   │   └── PostModel.php      # Modelo de datos
│   ├── Database/
│   │   └── Migrations/
│   │       └── CreatePostsTable.php
│   └── Config/
│       └── Routes.php         # Definición de rutas
├── writable/
│   └── database/
│       └── blog.db            # Base de datos SQLite
├── public/
│   └── index.php
├── .env                       # Configuración
└── spark                      # CLI de CodeIgniter
```

---

## 🔧 Comandos Útiles

### Ver rutas disponibles
```bash
php spark routes
```

### Revertir migraciones
```bash
php spark migrate:rollback
```

### Crear nueva migración
```bash
php spark make:migration NombreMigracion
```

### Crear nuevo modelo
```bash
php spark make:model NombreModelo
```

### Crear nuevo controlador
```bash
php spark make:controller NombreControlador
```

---

## 📝 Notas Importantes

1. **Tags**: Los tags se almacenan como JSON en la base de datos. Envía un array y se convertirá automáticamente.

2. **Timestamps**: Los campos `created_at` y `updated_at` se manejan automáticamente.

3. **Validación**: Todos los datos se validan en el servidor. No confíes solo en validación del cliente.

4. **SQLite**: La base de datos es un archivo en `writable/database/blog.db`. Puedes respaldarlo fácilmente.

---

## 📖 Documentación Completa

Para una guía detallada del proceso de desarrollo, consulta:
- `DOCUMENTACION_PROYECTO.md` - Documentación completa con explicaciones paso a paso

---

## 🤝 Contribuir

Este es un proyecto educativo. Siéntete libre de:
- Reportar bugs
- Sugerir mejoras
- Hacer fork y experimentar

---

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.
