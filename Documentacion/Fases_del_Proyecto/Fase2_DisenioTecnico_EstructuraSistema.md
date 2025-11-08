# Fase 2 - Diseño Técnico y Estructura del Sistema

Este documento define los aspectos técnicos previos a la implementación del sistema "El Refugio". Se especifican las decisiones clave sobre la arquitectura, la organización del proyecto, la base de datos, el entorno de desarrollo y la seguridad.

---

## 1. Estructura del Proyecto en Laravel

### Organización general

El sistema "El Refugio" se organizará en torno a módulos funcionales claramente definidos, cada uno encargado de gestionar una parte concreta del dominio de la aplicación. Esta modularidad permite estructurar el código de forma coherente y facilita tanto el mantenimiento como la escalabilidad del sistema.

Los principales módulos del sistema serán los siguientes:

* Usuarios (User): gestión de registros, inicio de sesión, perfiles y roles (user, admin).
* Animales (Animal): administración de fichas, estados y galería de imágenes.
* Formularios públicos (PublicRequest): envío de solicitudes de adopción, acogida y contacto por email; registro opcional en BD para trazabilidad.
* Panel de administración: gestión interna de usuarios, animales y solicitudes.

Cada módulo contará con su propio conjunto de modelos, controladores, vistas y componentes Livewire según necesidad. Esta organización sigue el patrón MVC proporcionado por Laravel, adaptado al enfoque modular del proyecto.


---


### Carpetas, convenciones y estructura del sistema

El proyecto seguirá la estructura de carpetas estándar de Laravel, organizando el código por tipo de elemento (modelo, controlador, vista, componente...) para facilitar el mantenimiento y la escalabilidad. Las convenciones son las siguientes:

#### 📁 Estructura de Carpetas del Proyecto

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


#### Convenciones de nombres

- Todos los nombres técnicos del código (clases, métodos, variables, archivos...) estarán escritos en **inglés**, siguiendo las buenas prácticas del desarrollo internacional.
- Los **métodos** y **variables** seguirán la convención **camelCase** (`userEmail`, `animalStatus`).
- Los **nombres de clases** y componentes seguirán la convención **PascalCase** (`UserProfile`, `PublicRequest`).
- Las **vistas y rutas** se nombrarán en **kebab-case** o **snake_case**, según lo recomendado por Laravel.
- El **contenido textual de la interfaz de usuario (etiquetas, formularios, mensajes)** estará en **español**, ya que el proyecto está destinado a un público hispanohablante.
- Los **comentarios y documentación** también estarán en español, para mantener la coherencia del entorno académico y facilitar su comprensión.

Este enfoque mixto garantiza que el proyecto sea técnicamente robusto y legible tanto por desarrolladores como por usuarios, manteniendo una estructura profesional y adecuada al contexto del TFG.

--- 

### Distribución de componentes Blade y Livewire

La aplicación contará con múltiples elementos reutilizables para facilitar la escalabilidad, la coherencia visual y la eficiencia del desarrollo. Estos componentes se dividirán en dos grandes grupos: **estáticos (Blade)** e **interactivos (Livewire)**, cada uno con su ubicación específica dentro de la estructura del proyecto.

#### Componentes Blade (estáticos)

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

#### Componentes Livewire (interactivos)

Estos componentes se ubicarán en `app/Http/Livewire` y sus vistas asociadas en `resources/views/livewire/`. Se utilizarán para añadir interactividad sin necesidad de recargar la página.

**Animales**
- `AnimalGallery`: galería de imágenes del animal.
- `AnimalProfile`: ficha extendida con pestañas (descripción, historial...).

**Formularios**
- `PublicForm`: formularios que podrán ser de adopción, acogida o contacto.

**Usuarios**
- `UserProfile`: vista editable del perfil del usuario.

**Administración**
- `AdminDashboard`: panel principal con resumen de estadísticas y accesos rápidos.
- `AnimalTable`: tabla editable con filtros para gestión de animales.
- `UserManagement`: componente para gestión de usuarios.
- `ContentEditor`: edición de textos estáticos de la web desde el panel.

---

#### Componentes adicionales (ampliaciones futuras)

**Colaboración**
- `DonationWidget`: widget para integrar donaciones en cualquier vista.
- `SponsorshipStatusBox`: muestra visual del estado del animal apadrinado.

**Seguimiento**
- `AdoptionTimeline`: línea de tiempo del proceso de adopción.
- `PostAdoptionFollowUp`: espacio privado para el seguimiento post-adopción.

**Multimedia**
- `MultimediaViewer`: visor integrado de imágenes y vídeos dentro de las fichas.

---

Esta previsión de componentes ayudará a estructurar mejor el desarrollo en la Fase 3 y permitirá mantener una interfaz coherente, reutilizable y escalable en todas las secciones del sistema. La lista podrá ajustarse o ampliarse en función de las necesidades que surjan durante la implementación.

---

## 2. Diseño de la Base de Datos

### Migraciones

Crear migraciones para `User`, `Animal`, `AnimalImage` y, opcionalmente, `PublicRequest`. Definir claves primarias, foráneas, índices y restricciones.

### Relaciones entre tablas

* `Animal` 1:N `AnimalImage` (`animal_id` FK).
* `Animal` 1:N `PublicRequest` (`animal_id` FK) 
* `Animal` N:1 `User` (`user_id` FK, NULLABLE). [Un animal sólo tendrá un único tutor aunque sea de forma temporal, como las acogidas].
* `User` 1:N `PublicRequest` (`user_id` FK nullable) [ opcional ].

--- 

1. `User`: usuarios autenticados del sistema con rol admin|user.
2. `Animal`: status (enum): unavailable, sheltered, fostered, adopted, deceased.
    - unavailable: no disponible (cuarentena, valoración veterinaria, etc.).
    - sheltered: el animal permanece en el centro y está disponible.
    - fostered: el animal está en acogida temporal.
    - adopted: adopción formalizada.
    - deceased: fallecido; se oculta de los listados públicos.
    > **nota**: Sólo los animales con estado sheltered o fostered podrán mostrarse como disponibles para adopción.

3. `AnimalImage`: galería de imágenes del animal.
Campos clave: `secure_url`, `provider`, `public_id` (si Cloudinary/S3), `profile_pic` (bool), `sort_order` (int).

4. `PublicRequest`: envío de solicitudes de adopción, acogida y contacto por email; registro opcional en BD para trazabilidad.
**Nota**: el envío de la solicitud no altera `Animal.status`; el estado solo cambia tras decisión final manual.

### Diagrama Entidad-Relación (E-R) y modelo conceptual

Se elaborará un diagrama E-R con las entidades `User`, `Animal`, `AnimalImage` y `PublicRequest` y sus relaciones.

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

> El archivo `.env.railway` permite configurar las variables de entorno de producción para Railway.  
> Así se mantiene la separación entre desarrollo local y entorno de despliegue real, evitando conflictos entre configuraciones sensibles.

### Conexión con base de datos MySQL
Configurar la conexión entre Laravel y MySQL utilizando XAMPP, incluyendo nombre de base de datos, usuario y contraseña.

### Instalación de dependencias necesarias
Listar las dependencias que deben instalarse al iniciar el proyecto (Livewire, Alpine.js y, opcionalmente, Tailwind CSS).

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

---

## 7. Componentes Reutilizables y Modularidad

### Componentes Blade

Enumerar los componentes de interfaz estática que se reutilizarán en múltiples vistas (por ejemplo: menús, tarjetas, pie de página).

### Componentes Livewire
Definir los componentes interactivos que se crearán con Livewire para evitar recargas de página (por ejemplo: formularios, listados dinámicos).

### Separación entre vistas públicas y privadas
Establecer claramente qué vistas son accesibles sin autenticación y cuáles forman parte del panel privado para usuarios registrados o administradores.

