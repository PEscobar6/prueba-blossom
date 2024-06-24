# Rick and Morty API

Este proyecto es una API RESTful para la gestión de personajes y episodios de la serie Rick and Morty, desarrollada con Laravel y MySQL.

## Requisitos

- Docker
- Docker Compose
- PHP >= 8.2
- Composer

## Instalación

1. Clona el repositorio:

   ```bash
   git clone https://github.com/tu-usuario/rick-and-morty-api.git
   cd rick-and-morty-api

2. Crea el archivo .env en la raíz del proyecto y copia el contenido del archivo .env.example. Asegúrate de configurar las variables de entorno adecuadamente:
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:WKBAWe+K09EgOPAy3aPaD+xrknW1Tr35wfAGKfXrAxw=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=rickandmorty
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

JWT_SECRET=3QcDwXqZQi8NHQlUK9VWAO3eCYH1P5qAhX7PsJGZvqBDWltugJbL2R3JckO5Prqd
```

3. Construye y ejecuta los contenedores de Docker:
La configuracion docker por defecto está con [Laravel Sail](https://laravel.com/docs/11.x/sail) pero se puede construir con Docker Compose
```sail | ./vendor/bin/sail up -d```
```docker-compose up --build```

4. Una vez que los contenedores estén en funcionamiento, abre una nueva terminal y ejecuta las migraciones para preparar la base de datos:
bash
```
./vendor/bin/sail artisan migrate --seed
ó
ocker-compose exec app php artisan migrate --seed
```
Esto construira la base de datos y creara el usuario pre-configurado admin. (admin@blossom.com, blossom2024)

5. Ejecuta la importacion de personajes y episodios
```
./vendor/bin/sail artisan import:rickandmorty
ó
docker-compose exec app php artisan import:rickandmorty
```

6. Para terminar la ejecución
```
./vendor/bin/sail down
ó
docker-compose down
```


## Uso
La aplicación estará disponible en `http://localhost:80`.

## Endpoints Disponibles

### Health Check

- `GET /api/v1/health` - Healtch Check Server Status

### Login

- `POST /api/v1/login` - Login para usuarios (usuario por defecto: email=admin@blossom.com password=blossom2024) 


### Usuarios

- `GET /api/v1/users` - Listar todos los usuarios
- `GET /api/v1/users/{id}` - Obtener un usuario por ID
- `POST /api/v1/users` - Crear un nuevo usuario
- `PUT /api/v1/users/{id}` - Actualizar un usuario
- `PATCH /api/v1/users/{id}` - Actualización parcial de un usuario
- `DELETE /api/v1/users/{id}` - Eliminar un usuario

### Episodios

- `GET /api/v1/episodes` - Listar todos los episodios
- `GET /api/v1/episodes/{id}` - Obtener un episodio por ID
- `POST /api/v1/episodes` - Crear un nuevo episodio
- `PUT /api/v1/episodes/{id}` - Actualizar un episodio
- `PATCH /api/v1/episodes/{id}` - Actualización parcial de un episodio
- `DELETE /api/v1/episodes/{id}` - Eliminar un episodio

### Personajes

- `GET /api/v1/characters` - Listar todos los personajes
- `GET /api/v1/characters/{id}` - Obtener un personaje por ID y los episodios en los que aparece
- `POST /api/v1/characters` - Crear un nuevo personaje
- `PUT /api/v1/characters/{id}` - Actualizar un personaje
- `PATCH /api/v1/characters/{id}` - Actualización parcial de un personaje
- `DELETE /api/v1/characters/{id}` - Eliminar un personaje

### Asignar personajes a episodios

- `POST /api/v1/episodes/{episodeId}/characters` - Asignar personajes a un episodio

## Notas

- Asegúrate de que Docker y Docker Compose estén instalados en tu sistema.
- Si encuentras problemas de conexión a la base de datos, asegúrate de que el servicio MySQL esté en funcionamiento y accesible desde el contenedor de la aplicación.
- Puedes verificar el estado de los contenedores con el comando `docker-compose ps`.
- Para SO Windows se debe usar `./vendor/bin/sail` bajo el subsistema de linux en Windows (WSL)

## Contribución

Si deseas contribuir a este proyecto, por favor crea un fork del repositorio y envía un pull request con tus cambios.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Para más detalles, revisa el archivo [LICENSE](LICENSE).
