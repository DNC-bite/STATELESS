<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



# STATELESS — Proyecto Académico SENA ADSO

Marca ficticia de ropa urbana colombiana desarrollada como proyecto de clase en SENA (Análisis y Desarrollo de Software). No es una marca real.

---

## Stack Tecnológico

- **Backend:** Laravel 12 / PHP 8.2
- **Base de datos:** MySQL
- **Frontend:** Blade + Bootstrap 5 + CSS personalizado
- **Pagos:** Stripe (modo test) + métodos colombianos simulados (Nequi, PSE, Efecty)
- **PDF:** barryvdh/laravel-dompdf
- **Servidor local:** XAMPP (PHP 8.2 en `C:\xampp82\php\php.exe`)

---

## Comandos importantes

```bash
# Levantar servidor
C:\xampp82\php\php.exe artisan serve
C:\xampp\php\php.exe artisan serve

# Instalar dependencias
C:\xampp82\php\php.exe C:\xampp82\php\composer require [paquete]

# Migraciones
C:\xampp82\php\php.exe artisan migrate
C:\xampp82\php\php.exe artisan migrate:fresh --seed

# Limpiar caché
C:\xampp82\php\php.exe artisan config:clear
C:\xampp82\php\php.exe artisan cache:clear
```

---

## Base de datos

- **Nombre:** `stateless`
- **Motor:** MySQL vía XAMPP
- **OJO:** El `.env` debe tener `DB_CONNECTION=mysql` y `DB_DATABASE=stateless`. Si dice `sqlite` hay que corregirlo.

---

## Roles

| Rol | Acceso |
|-----|--------|
| `admin` | Panel completo — ventas, usuarios, inventario, productos, categorías, proveedores, envíos |
| `empleado` | Panel limitado — ventas, inventario, envíos, proveedores |
| `cliente` | Tienda pública, carrito, checkout |

**Credenciales de prueba:**
- Email: `admin@example.com`
- Contraseña: `password`

---

## Estructura de rutas

| Ruta | Descripción |
|------|-------------|
| `/` | Página de inicio (tienda pública) |
| `/login` | Inicio de sesión |
| `/register` | Registro de clientes |
| `/account` | Mi Cuenta (hub por rol) |
| `/carrito` | Carrito de compras |
| `/checkout` | Checkout con Stripe |
| `/checkout/pse/{venta}` | Portal PSE simulado |
| `/checkout/factura/{venta}` | Factura electrónica |
| `/admin/categorias` | CRUD categorías |
| `/admin/productos` | CRUD productos |
| `/admin/proveedores` | CRUD proveedores |
| `/admin/ventas` | CRUD ventas |
| `/admin/envios` | CRUD envíos |
| `/admin/usuarios` | CRUD usuarios |
| `/empleado/ventas` | Ventas (empleado) |
| `/empleado/inventarios` | Inventario (empleado) |
| `/empleado/envios` | Envíos (empleado) |
| `/empleado/proveedores` | Proveedores (empleado) |

---

## Modelos y relaciones

- `User` → belongsTo `Role`
- `Role` → hasMany `User`
- `Producto` → belongsTo `Categoria`, belongsTo `Proveedor`, hasMany `ProductoImagen`
- `Carrito` → belongsTo `User`, hasMany `CarritoItem`
- `CarritoItem` → belongsTo `Carrito`, belongsTo `Producto`
- `Venta` → belongsTo `User`, hasOne `Envio`
- `Envio` → belongsTo `Venta`

---

## Módulos implementados

### Tienda pública
- Hero carrusel (3 slides con autoplay)
- Sección Essentials con carrusel de productos
- Carrito persistente en BD con AJAX
- Contador de carrito en navbar en tiempo real
- Detalle de producto con carrusel de imágenes múltiples

### Checkout
- Stripe (tarjeta débito/crédito en modo test)
- Nequi simulado
- PSE simulado con portal bancario falso
- Efecty simulado con código de pago generado
- Generación de factura electrónica PDF descargable
- Descuento automático de stock al confirmar pedido

### Panel Admin
- Dashboard con acceso por rol
- CRUD completo: Categorías, Proveedores, Productos, Ventas, Envíos, Usuarios
- Filtros en productos: Todos, Stock Bajo, Sin Stock, Activos, Inactivos
- Imágenes de productos desde `public/images/`

### Panel Empleado
- Ventas, Inventario, Envíos, Proveedores
- Sidebar dinámico según rol

---

## Imágenes de productos

Las imágenes se guardan en `public/images/`. En el panel admin se escribe el nombre del archivo (ej. `camiseta-negra.jpg`). Así funcionan en GitHub sin problemas.

---

## Variables de entorno importantes (.env)

```env
DB_CONNECTION=mysql
DB_DATABASE=stateless
DB_USERNAME=root
DB_PASSWORD=

STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
```

---

## Rama de desarrollo

- Rama principal: `santi-feature`
- Convención de commits: `tipo(alcance): descripción`

---

## Notas importantes

- Laravel pluraliza en inglés — modelos con nombres en español necesitan `protected $table = 'nombre_tabla'` (ej. `Proveedor` → `proveedores`, `ProductoImagen` → `producto_imagenes`)
- El middleware de roles está en `app/Http/Middleware/RoleMiddleware.php` y se registra en `bootstrap/app.php`
- En Laravel 12 no existe `Kernel.php` — el middleware se registra con `$middleware->alias()` en `bootstrap/app.php`