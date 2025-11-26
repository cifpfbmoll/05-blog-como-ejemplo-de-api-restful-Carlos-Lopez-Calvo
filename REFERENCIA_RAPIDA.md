# 🚀 Referencia Rápida - API Blog

## Servidor

```bash
# Iniciar servidor
php spark serve

# Detener servidor
Ctrl + C
```

**URL Base**: `http://localhost:8080`

---

## Endpoints

### 📋 Listar Posts
```bash
curl http://localhost:8080/posts
```

### 🔍 Ver Post
```bash
curl http://localhost:8080/posts/1
```

### ➕ Crear Post
```bash
curl -X POST http://localhost:8080/posts \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Título del Post",
    "content": "Contenido del post con al menos 10 caracteres",
    "category": "Categoría",
    "tags": ["tag1", "tag2"]
  }'
```

### ✏️ Actualizar Post
```bash
curl -X PUT http://localhost:8080/posts/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Nuevo Título"
  }'
```

### 🗑️ Eliminar Post
```bash
curl -X DELETE http://localhost:8080/posts/1
```

### 🔎 Buscar Posts
```bash
curl "http://localhost:8080/posts/search?term=php"
```

---

## Códigos HTTP

| Código | Significado |
|--------|-------------|
| 200 | OK - Éxito |
| 201 | Created - Creado |
| 400 | Bad Request - Datos inválidos |
| 404 | Not Found - No encontrado |

---

## Validación

### Crear Post
- `title`: Requerido, mínimo 5 caracteres
- `content`: Requerido, mínimo 10 caracteres
- `category`: Requerido
- `tags`: Opcional, array

### Actualizar Post
- Todos los campos opcionales
- Si se envían, deben cumplir las reglas

---

## Comandos Spark

```bash
# Migraciones
php spark migrate
php spark migrate:rollback
php spark migrate:status

# Ver rutas
php spark routes

# Generar código
php spark make:migration NombreMigracion
php spark make:model NombreModelo
php spark make:controller NombreControlador
```

---

## Base de Datos

```bash
# Ver estructura
sqlite3 writable/database/blog.db ".schema posts"

# Ver datos
sqlite3 writable/database/blog.db "SELECT * FROM posts;"

# Contar posts
sqlite3 writable/database/blog.db "SELECT COUNT(*) FROM posts;"

# Eliminar todos los posts
sqlite3 writable/database/blog.db "DELETE FROM posts;"
```

---

## Archivos Clave

| Archivo | Propósito |
|---------|-----------|
| `app/Controllers/Posts.php` | Lógica de la API |
| `app/Models/PostModel.php` | Modelo de datos |
| `app/Config/Routes.php` | Rutas |
| `.env` | Configuración |
| `writable/database/blog.db` | Base de datos |

---

## Documentación

- `DOCUMENTACION_PROYECTO.md` - Guía completa
- `README_API.md` - Referencia de API
- `POSTMAN_TESTS.md` - Guía de pruebas
- `ESTRUCTURA_PROYECTO.md` - Arquitectura
- `RESUMEN_PROYECTO.md` - Resumen general

---

## Prueba Rápida

```bash
# Ejecutar todas las pruebas
./test_api.sh
```

---

## Troubleshooting

### El servidor no inicia
```bash
# Verificar que el puerto 8080 esté libre
lsof -i :8080

# Usar otro puerto
php spark serve --port=3000
```

### Error de base de datos
```bash
# Verificar permisos
chmod -R 777 writable/

# Recrear base de datos
php spark migrate:rollback
php spark migrate
```

### Error 404 en todas las rutas
```bash
# Verificar rutas
php spark routes

# Reiniciar servidor
Ctrl + C
php spark serve
```

---

## Tips

- 💡 Usa Postman para pruebas interactivas
- 💡 Instala `jq` para formatear JSON: `curl http://localhost:8080/posts | jq`
- 💡 Los tags se almacenan como JSON string
- 💡 Los timestamps se manejan automáticamente
- 💡 La validación siempre ocurre en el servidor

---

## Ejemplo Completo

```bash
# 1. Iniciar servidor
php spark serve

# 2. Crear post (en otra terminal)
curl -X POST http://localhost:8080/posts \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Aprendiendo CodeIgniter 4",
    "content": "CodeIgniter 4 es un framework PHP moderno y potente",
    "category": "Desarrollo",
    "tags": ["php", "ci4", "framework"]
  }'

# 3. Ver posts
curl http://localhost:8080/posts

# 4. Buscar
curl "http://localhost:8080/posts/search?term=codeigniter"

# 5. Actualizar
curl -X PUT http://localhost:8080/posts/1 \
  -H "Content-Type: application/json" \
  -d '{"title": "Dominando CodeIgniter 4"}'

# 6. Eliminar
curl -X DELETE http://localhost:8080/posts/1
```

---

**¡Listo para usar!** 🎉
