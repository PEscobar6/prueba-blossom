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

3. Instalar dependencias del proyecto
```composer install```

4. Construye y ejecuta los contenedores de Docker:
La configuracion docker por defecto está con [Laravel Sail](https://laravel.com/docs/11.x/sail)
```sail | ./vendor/bin/sail up -d```

5. Una vez que los contenedores estén en funcionamiento, abre una nueva terminal y ejecuta las migraciones para preparar la base de datos:
bash
```
./vendor/bin/sail artisan migrate --seed
```
Esto construira la base de datos y creara el usuario pre-configurado admin. _(admin@blossom.com, blossom2024)_
Si no funciona, ejecuta primero
```
./vendor/bin/sail artisan migrate
```
Y luego
```
./vendor/bin/sail artisan migrate --seed
```

6. Ejecuta la importacion de personajes y episodios
```
./vendor/bin/sail artisan import:rickandmorty
```

7. Para terminar la ejecución
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
*Este Endpoint es vital para el uso de los demás endpoints, ya que es el que nos genera el jwt token para auntenticarnos con el sistema.*

**Request Body:**
  ```json
  {
      "email": "admin@blossom.com",
      "password": "blossom2024"
  }
```

**Response:**
  ```json
  {
    "message": "Login successful",
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "expires_in": 3600,
        "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@blossom.com",
            ...
        }
    },
    "status": 200
}
```


### Usuarios (Protected)

- `GET /api/v1/users` - Listar todos los usuarios

**Response:**
```json
   {
      "message": "Login successful",
      "data": {
         "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
         "expires_in": 3600,
         "user": {
            "id": 1,
            "name": "Admin",
            "email": "admin@blossom.com",
         }
      },
      "status": 200
   }
```

- `GET /api/v1/users/{id}` - Obtener un usuario por ID

**Response:**
```json
   {
    "message": "User found",
    "data": {
        "id": 1,
        "name": "Admin",
        "email": "admin@blossom.com",
        ...
    },
    "status": 200
}
```
- `POST /api/v1/users` - Crear un nuevo usuario

**Request Body:**
```json
   {
      "name": "New User",
      "email": "newuser@example.com",
      "password": "password"
   }
```
**Response:**
```json
   {
      "message": "User created successfully",
      "data": {
         "id": 2,
         "name": "New User",
         "email": "newuser@example.com",
         ...
      },
      "status": 201
   }
```
- `PUT /api/v1/users/{id}` - Actualizar un usuario

**Request Body:**
```json
   {
      "name": "Updated User",
      "email": "updateduser@example.com"
   }
```
**Response:**
```json
   {
      "message": "User updated successfully",
      "data": {
         "id": 2,
         "name": "Updated User",
         "email": "updateduser@example.com",
         ...
      },
      "status": 200
   }
```
- `PATCH /api/v1/users/{id}` - Actualización parcial de un usuario

**Request Body:**
```json
   {
      "email": "partiallyupdateduser@example.com"
   }
```
**Response:**
```json
   {
   "message": "User updated successfully",
   "data": {
      "id": 2,
      "name": "Updated User",
      "email": "partiallyupdateduser@example.com",
      ...
   },
   "status": 200
   }
```
- `DELETE /api/v1/users/{id}` - Eliminar un usuario

**Response:**
```json
   {
      "message": "User deleted successfully",
      "status": 200
   }
```

### Episodios (Protected)

- `GET /api/v1/episodes` - Listar todos los episodios

**Response:**
```json
   {
      "message": "Episodes found",
      "data": [
         {
            "id": 1,
            "name": "Pilot",
            "air_date": "2013-12-02",
            "episode": "S01E01",
            ...
         }
      ],
      "status": 200
   }
```
- `GET /api/v1/episodes/{id}` - Obtener un episodio por ID

**Response:**
```json
   {
      "message": "Episode found",
      "data": {
         "id": 1,
         "name": "Pilot",
         "air_date": "2013-12-02",
         "episode": "S01E01",
         ...
      },
      "status": 200
   }
```
- `POST /api/v1/episodes` - Crear un nuevo episodio

**Request Body:**
```json
   {
      "name": "New Episode",
      "air_date": "2024-01-01",
      "episode": "S01E02",
      "url": "http://example.com/new-episode"
   }
```
**Response:**
```json
   {
      "message": "Episode created successfully",
      "status": 201
   }
```
- `PUT /api/v1/episodes/{id}` - Actualizar un episodio

**Request Body:**
```json
   {
      "name": "Updated Episode",
      "air_date": "2024-01-02",
      "episode": "S01E03",
      "url": "http://example.com/updated-episode"
   }
```
**Response:**
```json
   {
      "message": "Episode updated successfully",
      "data": {
         "id": 1,
         "name": "Updated Episode",
         "air_date": "2024-01-02",
         "episode": "S01E03",
         ...
      },
      "status": 200
   }
```
- `PATCH /api/v1/episodes/{id}` - Actualización parcial de un episodio

**Request Body:**
```json
   {
      "air_date": "2024-01-02"
   }
```
**Response:**
```json
   {
      "message": "Episode updated successfully",
      "data": {
         "id": 1,
         "name": "Updated Episode",
         "air_date": "2024-01-02",
         "episode": "S01E03",
         ...
      },
      "status": 200
   }
```
- `DELETE /api/v1/episodes/{id}` - Eliminar un episodio

**Response:**
```json
   {
      "message": "Episode deleted successfully",
      "status": 200
   }
```

### Personajes (Protected)

- `GET /api/v1/characters` - Listar todos los personajes

**Response:**
```json
   {
      "message": "Characters found",
      "data": [
         {
            "id": 1,
            "name": "Rick Sanchez",
            "status": "Alive",
            "species": "Human",
            "type": "",
            "gender": "Male",
            "origin": {
                  "name": "Earth (C-137)",
                  "url": "https://rickandmortyapi.com/api/location/1"
            },
            "location": {
                  "name": "Citadel of Ricks",
                  "url": "https://rickandmortyapi.com/api/location/3"
            },
            "image": "https://rickandmortyapi.com/api/character/avatar/1.jpeg",
            "url": "https://rickandmortyapi.com/api/character/1",
            ...
         }
      ],
      "status": 200
   }
```
- `GET /api/v1/characters/{id}` - Obtener un personaje por ID y los episodios en los que aparece

**Response:**
```json
   {
      "message": "Character found",
      "data": {
         "id": 1,
         "name": "Rick Sanchez",
         "status": "Alive",
         "species": "Human",
         "type": "",
         "gender": "Male",
         "origin": {
               "name": "Earth (C-137)",
               "url": "https://rickandmortyapi.com/api/location/1"
         },
         "location": {
               "name": "Citadel of Ricks",
               "url": "https://rickandmortyapi.com/api/location/3"
         },
         "image": "https://rickandmortyapi.com/api/character/avatar/1.jpeg",
         "url": "https://rickandmortyapi.com/api/character/1",
         "episodes": [
               {
                  "id": 1,
                  "name": "Pilot",
                  "air_date": "2013-12-02",
                  "episode": "S01E01",
                  ...
               }
         ]
      },
      "status": 200
   }
```
- `POST /api/v1/characters` - Crear un nuevo personaje

**Request Body:**
```json
   {
      "name": "Morty Smith",
      "status": "Alive",
      "species": "Human",
      "type": "",
      "gender": "Male",
      "origin": {
         "name": "unknown",
         "url": ""
      },
      "location": {
         "name": "Citadel of Ricks",
         "url": "https://rickandmortyapi.com/api/location/3"
      },
      "image": "https://rickandmortyapi.com/api/character/avatar/2.jpeg",
      "url": "https://rickandmortyapi.com/api/character/2"
   }
```
**Response:**
```json
   {
      "message": "Character created successfully",
      "status": 201
   }
```
- `PUT /api/v1/characters/{id}` - Actualizar un personaje

**Request Body:**
```json
   {
      "name": "Updated Morty Smith",
      "status": "Alive",
      "species": "Human",
      "type": "",
      "gender": "Male",
      "origin": {
         "name": "Earth (Replacement Dimension)",
         "url": "https://rickandmortyapi.com/api/location/20"
      },
      "location": {
         "name": "Citadel of Ricks",
         "url": "https://rickandmortyapi.com/api/location/3"
      },
      "image": "https://rickandmortyapi.com/api/character/avatar/2.jpeg",
      "url": "https://rickandmortyapi.com/api/character/2"
   }
```
**Response:**
```json
   {
      "message": "Character updated successfully",
      "data": {
         "id": 2,
         "name": "Updated Morty Smith",
         "status": "Alive",
         "species": "Human",
         "type": "",
         "gender": "Male",
         "origin": {
               "name": "Earth (Replacement Dimension)",
               "url": "https://rickandmortyapi.com/api/location/20"
         },
         "location": {
               "name": "Citadel of Ricks",
               "url": "https://rickandmortyapi.com/api/location/3"
         },
         "image": "https://rickandmortyapi.com/api/character/avatar/2.jpeg",
         "url": "https://rickandmortyapi.com/api/character/2"
      },
      "status": 200
   }
```
- `PATCH /api/v1/characters/{id}` - Actualización parcial de un personaje

**Request Body:**
```json
   {
      "status": "Dead"
   }
```
**Response:**
```json
   {
      "message": "Character updated successfully",
      "data": {
         "id": 2,
         "name": "Morty Smith",
         "status": "Dead",
         "species": "Human",
         "type": "",
         "gender": "Male",
         "origin": {
               "name": "Earth (C-137)",
               "url": "https://rickandmortyapi.com/api/location/1"
         },
         "location": {
               "name": "Citadel of Ricks",
               "url": "https://rickandmortyapi.com/api/location/3"
         },
         "image": "https://rickandmortyapi.com/api/character/avatar/2.jpeg",
         "url": "https://rickandmortyapi.com/api/character/2"
      },
      "status": 200
   }
```
- `DELETE /api/v1/characters/{id}` - Eliminar un personaje

**Response:**
```json
   {
      "message": "Character deleted successfully",
      "status": 200
   }
```

### Asignar personajes a episodios (Protected)

- `POST /api/v1/episodes/{episodeId}/characters` - Asignar personajes a un episodio

**Request Body:**
```json
   {
      "character_ids": [1, 2, 3]
   }
```
**Response:**
```json
   {
      "message": "Characters assigned to episode successfully",
      "data": {
         "episode": {
               "id": 1,
               "name": "Pilot",
               "air_date": "2013-12-02",
               "episode": "S01E01",
               "characters": [
                  {
                     "id": 1,
                     "name": "Rick Sanchez",
                     "status": "Alive",
                     ...
                  },
                  {
                     "id": 2,
                     "name": "Morty Smith",
                     "status": "Alive",
                     ...
                  },
                  ...
               ]
         }
      },
      "status": 200
   }
```

## Notas

- Asegúrate de que Docker y Docker Compose estén instalados en tu sistema.
- Si encuentras problemas de conexión a la base de datos, asegúrate de que el servicio MySQL esté en funcionamiento y accesible desde el contenedor de la aplicación.
- Puedes verificar el estado de los contenedores con el comando `./vendor/bin/sail ps`.
- Para SO Windows se debe usar `./vendor/bin/sail` bajo el subsistema de linux en Windows (WSL), para linux y macOS no debería haber problemas.

## Contribución

Si deseas contribuir a este proyecto, por favor crea un fork del repositorio y envía un pull request con tus cambios.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Para más detalles, revisa el archivo [LICENSE](LICENSE).
