# Guía de Pruebas con Postman

Esta guía te ayudará a probar todos los endpoints de la API usando Postman.

## Configuración Inicial

1. **Descargar Postman**: https://www.postman.com/downloads/
2. **Asegurarse de que el servidor esté corriendo**:
   ```bash
   php spark serve
   ```
3. **URL Base**: `http://localhost:8080`

---

## Colección de Pruebas

### 📝 Prueba 1: Crear Primer Post

**Propósito**: Crear un post nuevo en la base de datos

**Método**: `POST`  
**URL**: `http://localhost:8080/posts`  
**Headers**:
```
Content-Type: application/json
```

**Body** (seleccionar "raw" y "JSON"):
```json
{
  "title": "Mi Primer Post en CI4",
  "content": "Este es el contenido de mi primer post usando CodeIgniter 4 y SQLite. Estoy aprendiendo a crear APIs RESTful.",
  "category": "Desarrollo",
  "tags": ["php", "codeigniter", "api", "rest"]
}
```

**Resultado Esperado**:
- ✅ Código de estado: `201 Created`
- ✅ Respuesta incluye el post creado con `id`, `created_at` y `updated_at`
- ✅ Tags convertidos a JSON string

**Captura de pantalla debe mostrar**:
- Método POST y URL
- Pestaña Body con el JSON
- Respuesta 201 con el post creado

---

### 📝 Prueba 2: Crear Segundo Post

**Propósito**: Crear otro post para tener datos de prueba

**Método**: `POST`  
**URL**: `http://localhost:8080/posts`  
**Headers**:
```
Content-Type: application/json
```

**Body**:
```json
{
  "title": "Introducción a SQLite",
  "content": "SQLite es una base de datos ligera y perfecta para desarrollo. No requiere servidor y se almacena en un solo archivo.",
  "category": "Bases de Datos",
  "tags": ["sqlite", "database", "sql"]
}
```

**Resultado Esperado**:
- ✅ Código: `201 Created`
- ✅ `id` diferente al primer post (probablemente 2)

---

### 📝 Prueba 3: Crear Tercer Post

**Método**: `POST`  
**URL**: `http://localhost:8080/posts`  
**Headers**:
```
Content-Type: application/json
```

**Body**:
```json
{
  "title": "APIs RESTful: Mejores Prácticas",
  "content": "Las APIs REST deben usar correctamente los métodos HTTP, códigos de estado y seguir convenciones de nomenclatura.",
  "category": "Desarrollo",
  "tags": ["api", "rest", "best-practices"]
}
```

---

### 📋 Prueba 4: Listar Todos los Posts

**Propósito**: Verificar que todos los posts creados están en la base de datos

**Método**: `GET`  
**URL**: `http://localhost:8080/posts`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Array con 3 posts
- ✅ Cada post tiene todos sus campos

**Captura debe mostrar**:
- Método GET y URL
- Respuesta 200 con array de posts

---

### 🔍 Prueba 5: Obtener Post Específico (Éxito)

**Propósito**: Obtener un post por su ID

**Método**: `GET`  
**URL**: `http://localhost:8080/posts/1`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Objeto con el post ID 1
- ✅ Todos los campos presentes

---

### ❌ Prueba 6: Obtener Post que No Existe

**Propósito**: Verificar manejo de errores 404

**Método**: `GET`  
**URL**: `http://localhost:8080/posts/999`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `404 Not Found`
- ✅ Mensaje: "Post no encontrado"

**Captura debe mostrar**:
- URL con ID 999
- Respuesta 404 con mensaje de error

**¿Por qué es importante?**
Demuestra que la API maneja correctamente recursos inexistentes.

---

### ✏️ Prueba 7: Actualizar Post (Éxito)

**Propósito**: Modificar un post existente

**Método**: `PUT`  
**URL**: `http://localhost:8080/posts/1`  
**Headers**:
```
Content-Type: application/json
```

**Body**:
```json
{
  "title": "Mi Primer Post en CI4 - ACTUALIZADO",
  "content": "Este contenido ha sido actualizado. Ahora incluye más información sobre CodeIgniter 4 y sus características."
}
```

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Post con título y contenido actualizados
- ✅ `updated_at` diferente a `created_at`
- ✅ Otros campos sin cambios

**Captura debe mostrar**:
- Método PUT y URL con ID
- Body con campos a actualizar
- Respuesta 200 con post actualizado

---

### ✏️ Prueba 8: Actualizar Solo un Campo

**Propósito**: Verificar actualización parcial

**Método**: `PUT`  
**URL**: `http://localhost:8080/posts/2`  
**Headers**:
```
Content-Type: application/json
```

**Body**:
```json
{
  "category": "Tecnología"
}
```

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Solo `category` cambió
- ✅ `title` y `content` sin cambios

---

### ❌ Prueba 9: Actualizar con Datos Inválidos

**Propósito**: Verificar validación en actualización

**Método**: `PUT`  
**URL**: `http://localhost:8080/posts/1`  
**Headers**:
```
Content-Type: application/json
```

**Body**:
```json
{
  "title": "Cor",
  "content": "Muy"
}
```

**Resultado Esperado**:
- ✅ Código: `400 Bad Request`
- ✅ Errores de validación:
  - title debe tener mínimo 5 caracteres
  - content debe tener mínimo 10 caracteres

**Captura debe mostrar**:
- Respuesta 400
- Objeto con errores de validación

---

### 🔍 Prueba 10: Buscar Posts (Éxito)

**Propósito**: Buscar posts por término

**Método**: `GET`  
**URL**: `http://localhost:8080/posts/search?term=ci4`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Array con posts que contienen "ci4" en title, content o category
- ✅ Probablemente devuelva el post 1

**Nota**: La búsqueda es case-insensitive en SQLite.

---

### 🔍 Prueba 11: Buscar por Categoría

**Método**: `GET`  
**URL**: `http://localhost:8080/posts/search?term=Desarrollo`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Posts con categoría "Desarrollo"

---

### 🔍 Prueba 12: Búsqueda Sin Resultados

**Método**: `GET`  
**URL**: `http://localhost:8080/posts/search?term=python`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Array vacío `[]`

---

### ❌ Prueba 13: Búsqueda Sin Término

**Propósito**: Verificar validación de parámetros

**Método**: `GET`  
**URL**: `http://localhost:8080/posts/search`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `400 Bad Request`
- ✅ Mensaje: "Debes proveer un término de búsqueda"

---

### ❌ Prueba 14: Crear Post con Datos Inválidos

**Propósito**: Verificar validación en creación

**Método**: `POST`  
**URL**: `http://localhost:8080/posts`  
**Headers**:
```
Content-Type: application/json
```

**Body**:
```json
{
  "title": "Cor",
  "content": "Muy corto"
}
```

**Resultado Esperado**:
- ✅ Código: `400 Bad Request`
- ✅ Errores:
  - title: mínimo 5 caracteres
  - content: mínimo 10 caracteres
  - category: requerido

**Captura debe mostrar**:
- Body con datos inválidos
- Respuesta 400 con todos los errores

---

### ❌ Prueba 15: Crear Post Sin Datos

**Método**: `POST`  
**URL**: `http://localhost:8080/posts`  
**Headers**:
```
Content-Type: application/json
```

**Body**:
```json
{}
```

**Resultado Esperado**:
- ✅ Código: `400 Bad Request`
- ✅ Todos los campos requeridos en errores

---

### 🗑️ Prueba 16: Eliminar Post (Éxito)

**Propósito**: Eliminar un post

**Método**: `DELETE`  
**URL**: `http://localhost:8080/posts/3`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Mensaje: "Post eliminado exitosamente"
- ✅ Datos del post eliminado en la respuesta

**Captura debe mostrar**:
- Método DELETE y URL con ID
- Respuesta 200 con confirmación

---

### ✅ Prueba 17: Verificar Eliminación

**Propósito**: Confirmar que el post fue eliminado

**Método**: `GET`  
**URL**: `http://localhost:8080/posts/3`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `404 Not Found`
- ✅ Mensaje: "Post no encontrado"

**Esto confirma que el DELETE funcionó correctamente.**

---

### ❌ Prueba 18: Eliminar Post que No Existe

**Método**: `DELETE`  
**URL**: `http://localhost:8080/posts/999`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `404 Not Found`
- ✅ Mensaje: "Post no encontrado"

---

### 📋 Prueba 19: Listar Posts Después de Eliminar

**Propósito**: Verificar estado final

**Método**: `GET`  
**URL**: `http://localhost:8080/posts`  
**Headers**: Ninguno necesario

**Resultado Esperado**:
- ✅ Código: `200 OK`
- ✅ Array con 2 posts (eliminamos el ID 3)
- ✅ Solo posts 1 y 2 presentes

---

## 📊 Resumen de Códigos de Estado

| Código | Nombre | Cuándo aparece |
|--------|--------|----------------|
| 200 | OK | GET, PUT, DELETE exitosos |
| 201 | Created | POST exitoso |
| 400 | Bad Request | Validación falla, datos inválidos |
| 404 | Not Found | Recurso no existe |

---

## 🎯 Checklist de Pruebas

Marca cada prueba al completarla:

- [ ] Crear 3 posts diferentes
- [ ] Listar todos los posts
- [ ] Obtener post específico (éxito)
- [ ] Obtener post inexistente (404)
- [ ] Actualizar post (éxito)
- [ ] Actualizar con datos inválidos (400)
- [ ] Buscar posts (éxito)
- [ ] Buscar sin término (400)
- [ ] Crear con datos inválidos (400)
- [ ] Eliminar post (éxito)
- [ ] Verificar eliminación (404)
- [ ] Eliminar post inexistente (404)

---

## 💡 Tips para Postman

### Crear una Colección
1. Click en "New Collection"
2. Nombrarla "Blog API - CI4"
3. Agregar todas las peticiones a la colección

### Usar Variables
Puedes crear una variable para la URL base:
1. En la colección, ir a "Variables"
2. Crear variable `base_url` = `http://localhost:8080`
3. Usar en peticiones: `{{base_url}}/posts`

### Guardar Respuestas
Postman permite guardar ejemplos de respuestas para documentación.

### Tests Automáticos
Puedes agregar scripts en la pestaña "Tests" para verificar automáticamente:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has data", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.data).to.exist;
});
```

---

## 📸 Capturas Recomendadas

Para tu documentación, toma capturas de:

1. **POST exitoso (201)**: Mostrando body y respuesta
2. **GET lista**: Array con múltiples posts
3. **GET específico (404)**: Error cuando no existe
4. **PUT exitoso**: Mostrando actualización
5. **Validación (400)**: Errores de validación claros
6. **DELETE exitoso**: Confirmación de eliminación
7. **Búsqueda**: Resultados filtrados

---

## 🔄 Reiniciar Base de Datos

Si quieres empezar de cero:

```bash
# Revertir migraciones
php spark migrate:rollback

# Volver a ejecutar
php spark migrate
```

Esto eliminará todos los posts y recreará la tabla vacía.

---

## ✅ Conclusión

Después de completar todas estas pruebas, habrás verificado:
- ✅ CRUD completo funciona
- ✅ Validación de datos
- ✅ Manejo de errores
- ✅ Búsqueda
- ✅ Códigos HTTP correctos
- ✅ Respuestas JSON consistentes

¡Tu API está lista para usar!
