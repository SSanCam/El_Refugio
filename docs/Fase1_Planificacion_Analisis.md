# Fase 1 - Analisis

Este documento corresponde a la primera fase del desarrollo del proyecto "El Refugio". Su objetivo es definir las bases funcionales y estructurales de la aplicación antes de iniciar su implementación técnica. Se analizarán los distintos tipos de usuarios, las funcionalidades clave, los primeros diseños de interfaz (wireframes), y un primer esbozo del modelo de datos.

## Convenciones de Nombres

En este proyecto se ha optado por utilizar una **nomenclatura en inglés** para todos los nombres de campos, tablas y variables en el código. Esta decisión tiene como objetivo hacer el proyecto más **accesible, escalable y compatible** con las mejores prácticas de desarrollo y facilitar la integración con herramientas y bibliotecas externas que comúnmente están en inglés. 

- **Nombres de campos y variables**: Se utilizará inglés para asegurar consistencia y facilitar la comprensión en entornos internacionales.
- **Descripción y comentarios**: Aunque los nombres de los campos y variables están en inglés, las **descripciones** y **comentarios** se mantendrán en **español** para adecuarse al contexto del proyecto, que se desarrollará y presentará en España.
- **Convenciones de nombres en las tablas**: Los campos de las tablas también seguirán esta regla, lo que mejorará la integridad y claridad del modelo de datos.

Este enfoque garantiza que el proyecto sea comprensible tanto para desarrolladores locales como internacionales, sin perder la especificidad que requiere el proyecto en su contexto actual.

---


## 1. Gestión de Usuarios y Accesos

En esta sección se identifican los distintos perfiles de usuario que interactuarán con la aplicación, así como sus roles y permisos. Esto permitirá establecer qué funcionalidades estarán disponibles para cada uno.

La entidad `User` representa a cualquier persona que interactúa con la plataforma web "El Refugio". Esta tabla unifica tanto a los usuarios registrados en la web como a los usuarios vinculados al refugio (adoptantes, acogedores, apadrinadores, voluntarios, etc.). La tabla `User` tiene la siguiente estructura:

- **Usuario general**: personas externas al refugio, interesadas en acoger, adoptar o apadrinar animales. También pueden enviar formularios de contacto o solicitar ser voluntarios. Su interacción está limitada a la parte pública de la plataforma o a funcionalidades específicas permitidas por su rol.

- **Administrador**: personal autorizado del refugio. Tiene acceso completo al panel de gestión de la aplicación, pudiendo realizar operaciones CRUD (crear, leer, actualizar y eliminar) sobre los usuarios registrados, animales, solicitudes de adopción, acogida y apadrinamiento. También puede gestionar los contenidos de la plataforma o cualquier funcionalidad que se añada posteriormente.

El sistema se encargará de restringir el acceso a ciertas áreas o acciones en función del rol del usuario autenticado. Esta distinción es fundamental para asegurar tanto la seguridad como el correcto funcionamiento interno de la aplicación.

Además de los usuarios registrados, la aplicación contempla un uso parcial sin necesidad de registro. Estos usuarios anónimos pueden acceder libremente a las siguientes funcionalidades públicas:

- Consultar el listado de animales disponibles para adopción o acogida.
- Leer información general sobre el refugio.
- Enviar formularios de contacto.
- Realizar donaciones económicas (sin necesidad de crear cuenta).

Estas interacciones no requieren un registro en el sistema, ya que no implican una gestión interna de datos personales persistentes ni el acceso a funcionalidades protegidas. Esta decisión busca facilitar la interacción y colaboración con el refugio sin imponer barreras innecesarias a usuarios puntuales o donantes ocasionales.

---

## 1.1. Gestión de formularios públicos

El sistema contempla distintos formularios accesibles desde la parte pública de la plataforma, sin necesidad de iniciar sesión. Cada uno de ellos responde a una finalidad concreta y permite a cualquier usuario interesarse o colaborar con el refugio de manera sencilla.

A continuación, se definen los tipos principales de formularios gestionados por el sistema:

| Formulario        | Descripción                                                                                       | Genera entidad         |
|-------------------|---------------------------------------------------------------------------------------------------|------------------------|
| **Adopción**       | Solicitud para adoptar un animal específico. Permite recoger información básica del adoptante.   | `Adoption_Request`     |
| **Acogida**        | Solicitud para ofrecerse como hogar temporal. Puede incluir disponibilidad y preferencias.        | `Foster_Request`       |
| **Voluntariado**   | Formulario para ofrecerse como voluntario del refugio. Incluye motivación y disponibilidad.       | `Volunteer_Request`    |
| **Contacto**       | Formulario de contacto general. Permite enviar mensajes o dudas al refugio sin crear cuenta.      | `Contact_Message`      |

Cada formulario se almacenará en su propia tabla en la base de datos, lo que facilita su gestión, validación y seguimiento desde el panel de administración. En el caso de usuarios registrados, ciertos campos (como nombre o email) se podrán omitir o rellenar automáticamente.

---

## 2. Funcionalidades principales

En esta sección se detallan las funcionalidades que debe ofrecer la aplicación web "El Refugio", tanto para los usuarios públicos como para aquellos registrados. Esta separación permite diferenciar claramente qué puede hacer cada tipo de usuario y establecer las bases para la implementación posterior.

### 🔓 Funcionalidades públicas (sin necesidad de registro)

- **Consultar animales disponibles:** cualquier persona puede visualizar el listado de animales que se encuentran en adopción o acogida, filtrando por especie, edad, raza o estado.
- **Ver detalles de un animal:** se podrá acceder a la ficha individual de cada animal con información más específica como comportamiento, salud, fotos o historia.
- **Formulario de contacto:** permite a los usuarios enviar mensajes o consultas generales al refugio sin necesidad de registrarse.
- **Realizar donaciones económicas:** se ofrecerá un apartado para colaborar económicamente con el refugio sin requerir una cuenta de usuario.
- **Información general del refugio:** acceso a secciones estáticas como misión, historia, ubicación, redes sociales o formas de colaborar.

---


### 🔐 Funcionalidades privadas (requieren cuenta registrada)

#### Para usuarios generales (rol: usuario)

- **Registrarse e iniciar sesión**: Sistema de autenticación para acceder a funcionalidades personalizadas.
- **Consultar el estado de sus solicitudes**: Visualizar el historial y estado actual de adopciones, acogidas y apadrinamientos asociados a su cuenta.
- **Recibir actualizaciones de animales apadrinados**: Notificaciones, seguimiento y contenido adicional vinculado al animal.
- **Actualizar su perfil**: Los usuarios podrán modificar sus datos personales y preferencias (acoger, apadrinar, ser voluntario, etc.).
- **Acceder a funcionalidades personalizadas**: Visualización de contenido adaptado al usuario autenticado.

#### Para administradores (rol: admin)

- **Gestión de animales (CRUD)**: Crear, editar, eliminar o actualizar fichas de animales en la base de datos.
- **Gestión de usuarios**: Ver, editar o eliminar usuarios registrados. Cambiar roles si es necesario.
- **Gestión de solicitudes**: Revisar, aprobar o rechazar solicitudes de adopción, acogida o apadrinamiento.
- **Panel de administración**: Acceso a un panel privado donde se centralizan todas las gestiones internas del refugio.
- **Gestión de contenido adicional**: Modificar textos de la web, datos de contacto o información general del refugio.

---


## 3. Wireframes iniciales

Los wireframes son bocetos que representan la estructura visual y de navegación de la aplicación. Aunque no definen el diseño final, sirven como base para imaginar el flujo de pantallas y la disposición de los elementos principales.

Aunque se cuenta con un primer boceto en Figma, se ha decidido posponer la elaboración definitiva de los wireframes hasta contar con una estructura funcional más consolidada del sistema. 

Dado que los wireframes representan la disposición visual de las pantallas y el flujo de navegación, es importante basarlos en un conjunto claro y validado de funcionalidades, entidades y relaciones. Esto evitará revisiones innecesarias y permitirá diseñar una experiencia de usuario más coherente y eficiente.

Los wireframes definitivos se desarrollarán en una fase posterior, una vez esté más avanzado el diseño técnico y funcional de la aplicación.

---

## 4. Modelo de Datos

Esta sección presenta las entidades que formarán parte de la base de datos del sistema, así como sus atributos principales y relaciones entre ellas. Es un primer paso hacia el diseño de la estructura lógica de la aplicación.

## **Entidad: User**

La entidad `User` representa a cualquier persona que interactúa con la plataforma "El Refugio". Esta tabla unifica tanto a los usuarios registrados en la web como a los usuarios vinculados al refugio (adoptantes, acogedores, apadrinadores, voluntarios, etc.). El sistema permitirá que el refugio complete los datos necesarios cuando se registre un usuario para procesos más formales como adopciones, acogidas, etc.

**Campos principales:**

| Campo            | Tipo de dato   | Descripción |
|------------------|----------------|-------------|
| `id_user`        | int            | Clave primaria autogenerada por Laravel |
| `first_name`     | string         | Nombre del usuario (opcional para registros web) |
| `last_name`      | string         | Apellidos del usuario (opcional para registros web) |
| `email`          | string         | Correo electrónico (único y obligatorio para todos los registros) |
| `alias`          | string/null    | Alias opcional del usuario (único si se introduce) |
| `password`       | string         | Contraseña cifrada (bcrypt) |
| `role`           | string         | Tipo de usuario: `admin`, `user` |
| `dni`            | string/null    | Documento Nacional de Identidad  |
| `phone`          | string/null    | Número de teléfono  |
| `address`        | string/null    | Dirección del usuario  |
| `status`         | string         | Roles adicionales como `adoptante`, `voluntario`, `acogedor`, etc. |
| `created_at`     | timestamp      | Fecha de creación del registro (autogenerado por Laravel) |
| `updated_at`     | timestamp      | Fecha de última modificación (autogenerado) |

---

##  **Entidad: Animal**

La entidad `Animal` almacena toda la información relacionada con los animales del refugio. Incluye datos básicos como el nombre, especie, raza, sexo y tamaño, pero también detalles importantes como la fecha de entrada al refugio, estado actual (en adopción, acogido, adoptado), y otras características físicas como el peso y la altura.

El campo `fecha_adopcion` se usará para marcar la adopción de un animal, mientras que el `dni_adoptante` permite vincularlo con la persona que ha adoptado el animal, aunque no esté registrada como usuario en el sistema. Además, el campo `microchip` proporciona una referencia única para identificar a cada animal, que puede ser consultada en caso de que se necesite.


| Field            | Data Type   | Description |
|------------------|-------------|-------------|
| `id_animal`             | int         | Clave primaria autogenerada por Laravel |
| `name`           | string      | Nombre del animal |
| `species`        | string      | Especie del animal (por ejemplo: perro, gato...) |
| `breed`          | string      | Raza del animal |
| `sex`            | string      | Sexo del animal (macho/hembra) |
| `size`           | string      | Tamaño estimado (pequeño, mediano, grande) |
| `weight`         | float       | Peso del animal en kilogramos (kg) |
| `height`         | float       | Altura del animal en centímetros (cm) |
| `birth_date`     | date        | Fecha de nacimiento del animal (si se conoce) |
| `age`            | string/null | Edad estimada, en caso de no conocer la fecha exacta de nacimiento |
| `status`         | string      | Estado actual del animal: en adopción, acogido, adoptado, etc. |
| `entry_date`     | date        | Fecha en la que el animal ingresó al refugio |
| `microchip`      | string/null | Código identificador del microchip (null si aún no tiene) |
| `description`    | text        | Descripción general del animal, carácter, historia, etc. |
| `observations`   | text/null   | Observaciones internas del personal (salud, seguimiento...) |
| `image`          | string/null | Ruta o nombre de archivo de la imagen del animal |
| `created_at`     | timestamp   | Fecha de creación del registro (autogenerado por Laravel) |
| `updated_at`     | timestamp   | Fecha de última modificación del registro (autogenerado) |


---


##  **Entidad: Veterinary_History**

La entidad `Veterinary_History` almacena el historial veterinario de cada animal en el refugio. Esta tabla recoge los eventos relacionados con la salud del animal, como vacunaciones, cirugías y otros tratamientos médicos específicos. Cada registro está vinculado a un animal a través del campo `id_animal` y puede contener una descripción detallada del tratamiento, la fecha en que se realizó y observaciones adicionales sobre el estado del animal.


| Field                | Data Type   | Description |
|----------------------|-------------|-------------|
| `id_history`         | int         | Clave primaria autogenerada por Laravel |
| `id_animal`          | int         | Identificador del animal (relacionado con la entidad `Animal`) |
| `microchip`          | string/null | Código del microchip del animal (si tiene) |
| `treatment_date`     | date        | Fecha en la que se registró el tratamiento o intervención |
| `treatment_description` | text     | Descripción detallada del tratamiento realizado (vacunación, cirugía, etc.) |
| `treatment_type`     | string      | Tipo de tratamiento (vacunación, cirugía, medicamento, etc.) |
| `observations`       | text/null   | Observaciones adicionales relacionadas con el tratamiento o estado del animal |
| `created_at`         | timestamp   | Fecha de creación del registro (autogenerado por Laravel) |
| `updated_at`         | timestamp   | Fecha de última modificación del registro (autogenerado) |

---

##  **Entidad: Animal_Medication**

La entidad `Animal_Medication` gestiona los tratamientos **continuos** que requieren los animales, tales como medicamentos diarios o periódicos. A través de esta tabla se puede hacer un seguimiento de los tratamientos a largo plazo que no son eventos puntuales, sino que deben ser administrados de manera regular, como en el caso de enfermedades crónicas o tratamientos preventivos.

Cada registro está vinculado a un animal mediante el campo `id_animal` y detalla el medicamento, la dosis y la frecuencia con la que debe administrarse. Además, incluye la fecha de inicio del tratamiento y, si corresponde, la fecha de finalización. Si el tratamiento está en curso, el campo `end_date` será nulo.

| Field               | Data Type   | Description |
|---------------------|-------------|-------------|
| `id_medication`     | int         | Clave primaria autogenerada por Laravel |
| `id_animal`         | int         | Identificador del animal (relacionado con la entidad `Animal`) |
| `medication_name`   | string      | Nombre del medicamento |
| `dosage`            | string      | Dosis del medicamento (por ejemplo: media pastilla) |
| `frequency`         | string      | Frecuencia de administración (por ejemplo: diaria) |
| `start_date`        | date        | Fecha en la que comenzó el tratamiento |
| `end_date`          | date/null   | Fecha en la que terminó el tratamiento (si aplica) |
| `description`       | text        | Descripción adicional o comentarios del tratamiento |
| `created_at`        | timestamp   | Fecha de creación del registro (autogenerado por Laravel) |
| `updated_at`        | timestamp   | Fecha de última modificación del registro (autogenerado) |


---


## **Entidad: Adoptions**

La entidad `Adoptions` gestiona el proceso de adopción de los animales en el refugio. Permite vincular a un adoptante con un animal adoptado, y almacenar información sobre la adopción, como la fecha, el estado y las condiciones acordadas.

Todos los adoptantes están representados mediante la entidad única `User`, independientemente de si tienen cuenta web o han sido registrados internamente por el refugio tras aceptar una solicitud enviada sin registro.

| Field                | Data Type   | Description |
|----------------------|-------------|-------------|
| `id_adoption`        | int         | Clave primaria autogenerada por Laravel |
| `id_animal`          | int         | Identificador del animal adoptado |
| `id_user`            | int         | Identificador del usuario que adopta (entidad `User`) |
| `adoption_date`      | date        | Fecha en que se formalizó la adopción |
| `adoption_status`    | string      | Estado de la adopción: `pending`, `completed`, `cancelled`, etc. |
| `adoption_conditions`| text/null   | Condiciones acordadas (por ejemplo, seguimiento post-adopción) |
| `created_at`         | timestamp   | Fecha de creación del registro |
| `updated_at`         | timestamp   | Fecha de última modificación del registro |


### Relación con `User`:
El campo `id_user` se relaciona con un registro de la entidad `User`, sin importar si fue creado mediante registro web o registrado internamente por el refugio tras aceptar una solicitud. De este modo, toda la gestión de usuarios queda centralizada y unificada.


---


## **Entidad: Foster**

La entidad `Foster` gestiona las acogidas temporales de los animales en el refugio. Permite a cualquier usuario, con o sin cuenta en la web, ofrecerse para acoger a un animal de manera temporal.

Si el animal es adoptado después de la acogida, el estado se actualizará en la entidad `Adoptions`. Además, las fechas de inicio y fin permiten gestionar el periodo de acogida de manera eficiente.

| Campo          | Tipo de dato   | Descripción |
|----------------|----------------|-------------|
| `id_foster`    | int            | Clave primaria autogenerada por Laravel |
| `id_animal`    | int            | Identificador del animal (relacionado con `Animal`) |
| `id_user`      | int            | Identificador del usuario (relacionado con `User`) |
| `start_date`   | date           | Fecha de inicio de la acogida |
| `end_date`     | date           | Fecha de finalización de la acogida (si aplica) |
| `status`       | string         | Estado: `pending`, `fostering`, `finished`, etc. |
| `comments`     | text/null      | Comentarios sobre el proceso de acogida |
| `created_at`   | timestamp      | Fecha de creación del registro |
| `updated_at`   | timestamp      | Fecha de última modificación |


**`id_user`**: Relaciona la acogida con el usuario que ofrece el hogar temporal. Este usuario pertenece a la entidad `User`, y puede haber sido creado desde un registro web o por el refugio tras aceptar la solicitud.


### **Flujos de trabajo**:

1. **Cambio de lugar de acogida**: Si el animal cambia de lugar de acogida, se generará un nuevo registro de acogida, mientras que el anterior se actualizará con una fecha de finalización y observaciones del cambio.
   
2. **Retorno al refugio**: Si el animal regresa al refugio, también se actualizará el registro de acogida con la fecha de finalización y se registrará en las observaciones.

3. **Adopción**: Si el animal es adoptado, se actualizará el estado en la entidad **`Animal`** y se creará un nuevo registro en **`Adoptions`**. Además, el registro de **Foster** se actualizará con la fecha de finalización.


---

### Entidades para los formularios

## **Entidad: Adoption_Request**

La entidad `Adoption_Request` almacena las solicitudes de adopción enviadas desde el formulario público. Puede ser rellenado por usuarios anónimos o registrados, y es gestionada desde el panel de administración.

**Campos principales:**

| Campo           | Tipo de dato   | Descripción |
|------------------|----------------|-------------|
| `id_request`     | INTEGER        | Clave primaria autogenerada por Laravel |
| `first_name`     | VARCHAR(100)   | Nombre del solicitante |
| `last_name`      | VARCHAR(100)   | Apellidos del solicitante |
| `email`          | VARCHAR(255)   | Correo electrónico |
| `phone`          | VARCHAR(20)    | Teléfono de contacto |
| `address`        | VARCHAR(255)   | Dirección del solicitante |
| `animal_name`    | VARCHAR(100)   | Nombre del animal deseado (si aplica) |
| `has_other_pets` | TEXT NULL      | Información sobre otras mascotas en casa (opcional) |
| `message`        | TEXT           | Motivo de la adopción o mensaje adicional |
| `status`         | VARCHAR(50)    | Estado de la solicitud (`pending`, `reviewed`, `accepted`, `rejected`) |
| `admin_notes`    | TEXT NULL      | Observaciones internas del personal |
| `created_at`     | TIMESTAMP      | Fecha de creación |
| `updated_at`     | TIMESTAMP      | Fecha de modificación |

- **`User`**: si el correo electrónico coincide con uno ya registrado, se vincula automáticamente.
- **`Animal`**: la búsqueda se realiza inicialmente por nombre, pero puede validarse contra el ID real durante la revisión.

### Flujo de trabajo:

1. **Envío del formulario**: el usuario completa la solicitud desde la web, sin necesidad de estar registrado.
2. **Registro automático**: la solicitud se guarda en la tabla `Adoption_Request` con estado `pending`.
3. **Revisión manual**: el personal del refugio revisa el formulario desde el panel de administración.
4. **Coincidencia por email**:
   - Si el email ya está vinculado a un `User`, se asocia automáticamente la solicitud.
   - Si no existe, se puede crear un nuevo usuario si la solicitud es aceptada.
5. **Conversión a adopción**: si se aprueba, se genera un nuevo registro en la tabla `Adoptions` y se actualiza el estado del animal y de la solicitud.
6. **Seguimiento posterior**: el registro de la solicitud queda archivado para trazabilidad futura, sin ser eliminado.

---

## **Entidad: Foster_Request**

La entidad `Foster_Request` almacena las solicitudes de acogida enviadas desde el formulario público. Puede ser rellenado por usuarios anónimos o registrados, y es gestionado desde el panel de administración.

**Campos principales:**

| Campo           | Tipo de dato   | Descripción |
|------------------|----------------|-------------|
| `id_request`     | INTEGER        | Clave primaria autogenerada por Laravel |
| `first_name`     | VARCHAR(100)   | Nombre del solicitante |
| `last_name`      | VARCHAR(100)   | Apellidos del solicitante |
| `email`          | VARCHAR(255)   | Correo electrónico |
| `phone`          | VARCHAR(20)    | Teléfono de contacto |
| `address`        | VARCHAR(255)   | Dirección del solicitante |
| `animal_name`    | VARCHAR(100)   | Nombre del animal deseado (si aplica) |
| `message`        | TEXT           | Motivo de la acogida o información adicional |
| `status`         | VARCHAR(50)    | Estado de la solicitud (`pending`, `reviewed`, `accepted`, `rejected`) |
| `admin_notes`    | TEXT NULL      | Observaciones internas del personal |
| `created_at`     | TIMESTAMP      | Fecha de creación |
| `updated_at`     | TIMESTAMP      | Fecha de modificación |

- **`User`**: si el correo electrónico coincide con uno ya registrado, se vincula automáticamente.
- **`Animal`**: la búsqueda se realiza inicialmente por nombre, pero puede validarse contra el ID real durante la revisión.

### Flujo de trabajo:

1. **Envío del formulario**: el usuario completa la solicitud desde la web, sin necesidad de estar registrado.
2. **Registro automático**: la solicitud se guarda en la tabla `Foster_Request` con estado `pending`.
3. **Revisión manual**: el personal del refugio revisa el formulario desde el panel de administración.
4. **Coincidencia por email**:
   - Si el email ya está vinculado a un `User`, se asocia automáticamente la solicitud.
   - Si no existe, se puede crear un nuevo usuario si la solicitud es aceptada.
5. **Conversión a acogida**: si se aprueba, se genera un nuevo registro en la tabla `Foster` y se actualiza el estado del animal y de la solicitud.
6. **Seguimiento posterior**: el registro de la solicitud queda archivado para trazabilidad futura, sin ser eliminado.

---

## **Entidad: Volunteer_Request**

La entidad `Volunteer_Request` almacena las solicitudes de voluntariado enviadas desde el formulario público. Puede ser rellenado por usuarios anónimos o registrados, y es gestionado desde el panel de administración.

**Campos principales:**

| Campo           | Tipo de dato   | Descripción |
|------------------|----------------|-------------|
| `id_request`     | INTEGER        | Clave primaria autogenerada por Laravel |
| `first_name`     | VARCHAR(100)   | Nombre del solicitante |
| `last_name`      | VARCHAR(100)   | Apellidos del solicitante |
| `email`          | VARCHAR(255)   | Correo electrónico |
| `phone`          | VARCHAR(20)    | Teléfono de contacto |
| `availability`   | TEXT           | Días y horarios disponibles para colaborar |
| `motivation`     | TEXT           | Motivo o interés para colaborar como voluntario |
| `status`         | VARCHAR(50)    | Estado de la solicitud (`pending`, `reviewed`, `accepted`, `rejected`) |
| `admin_notes`    | TEXT NULL      | Observaciones internas del personal |
| `created_at`     | TIMESTAMP      | Fecha de creación |
| `updated_at`     | TIMESTAMP      | Fecha de modificación |

- **`User`**: si el correo electrónico coincide con uno ya registrado, se vincula automáticamente a la solicitud.

### Flujo de trabajo:

1. **Envío del formulario**: el usuario completa el formulario de voluntariado desde la web sin necesidad de registrarse.
2. **Registro automático**: se guarda la solicitud con estado `pending` en la tabla `Volunteer_Request`.
3. **Revisión administrativa**: el personal del refugio evalúa la solicitud desde el panel de administración.
4. **Asociación por email**:
   - Si el email ya está vinculado a un `User`, se establece la relación.
   - Si no existe, se puede crear un nuevo usuario si la solicitud es aceptada.
5. **Aceptación y seguimiento**:
   - Al aceptarse, puede actualizarse el `status` del `User` a `volunteer`.
   - La solicitud queda registrada como parte del historial del sistema.

---

## **Entidad: Contact_Message**

La entidad `Contact_Message` almacena los mensajes enviados a través del formulario de contacto general de la web. Está disponible para cualquier persona, registrada o no, que desee realizar una consulta, comentario o sugerencia al refugio.

**Campos principales:**

| Campo           | Tipo de dato   | Descripción |
|------------------|----------------|-------------|
| `id_message`     | INTEGER        | Clave primaria autogenerada por Laravel |
| `first_name`     | VARCHAR(100)   | Nombre del remitente |
| `last_name`      | VARCHAR(100)   | Apellidos del remitente |
| `email`          | VARCHAR(255)   | Correo electrónico de contacto |
| `phone`          | VARCHAR(20)    | Teléfono de contacto (opcional) |
| `subject`        | VARCHAR(150)   | Asunto del mensaje |
| `message`        | TEXT           | Contenido completo del mensaje |
| `status`         | VARCHAR(50)    | Estado de la solicitud (`pending`, `reviewed`, `archived`) |
| `admin_notes`    | TEXT NULL      | Observaciones internas del personal |
| `created_at`     | TIMESTAMP      | Fecha de creación |
| `updated_at`     | TIMESTAMP      | Fecha de modificación |

**Relaciones con otras entidades:**

- **`User`**: si el correo electrónico coincide con uno ya registrado, se vincula automáticamente mediante `user_id`. En caso de que el usuario esté autenticado en el momento del envío, los campos de nombre y correo se rellenan automáticamente y se establece la relación directa.

### Flujo de trabajo:

1. **Envío del formulario**: el usuario accede al formulario de contacto sin necesidad de registrarse.
2. **Registro automático**: el mensaje se guarda en la base de datos con estado `pending`.
3. **Gestión interna**: el personal del refugio visualiza los mensajes desde el panel de administración y puede marcar su estado como `reviewed` o `archived`.
4. **Seguimiento opcional**: si el mensaje requiere respuesta o acción adicional, se puede añadir una nota interna para documentación o seguimiento posterior.

---

## 5. Observaciones / Ideas adicionales

Aunque el objetivo principal es desarrollar una aplicación web funcional y práctica para la gestión interna del refugio, se contemplan mejoras y funcionalidades adicionales que pueden incorporarse según el tiempo disponible durante el desarrollo o como ampliaciones futuras. Algunas de ellas se consideran especialmente valiosas y están previstas para su implementación si la planificación lo permite:

- ✅ **Sistema de gestión de citas o visitas:** permitir que los usuarios interesados puedan solicitar una cita para visitar el refugio o conocer a un animal concreto. Los administradores podrán gestionar estas solicitudes desde el panel interno.

- ✅ **Blog o sección de noticias:** será la página de inicio o landing page de la plataforma, donde se publicarán actualizaciones del refugio, historias de adopción, actividades realizadas y otra información de interés.

- ✅ **Historial público de adopciones realizadas:** se mostrará una sección accesible desde la página principal con los animales que han encontrado hogar. Puede actualizarse automáticamente o incluir una descripción personalizada por parte del personal.

- ✅ **Seguimiento de apadrinamientos activos:** en el perfil del usuario padrino se podrá gestionar su relación con el animal apadrinado. Si el animal es adoptado, se notificará al padrino para que decida si desea continuar colaborando o finalizar su aportación.

- ✅ **Galería multimedia integrada:** cada ficha de animal incluirá fotos y vídeos representativos. No se plantea una galería general, sino contenido enriquecido dentro del perfil de cada animal.

- ✅ **Sistema de seguimiento post-adopción:** se considera incorporar una funcionalidad privada y bidireccional entre el adoptante y el refugio para dar seguimiento al bienestar del animal. Esta función quedará como concepto en esta fase.

- 🔜 **Tienda solidaria (merchandising):** posible incorporación futura donde se puedan vender productos para ayudar económicamente al refugio.

- ✅ **Panel de estadísticas para administración:** incluir indicadores clave como número de adopciones, acogidas activas, padrinos registrados, etc., accesible solo desde el panel de administración.

- 🔜 **Integración con redes sociales (Instagram/Facebook):** permitir que las publicaciones realizadas por los administradores (por ejemplo, al subir un nuevo animal en adopción) se compartan automáticamente en redes sociales del refugio. Esto ayudaría a ampliar el alcance y la visibilidad sin necesidad de duplicar contenido manualmente.

Estas funcionalidades no forman parte obligatoria del desarrollo inicial, pero se contemplan como escalables, realistas y de gran valor añadido para la plataforma y su comunidad.

- 🔜 **Sistema de donaciones puntuales:** se considerará la incorporación de un sistema para gestionar donaciones puntuales realizadas por los usuarios al refugio. Esto permitirá a los donantes realizar contribuciones únicas, sin necesidad de registros recurrentes. Esta funcionalidad será implementada en una fase futura, a medida que se consolide el sistema de pagos.

- 🔜 **Sistema de donaciones recurrentes (apadrinamiento):** se considera implementar un sistema de donaciones recurrentes para apadrinamientos. Esto permitirá a los usuarios realizar donaciones periódicas a los animales del refugio, asociando cada apadrinamiento a un animal específico. El sistema notificará al usuario si el animal es adoptado y cancelará automáticamente la donación recurrente. Esta funcionalidad será implementada en una fase futura, ya que involucra la integración de un sistema de pagos seguro y su gestión.
