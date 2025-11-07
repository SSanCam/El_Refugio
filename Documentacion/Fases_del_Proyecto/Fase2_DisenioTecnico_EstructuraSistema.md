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
- **Panel de administración**: Funcionalidad privada destinada a los administradores del refugio, desde donde podrán gestionar usuarios, animales y solicitudes.
- **Solicitudes públicas (`PublicFormRequest`)**: Entidad que centraliza todas las solicitudes enviadas desde formularios accesibles sin necesidad de estar registrado (adopción, acogida, voluntariado, contacto). Se gestiona desde el panel de administración y permite convertirlas en entidades formales (`Adoption`, `Foster`, etc.).

Cada módulo contará con su propio conjunto de modelos, controladores, vistas y componentes Livewire si aplica. Esta organización sigue el patrón MVC proporcionado por Laravel, adaptado al enfoque modular del proyecto.


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
- Los **métodos** y **variables** seguirán la convención **camelCase** (`userEmail`, `adoptionStatus`).
- Los **nombres de clases** y componentes seguirán la convención **PascalCase** (`UserProfile`, `AdoptionRequest`).
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
- `AnimalList`: listado dinámico con filtros.
- `AnimalGallery`: galería de imágenes del animal.
- `AnimalProfile`: ficha extendida con pestañas (descripción, historial...).
- `AnimalStatusToggle`: interruptor de cambio de estado del animal.

**Formularios**
- `AdoptionForm`: formulario interactivo para solicitar adopción.
- `FosterForm`: formulario para acogida temporal.
- `SponsorshipForm`: formulario de apadrinamiento.
- `ContactForm`: formulario general de contacto.
- `VisitRequestForm`: formulario para solicitar una cita o visita al refugio.

**Usuarios**
- `UserProfile`: vista editable del perfil del usuario.
- `UserRequestHistory`: listado de solicitudes del usuario actual.
- `UserRoleBadge`: identificador visual del rol (`user`, `admin`).

**Administración**
- `AdminDashboard`: panel principal con resumen de estadísticas y accesos rápidos.
- `AnimalTable`: tabla editable con filtros para gestión de animales.
- `UserManagement`: componente para gestión de usuarios.
- `RequestApprovalPanel`: revisión y control de solicitudes pendientes.
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
Planificar la creación de migraciones para cada entidad definida en la Fase 1, utilizando el sistema de migraciones de Laravel para definir tablas y restricciones.

### Relaciones entre tablas
Especificar qué tipo de relaciones existirán entre las entidades (1:N, N:N), cómo se aplicarán y qué claves foráneas serán necesarias.

El sistema estará compuesto por entidades como `User`, `Animal`, `Adoption`, `Foster`, `VolunteerRequest`, `Sponsorship`, y `AnimalImage`. Cada una cumplirá una función específica en la gestión del refugio y se relacionará entre sí mediante claves foráneas para mantener la coherencia de los datos.

- `User`: representa a todos los usuarios del sistema, tanto visitantes registrados como personal del refugio.
- `Animal`: almacena información detallada de cada animal alojado en el refugio.
- `Adoptions` y `Foster`: registran las solicitudes y procesos de adopción y acogida, respectivamente.
- `Public_Form_Request`: recoge todas las solicitudes enviadas desde formularios públicos (adopción, acogida, voluntariado y contacto), sin necesidad de registro previo.

### Diagrama Entidad-Relación (E-R) y modelo conceptual

Se elaborará un diagrama Entidad-Relación (E-R) que represente gráficamente las entidades principales (`User`, `Animal`, `Adoption`, `Foster`, etc.) y las relaciones entre ellas. Este diagrama sirve de apoyo visual al modelo lógico y físico de la base de datos.

El diagrama se incluirá en los anexos y servirá también de guía para la implementación de las migraciones en Laravel.

Además, el modelo conceptual de relaciones y navegación entre pantallas también está reflejado en los **wireframes diseñados en Figma**, disponibles en la carpeta de documentación visual del proyecto. Estos esquemas permiten vincular el flujo de datos con la estructura de interfaz prevista.


### Archivado histórico y gestión de base de datos secundaria (refugio_archivo)

Para garantizar el rendimiento, la escalabilidad y la conservación segura de los datos, se ha definido una estrategia de mantenimiento periódico que separa los datos operativos actuales de aquellos registros que ya están cerrados.

Dado que entidades como `Foster`, `Adoptions` o `Sponsorship` representan procesos que pueden finalizar (por ejemplo, cuando un animal es adoptado, finaliza una acogida o se cierra un apadrinamiento), no es necesario que estos registros permanezcan indefinidamente en la base de datos principal una vez han concluido.

Por ello, se ha creado una **base de datos secundaria** llamada `refugio_archivo`, destinada exclusivamente a almacenar registros históricos. Esta base de datos permite liberar la carga de la base activa sin perder información relevante para seguimiento, auditoría o análisis posteriores.

- Un **comando programado (cron job o tarea Laravel)** se ejecutará **mensualmente**, detectando los registros marcados como finalizados mediante campos como `status` (`finished`, `cancelled`) o fechas como `end_date` o `adoption_date`.
- Estos registros serán **copiados a la base de datos de archivo**, y posteriormente **eliminados de la base principal** para mantenerla optimizada.
- Esta operación estará **limitada a usuarios con rol de administrador**, garantizando seguridad y trazabilidad.
- La base de datos de archivo quedará accesible exclusivamente desde el sistema interno, con permisos restringidos, para consultas administrativas, legales o estadísticas.

Esta estrategia permite **preservar todo el historial del refugio** de forma segura, a la vez que mantiene el sistema principal **ágil, ordenado y eficiente**.

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
Listar las dependencias que deben instalarse al iniciar el proyecto (Livewire, Alpine.js, Tailwind opcional, Laravel UI o Breeze si aplica).

---

## 5. Seguridad y Gestión de Roles

### Sistema de autenticación
Seleccionar el paquete o método de autenticación (por ejemplo, Laravel Breeze) e implementar registro, login, logout y recuperación de contraseña.

### Middleware y protección de rutas
Definir y aplicar middlewares para proteger rutas privadas y restringir el acceso según el tipo de usuario autenticado.

### Gestión de roles: `user` y `admin`
Establecer los roles principales del sistema y cómo se asignarán y controlarán mediante lógica de backend o middleware.

- `User`: engloba a todos los usuarios registrados en el sistema, incluyendo adoptantes, acogedores, padrinos, voluntarios y colaboradores. Tienen acceso a funcionalidades básicas como visualizar animales, enviar formularios y consultar su historial.

- `Admin`: rol exclusivo del personal autorizado del refugio. Tienen acceso completo al panel de administración y son responsables de gestionar usuarios, animales, formularios públicos y contenidos del sitio. También pueden aprobar solicitudes, archivar registros y modificar configuraciones del sistema.

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

