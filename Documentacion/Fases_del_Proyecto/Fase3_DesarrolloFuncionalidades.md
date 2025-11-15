# Fase 3 - Desarrollo de Funcionalidades.

## Estructura general del desarrollo

Antes de iniciar la implementación de las funcionalidades, se establece la metodología de trabajo que guiará esta fase. El desarrollo se organizará siguiendo una estructura modular y por módulos funcionales y capas lógicas, basada en las decisiones técnicas previamente documentadas.

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

La gestión de animales constituye uno de los pilares fundamentales del sistema, ya que permite administrar la información de los animales, tanto animales disponibles para adopción o acogida, como para los animales no disponibles, pero que necesitan el registro en la base de datos del refugio.

### Modelo y migración

Se ha creado el modelo `Animal` junto con su correspondiente migración, siguiendo la estructura definida en la Fase 1.
Este modelo recoge los atributos principales del animal —nombre, especie, raza, fecha de nacimiento, sexo, tamaño, peso, estado, número de microchip e imágenes asociadas— además de otros campos relevantes para la gestión interna.
Asimismo, mantiene las relaciones con las entidades `Adoption` y `Foster`, que permiten registrar los procesos de adopción y acogida vinculados a cada animal.

La migración genera la tabla `animals` en la base de datos, definiendo claves primarias, tipos de datos adecuados, valores por defecto y marcas de tiempo automáticas.
Se aplican restricciones como `nullable`, `default` o `unique` según corresponda para garantizar la integridad de los datos.

### CRUD completo con Livewire

Se ha implementado un componente Livewire que permite realizar todas las operaciones CRUD —crear, leer, actualizar y eliminar— sobre los registros de animales directamente desde el panel de administración.

El listado se presenta en una tabla dinámica con paginación y filtros, lo que facilita la gestión y búsqueda de registros.
Las acciones de edición y eliminación se ejecutan sin necesidad de recargar la página, aprovechando el comportamiento reactivo de Livewire, y están protegidas mediante confirmaciones y validaciones que garantizan la integridad de los datos.

### Validaciones

Se aplican validaciones tanto en el servidor —a través del componente Livewire— como en el cliente, utilizando Alpine.js para ofrecer interacciones simples y retroalimentación inmediata.

Las reglas de validación contemplan campos obligatorios, formatos de datos, rangos numéricos y límites de longitud, adaptándose a cada tipo de campo según su naturaleza. Esto garantiza que la información registrada sea coherente y fiable antes de ser almacenada en la base de datos.

### Gestión de imágenes y galería multimedia

El sistema permite la carga de imágenes desde los formularios de creación y edición de animales.
Las imágenes se almacenan en un servicio externo (por ejemplo, Cloudinary), y se referencian mediante los campos `secure_url` y `public_id`, definidos en la entidad `AnimalImage`.

Cada ficha de animal cuenta con una galería multimedia que permite mostrar varias imágenes o incluso vídeos, mejorando la presentación visual y aumentando las posibilidades de adopción o acogida.

### Búsqueda y filtros

La vista pública de animales incorpora un buscador interactivo junto con filtros por especie, edad, sexo, estado, tamaño o nombre.
Estos filtros permiten a los usuarios explorar fácilmente el catálogo de animales según sus preferencias.

La lógica de filtrado se implementa con Livewire, lo que permite actualizar los resultados dinámicamente sin necesidad de recargar la página.


> Estas funcionalidades están previstas para su implementación siguiendo la estructura técnica definida en las fases anteriores.

---

## 2. Gestión de Usuarios

El sistema de gestión de usuarios permite controlar el acceso a la plataforma, distinguir entre tipos de usuario, y facilitar la edición de datos personales y preferencias. Todos los usuarios del sistema se gestionan mediante una única entidad (`User`), tal y como se definió en la Fase 1.

### Registro, login y logout

Se ha implementado el sistema de autenticación utilizando Laravel Breeze, que ofrece funcionalidades predefinidas para registro, inicio de sesión, cierre de sesión y recuperación de contraseña. El proceso de registro requiere que el usuario introduzca su correo electrónico, nombre y una contraseña segura.

### Verificación de correo electrónico

Durante el registro, el sistema envía un correo de verificación al usuario. Hasta que no se confirme el email, el acceso a funcionalidades privadas permanece restringido mediante el middleware `verified`. Esta medida mejora la seguridad del sistema y evita registros falsos o no deseados.

En caso de que el usuario modifique su dirección de correo electrónico desde su perfil, el sistema desactiva automáticamente la verificación anterior y envía un nuevo correo de confirmación. El acceso a funcionalidades restringidas permanece bloqueado hasta que se verifique la nueva dirección.

### Recuperación y cambio de contraseña

Los usuarios pueden recuperar su contraseña desde la pantalla de login a través de un enlace de recuperación. Una vez autenticados, también pueden modificar su contraseña desde su área de perfil. El sistema aplica validaciones de seguridad mínimas para asegurar una contraseña robusta.

### Acceso a formularios sin necesidad de registro

Los formularios de solicitud de adopción, acogida o contacto están disponibles públicamente, sin necesidad de iniciar sesión. Cualquier persona interesada puede enviar una solicitud desde la web vía email. La solicitud será valorada manualmente por el personal del refugio, cualquier formulario será finalizado presencialmente. Si el proceso se finaliza, el registro en la base de datos será manual por el personal administrativo. 

### Gestión del perfil

Cada usuario registrado dispone de un área personal desde donde puede actualizar su información básica: nombre, alias, teléfono, dirección o preferencias de colaboración (por ejemplo, si desea acoger o recibir información sobre futuras campañas). Estos campos se corresponden con los atributos definidos en la entidad `User`, incluyendo el campo `status`.

En caso de modificar su dirección de correo electrónico, el sistema reactivará el proceso de verificación para garantizar que la nueva dirección es válida.

### Roles y permisos

El sistema distingue dos roles principales:

- `user`: rol asignado por defecto a todo usuario que se registra en la plataforma. Ésto sólo puede ser modificado por un usuario administrador y no se verá en la vista pública de forma que se refuerza la seguridad del sitio.

- `admin`: rol reservado a personal autorizado del refugio, con acceso total al panel de administración. Se controlará que un usuario administrador no podrá eliminarse o desactivarse a sí mismos.

El control de acceso a las rutas se realiza mediante middleware, permitiendo proteger funcionalidades específicas según el rol autenticado.

### Panel y funcionalidades para usuarios registrados

Los usuarios registrados disponen de un panel personalizado desde el cual pueden:

- Ver y editar su información personal.

Futuras funcionalidades
- Hacer seguimiento de sus solicitudes.
- Recibir notificaciones personalizadas y mensajes del sistema.
- Consultar el estado de animales apadrinados o adoptados.
- Interactuar en la plataforma mediante comentarios en el blog o mensajería privada con el refugio o con otros usuarios, si se habilita.

> Estas funcionalidades forman parte de la base esencial del sistema y están previstas para ser desarrolladas conforme a la estructura técnica definida en las fases anteriores.

---

## 3. Gestión de acogidas

El sistema contempla la posibilidad de que cualquier persona interesada pueda ofrecerse como hogar temporal para uno o más animales. Esta funcionalidad es clave dentro del flujo de adopción y bienestar del animal, ya que permite evaluar entornos y preparar futuras adopciones, en un entorno familiar. 

> Para los casos en los que la acogida culmina en adopción, ver punto 4.

### Formulario público de solicitud

El formulario de acogida está disponible en la web pública y permite a cualquier persona interesada enviar una solicitud sin necesidad de registro.
Al completarlo, los datos se envían automáticamente por correo electrónico al refugio, donde el personal administrativo los revisará manualmente.
Tras el envío, se muestra un mensaje de confirmación al usuario indicando que su solicitud ha sido enviada correctamente.
> El formulario no se almacena en la base de datos ni genera registros automáticos, sino manualmente por el personal administrativo.

### Revisión y gestión por parte del administrador

Las solicitudes recibidas por correo se gestionan de forma interna por el equipo del refugio.
Una vez revisada la información y confirmada la disponibilidad del animal, el personal administrativo formaliza el proceso presencialmente con el solicitante.
Cuando la acogida se aprueba y el contrato queda firmado, se crea manualmente un nuevo registro en la entidad Foster, vinculando al usuario y al animal correspondientes.

### Asociación con entidades y gestión de estados

Cada registro de acogida manual se asocia a:

- Un `User`, correspondiente al tutor temporal del animal.

- Un `Animal`, que pasa a tener estado `fostered`.

El registro incluye las fechas de inicio y fin del período de acogida, así como comentarios internos o notas administrativas.
Estos datos permiten mantener un historial claro y trazable de cada proceso de acogida.

### Cierre por adopción

Si el animal acogido es finalmente adoptado, el administrador cierra manualmente el registro activo en la entidad `Foster`, indicando la fecha de finalización y el motivo del cierre (`comments`).
A continuación, se crea un nuevo registro en la entidad `Adoption` y se actualiza el estado del animal a `adopted`, manteniendo así la coherencia de los datos internos del sistema.

> Estas funcionalidades están previstas para su implementación siguiendo la estructura técnica definida en las fases anteriores.

---

## 4. Gestión de Adopciones

En muchos casos reales, las adopciones se formalizan tras un periodo previo de acogida temporal.
El sistema contempla este flujo específico para facilitar el seguimiento y garantizar la correcta adaptación del animal a su nuevo entorno.

- El usuario interesado completa el **formulario público de adopción**, que se envía por correo electrónico al refugio.
- El personal administrativo revisa la solicitud y, si lo considera adecuado, propone una **acogida temporal previa** (generalmente de unas semanas) para valorar la compatibilidad del animal con el entorno familiar.
- Una vez formalizado el acuerdo, se crea **manualmente** un registro en la entidad `Foster`, indicando las fechas de inicio y fin previstas.
- Durante el periodo de acogida, el equipo del refugio realiza el seguimiento necesario, como visita a la vivienda.
- Si la valoración final es positiva, el administrador procede a formalizar la adopción en el sistema mediante la creación de un nuevo registro en la entidad `Adoption`.
  - En ese momento, el registro de acogida se cierra manualmente.
  - El estado del animal se actualiza a `adopted`.

> Este flujo permite una transición ordenada y supervisada entre la fase de acogida y la adopción definitiva, siguiendo la práctica habitual de muchos refugios.

### Texto explicativo en el formulario de adopción

El formulario público de adopción incluirá una nota informativa para los solicitantes, explicando de forma clara el proceso habitual y las fases del mismo:

> “En El Refugio, muchas adopciones se realizan tras un periodo de acogida temporal para comprobar la adaptación del animal a su nuevo entorno.
> Si estás interesado en adoptar, es posible que primero participes en una breve etapa de acogida (aproximadamente un mes) antes de formalizar la adopción definitiva en nuestras instalaciones.
> Todo el proceso será acompañado y supervisado por nuestro equipo.”

Este mensaje sirve para **gestionar expectativas** y favorecer adopciones responsables y meditadas.

---

## 5. Gestión de formularios públicos

El sistema permite que cualquier persona interesada pueda contactar con el refugio o enviar solicitudes de adopción, acogida o contacto directamente desde la web, sin necesidad de registrarse previamente.
Esta funcionalidad mantiene una puerta abierta a la participación ciudadana, evitando barreras técnicas y priorizando la accesibilidad.

### Tipos de formularios gestionados

- Solicitud de adopción
- Solicitud de acogida
- Formulario general de contacto

### Envío y recepción

Todos los formularios públicos están desarrollados como componentes Livewire independientes y accesibles desde la interfaz web.
Cuando un usuario completa un formulario:

- Los datos se **envían por correo electrónico** al refugio.
- **No** se almacenan en la base de datos.
- El usuario visualiza un mensaje de confirmación en pantalla, indicando que la solicitud se ha enviado correctamente. Opcionalmente, se enviará un correo electrónico automático al usuario, indicando que su solicitud será procesada y se le contactará por los medios obtenidos: correo electrónico o móvil.

> Este enfoque evita el almacenamiento innecesario de información sensible y mantiene la estructura del sistema ligera y segura.

### Revisión y gestión por parte del personal del refugio

El equipo administrativo recibe las solicitudes en su correo institucional y las revisa manualmente.
Tras la valoración correspondiente, y en caso de aprobación, los datos pueden introducirse manualmente en el sistema para crear los registros necesarios:

- Un nuevo usuario (`User`), si la persona aún no está registrada o completando el resto de campos necesarios si lo está.
- Una adopción (`Adoption`) o una acogida (`Foster`), según corresponda.

De esta forma se mantiene la trazabilidad y coherencia en los datos sin automatismos en decisiones sensibles.

### Seguimiento y trazabilidad

Aunque las solicitudes no se almacenan automáticamente, los registros administrativos (`Adoption`, `Foster`, `User`) permiten vincular de forma controlada la información de cada proceso formalizado, conservando la trazabilidad de los casos aprobados o completados.

> Esta funcionalidad garantiza una gestión flexible, organizada y trazable de todas las solicitudes recibidas desde el exterior, sin comprometer la seguridad ni la calidad del proceso interno del refugio.

---

## 6. Panel de administración

El Panel de Administración es el espacio central de gestión reservado exclusivamente para los usuarios con rol `admin`. A través de este panel, el personal autorizado del refugio podrá administrar los diferentes módulos del sistema de forma eficiente y segura.

### Acceso y seguridad

- El acceso al panel estará restringido mediante middleware de autenticación y verificación (`auth`, `verified`, `admin`).
- Solo los usuarios autenticados con el rol `admin` tendrán acceso al panel de administración y podrán operar dentro de él.
- Los intentos de acceso no autorizado serán bloqueados y redireccionados a páginas de error o login.

---

### Funcionalidades incluidas en la primera versión

**1. Gestión de animales (`Animal`)**
- Crear nuevos registros de animales o nuevos usuarios, si fuera necesario.
- Editar la información de los animales o usuarios.
- Eliminar registros de animales, o usuarios, si fuera necesario.
- Subir y gestionar imágenes y galerías multimedia de cada animal.
- Registrar observaciones y tratamientos generales (`observations`) asociados a cada animal.

**2. Gestión de usuarios (`User`)**
- Visualizar el listado de usuarios registrados en la base de datos.
- Editar los datos personales de los usuarios.
- Modificar el rol de un usuario (`user` o `admin`).
- Eliminar usuarios cuando corresponda.

---

### Funcionalidades previstas para futuras versiones

**3. Panel de estadísticas básicas**
- Visualizar métricas relevantes para el funcionamiento del refugio, tales como:
  - Número de animales activos.
  - Número de adopciones completadas.
  - Número de acogidas en curso.
  - Número de solicitudes de voluntariado recibidas.
- Presentación simple en forma de contadores o tablas informativas.

**4. Gestión de citas o visitas** (previsto para futuras versiones)
- Visualizar solicitudes de citas para visitas al refugio.
- Aprobar o rechazar las solicitudes de cita.
- Gestionar la planificación de visitas de potenciales adoptantes o voluntarios.

**5. Gestión de publicaciones (blog o noticias)** (previsto para futuras versiones)
- Crear, editar y eliminar entradas del blog o noticias del refugio.
- Publicar actualizaciones, eventos, campañas, historias de adopción.

**6. Gestión de tienda solidaria (merchandising)** (previsto para futuras versiones)
- Añadir, editar o eliminar productos disponibles en la tienda online.
- Gestionar stock y categorías de productos solidarios.

---

### Organización interna del panel

- El panel de administración se estructurará en módulos o secciones independientes.
- Cada módulo contará con un menú propio y un listado principal (index) para visualizar los registros existentes.
- Desde cada listado se podrá acceder a formularios de creación, edición y gestión de registros relacionados.
- El diseño priorizará la claridad, la accesibilidad rápida a cada área funcional y la escalabilidad futura.
- Las informaciones cruzadas (adopciones o acogidas) se visualizarán gracias a vistas de la base de datos.
- Las solicitudes recibidas mediante formularios públicos se gestionan manualmente por el personal del refugio, sin funcionalidades específicas en esta versión.

---

## 7. Reutilización de componentes y mejoras visuales

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

- **Tarjeta de animal**: Componente que muestra de forma estandarizada los datos principales de un animal (imagen, nombre, estado).
- **Formularios públicos (adopción, acogida y contacto)**: Componentes interactivos que permiten enviar solicitudes públicas, **vía email**, sin necesidad de recargar la página.
- **Alertas y mensajes de estado**: Componentes que informan visualmente al usuario del resultado de acciones (éxito, error, advertencia).

> Estos componentes se encuentran organizados dentro de `resources/views/livewire/` para las vistas y `app/Http/Livewire/` para la lógica del componente.

---

### Integración de Alpine.js para interacciones rápidas

Alpine.js se utiliza como librería complementaria para añadir interactividad ligera en el frontend, permitiendo:

- Mostrar y ocultar elementos de forma dinámica.
- Manejar estados locales de componentes (por ejemplo, abrir o cerrar un modal).
- Añadir transiciones suaves y efectos visuales sencillos sin recargar la página.

> Su uso es mínimo pero estratégico para mantener una experiencia de usuario ágil y fluida.

---

### Aplicación progresiva de estilos (opcional: Tailwind CSS)

Para la parte visual, se plantea utilizar Tailwind CSS como framework de diseño en una fase de mejora futura. Esto permitiría:

- Estilizar de forma rápida y consistente todos los componentes.
- Reducir el tiempo de maquetación.
- Facilitar el diseño responsive adaptable a dispositivos móviles.

> Actualmente, se mantienen estilos básicos personalizados. La integración completa de Tailwind CSS se considera como una mejora opcional para siguientes fases de refinamiento visual.

---

## 8. Gestión de errores y validaciones

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

- Mostrar mensajes de error dinámicos sin necesidad de recargar la página.
- Mejorar la experiencia de usuario ofreciendo retroalimentación rápida sobre errores de validación.

---

### Gestión de errores personalizados

La aplicación contará con un sistema de manejo de errores personalizados para:

- Capturar y mostrar errores específicos en las operaciones del panel de administración o en los formularios públicos.
- Redireccionar adecuadamente al usuario en caso de error grave (por ejemplo, error 404 o acceso no autorizado).
- Utilizar vistas de error personalizadas para una mejor experiencia de usuario.

Cuando se produzca un error en una operación (por ejemplo, intento de acceder a una entidad inexistente), el sistema mostrará mensajes claros como:

- "El animal solicitado no existe o ha sido eliminado."
- "No tienes permisos suficientes para acceder a esta sección."
- "Se ha producido un error al enviar tu solicitud. Inténtalo de nuevo más tarde."

---

### Redirecciones en caso de error

En situaciones donde no se pueda completar una acción, se realizarán redirecciones amigables:

- Volver al listado correspondiente (por ejemplo, lista de animales o lista de usuarios).
- Mostrar un mensaje de alerta o error en la vista de destino.
- Mantener los datos del formulario en caso de fallo, permitiendo corregir errores sin tener que reescribir toda la información.

---

### Objetivos de la estrategia de validación y gestión de errores

- **Seguridad**: impedir la entrada de datos no válidos o maliciosos.
- **Fiabilidad**: garantizar que las operaciones del sistema se realizan solo con datos válidos.
- **Accesibilidad**: informar adecuadamente al usuario en caso de error, sin causar frustración.
- **Mantenibilidad**: centralizar la lógica de validación y errores para facilitar futuras ampliaciones o cambios.

---