# Actividades Complementarias (Release Demo ITICS v1.0)

Repositorio para el proyecto del módulo de gestión de actividades complementarias para el SGE.
Esta rama es la implementacion para su uso en el departamaneto de ITICS para su uso. Tiene modificaciones especiales.

# Modificaciones

Estas modificaciones se crearon por que el sistema estara aparte del SGE y por cuestiones del servidor gratituo<br>

-   Seed para actividades complementarias (Solo pose las actividades complementarias de ITICS)
-   Nueva forma de cerrar un expediente (Se pide una URL donde se encuentre el expediente devez de subirlo al servidor)
-   Seed usuarios (Ususarios para ITICS)
-   Modulo para administrar usuarios para mostrar su contraseña de default y restaurar la misma
-   Se implementara en un servidor

# Instalacion Local

-   Instalar PostgreSQL
-   Instalar PHP v7.4.9
-   Instalar Composer
-   Intalar las extenciones de php para postgresql (pdo_pgsql)
-   Clonar o descargar la rama
-   Configurar el .env de la raiz del proyecto con la configuracion de la base de datos (copiar .env.example)
    -   Ejemplo:
        -   DB_CONNECTION=pgsql
        -   DB_HOST=localhost
        -   DB_PORT=5432
        -   DB_DATABASE=(nombre_base_datos)
        -   DB_USERNAME=postgres
        -   DB_PASSWORD=(contraseña_root/postgres)
-   Abrir una terminal en la raiz
    -   composer install
    -   php artisan migrate --seed
    -   php artisan key:generate
    -   php artisan storage:link
    -   php artisan serve
-   Abrir un navegador en el http://127.0.0.1:8000/

# Servidor Demo

https://itm-actcom-itics.herokuapp.com/login<br>
El servidor demo para su implementacion en el departamento de ITICS es Free por lo que tiene ciertas limitaciones:

-   Duerme después de 30 minutos de inactividad, de lo contrario, siempre en función de las horas de dinamómetro libres mensuales restantes (550-1000 horas de dinamómetro al mes).
-   0 of 20 conecciones a la BD
-   10,000 rows en la BD

# Deploy

https://www.youtube.com/watch?v=GE2Kmy8WL3g
