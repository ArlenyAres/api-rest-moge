
![logo moge](https://github.com/01joanna/codecrafters-app/assets/122264533/35568a99-cf77-451e-93be-58dd18672ac5)


#  API REST de Moge: 
Portal de Eventos Tecnológicos

## Descripción
Moge es una plataforma web dedicada a conectar a entusiastas de la tecnología con una amplia gama de eventos y oportunidades de aprendizaje. Nuestro objetivo es mantener a nuestra comunidad al día con las últimas tendencias y avances en el campo de la tecnología, ofreciendo una selección cuidadosa de eventos diseñados y creados por los integrantes de la comunidad


## Introducción
Este proyecto es el backend de la plataforma web de Moge, diseñada para facilitar la organización de eventos tecnológicos. El backend se construye utilizando PHP con el framework Laravel, proporcionando una API RESTful que interactúa con una base de datos MySQL.

#### 📝 Requisitos
PHP 7.4 o superior
Composer
MySQL 5.7 o superior

#### 🛠️ Configuración
Clonar el repositorio: 
Clona este repositorio en tu máquina local.

git clone (https://github.com/ArlenyAres/api-rest.git)

#### :small_red_triangle: Instalar dependencias: Navega al directorio del proyecto y ejecuta el siguiente comando para instalar las dependencias de PHP.
composer install

#### :small_red_triangle:  Configurar la base de datos: 
Crea una base de datos MySQL y configura las credenciales en el archivo .env.

DB_CONNECTION=mysql

DB_HOST=localhost

DB_PORT=3306

DB_DATABASE=api-rest

DB_USERNAME=tu_usuario

DB_PASSWORD=tu_contraseña

#### :small_red_triangle: Migraciones y Seeders: 

Ejecuta las migraciones y seeders para crear las tablas y datos iniciales en la base de datos.

php artisan migrate
php artisan db:seed

#### :small_red_triangle: Generar APP_KEY: Genera una clave de aplicación para Laravel.

php artisan key:generate

#### :small_red_triangle: Ejecutar el servidor: Inicia el servidor de desarrollo de Laravel.

php artisan serve


### :lock: La API REST de Moge se basa en Laravel y utiliza Laravel Sanctum para la autenticación, APIs basadas en tokens simples

#### La API REST de Mogue utiliza Laravel y Sanctum para proporcionar una autenticación segura y eficiente. 
Al utilizar Sanctum, se simplifica el proceso de autenticación y se mantiene una alta seguridad, permitiendo a los usuarios acceder a recursos protegidos de manera controlada y segura.

#### :closed_lock_with_key: Middleware de Sanctum:
Se añade el middleware de Sanctum al archivo kernel.php para asegurar que las solicitudes a la API estén protegidas y sean autenticadas correctamente.
Uso de Traits: En el modelo User, se utiliza el trait HasApiTokens de Sanctum para habilitar la generación de tokens de API para los usuarios.

#### :closed_lock_with_key: Controladores y Rutas
Controladores de API: Se definen controladores de API para manejar las operaciones de registro y login. Estos controladores utilizan Sanctum para autenticar a los usuarios y generar tokens de acceso. Los tokens generados se envían en la respuesta para que el cliente pueda utilizarlos en solicitudes subsiguientes.
Rutas de API: Se definen rutas específicas para las operaciones de registro y login, asegurando que estas rutas estén protegidas por Sanctum y solo sean accesibles a través de solicitudes autenticadas.

#### :closed_lock_with_key: Seguridad y Autorización
Protección de Rutas: Las rutas de la API están protegidas por Sanctum, lo que garantiza que solo los usuarios autenticados puedan acceder a los recursos protegidos. Esto se logra mediante el uso de middleware que verifica la autenticidad del token de acceso proporcionado en las solicitudes.
Gestión de Tokens: Sanctum permite revocar tokens de acceso, proporcionando una forma segura de manejar la autenticación y autorización en la API.





####  🔧 Pruebas
Para ejecutar las pruebas unitarias y de integración, utiliza el siguiente comando:

php artisan test

## :atom: Desarolladoras
Arleny Medina
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/arleny-medina-prince)


Johanna Cuevas
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/jokume/)


## :dart: Cómo Contribuir
Si estás interesado en contribuir a este proyecto, hay varias formas de hacerlo:

Comparte este proyecto: Ayuda a difundir el conocimiento compartiendo MOGE con otros entusiastas de la tecnología.
Contribuciones de Código: Si tienes habilidades de programación, puedes contribuir directamente al código del proyecto.
Reporta problemas o propón mejoras: Si encuentras algún problema o tienes una idea para mejorar Explore, no dudes en abrir un nuevo problema o contribuir con un Pull Request.


![logo moge](https://github.com/01joanna/codecrafters-app/assets/122264533/35568a99-cf77-451e-93be-58dd18672ac5)












<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

