<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Galvez test

Test es una aplicación par comprobar conocimientos y habilidades de integración de varias tecnologías
La instalación de la aplicacion requrirá de unos solos pocos pasos para su uso
- Clonar el repositorio git@github.com:jmleal2010/galvez-test.git o https://github.com/jmleal2010/galvez-test de dominio publico
- Ejecutar composer install para instalar las dependencias 'vendors' de Laravel "composer install"
- Instalar las dependencias de javascript con cualquier paquete de instalador de dependencias (yarn o npm), se utilizó npm "npm install"
- El proximo paso será configurar nuestro archivo de variables de entorno .env en la cual estableceremos el nombre de la aplicacion, entorno, key, debug, url de la app y los parametros de la base de datos
- Una vez configurados los parametros de la base de datos, corremos las migraciones con el parametro --seed para cargar datos de ejemplo


## Lista de comandos
1. git clone https://github.com/jmleal2010/galvez-test [nombreProyecto]
2. composer install
3. npm run install
4. php artisan migrate:fresh --seed
5. php artisan serve
6. npm run dev
## Importante

Recordar que hay que configurar las variables de entorno, una vez configuradas en nuestro archivo .env
ejecutaremos el comando
1. php artisan key:generate
### Variables necesarias

- **APP_NAME**
- **APP_URL**
- **APP_KEY**
- **APP_ENV**
- **DB_CONNECTION**
- **DB_HOST**
- **DB_PORT**
- **DB_DATABASE**
- **DB_USERNAME**
- **DB_PASSWORD**

### Requisitos
1. PHP en >8.1
2. Tipo de conector a base de datos "mysql x defecto"
