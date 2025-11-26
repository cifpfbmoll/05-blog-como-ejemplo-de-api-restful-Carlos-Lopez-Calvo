#!/bin/bash

# Script de prueba rápida para la API del Blog
# Asegúrate de que el servidor esté corriendo: php spark serve

BASE_URL="http://localhost:8080"
echo "========================================="
echo "  Pruebas de API RESTful - Blog CI4"
echo "========================================="
echo ""

# Colores para output
GREEN='\033[0;32m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}1. Creando primer post...${NC}"
curl -X POST "$BASE_URL/posts" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Mi Primer Post en CI4",
    "content": "Este es el contenido de mi primer post usando CodeIgniter 4 y SQLite.",
    "category": "Desarrollo",
    "tags": ["php", "codeigniter", "api"]
  }' \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}2. Creando segundo post...${NC}"
curl -X POST "$BASE_URL/posts" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Introducción a SQLite",
    "content": "SQLite es una base de datos ligera y perfecta para desarrollo.",
    "category": "Bases de Datos",
    "tags": ["sqlite", "database"]
  }' \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}3. Listando todos los posts...${NC}"
curl -X GET "$BASE_URL/posts" \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}4. Obteniendo post específico (ID: 1)...${NC}"
curl -X GET "$BASE_URL/posts/1" \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}5. Intentando obtener post inexistente (ID: 999)...${NC}"
curl -X GET "$BASE_URL/posts/999" \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}6. Actualizando post (ID: 1)...${NC}"
curl -X PUT "$BASE_URL/posts/1" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Mi Primer Post ACTUALIZADO"
  }' \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}7. Buscando posts con término 'ci4'...${NC}"
curl -X GET "$BASE_URL/posts/search?term=ci4" \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}8. Intentando crear post con datos inválidos...${NC}"
curl -X POST "$BASE_URL/posts" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Cor",
    "content": "Muy"
  }' \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}9. Eliminando post (ID: 2)...${NC}"
curl -X DELETE "$BASE_URL/posts/2" \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo -e "${BLUE}10. Verificando que el post fue eliminado...${NC}"
curl -X GET "$BASE_URL/posts/2" \
  -w "\nCódigo HTTP: %{http_code}\n\n"

echo ""
echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}  Pruebas completadas${NC}"
echo -e "${GREEN}=========================================${NC}"
echo ""
echo "Para ver los resultados formateados, instala 'jq':"
echo "  sudo apt-get install jq"
echo ""
echo "Luego ejecuta:"
echo "  curl http://localhost:8080/posts | jq"
