# Fase 2 - Diseño Técnico y Estructura del Sistema

Este documento define los aspectos técnicos previos a la implementación del sistema "El Refugio". Se especifican las decisiones clave sobre la arquitectura, la organización del proyecto, la base de datos, el entorno de desarrollo y la seguridad.

Estas decisiones se alinean con la Fase 1: los *formularios públicos* no se persisten en base de datos (se gestionan por correo) y la actualización del status de los animales se realizará desde la lógica de backend (Observers/Events de Laravel), no mediante triggers SQL.

---

## 1. Estructura del Proyecto en Laravel

### a. Organización general

El sistema "El Refugio" se organizará en torno a módulos funcionales claramente definidos, cada uno encargado de gestionar una parte concreta del dominio de la aplicación. Esta modularidad permite estructurar el código de forma coherente y facilita tanto el mantenimiento como la escalabilidad del sistema.

Los principales módulos del sistema serán los siguientes:

* Usuarios (User): gestión de registros, inicio de sesión, perfiles y roles (user, admin).
* Animales (Animal): administración de fichas, estados y galería de imágenes.
* Formularios públicos: envío por email; sin persistencia en la base de datos.
* Panel de administración: gestión interna de usuarios, animales, registros manuales de adopciones y acogidas, ademas de visualización de información sobre las mismas.

Cada módulo contará con su propio conjunto de modelos, controladores, vistas y componentes Livewire según necesidad. Esta organización sigue el patrón MVC proporcionado por Laravel, adaptado al enfoque modular del proyecto.

---

### b. Carpetas, convenciones y estructura del sistema

El proyecto seguirá la estructura de carpetas estándar de Laravel, organizando el código por tipo de elemento (modelo, controlador, vista, componente...) para facilitar el mantenimiento y la escalabilidad. Las convenciones son las siguientes:

- #### Estructura de Carpetas del Proyecto

```plaintext
📁 app/
├── Enums/              # Enumeraciones personalizadas (si usas constantes de estados, roles, etc.)
├── Exceptions/         # Clases de manejo de excepciones
├── Http/
│   ├── Controllers/    # Controladores del sistema (por entidad)
│   ├── Livewire/       # Componentes Livewire interactivos
│   └── Middleware/     # Middleware para rutas, autenticación, etc.
├── Mail/               # Clases para envío de correos (si se implementa)
├── Models/             # Entidades del sistema (User, Animal, etc.)
├── Observers/          # Observadores de modelos (si usas eventos tipo updated/deleted)
├── Providers/          # Configuración de servicios y bindings de Laravel
├── Services/           # Lógica de negocio reutilizable (si se separa del controlador)

📁 bootstrap/            # Configuración de arranque del framework
📁 config/               # Archivos de configuración del sistema (app.php, database.php, etc.)

📁 database/
├── factories/          # Factories para testeo con datos ficticios
├── migrations/         # Archivos de migración (estructura de las tablas)
├── seeders/            # Datos de ejemplo para inicializar la base de datos

📁 public/               # Archivos públicos accesibles desde el navegador (index.php, imágenes, etc.)

📁 resources/
├── css/                # Archivos de estilos (Tailwind o personalizados)
├── js/                 # Scripts de Alpine.js o JS personalizado
└── views/              # Vistas Blade (.blade.php)
    ├── components/     # Componentes Blade reutilizables (botones, formularios, layout)
    ├── livewire/       # Vistas asociadas a componentes Livewire
    ├── animals/        # Vistas relacionadas con los animales
    ├── users/          # Vistas del perfil o gestión de usuario
    ├── admin/          # Panel de administración

📁 routes/
├── web.php             # Rutas web (frontend)
├── api.php             # Rutas de API (si se expone alguna)

```
   > **nota:** Si el entorno de desarrollo o despliegue se dockeriza, los archivos **Dockerfile** y **docker-compose.yml** se ubicarán en el directorio raíz del proyecto. Estos contendrán la configuración de los servicios necesarios (contenedor PHP/Laravel, servidor web y base de datos MySQL) para facilitar la instalación, despliegue y replicación del entorno en diferentes sistemas.

- #### Convenciones de nombres

    - Todos los nombres técnicos del código (clases, métodos, variables, archivos...) estarán escritos en **inglés**, siguiendo las buenas prácticas del desarrollo internacional.
    
    - Los **métodos** y **variables** seguirán la convención **camelCase** (`userEmail`, `animalStatus`).
    
    - Los **nombres de clases** y componentes seguirán la convención **PascalCase** (`UserProfile`, `PublicForm`).
    
    - Las **vistas y rutas** se nombrarán en **kebab-case** (url, rutas y Blade) o **snake_case** (campos de las vistas de la base de datos o variables de PHP), según lo recomendado por Laravel.
    
    - El **contenido textual de la interfaz de usuario (etiquetas, formularios, mensajes)** estará en **español**, ya que el proyecto está destinado a un público hispanohablante.
    
    - Los **comentarios y documentación** también estarán en español, para mantener la coherencia del entorno académico y facilitar su comprensión.

Este enfoque mixto garantiza que el proyecto sea técnicamente robusto y legible tanto por desarrolladores como por usuarios, manteniendo una estructura profesional y adecuada al contexto del TFG.

--- 

### c. Distribución de componentes Blade y Livewire

La aplicación contará con múltiples elementos reutilizables para facilitar la escalabilidad, la coherencia visual y la eficiencia del desarrollo. Estos componentes se dividirán en dos grandes grupos: **estáticos (Blade)** e **interactivos (Livewire)**, cada uno con su ubicación específica dentro de la estructura del proyecto.

- #### Componentes Blade (estáticos)

Se utilizarán para elementos de interfaz sin lógica compleja, y se almacenarán en `resources/views/components/`.

**Estructura general**
- `header.blade.php`: cabecera común con el menú de navegación.
- `footer.blade.php`: pie de página con información de contacto y enlaces.
- `sidebar.blade.php`: barra lateral para panel de usuario o administración.
- `breadcrumb.blade.php`: navegación contextual (migas de pan).

**Contenido y presentación**
- `animal-card.blade.php`: tarjeta de presentación del animal (foto, nombre, estado).
- `user-card.blade.php`: tarjeta resumen de usuario (para vista admin o perfil).
- `badge.blade.php`: etiqueta para estados como `Adoptado`, `Acogido`, etc.
- `stat-box.blade.php`: caja visual con métricas (para dashboard admin).

**UI reutilizable**
- `alert.blade.php`: mensajes de éxito, error o advertencia.
- `button.blade.php`: botón reutilizable con estilos unificados.
- `input.blade.php`: campo de entrada reutilizable.
- `label.blade.php`: etiqueta asociada a campos de formulario.
- `modal.blade.php`: componente modal para acciones o confirmaciones.

---

- #### Componentes Livewire (interactivos)

Estos componentes se ubicarán en `app/Http/Livewire` y sus vistas asociadas en `resources/views/livewire/`. Se utilizarán para añadir interactividad sin necesidad de recargar la página.

**Animales**
- `AnimalGallery`: galería de imágenes del animal.
- `AnimalProfile`: ficha extendida con pestañas (descripción, historial...).

**Formularios**
- `PublicForm`: formularios de adopción, acogida o contacto (envío por email; sin persistencia en BD)

**Usuarios**
- `UserProfile`: vista editable del perfil del usuario.

**Administración**
- `AdminDashboard`: panel principal con resumen de estadísticas y accesos rápidos.
- `AnimalTable`: tabla editable con filtros para gestión de animales.
- `UserManagement`: componente para gestión de usuarios.
- `ContentEditor`: edición de textos estáticos de la web desde el panel.

---

- #### Componentes adicionales (ampliaciones futuras)

**Colaboración**
- `DonationWidget`: widget para integrar donaciones en cualquier vista.
- `SponsorshipStatusBox`: muestra visual del estado del animal apadrinado.
- `StoreProductCard`: componente para mostrar productos en una futura tienda solidaria.
- `CartWidget`: resumen visual del carrito de compras (si se implementa la tienda).

**Seguimiento**
- `AdoptionTimeline`: línea de tiempo del proceso de adopción.
- `PostAdoptionFollowUp`: espacio privado para el seguimiento post-adopción.

**Multimedia**
- `MultimediaViewer`: visor integrado de imágenes y vídeos dentro de las fichas.

Esta previsión de componentes ayudará a estructurar mejor el desarrollo en la Fase 3 y permitirá mantener una interfaz coherente, reutilizable y escalable en todas las secciones del sistema. La lista podrá ajustarse o ampliarse en función de las necesidades que surjan durante la implementación.

---

## 2. Diseño de la Base de Datos

### a. Migraciones

Crear migraciones para `User`, `Animal`, `AnimalImage`, `Adoption` y `Foster`. Definir claves primarias, foráneas, índices y restricciones.

> Las tablas `Adoption` y `Foster` se completarán manualmente por el personal administrativo del refugio, una vez formalizados los procesos correspondientes.  

> No se generarán automáticamente desde la web pública, pero garantizan trazabilidad y coherencia en la gestión interna.

### b. Relaciones entre tablas

* `Animal` 1:N `AnimalImage` (`animal_id` FK).
* `User` 1:N `Adoption` (`user_id` FK).
* `Animal` 1:N `Adoption` (`animal_id` FK).
* `User` 1:N `Foster` (`user_id` FK).
* `Animal` 1:N `Foster` (`animal_id` FK).

> Al crear/cerrar `Adoption`/`Foster`, `animals.status` se actualiza desde backend (Observers/Events).
> Restringir: una adopción activa por animal y una acogida activa por animal (índices/constraints lógicas).

--- 

1. `User`: usuarios autenticados del sistema con rol admin|user.

2. `Animal`: status (enum): unavailable, sheltered, fostered, adopted, deceased.  
    - unavailable: no disponible (cuarentena, valoración veterinaria, etc.).  
    - sheltered: el animal permanece en el centro y está disponible.  
    - fostered: el animal está en acogida temporal.  
    - adopted: adopción formalizada.  
    - deceased: fallecido; se oculta de los listados públicos.  
    > **nota:** Sólo los animales con estado `sheltered` o `fostered` podrán mostrarse como disponibles para adopción.

3. `AnimalImage`: galería de imágenes del animal.  
Campos clave: `secure_url`, `provider`, `public_id` (si Cloudinary/S3), `profile_pic` (bool).

4. `Adoption` y `Foster`: registros manuales creados por el personal administrativo para mantener el historial de adopciones y acogidas.  
> La creación de un registro en cualquiera de estas tablas actualiza automáticamente el campo `status` del animal correspondiente.


### c. Diagrama Entidad-Relación (E-R) y modelo conceptual

El modelo conceptual de datos ya fue definido en la **Fase 1 – Planificación y Análisis**, donde se detallan las entidades y sus relaciones principales.

>[Ver modelo de datos](../Diagramas/Modelo_Datos_ER.svg)

---

## 3. Arquitectura del Sistema

### Patrón MVC en Laravel
Aplicar la estructura Modelo-Vista-Controlador para separar la lógica de negocio, la interfaz de usuario y el acceso a datos.
La validación de datos se realizará mediante Form Requests ubicados en `app/Http/Requests`, y la autorización de acciones mediante Policies o Gates, manteniendo controladores ligeros y fácilmente mantenibles.

### Capa de servicios
Se valorará la creación de una capa intermedia de servicios destinada a manejar lógica de negocio más compleja o reutilizable, separándola del controlador principal.
Por ejemplo, un servicio podría encargarse de coordinar los procesos de adopción o acogida (creación del registro correspondiente, actualización automática del `status` del animal y notificación por correo).
El cambio de estado de los animales se reforzará mediante Model Observers, asegurando la coherencia de los datos internos.

### Integración Blade + Livewire + Alpine.js
El sistema combinará **Blade** (estructura y maquetación), Livewire v3 (interactividad sin recargar la página) y **Alpine.js v3** (funcionalidad frontend ligera).
Se mantendrá el orden correcto de carga: Alpine antes y `@livewireScripts` al final del documento, para evitar conflictos entre librerías.
En aquellos componentes de terceros que manipulen directamente el DOM se aplicará la directiva `wire:ignore`.
El envío de correos electrónicos derivados de formularios se realizará mediante Jobs en cola, evitando bloquear las peticiones del usuario.

---

## 4. Configuración del Entorno

### Archivo `.env` y entorno local
Definir las variables necesarias en el entorno de desarrollo, como conexión a base de datos, entorno de aplicación y credenciales locales.

> El archivo `.env.railway` permite configurar las variables de entorno de producción para Railway.
>De esta forma se mantiene la separación entre desarrollo local y entorno de despliegue real, evitando conflictos entre configuraciones sensibles.

### Conexión con base de datos MySQL
Configurar la conexión entre Laravel y MySQL utilizando XAMPP, incluyendo nombre de base de datos, usuario y contraseña.
El servidor local se ejecutará con `php artisan serve` (o Docker/Sail). XAMPP se empleará únicamente para el servicio de base de datos MySQL.

### Instalación de dependencias necesarias
Instalar las dependencias requeridas al iniciar el proyecto, incluyendo Livewire, Alpine.js y, opcionalmente, Tailwind CSS.

> **Nota:** El despliegue se documentará un despliegue temporal en Render o Railway (con capturas y vídeo demostrativo).
>La presentación final se realizará en entorno local, por limitaciones de los planes gratuitos de estos servicios.

---

## 5. Seguridad y Gestión de Roles

### Sistema de autenticación

Autenticación por sesiones utilizando el sistema nativo de Laravel (Auth).

### Middleware y protección de rutas

Definir y aplicar middlewares para proteger rutas privadas y restringir el acceso según el tipo de usuario autenticado. 

- `Anti-spam`: limitación de tasa por IP/email mediante throttle (p. ej., 5 solicitudes/minuto en formularios públicos).

### Gestión de roles: `user` y `admin`

Establecer los roles principales del sistema y cómo se asignarán y controlarán mediante lógica de backend o middleware.

- `User`: engloba a todos los usuarios registrados en el sistema, incluyendo adoptantes y acogedores. Tienen acceso a funcionalidades básicas como visualizar animales, enviar formularios y consultar su historial.

- `Admin`: acceso completo al panel. Gestiona usuarios, animales y formularios públicos; puede cambiar estados de animales y administrar el contenido visible en la web.

---

## 6. Flujo de Datos y Navegación

### Ciclo general de interacción

1. El usuario accede a la ficha del animal desde el listado público.
2. Selecciona la acción “Adoptar” o “Acoger”, lo que abre el formulario correspondiente.
3. El formulario recopila los datos y los envía por correo al personal administrativo.
4. El asunto del correo incluye el tipo de solicitud y el nombre del animal (ejemplo: ADOPCIÓN – Paquito).
5. El refugio evalúa las solicitudes y decide si procede la adopción o acogida.
6. Tras la decisión final, el estado del animal se actualiza a `unavailable`(no disponible), `adopted` (adoptado), `fostered` (en acogida), `sheltered` (si vuelve) o `deceased` (fallecido).

> **Nota:** la actualización de estado se realiza automáticamente mediante la lógica de backend (Observers o Services), garantizando coherencia y evitando duplicidades.

---

## 7. Componentes Reutilizables y Modularidad

### Componentes Blade

Componentes de interfaz estática reutilizables en múltiples vistas (por ejemplo: menús, cabeceras, tarjetas, pie de página o modales).

### Componentes Livewire
Componentes interactivos diseñados para formularios y listados dinámicos sin recargar la página.

### Separación entre vistas públicas y privadas
Las vistas públicas (`animals`, `adoption`, `contact` ...) serán accesibles sin autenticación.
Las vistas privadas (`admin`, `users`, `dashboard`...) requerirán autenticación y rol apropiado (`user` o `admin`).
