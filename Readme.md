Entorno de desarrollo
=====================

Renombre cada uno de los archivos .env.example a .env

    1. .env.example
    2. ./backend/.env.example
    3. ./frontend/.env.example

Para levantar la aplicación en modo de desarrollo se debe ejecutar el siguiente comando:

    docker-compose -f docker-compose-dev.yml up -d


Entorno de producción
=====================

Para levantar la aplicación en producción se debe ejecutar el siguiente comando:

    docker-compose up -d

