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

- `user`: rol asignado por defecto a todo usuario que se registra en la plataforma.
- `admin`: rol reservado a personal autorizado del refugio, con acceso total al panel de administración.

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

El sistema contempla la posibilidad de que cualquier persona interesada pueda ofrecerse como hogar temporal para uno o más animales. Esta funcionalidad es clave dentro del flujo de adopción y bienestar del animal, ya que permite evaluar entornos y preparar futuras adopciones en un entorno familiar.

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

## 5. Historial veterinario (`Veterinary_History`)

El historial veterinario de cada animal permite registrar todos los eventos médicos relevantes a lo largo de su estancia en el refugio. Esta funcionalidad es clave para garantizar el seguimiento de la salud de cada animal, registrar tratamientos aplicados y mantener trazabilidad médica.

### Modelo y relaciones

La entidad `Veterinary_History` se ha diseñado para almacenar tratamientos, observaciones clínicas, vacunas, intervenciones quirúrgicas u otros eventos médicos. Cada registro incluye:

- El tipo de tratamiento.
- La fecha en que se realizó.
- Una descripción detallada.
- Observaciones adicionales si las hubiera.

Cada entrada está vinculada a un `Animal` mediante una relación 1:N (`id_animal`). Esta asociación permite visualizar el historial médico completo de un animal desde su ficha.

### Registro de eventos médicos

Los usuarios con rol `admin` pueden añadir nuevos tratamientos desde el panel de administración. Los campos requeridos son:

- Animal correspondiente.
- Fecha del tratamiento.
- Tipo de tratamiento (vacunación, cirugía, desparasitación, etc.).
- Descripción detallada del evento.
- Observaciones opcionales.

El sistema permite editar o eliminar registros si es necesario, siguiendo permisos restringidos por rol.

### Visualización agrupada

Desde la vista extendida del animal (en la parte administrativa), se presenta el historial completo agrupado por orden cronológico descendente. Esto permite al personal consultar de forma rápida todo el historial clínico sin necesidad de navegar por otras secciones.

El listado incluye:

- Fecha.
- Tipo de tratamiento.
- Descripción.
- Observaciones.
- Icono de edición (si el usuario tiene permisos).

Esta visualización facilita la toma de decisiones sobre tratamientos futuros o evaluaciones veterinarias.

### Posibilidad de exportar

Como funcionalidad ampliable, se contempla la opción futura de exportar el historial completo en formato PDF. Esta función puede ser útil en procesos de adopción, informes veterinarios o entregas de documentación.

---

## 5. Historial de medicación continua

El sistema incluye la gestión de tratamientos prolongados o crónicos para cada animal, tales como medicación diaria, semanal o periódica. Esta funcionalidad permite llevar un control preciso de medicamentos activos o finalizados, y se complementa con el historial veterinario general.

### Registro de tratamientos

Desde el panel de administración se podrán registrar los tratamientos mediante un formulario con los siguientes campos:

- Medicamento
- Dosis
- Frecuencia (por ejemplo: diaria, semanal)
- Fecha de inicio (`start_date`)
- Fecha de finalización (`end_date`, opcional)
- Descripción o comentarios

El tratamiento se considera **activo** si no tiene registrada una fecha de finalización.

### Asociación con animales

Cada tratamiento estará vinculado a un único animal. Desde la ficha del animal, el personal podrá acceder a todos sus tratamientos activos y pasados, visualizados de forma cronológica.

### Vista agrupada y filtros

Se habilitará una vista en el panel de administración que agrupe todos los tratamientos por animal. Además, se podrán aplicar filtros para visualizar únicamente los tratamientos:

- En curso (sin fecha de finalización)
- Finalizados
- Por frecuencia (diaria, semanal, etc.)

### Finalización manual del tratamiento

El administrador podrá modificar cualquier tratamiento para añadirle una fecha de finalización si corresponde. Esta acción marca automáticamente el tratamiento como **cerrado** en la interfaz.

### Consideraciones futuras

Aunque el sistema no generará alertas automáticas, se contempla añadir en el futuro una visualización destacada de aquellos tratamientos en curso que lleven más tiempo activos o que se aproximen a una revisión programada.

---

## 6. Gestión de formularios públicos

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

Con el fin de centralizar y simplificar la gestión de todas estas peticiones, se ha diseñado una estructura unificada que almacena los datos en una única tabla de base de datos, permitiendo su posterior tratamiento por parte del personal del refugio.

### Envío y confirmación visual

Los formularios estarán accesibles desde la interfaz pública de la web. Una vez completados y enviados, se mostrará un mensaje visual de confirmación (por ejemplo, un popup o un aviso en pantalla) para informar al usuario de que su solicitud ha sido registrada correctamente. No es necesario estar autenticado para enviar una solicitud.

### Almacenamiento unificado

Todas las solicitudes recibidas se almacenan en una tabla común bajo la entidad `Public_Form_Request`. Esta entidad incluye campos genéricos como nombre, correo electrónico y mensaje, así como campos específicos como el tipo de solicitud (`type`) o el identificador del animal si procede.

### Campos definidos

La estructura prevista de esta entidad es la siguiente:

- `id_request`: Clave primaria autogenerada.
- `type`: Tipo de formulario enviado (`adoption`, `foster`, `volunteer`, `contact`).
- `full_name`: Nombre completo del solicitante.
- `email`: Correo electrónico de contacto.
- `phone`: Número de teléfono (opcional).
- `message`: Cuerpo del mensaje o motivo de la solicitud.
- `animal_id`: ID del animal, si la solicitud está asociada a uno (por ejemplo, en adopciones).
- `status`: Estado de la solicitud (`pending`, `reviewed`, `accepted`, `rejected`).
- `admin_notes`: Campo interno para observaciones del equipo del refugio.
- `created_at` / `updated_at`: Fechas de creación y modificación, generadas automáticamente por Laravel.

### Gestión desde el panel de administración

Los administradores podrán acceder a un panel centralizado desde el cual visualizar todas las solicitudes recibidas. Esta interfaz permitirá:

- Filtrar por tipo (`adopción`, `acogida`, etc.), estado o fecha.
- Consultar el detalle completo de cada solicitud.
- Cambiar su estado y añadir observaciones internas.
- Formalizar la solicitud, en caso de aceptación, creando registros en otras entidades (`Adoptions`, `Foster`, `User`, etc.).

### Ventajas del enfoque

- **Centralización**: evita la necesidad de crear múltiples tablas para formularios similares.
- **Flexibilidad**: permite añadir fácilmente nuevos tipos de formularios en el futuro.
- **Trazabilidad**: todas las solicitudes quedan registradas y pueden consultarse en cualquier momento.
- **Integración**: las solicitudes aceptadas pueden transformarse en registros formales dentro del sistema (por ejemplo, generando automáticamente una entrada en la tabla `Foster` o `Adoptions`).

---

## 6. Gestión de formularios públicos

El sistema permite que cualquier persona, sin necesidad de estar registrada, pueda enviar solicitudes al refugio a través de formularios públicos disponibles en la web. Estas solicitudes pueden corresponder a distintos tipos: adopción, acogida, voluntariado o contacto general.

Con el fin de centralizar y simplificar la gestión de todas estas peticiones, se ha diseñado una estructura unificada que almacena los datos en una única tabla de base de datos, permitiendo su posterior tratamiento por parte del personal del refugio.

### Envío y confirmación visual

Los formularios estarán accesibles desde la interfaz pública de la web. Una vez completados y enviados, se mostrará un mensaje visual de confirmación (por ejemplo, un popup o un aviso en pantalla) para informar al usuario de que su solicitud ha sido registrada correctamente. No es necesario estar autenticado para enviar una solicitud.

### Almacenamiento unificado

Todas las solicitudes recibidas se almacenan en una tabla común bajo la entidad `Public_Form_Request`. Esta entidad incluye campos genéricos como nombre, correo electrónico y mensaje, así como campos específicos como el tipo de solicitud (`type`) o el identificador del animal si procede.

### Campos definidos

La estructura prevista de esta entidad es la siguiente:

- `id_request`: Clave primaria autogenerada.
- `type`: Tipo de formulario enviado (`adoption`, `foster`, `volunteer`, `contact`).
- `full_name`: Nombre completo del solicitante.
- `email`: Correo electrónico de contacto.
- `phone`: Número de teléfono (opcional).
- `message`: Cuerpo del mensaje o motivo de la solicitud.
- `animal_id`: ID del animal, si la solicitud está asociada a uno (por ejemplo, en adopciones).
- `status`: Estado de la solicitud (`pending`, `reviewed`, `accepted`, `rejected`).
- `admin_notes`: Campo interno para observaciones del equipo del refugio.
- `created_at` / `updated_at`: Fechas de creación y modificación, generadas automáticamente por Laravel.

### Gestión desde el panel de administración

Los administradores podrán acceder a un panel centralizado desde el cual visualizar todas las solicitudes recibidas. Esta interfaz permitirá:

- Filtrar por tipo (`adopción`, `acogida`, etc.), estado o fecha.
- Consultar el detalle completo de cada solicitud.
- Cambiar su estado y añadir observaciones internas.
- Formalizar la solicitud, en caso de aceptación, creando registros en otras entidades (`Adoptions`, `Foster`, `User`, etc.).

### Ventajas del enfoque

- **Centralización**: evita la necesidad de crear múltiples tablas para formularios similares.
- **Flexibilidad**: permite añadir fácilmente nuevos tipos de formularios en el futuro.
- **Trazabilidad**: todas las solicitudes quedan registradas y pueden consultarse en cualquier momento.
- **Integración**: las solicitudes aceptadas pueden transformarse en registros formales dentro del sistema (por ejemplo, generando automáticamente una entrada en la tabla `Foster` o `Adoptions`).

---

## 🛠 8. Panel de administración
- Acceso exclusivo por rol `admin`
- Vistas centralizadas para gestionar animales, usuarios y solicitudes
- Panel de estadísticas básicas (si aplica)

---

## 🔁 9. Reutilización de componentes y mejoras visuales
- Componentes Livewire reutilizables (tarjetas de animal, formularios, alertas...)
- Integración con Alpine.js para interacciones rápidas
- Aplicación progresiva de estilos (opcional: Tailwind CSS)

---

## 📌 10. Gestión de errores y validaciones
- Validaciones backend con Laravel
- Validaciones frontend con Livewire/Alpine
- Gestión de errores personalizados y redirecciones


---

## Mejoras implementadas respecto al diseño previsto

Durante el desarrollo del sistema, y aprovechando el tiempo disponible antes de la entrega, se han llevado a cabo algunas funcionalidades adicionales que no estaban contempladas dentro del desarrollo mínimo indispensable. Estas mejoras complementan y enriquecen la experiencia general de la aplicación sin alterar la estructura definida en la Fase 2.

A continuación se listan las funcionalidades extra implementadas:

- **Sistema de gestión de citas o visitas**: Permite a los usuarios solicitar una cita para conocer un animal o visitar el refugio. El panel de administración incluye una sección para gestionar dichas solicitudes.

- **Blog o sección de noticias**: Página principal donde se publican novedades del refugio, historias de adopción o eventos.

- **Historial público de adopciones realizadas**: Sección accesible desde el inicio con animales que ya han sido adoptados, incluyendo fecha y una breve historia si se desea.

- **Seguimiento de apadrinamientos activos**: Los usuarios padrinos pueden seguir el estado del animal apadrinado desde su perfil. Si el animal es adoptado, se les notifica para decidir si desean continuar colaborando.

- **Galería multimedia integrada**: Las fichas de los animales incluyen imágenes y vídeos adicionales para mejorar su presentación.

- **Sistema de seguimiento post-adopción**: Funcionalidad privada que permite al refugio contactar con los adoptantes y registrar información sobre la adaptación del animal.

- **Tienda solidaria (merchandising)**: Funcionalidad para ofrecer productos solidarios desde la web. La gestión de productos se realiza desde el panel de administración.

- **Panel de estadísticas para administración**: Sección visual con métricas relevantes como número de animales activos, adopciones realizadas, padrinos registrados, etc.

- **Integración con redes sociales (prevista)**: Se ha estructurado la plataforma para permitir, en futuras versiones, la vinculación con redes sociales (como Instagram o Facebook) para facilitar la difusión del contenido.

- **Sistema de donaciones puntuales y recurrentes**: Módulo para permitir donaciones económicas al refugio, tanto únicas como periódicas. Vinculado opcionalmente al sistema de apadrinamiento.

Estas funcionalidades, aunque no esenciales para el funcionamiento básico de la aplicación, aportan un gran valor añadido al sistema y enriquecen la experiencia de los usuarios y del personal del refugio.
