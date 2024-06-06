**Requisitos del sistema:**

* **PHP:** Versión 8.2 o posterior (asegura la compatibilidad con las dependencias del proyecto)
* **Node.js:** Versión 18 o posterior (admite funciones modernas de JavaScript)
* **Composer:** Herramienta de gestión de dependencias para proyectos PHP
* **pnpm (Performant Node Package Manager):** Herramienta de gestión de paquetes para proyectos Node.js
* **Docker:** Plataforma de contenedorización (opcional, pero recomendada para ejecutar la versión mysql)

# Instrucciones de instalación:

1. Ejecutar el comando `docker-compose up -d` para inicializar los contenedores de Docker.

2. Ejecutar el script `pnpm install:windows` para instalar las dependencias del proyecto en windows. en linux  `pnpm install:linux`  .

3. Ejecutar el script `pnpm load:data` para cargar los datos de ejemplo.

4. Ejecutar el script `pnpm dev` para iniciar el desarrollo del proyecto.