# Sistema de Gestión de Productos con Precios en Múltiples Divisas

## Descripción
API RESTful desarrollada en Laravel para gestión de productos con precios en diferentes divisas.

## Características Principales
- ✅ CRUD completo de productos
- 💰 Soporte para múltiples divisas
- 🛡️ Autenticación JWT integrada
- 📚 Documentación scribe
- 📊 Pruebas E2E


## Requisitos
- PHP 8.1+
- Laravel 10+
- MySQL 8.0+
- Composer 2.0+

## Instalación
bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

## Estructura del Proyecto
app/
├── Http/
│   ├── Controllers/
│   │   ├── ProductController.php
│   │   └── ProductPriceController.php
├── Models/
│   ├── Product.php
│   └── ProductPrice.php
tests/
├── Feature/
│   ├── ProductApiEndToEndTest.php
│   └── ProductPriceApiEndToEndTest.php

## Endpoints Principales
## Productos
- GET /api/products - Listar todos los productos

- POST /api/products - Crear nuevo producto

- GET /api/products/{id} - Obtener producto específico

- PUT /api/products/{id} - Actualizar producto

- DELETE /api/products/{id} - Eliminar producto

## Precios de Productos
- GET /api/products/{id}/prices - Listar precios en diferentes divisas

- POST /api/products/{id}/prices - Agregar nuevo precio en divisa alternativa

## Pruebas
php artisan test

## Pruebas específicas
php artisan test --filter=ProductApiEndToEndTest

## Documentación API
## Acceder a la documentación interactiva:

http://localhost:8000/docs/

## Generar documentación:
php artisan scribe:generate
