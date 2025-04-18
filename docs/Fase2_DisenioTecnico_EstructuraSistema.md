# Fase 2 - Diseño Técnico y Estructura del Sistema

Este documento define los aspectos técnicos previos a la implementación del sistema "El Refugio". Se especifican las decisiones clave sobre la arquitectura, la organización del proyecto, la base de datos, el entorno de desarrollo y la seguridad.

---

## 1. Estructura del Proyecto en Laravel

### Organización general

El sistema "El Refugio" se organizará en torno a módulos funcionales claramente definidos, cada uno encargado de gestionar una parte concreta del dominio de la aplicación. Esta modularidad permite estructurar el código de forma coherente y facilita tanto el mantenimiento como la escalabilidad del sistema.

Los principales módulos del sistema serán los siguientes:

- **Usuarios (`User`)**: Gestión de registros, inicio de sesión, perfiles y roles (`user` y `admin`). Todos los tipos de usuario (adoptantes, padrinos, voluntarios, etc.) estarán unificados en esta única entidad.
- **Animales (`Animal`)**: Administración de animales disponibles en adopción o acogida, incluyendo datos básicos, estado y galería multimedia.
- **Adopciones (`Adoption`)**: Gestión de solicitudes de adopción enviadas por los usuarios, con estados para seguimiento y revisión.
- **Acogidas (`Foster`)**: Registro de solicitudes de acogida temporal, también asociadas a usuarios.
- **Historial veterinario (`VeterinaryHistory`)** y **medicación (`AnimalMedication`)**: Información médica, tratamientos y seguimientos de salud de cada animal.
- **Panel de administración**: Funcionalidad privada destinada a los administradores del refugio, desde donde podrán gestionar usuarios, animales y solicitudes.

Cada módulo contará con su propio conjunto de modelos, controladores, vistas y componentes Livewire si aplica. Esta organización sigue el patrón MVC proporcionado por Laravel, adaptado al enfoque modular del proyecto.


### Carpetas y convenciones
Establecer la jerarquía de carpetas para controladores, modelos, vistas y Livewire, así como las convenciones de nombres en inglés aplicadas en todo el proyecto.

### Distribución de componentes Blade y Livewire
Determinar qué elementos se reutilizarán como componentes (cabecera, pie, tarjetas de animales, formularios, etc.) y dónde se ubicarán en la estructura.

---

## 2. Diseño de la Base de Datos

### Migraciones
Planificar la creación de migraciones para cada entidad definida en la Fase 1, utilizando el sistema de migraciones de Laravel para definir tablas y restricciones.

### Relaciones entre tablas
Especificar qué tipo de relaciones existirán entre las entidades (1:N, N:N), cómo se aplicarán y qué claves foráneas serán necesarias.

### Diagrama Entidad-Relación
Preparar un esquema gráfico que represente todas las entidades y sus relaciones, como apoyo visual al modelo físico de base de datos.

---

## 3. Arquitectura del Sistema

### Patrón MVC en Laravel
Aplicar la estructura Modelo-Vista-Controlador para separar la lógica de negocio, la interfaz de usuario y el acceso a datos.

### Capa de servicios
Evaluar la necesidad de una capa intermedia para manejar lógica de negocio más compleja o reutilizable, separándola del controlador.

### Integración Blade + Livewire + Alpine.js
Planificar cómo se combinarán Blade (estructura), Livewire (interactividad) y Alpine.js (funcionalidad frontend ligera) en el desarrollo.

---

## 4. Configuración del Entorno

### Archivo `.env` y entorno local
Definir las variables necesarias en el entorno de desarrollo, como conexión a base de datos, entorno de aplicación y credenciales locales.

### Conexión con base de datos MySQL
Configurar la conexión entre Laravel y MySQL utilizando XAMPP, incluyendo nombre de base de datos, usuario y contraseña.

### Instalación de dependencias necesarias
Listar las dependencias que deben instalarse al iniciar el proyecto (Livewire, Alpine.js, Tailwind opcional, Laravel UI o Breeze si aplica).

---

## 5. Seguridad y Gestión de Roles

### Sistema de autenticación
Seleccionar el paquete o método de autenticación (por ejemplo, Laravel Breeze) e implementar registro, login, logout y recuperación de contraseña.

### Middleware y protección de rutas
Definir y aplicar middlewares para proteger rutas privadas y restringir el acceso según el tipo de usuario autenticado.

### Gestión de roles: `user` y `admin`
Establecer los roles principales del sistema y cómo se asignarán y controlarán mediante lógica de backend o middleware.

---

## 6. Flujo de Datos y Navegación

### Ciclo general de interacción
Describir cómo fluye la información entre el frontend y el backend, desde que el usuario realiza una acción hasta que se guarda en la base de datos.

### Ejemplo: Solicitud de adopción
Documentar como ejemplo una interacción completa: usuario inicia sesión, accede a un animal, rellena un formulario y se guarda la solicitud.

---

## 7. Componentes Reutilizables y Modularidad

### Componentes Blade
Enumerar los componentes de interfaz estática que se reutilizarán en múltiples vistas (por ejemplo: menús, tarjetas, pie de página).

### Componentes Livewire
Definir los componentes interactivos que se crearán con Livewire para evitar recargas de página (por ejemplo: formularios, listados dinámicos).

### Separación entre vistas públicas y privadas
Establecer claramente qué vistas son accesibles sin autenticación y cuáles forman parte del panel privado para usuarios registrados o administradores.
