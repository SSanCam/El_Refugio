# Fase 3 - Desarrollo de Funcionalidades.

## Estructura general del desarrollo

Antes de iniciar la implementación de las funcionalidades, se establece la metodología de trabajo que guiará esta fase. El desarrollo se organizará siguiendo una estructura modular y por capas, basada en las decisiones técnicas previamente documentadas.

Cada módulo funcional se desarrollará de forma independiente, agrupando su lógica, componentes y vistas asociadas. Se aplicará el patrón Modelo–Vista–Controlador (MVC), propio de Laravel, complementado con el uso de Livewire para añadir interactividad sin necesidad de recargar la página.

El flujo de trabajo para cada funcionalidad será el siguiente:

1. **Modelo**: definición de la entidad correspondiente y sus relaciones.
2. **Migración**: creación de la tabla en base de datos utilizando migraciones de Laravel.
3. **Controlador**: definición de la lógica principal de la funcionalidad.
4. **Componente Livewire** (si aplica): implementación de la lógica interactiva y dinámica.
5. **Vista Blade**: construcción de la interfaz de usuario asociada.

Este enfoque busca mantener una estructura clara, coherente y fácilmente escalable a medida que evolucione el proyecto.


---

## 1. Gestión de animales

La gestión de animales constituye uno de los pilares fundamentales del sistema, ya que permite administrar la información de los animales disponibles para adopción, acogida o que ya han sido adoptados.

### Modelo y migración

Se ha creado el modelo `Animal` junto con su respectiva migración, siguiendo la estructura definida en la Fase 1. El modelo incluye atributos como nombre, especie, raza, edad, sexo, tamaño, peso, estado, microchip, imágenes y otros campos relevantes. También se han definido relaciones con las entidades `Adoptions`, `Foster`, `Veterinary_History` y `Animal_Medication`.

La migración genera la tabla `animals` en la base de datos, con claves primarias, tipos de datos adecuados, valores por defecto y timestamps. Se han aplicado restricciones como `nullable`, `default`, o `unique` cuando ha sido necesario.

### CRUD completo con Livewire

Se ha implementado un componente Livewire que permite realizar operaciones CRUD (crear, leer, actualizar y eliminar) sobre los registros de animales desde la interfaz del panel de administración. El listado de animales se muestra en una tabla dinámica, con paginación y filtros.

Las acciones de edición y eliminación se realizan sin recargar la página, gracias al comportamiento reactivo de Livewire, y están protegidas mediante confirmaciones y validaciones.

### Validaciones

Se han aplicado validaciones tanto del lado del servidor (en el componente Livewire) como del cliente, utilizando Alpine.js para interacciones simples y retroalimentación inmediata.

Las validaciones incluyen campos obligatorios, formato de datos, rangos numéricos y restricciones de longitud, adaptándose según el tipo de campo.

### Gestión de imágenes y galería multimedia

Se ha implementado un sistema de carga de imágenes desde el formulario de creación y edición de animales. Las imágenes se almacenan en el directorio `storage` y se vinculan al registro correspondiente.

Además, se ha habilitado una galería multimedia para cada ficha de animal, que permite mostrar varias imágenes y vídeos si se añaden. Esta funcionalidad mejora la presentación de cada animal y su visibilidad para potenciales adoptantes o acogedores.

### Búsqueda y filtros

En la vista pública de animales se ha incluido un buscador interactivo y varios filtros por especie, edad, sexo, estado, tamaño o nombre. Estos filtros permiten al usuario navegar fácilmente entre los registros según sus preferencias o necesidades.

La lógica de filtrado se implementa mediante Livewire, y los resultados se actualizan dinámicamente sin recarga de página.

---

Estas funcionalidades están previstas para su implementación siguiendo la estructura técnica definida en las fases anteriores.

---

## 2. Gestión de usuarios

El sistema de gestión de usuarios permite controlar el acceso a la plataforma, distinguir entre tipos de usuario, y facilitar la edición de datos personales y preferencias. Todos los usuarios del sistema se gestionan mediante una única entidad (`User`), tal y como se definió en la Fase 1.

### Registro, login y logout

Se ha implementado el sistema de autenticación utilizando Laravel Breeze, que ofrece funcionalidades predefinidas para registro, inicio de sesión, cierre de sesión y recuperación de contraseña. El proceso de registro requiere que el usuario introduzca su correo electrónico, nombre y una contraseña segura.

### Verificación de correo electrónico

Durante el registro, el sistema envía un correo de verificación al usuario. Hasta que no se confirme el email, el acceso a funcionalidades privadas permanece restringido mediante el middleware `verified`. Esta medida mejora la seguridad del sistema y evita registros falsos o no deseados.

En caso de que el usuario modifique su dirección de correo electrónico desde su perfil, el sistema desactiva automáticamente la verificación anterior y envía un nuevo correo de confirmación. El acceso a funcionalidades restringidas permanece bloqueado hasta que se verifique la nueva dirección.

### Recuperación y cambio de contraseña

Los usuarios pueden recuperar su contraseña desde la pantalla de login a través de un enlace de recuperación. Una vez autenticados, también pueden modificar su contraseña desde su área de perfil. El sistema aplica validaciones de seguridad mínimas para asegurar una contraseña robusta.

### Acceso a formularios sin necesidad de registro

Los formularios de solicitud de adopción, acogida o voluntariado están disponibles públicamente, sin necesidad de iniciar sesión. Cualquier persona interesada puede enviar una solicitud desde la web. Si la solicitud es aceptada por el refugio, se procederá a registrar sus datos en el sistema como nuevo usuario. Esta estrategia permite eliminar barreras de entrada para nuevos adoptantes o colaboradores.

### Gestión del perfil

Cada usuario registrado dispone de un área personal desde donde puede actualizar su información básica: nombre, alias, teléfono, dirección o preferencias de colaboración (por ejemplo, si desea acoger, apadrinar o ser voluntario). Estos campos se corresponden con los atributos definidos en la entidad `User`, incluyendo el campo `status`.

En caso de modificar su dirección de correo electrónico, el sistema reactivará el proceso de verificación para garantizar que la nueva dirección es válida.

### Roles y permisos

El sistema distingue dos roles principales:

- `user`: rol asignado por defecto a todo usuario que se registra en la plataforma. Ésto sólo puede ser modificado por un usuario administrador y no se verá en la vista pública de forma que se refuerza la seguridad del sitio.

- `admin`: rol reservado a personal autorizado del refugio, con acceso total al panel de administración. Se controlará que un usuario administrador no podrá eliminarse o desactivarse ellos así mismos.

El control de acceso a las rutas se realiza mediante middleware, permitiendo proteger funcionalidades específicas según el rol autenticado.

### Panel y funcionalidades para usuarios registrados

Los usuarios registrados disponen de un panel personalizado desde el cual pueden:

- Ver y editar su información personal.
- Acceder a formularios y hacer seguimiento de sus solicitudes.
- Recibir notificaciones personalizadas y mensajes del sistema.
- Consultar el estado de animales apadrinados o adoptados.
- (Futuro) Interactuar en la plataforma mediante comentarios en el blog o mensajería privada con el refugio o con otros usuarios, si se habilita.

---

Estas funcionalidades forman parte de la base esencial del sistema y están previstas para ser desarrolladas conforme a la estructura técnica definida en las fases anteriores.

---

## 3. Gestión de acogidas

El sistema contempla la posibilidad de que cualquier persona interesada pueda ofrecerse como hogar temporal para uno o más animales. Esta funcionalidad es clave dentro del flujo de adopción y bienestar del animal, ya que permite evaluar entornos y preparar futuras adopciones en un entorno familiar. Para los casos en los que la acogida culmina en adopción, ver punto 4.

### Formulario público de solicitud

Se ha diseñado un formulario accesible desde la web pública que permite enviar una solicitud de acogida sin necesidad de estar registrado. El formulario recoge los datos personales mínimos necesarios y permite al usuario seleccionar el animal deseado o dejar la elección abierta.

Una vez enviado, se mostrará un mensaje de confirmación en la web para informar de que la solicitud ha sido registrada correctamente. No se requiere autenticación para completar este proceso.

### Revisión y gestión por parte del administrador

Todas las solicitudes se almacenan en la base de datos con estado inicial `pending`. Desde el panel de administración, los usuarios con rol `admin` pueden visualizar un listado de solicitudes pendientes, acceder a su detalle y decidir si aceptarlas o rechazarlas.

Si la solicitud es aprobada, los datos de la persona solicitante se registran en el sistema como un nuevo `User`, y se crea una nueva entrada en la entidad `Foster`, vinculada al animal correspondiente.

### Asociación con entidades y gestión de estados

Cada registro de acogida está relacionado con:

- Un `User` (creado si no existía previamente).
- Un `Animal` que será acogido.

El sistema permite gestionar los distintos estados del proceso mediante el campo `status`, que puede adoptar valores como `pending`, `fostering`, `finished`, etc. También se registran las fechas de inicio y fin de la acogida y se permite añadir comentarios internos (por ejemplo, si el animal cambia de hogar temporal o regresa al refugio).

### Cierre por adopción

En caso de que el animal acogido sea adoptado, el sistema cerrará automáticamente la acogida activa vinculada a dicho animal, registrando su fecha de finalización y motivo de cierre.

---

Estas funcionalidades están previstas para su implementación siguiendo la estructura técnica definida en las fases anteriores.

---

## 4. Gestión de Adopciones

En muchos casos reales, las adopciones se formalizan tras un periodo previo de acogida temporal. El sistema contempla este flujo específico para facilitar el seguimiento:

- El usuario interesado inicia el proceso a través de una solicitud de adopción desde la web.
- Desde el refugio, se le ofrece una **acogida temporal previa** (máximo 30 días) para comprobar la compatibilidad del entorno.
- Esta acogida queda registrada en la entidad `Foster` con su fecha de inicio y una fecha de finalización prevista.
- Durante ese periodo, el equipo del refugio puede realizar visitas o contacto de seguimiento para evaluar la situación.
- Si la valoración es positiva, se procede a formalizar la adopción desde el panel de administración. Esto generará:
  - Un nuevo registro en `Adoptions`.
  - El cierre automático del registro de acogida.
  - La actualización del estado del animal a `adopted`.

Este proceso permite una transición ordenada y supervisada entre acogida y adopción definitiva, alineado con la práctica habitual de muchos refugios.

### Texto explicativo en el formulario de adopción

El formulario de solicitud de adopción incluirá una nota informativa visible para el usuario donde se expliquen claramente los pasos habituales del proceso:

> "En El Refugio, muchas adopciones se realizan tras una acogida temporal para comprobar la adaptación del animal a su nuevo entorno. Si estás interesado en adoptar, primero podrías pasar por una etapa breve de acogida (aproximadamente un mes) antes de formalizar la adopción en nuestras instalaciones. Todo el proceso será acompañado y supervisado por nuestro equipo."

Este mensaje sirve para **gestionar expectativas** y favorecer adopciones responsables y meditadas.

---

## 5. Gestión de formularios públicos

El sistema permite que cualquier persona interesada pueda contactar con el refugio, enviar una solicitud de adopción, acogida o voluntariado directamente desde la web, sin necesidad de registrarse previamente. Esta funcionalidad es esencial para mantener una puerta abierta a la colaboración y participación ciudadana sin barreras técnicas.

### Tipos de formularios gestionados

- Solicitud de adopción
- Solicitud de acogida
- Solicitud para ser voluntario/a
- Formulario general de contacto

### Registro y almacenamiento en base de datos

Cada tipo de formulario cuenta con su propia entidad en la base de datos (`Adoption_Request`, `Foster_Request`, `Volunteer_Request`, `Contact_Message`, etc.). Al enviar un formulario:

- Los datos se almacenan automáticamente.
- No se requiere autenticación previa.
- Se genera un mensaje de confirmación en la interfaz (por ejemplo, un pop-up, banner o vista de agradecimiento).

### Notificación y gestión en el panel de administración

Los administradores visualizan en su panel todas las solicitudes nuevas recibidas, categorizadas según el tipo de formulario. Cada entrada muestra:

- Fecha de envío
- Datos personales del remitente
- Tipo de solicitud y contenido

Desde el panel, el personal autorizado puede:

- Marcar una solicitud como **revisada**
- Añadir comentarios internos
- **Aceptar** o **rechazar** manualmente la solicitud

### Aceptación y conversión en entidad final

Cuando una solicitud es aceptada, el sistema permite generar manualmente la entidad correspondiente. Por ejemplo:

- Una solicitud de adopción aceptada puede generar un nuevo registro en `Adoptions`.
- Una solicitud de acogida puede convertirse en una entrada en `Foster`.
- Si la persona no está registrada, se crea una nueva entrada en `User` asociada al proceso.

Este enfoque permite realizar una **evaluación previa del perfil**, contactar con la persona si es necesario, y evitar automatismos en decisiones delicadas como la adopción o la acogida.

### Rechazo de solicitudes

Si una solicitud es rechazada, se registra como tal, se mantiene en el historial y no genera nuevas entidades. Esto permite conservar un registro administrativo completo.

---

Esta funcionalidad garantiza una gestión flexible, organizada y trazable de todas las solicitudes recibidas desde el exterior, sin comprometer la seguridad ni la calidad del proceso interno del refugio.

---

## 6. Gestión de formularios públicos

El sistema permite que cualquier persona, sin necesidad de estar registrada, pueda enviar solicitudes al refugio a través de formularios públicos disponibles en la web. Estas solicitudes pueden corresponder a distintos tipos: adopción, acogida, voluntariado o contacto general.

Con el fin de gestionar de manera eficiente y lógica cada tipo de solicitud, se ha diseñado una estructura organizada de almacenamiento que agrupa o separa formularios según su finalidad:

### Agrupación y entidades

* Solicitudes de adopción y acogida se almacenan en una única tabla denominada `Animal_Request`. Dentro de esta tabla, un campo `type` distinguirá si la solicitud es de tipo `adoption` o `foster`.

* Solicitudes de voluntariado se almacenan en su propia tabla `Volunteer_Request`, dado que su finalidad es diferente y requiere campos específicos (como disponibilidad y motivación).

* Mensajes generales de contacto se almacenan en su propia tabla `Contact_Message`, enfocada exclusivamente en consultas o comunicaciones generales, sin relación directa con animales ni adopciones.

Este enfoque proporciona un equilibrio entre la centralización donde es lógico y la separación donde es necesario, optimizando así el mantenimiento del sistema, su rendimiento y su escalabilidad futura.

### Envío y confirmación visual

Los formularios estarán accesibles desde la interfaz pública de la web. Una vez completados y enviados, se mostrará un mensaje visual de confirmación (por ejemplo, un popup o un aviso en pantalla) para informar al usuario de que su solicitud ha sido registrada correctamente. No es necesario estar autenticado para enviar una solicitud.

### Estructura de las tablas

#### Animal_Request (para adopciones y acogidas)

- `id_request`: Clave primaria autogenerada.
- `type`: Tipo de solicitud (`adoption` o `foster`).
- `first_name`: Nombre del solicitante.
- `last_name`: Apellidos del solicitante.
- `email`: Correo electrónico de contacto.
- `phone`: Número de teléfono (opcional).
- `address`: Dirección del solicitante.
- `animal_id`: ID del animal relacionado (opcional).
- `message`: Mensaje o motivo de la solicitud.
- `status`: Estado de la solicitud (`pending`, `reviewed`, `accepted`, `rejected`).
- `admin_notes`: Observaciones internas para el equipo.
- `created_at`: Fecha de creación (autogenerado por Laravel).
- `updated_at`: Fecha de actualización (autogenerado).

#### Volunteer_Request (para voluntariado)

- `id_request`: Clave primaria autogenerada.
- `first_name`: Nombre del solicitante.
- `last_name`: Apellidos del solicitante.
- `email`: Correo electrónico de contacto.
- `phone`: Número de teléfono (opcional).
- `availability`: Disponibilidad para colaborar (días, horarios).
- `motivation`: Motivación para ser voluntario.
- `status`: Estado de la solicitud (`pending`, `reviewed`, `accepted`, `rejected`).
- `admin_notes`: Observaciones internas para el equipo.
- `created_at`: Fecha de creación (autogenerado).
- `updated_at`: Fecha de actualización (autogenerado).

#### Contact_Message (para contacto general)

- `id_message`: Clave primaria autogenerada.
- `user_id`: ID del usuario registrado (opcional, si está logueado).
- `email`: Correo electrónico de contacto (obligatorio si no está logueado).
- `phone`: Número de teléfono (opcional).
- `subject`: Asunto del mensaje.
- `message`: Contenido del mensaje o consulta.
- `status`: Estado de la solicitud (`pending`, `reviewed`, `archived`).
- `admin_notes`: Observaciones internas para el equipo del refugio.
- `created_at`: Fecha de creación (autogenerado).
- `updated_at`: Fecha de actualización (autogenerado).

### Gestión desde el panel de administración

Los administradores podrán acceder a un panel centralizado desde el cual visualizar todas las solicitudes recibidas, organizadas según el tipo de formulario enviado. La interfaz permitirá:

- Visualizar las solicitudes de **adopción** y **acogida** almacenadas en la tabla `Animal_Request`.
- Visualizar las solicitudes de **voluntariado** almacenadas en la tabla `Volunteer_Request`.
- Visualizar los **mensajes de contacto general** almacenados en la tabla `Contact_Message`.
- Filtrar las solicitudes por tipo de solicitud, estado (`pending`, `reviewed`, `accepted`, `rejected`, `archived`) o fecha.
- Consultar el detalle completo de cada solicitud individualmente.
- Cambiar el estado de cada solicitud y añadir observaciones internas.
- Formalizar una solicitud aceptada:
  - Las solicitudes de **adopción** o **acogida** pueden generar un nuevo registro en las tablas `Adoptions` o `Foster`.
  - Las solicitudes de **voluntariado** pueden actualizar el perfil del usuario relacionado, si corresponde.

Cada tipo de solicitud se gestionará en su propia sección específica del panel administrativo, facilitando así una organización clara y eficiente.

---

### Ventajas del enfoque

- **Centralización lógica**: Se agrupan las solicitudes similares (adopción y acogida) en una misma tabla y se separan aquellas de naturaleza diferente (voluntariado y contacto), optimizando la gestión interna.
- **Flexibilidad**: Permite añadir nuevos tipos de formularios en el futuro de forma sencilla, sin romper la estructura actual.
- **Organización de datos**: Cada tipo de solicitud queda adecuadamente categorizado, mejorando la trazabilidad y la eficiencia de revisión.
- **Facilidad de administración**: El personal del refugio puede gestionar fácilmente cada tipo de solicitud en su apartado correspondiente, sin necesidad de filtrar en una única tabla masiva.
- **Escalabilidad**: A medida que el refugio crezca, el sistema podrá adaptarse a un mayor volumen de solicitudes de manera ordenada.

---

## 7. Panel de administración

El Panel de Administración será el espacio central de gestión reservado exclusivamente para los usuarios con rol `admin`. A través de este panel, el personal autorizado del refugio podrá gestionar los diferentes módulos del sistema de manera eficiente y segura.

### Acceso y seguridad

- El acceso al panel estará restringido mediante middleware de autenticación y verificación (`auth`, `verified`, `admin`).
- Solo los usuarios autenticados con el rol `admin` podrán acceder y operar dentro del panel de administración.
- Los intentos de acceso no autorizado serán bloqueados y redireccionados a páginas de error o login.

---

### Funcionalidades principales disponibles en la primera versión

**1. Gestión de animales (`Animal`)**
- Crear nuevos registros de animales disponibles para adopción o acogida.
- Editar la información de los animales.
- Eliminar registros de animales si fuera necesario.
- Subir y gestionar imágenes y galerías multimedia de cada animal.
- Actualizar el estado de los animales (en adopción, acogido, adoptado).
- Visualizar el historial veterinario y los tratamientos médicos de cada animal.

**2. Gestión de usuarios (`User`)**
- Visualizar el listado de usuarios registrados en la plataforma.
- Editar los datos personales de los usuarios.
- Modificar el rol de un usuario (`user` o `admin`).
- Eliminar usuarios cuando corresponda.

**3. Gestión de formularios públicos**
- Visualizar y gestionar solicitudes de adopción y acogida (`Animal_Request`).
- Visualizar y gestionar solicitudes de voluntariado (`Volunteer_Request`).
- Visualizar y gestionar mensajes de contacto general (`Contact_Message`).
- Aceptar o rechazar solicitudes públicas.
- Formalizar solicitudes aceptadas convirtiéndolas en registros definitivos (`Adoptions`, `Foster`, `User`).

**4. Panel de estadísticas básicas**
- Visualizar métricas relevantes para el funcionamiento del refugio, tales como:
  - Número de animales activos.
  - Número de adopciones completadas.
  - Número de acogidas en curso.
  - Número de solicitudes de voluntariado recibidas.
- Presentación simple en forma de contadores o tablas informativas.

---

### Funcionalidades previstas para futuras versiones

**5. Gestión de citas o visitas** (previsto para futuras versiones)
- Visualizar solicitudes de citas para visitas al refugio.
- Aprobar o rechazar las solicitudes de cita.
- Gestionar la planificación de visitas de potenciales adoptantes o voluntarios.

**6. Gestión de publicaciones (blog o noticias)** (previsto para futuras versiones)
- Crear, editar y eliminar entradas del blog o noticias del refugio.
- Publicar actualizaciones, eventos, campañas, historias de adopción.

**7. Gestión de tienda solidaria (merchandising)** (previsto para futuras versiones)
- Añadir, editar o eliminar productos disponibles en la tienda online.
- Gestionar stock y categorías de productos solidarios.

---

### Organización interna del panel

- El panel de administración se estructurará en módulos o secciones independientes.
- Cada módulo contará con un menú propio y un listado principal (index) para visualizar los registros existentes.
- Desde cada listado se podrá acceder a formularios de creación, edición y gestión de registros relacionados.
- El diseño priorizará la claridad, la accesibilidad rápida a cada área funcional y la escalabilidad futura.

---

## 8. Reutilización de componentes y mejoras visuales

### Reutilización de componentes

Siguiendo las mejores prácticas de desarrollo en Laravel y Livewire, la plataforma "El Refugio" se ha diseñado utilizando componentes reutilizables. Esto permite:

- **Modularidad**: Cada parte de la interfaz puede modificarse o ampliarse sin afectar a todo el sistema.
- **Mantenibilidad**: El código es más fácil de entender, actualizar y depurar.
- **Reutilización**: Los componentes pueden utilizarse en diferentes secciones de la web sin necesidad de reescribirlos.
- **Escalabilidad**: A medida que el sistema crece, nuevos componentes pueden crearse o adaptar los existentes de forma sencilla.
- **Reducir duplicación de código**.
- **Facilitar el mantenimiento** y futuras modificaciones.
- **Mejorar la escalabilidad** del sistema.

Los componentes se utilizan tanto en la gestión interna como en la vista pública, proporcionando una interfaz coherente y modular.

#### Componentes Livewire reutilizables implementados

- **Tarjeta de animal (`AnimalCard`)**: Componente que muestra de forma estandarizada los datos principales de un animal (imagen, nombre, estado).
- **Formulario de adopción/acogida (`AdoptionForm`, `FosterForm`)**: Componentes interactivos que permiten enviar solicitudes públicas sin necesidad de recargar la página.
- **Formulario de voluntariado (`VolunteerForm`)**: Formulario dinámico para envío de solicitudes de voluntariado.
- **Formulario de contacto (`ContactForm`)**: Para enviar mensajes al refugio de forma rápida y sencilla.
- **Alertas y mensajes de estado (`Alert`)**: Componentes que informan visualmente al usuario del resultado de acciones (éxito, error, advertencia).
- **Tablas dinámicas (`RequestTable`, `AnimalTable`)**: Listados editables de registros en el panel de administración.

Estos componentes se encuentran organizados dentro de `resources/views/livewire/` para las vistas y `app/Http/Livewire/` para la lógica del componente.

---

### Integración de Alpine.js para interacciones rápidas

Alpine.js se utiliza como librería complementaria para añadir interactividad ligera en el frontend, permitiendo:

- Mostrar y ocultar elementos de forma dinámica.
- Manejar estados locales de componentes (por ejemplo, abrir o cerrar un modal).
- Añadir transiciones suaves y efectos visuales sencillos sin recargar la página.

Su uso es mínimo pero estratégico para mantener una experiencia de usuario ágil y fluida.

---

### Aplicación progresiva de estilos (opcional: Tailwind CSS)

Para la parte visual, se plantea utilizar Tailwind CSS como framework de diseño en una fase de mejora futura. Esto permitiría:

- Estilizar de forma rápida y consistente todos los componentes.
- Reducir el tiempo de maquetación.
- Facilitar el diseño responsive adaptable a dispositivos móviles.

Actualmente, se mantienen estilos básicos personalizados. La integración completa de Tailwind CSS se considera como una mejora opcional para siguientes fases de refinamiento visual.

---
## 9. Gestión de errores y validaciones

Una correcta gestión de errores y validaciones es fundamental para garantizar la fiabilidad, seguridad y buena experiencia de usuario dentro de la plataforma "El Refugio".

### Validaciones en backend (Laravel)

Las validaciones de datos en el servidor se realizan utilizando el sistema de validaciones nativo de Laravel. Esto garantiza que:

- Los datos recibidos en los controladores o componentes cumplen los requisitos de formato, tipo y obligatoriedad.
- Se aplican reglas como `required`, `email`, `numeric`, `min`, `max`, `string`, entre otras, dependiendo del tipo de campo.
- Se protegen las operaciones críticas del sistema contra datos maliciosos o inconsistentes.

Estas validaciones se aplican antes de procesar cualquier operación en base de datos o lógica de negocio, asegurando la integridad del sistema.

---

### Validaciones en frontend (Livewire y Alpine.js)

En el lado del cliente, se utilizan Livewire y Alpine.js para:

- Validar de forma inmediata la entrada de datos en los formularios (por ejemplo, comprobar si un campo obligatorio está vacío).
- Mostrar mensajes de error dinámicos sin necesidad de recargar la página.
- Mejorar la experiencia de usuario ofreciendo retroalimentación rápida sobre errores de validación.

La combinación de Livewire y Alpine.js permite construir formularios reactivos, donde los errores se actualizan en tiempo real conforme el usuario completa los campos.

---

### Gestión de errores personalizados

La aplicación contará con un sistema de manejo de errores personalizados para:

- Capturar y mostrar errores específicos en las operaciones del panel de administración o en los formularios públicos.
- Redireccionar adecuadamente al usuario en caso de error grave (por ejemplo, error 404 o acceso no autorizado).
- Utilizar páginas de error personalizadas para una mejor experiencia de usuario.

Cuando se produzca un error en una operación (por ejemplo, intento de acceder a una entidad inexistente), el sistema mostrará mensajes claros como:

- "El animal solicitado no existe o ha sido eliminado."
- "No tienes permisos suficientes para acceder a esta sección."
- "Se ha producido un error al enviar tu solicitud. Inténtalo de nuevo más tarde."

---

### Redirecciones en caso de error

En situaciones donde no se pueda completar una acción, se realizarán redirecciones amigables:

- Volver al listado correspondiente (por ejemplo, lista de animales, lista de solicitudes).
- Mostrar un mensaje de alerta o error en la vista de destino.
- Mantener los datos del formulario en caso de fallo, permitiendo corregir errores sin tener que reescribir toda la información.

---

### Objetivos de la estrategia de validación y gestión de errores

- **Seguridad**: impedir la entrada de datos no válidos o maliciosos.
- **Fiabilidad**: garantizar que las operaciones del sistema se realizan solo con datos válidos.
- **Accesibilidad**: informar adecuadamente al usuario en caso de error, sin causar frustración.
- **Mantenibilidad**: centralizar la lógica de validación y errores para facilitar futuras ampliaciones o cambios.

---

## Resumen de la Fase 3: Estado de Funcionalidades

A continuación se presenta un resumen del estado actual de las funcionalidades desarrolladas en esta fase:

### Funcionalidades implementadas

- **Gestión de animales:** CRUD completo, gestión de imágenes, búsqueda y filtros.
- **Gestión de usuarios:** Registro, login, roles, verificación de correo, gestión de perfil.
- **Gestión de acogidas:** Solicitud pública, gestión de estados, cierre automático por adopción, las dechas de inicio/fin pueden ser modificadas por administradores.
- **Gestión de adopciones:** Flujo de acogida previa, formalización de adopciones.
- **Historial veterinario:** Registro de eventos médicos y tratamientos prolongados.
- **Gestión de formularios públicos:** Adopciones, acogidas, voluntariado y contacto organizados en entidades separadas.
- **Panel de administración:** Módulos funcionales para animales, usuarios, solicitudes públicas y estadísticas básicas.
- **Reutilización de componentes:** Implementación de componentes Livewire y Alpine.js.
- **Gestión de errores y validaciones:** Validaciones backend y frontend, errores personalizados y redirecciones amigables.

### Funcionalidades previstas para futuras versiones

- Gestión de citas o visitas al refugio.
- Gestión de publicaciones (blog o noticias).
- Gestión de tienda solidaria (merchandising).
- Ampliación del panel de estadísticas con métricas avanzadas.
- Integración de Tailwind CSS para mejora visual progresiva.
- Sistema de donaciones económicas online.
