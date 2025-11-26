# 📥 Cómo Importar la Colección de Postman

## 🎯 Archivo de Colección

**Archivo**: `Blog_API_Postman_Collection.json`

Esta colección incluye:
- ✅ 17 pruebas completas
- ✅ Tests automáticos para cada petición
- ✅ Variables de colección configuradas
- ✅ Organización por categorías
- ✅ Descripciones detalladas

---

## 📥 Pasos para Importar

### 1. Abrir Postman

Si no tienes Postman instalado:
- Descarga desde: https://www.postman.com/downloads/
- Instala y abre la aplicación

### 2. Importar la Colección

**Opción A: Arrastrar y Soltar**
1. Abre Postman
2. Arrastra el archivo `Blog_API_Postman_Collection.json` a la ventana de Postman
3. ¡Listo!

**Opción B: Botón Import**
1. Abre Postman
2. Click en el botón **"Import"** (esquina superior izquierda)
3. Click en **"Upload Files"**
4. Selecciona `Blog_API_Postman_Collection.json`
5. Click en **"Import"**

### 3. Verificar la Importación

Deberías ver en el panel izquierdo:
```
📁 Collections
  └─ 📁 Blog API - CodeIgniter 4
      ├─ 📁 Posts (10 peticiones)
      ├─ 📁 Búsqueda (4 peticiones)
      └─ 📁 Eliminación (3 peticiones)
```

---

## ⚙️ Configuración

### Variables de Colección

La colección incluye 2 variables pre-configuradas:

| Variable | Valor | Descripción |
|----------|-------|-------------|
| `base_url` | `http://localhost:8080` | URL base de la API |
| `post_id` | `1` | ID del post (se actualiza automáticamente) |

**Para ver/editar variables:**
1. Click derecho en la colección "Blog API - CodeIgniter 4"
2. Selecciona **"Edit"**
3. Ve a la pestaña **"Variables"**

### Cambiar el Puerto

Si tu servidor corre en otro puerto:
1. Edita la variable `base_url`
2. Cambia a tu puerto (ej: `http://localhost:3000`)
3. Guarda

---

## 🚀 Ejecutar las Pruebas

### Antes de Empezar

**¡IMPORTANTE!** Asegúrate de que el servidor esté corriendo:
```bash
php spark serve
```

### Ejecutar una Prueba Individual

1. Expande la carpeta **"Posts"**
2. Click en **"1. Crear Primer Post"**
3. Click en el botón azul **"Send"**
4. Verifica la respuesta

### Ejecutar Toda la Colección

**Opción 1: Runner**
1. Click derecho en "Blog API - CodeIgniter 4"
2. Selecciona **"Run collection"**
3. Click en **"Run Blog API - CodeIgniter 4"**
4. Observa los resultados

**Opción 2: Secuencial Manual**
Ejecuta las pruebas en orden:
1. Posts → 1, 2, 3 (crear posts)
2. Posts → 4 (listar)
3. Posts → 5, 6 (obtener)
4. Posts → 7, 8, 9 (actualizar)
5. Posts → 10 (validación)
6. Búsqueda → 11, 12, 13, 14
7. Eliminación → 15, 16, 17

---

## ✅ Tests Automáticos

Cada petición incluye tests automáticos que se ejecutan después de recibir la respuesta.

### Ver Resultados de Tests

Después de enviar una petición:
1. Mira la pestaña **"Test Results"** (abajo)
2. Verás algo como:
   ```
   ✓ Status code is 201
   ✓ Response has data
   ✓ Post created successfully
   ```

### Ejemplo de Test Incluido

```javascript
pm.test("Status code is 201", function () {
    pm.response.to.have.status(201);
});

pm.test("Response has data", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.data).to.exist;
});
```

---

## 📋 Estructura de la Colección

### 1. Posts (10 pruebas)

| # | Nombre | Método | Propósito |
|---|--------|--------|-----------|
| 1 | Crear Primer Post | POST | Crear post y guardar ID |
| 2 | Crear Segundo Post | POST | Más datos de prueba |
| 3 | Crear Tercer Post | POST | Más datos de prueba |
| 4 | Listar Todos los Posts | GET | Ver todos los posts |
| 5 | Obtener Post Específico | GET | Ver un post por ID |
| 6 | Obtener Post Inexistente | GET | Probar error 404 |
| 7 | Actualizar Post | PUT | Actualizar post completo |
| 8 | Actualizar Solo un Campo | PUT | Actualización parcial |
| 9 | Actualizar con Datos Inválidos | PUT | Probar validación |
| 10 | Crear Post con Datos Inválidos | POST | Probar validación |

### 2. Búsqueda (4 pruebas)

| # | Nombre | Método | Propósito |
|---|--------|--------|-----------|
| 11 | Buscar Posts | GET | Búsqueda exitosa |
| 12 | Buscar por Categoría | GET | Búsqueda por categoría |
| 13 | Búsqueda Sin Resultados | GET | Array vacío |
| 14 | Búsqueda Sin Término | GET | Error 400 |

### 3. Eliminación (3 pruebas)

| # | Nombre | Método | Propósito |
|---|--------|--------|-----------|
| 15 | Eliminar Post | DELETE | Eliminar exitosamente |
| 16 | Verificar Post Eliminado | GET | Confirmar 404 |
| 17 | Eliminar Post Inexistente | DELETE | Error 404 |

---

## 🎯 Orden Recomendado de Ejecución

### Primera Vez (Base de Datos Vacía)

1. **Crear datos** (1-3)
2. **Listar** (4)
3. **Obtener** (5-6)
4. **Actualizar** (7-9)
5. **Buscar** (11-14)
6. **Validación** (10)
7. **Eliminar** (15-17)

### Pruebas Repetidas

Si ya tienes datos:
- Puedes ejecutar las pruebas en cualquier orden
- La prueba #1 guarda automáticamente el `post_id`
- Ajusta los IDs manualmente si es necesario

---

## 🔧 Personalización

### Modificar una Petición

1. Click en la petición que quieres modificar
2. Edita:
   - URL
   - Headers
   - Body
   - Tests
3. Click **"Save"**

### Agregar Nueva Petición

1. Click derecho en una carpeta (ej: "Posts")
2. Selecciona **"Add Request"**
3. Configura la petición
4. Guarda

### Duplicar Petición

1. Click derecho en una petición
2. Selecciona **"Duplicate"**
3. Modifica la copia

---

## 📊 Interpretar Resultados

### Códigos de Estado Esperados

| Código | Significado | Cuándo |
|--------|-------------|--------|
| 200 | OK | GET, PUT, DELETE exitosos |
| 201 | Created | POST exitoso |
| 400 | Bad Request | Validación falla |
| 404 | Not Found | Recurso no existe |

### Estructura de Respuesta Exitosa

```json
{
    "status": 200,
    "error": null,
    "messages": {
        "success": "Mensaje de éxito"
    },
    "data": {
        // Datos del post
    }
}
```

### Estructura de Respuesta de Error

```json
{
    "status": 400,
    "error": "Bad Request",
    "messages": {
        "error": {
            "title": "El campo title es requerido.",
            "content": "El campo content debe tener al menos 10 caracteres."
        }
    }
}
```

---

## 🐛 Troubleshooting

### Error: "Could not get response"

**Causa**: El servidor no está corriendo

**Solución**:
```bash
php spark serve
```

### Error: "Error: connect ECONNREFUSED"

**Causa**: Puerto incorrecto o servidor no disponible

**Solución**:
1. Verifica que el servidor esté corriendo
2. Verifica la variable `base_url`
3. Verifica el puerto en el comando `php spark serve`

### Tests Fallan

**Causa**: Datos no coinciden con lo esperado

**Solución**:
1. Lee el mensaje de error del test
2. Verifica la respuesta en la pestaña "Body"
3. Ajusta el test o los datos según sea necesario

### Post ID no se guarda automáticamente

**Causa**: La primera prueba no se ejecutó

**Solución**:
1. Ejecuta la prueba #1 "Crear Primer Post"
2. Verifica en Variables que `post_id` tenga un valor
3. O edita manualmente la variable `post_id`

---

## 💡 Tips y Trucos

### 1. Usar el Runner para Pruebas Completas

El Runner ejecuta todas las pruebas en secuencia y muestra un resumen:
- Total de pruebas
- Pruebas pasadas
- Pruebas fallidas
- Tiempo de ejecución

### 2. Guardar Respuestas como Ejemplos

1. Después de enviar una petición exitosa
2. Click en **"Save Response"**
3. Nombra el ejemplo
4. Ahora puedes ver ejemplos sin ejecutar

### 3. Usar Environments

Para múltiples entornos (desarrollo, producción):
1. Click en el icono de ojo (esquina superior derecha)
2. Click en **"Add"** junto a Environments
3. Crea variables para cada entorno
4. Cambia entre entornos fácilmente

### 4. Exportar Resultados

Después de ejecutar en el Runner:
1. Click en **"Export Results"**
2. Guarda el archivo JSON
3. Comparte con tu equipo

### 5. Documentación Automática

Postman puede generar documentación:
1. Click derecho en la colección
2. Selecciona **"View Documentation"**
3. Click en **"Publish"** para compartir

---

## 📝 Notas Importantes

1. **Orden de Ejecución**: Algunas pruebas dependen de otras (ej: actualizar requiere que exista un post)

2. **Variables Automáticas**: La prueba #1 guarda automáticamente el `post_id` para usar en otras pruebas

3. **Base de Datos**: Las pruebas modifican la base de datos real. Para resetear:
   ```bash
   php spark migrate:rollback
   php spark migrate
   ```

4. **Tests Automáticos**: Todos los tests están incluidos y se ejecutan automáticamente

5. **Personalización**: Puedes modificar cualquier petición según tus necesidades

---

## 🎓 Recursos Adicionales

- **Postman Learning Center**: https://learning.postman.com/
- **Postman API**: https://www.postman.com/postman/workspace/postman-public-workspace/
- **Documentación del Proyecto**: Ver `POSTMAN_TESTS.md` para guía detallada

---

## ✅ Checklist de Importación

- [ ] Postman instalado
- [ ] Archivo JSON importado
- [ ] Colección visible en Postman
- [ ] Variables configuradas
- [ ] Servidor corriendo (`php spark serve`)
- [ ] Primera prueba ejecutada exitosamente
- [ ] Tests automáticos funcionando

---

## 🎉 ¡Listo para Usar!

Una vez importada la colección, puedes:
- ✅ Ejecutar pruebas individuales
- ✅ Ejecutar toda la colección con el Runner
- ✅ Ver tests automáticos
- ✅ Modificar peticiones
- ✅ Agregar nuevas pruebas
- ✅ Compartir con tu equipo

---

**Archivo de Colección**: `Blog_API_Postman_Collection.json`  
**Versión**: 1.0.0  
**Última Actualización**: 5 de Noviembre, 2025

¡Disfruta probando tu API! 🚀
