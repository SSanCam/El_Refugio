# Fase 1 - Analisis

Este documento corresponde a la primera fase del desarrollo del proyecto "El Refugio". Su objetivo es definir las bases funcionales y estructurales de la aplicación antes de iniciar su implementación técnica. Se analizarán los distintos tipos de usuarios, las funcionalidades clave, los primeros diseños de interfaz (wireframes), y un primer esbozo del modelo de datos.

## Convenciones de Nombres

En este proyecto se ha optado por utilizar una **nomenclatura en inglés** para todos los nombres de campos, tablas y variables en el código. Esta decisión tiene como objetivo hacer el proyecto más **accesible, escalable y compatible** con las mejores prácticas de desarrollo y facilitar la integración con herramientas y bibliotecas externas que comúnmente están en inglés. 

- **Nombres de campos y variables**: Se utilizará inglés para asegurar consistencia y facilitar la comprensión en entornos internacionales.
- **Descripción y comentarios**: Aunque los nombres de los campos y variables están en inglés, las **descripciones** y **comentarios** se mantendrán en **español** para adecuarse al contexto del proyecto, que se desarrollará y presentará en España.
- **Convenciones de nombres en las tablas**: Los campos de las tablas también seguirán esta regla, lo que mejorará la integridad y claridad del modelo de datos.

Este enfoque garantiza que el proyecto sea comprensible tanto para desarrolladores locales como internacionales, sin perder la especificidad que requiere el proyecto en su contexto actual.

<br>


## 1. Gestión de Usuarios y Accesos

En esta sección se identifican los distintos perfiles de usuario que interactuarán con la aplicación, así como sus roles y permisos. Esto permitirá establecer qué funcionalidades estarán disponibles para cada uno.

La entidad `Usuario` representa a cualquier persona que interactúa con la plataforma web "El Refugio", ya sea de forma pública o mediante autenticación con una cuenta registrada. Existen dos tipos de usuario definidos en el sistema, diferenciados por el valor del campo `rol`:

- **Usuario general**: personas externas al refugio, interesadas en acoger, adoptar o apadrinar animales. También pueden enviar formularios de contacto o solicitar ser voluntarios. Su interacción está limitada a la parte pública de la plataforma o a funcionalidades específicas permitidas por su rol.
- **Administrador**: personal autorizado del refugio. Tiene acceso completo al panel de gestión de la aplicación, pudiendo realizar operaciones CRUD (crear, leer, actualizar y eliminar) sobre los usuarios registrados, animales, solicitudes de adopción, acogida y apadrinamiento. También puede gestionar los contenidos de la plataforma o cualquier funcionalidad que se añada posteriormente.

El sistema se encargará de restringir el acceso a ciertas áreas o acciones en función del rol del usuario autenticado. Esta distinción es fundamental para asegurar tanto la seguridad como el correcto funcionamiento interno de la aplicación.

Además de los usuarios registrados, la aplicación contempla un uso parcial sin necesidad de registro. Estos usuarios anónimos pueden acceder libremente a las siguientes funcionalidades públicas:

- Consultar el listado de animales disponibles para adopción o acogida.
- Leer información general sobre el refugio.
- Enviar formularios de contacto.
- Realizar donaciones económicas (sin necesidad de crear cuenta).

Estas interacciones no requieren un registro en el sistema, ya que no implican una gestión interna de datos personales persistentes ni el acceso a funcionalidades protegidas. Esta decisión busca facilitar la interacción y colaboración con el refugio sin imponer barreras innecesarias a usuarios puntuales o donantes ocasionales.

<br>


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

- **Registrarse e iniciar sesión:** sistema de autenticación para acceder a funcionalidades personalizadas.

- **Solicitar adopción de un animal:** formulario para enviar una solicitud de adopción, asociado al usuario autenticado.

- **Solicitar acogida temporal:** los usuarios pueden ofrecerse como casa de acogida para uno o más animales.

- **Apadrinar un animal:** funcionalidad para elegir un animal y comprometerse a una ayuda económica periódica o puntual.

- **Actualizar su perfil:** los usuarios podrán modificar sus datos personales o cambiar sus preferencias (acoger, apadrinar, ser voluntario, etc.).

#### Para administradores (rol: admin)

- **Gestión de animales (CRUD):** crear, editar, eliminar o actualizar fichas de animales en la base de datos.

- **Gestión de usuarios:** ver, editar o eliminar usuarios registrados. Cambiar roles si es necesario.

- **Gestión de solicitudes:** revisar, aprobar o rechazar solicitudes de adopción, acogida o apadrinamiento.

- **Panel de administración:** acceso a un panel privado donde se centralizan todas las gestiones internas del refugio.

- **Gestión de contenido adicional:** modificar textos de la web, datos de contacto o información general del refugio.

<br>


## 3. Wireframes iniciales

Los wireframes son bocetos que representan la estructura visual y de navegación de la aplicación. Aunque no definen el diseño final, sirven como base para imaginar el flujo de pantallas y la disposición de los elementos principales.


Aunque se cuenta con un primer boceto en Figma, se ha decidido posponer la elaboración definitiva de los wireframes hasta contar con una estructura funcional más consolidada del sistema. 

Dado que los wireframes representan la disposición visual de las pantallas y el flujo de navegación, es importante basarlos en un conjunto claro y validado de funcionalidades, entidades y relaciones. Esto evitará revisiones innecesarias y permitirá diseñar una experiencia de usuario más coherente y eficiente.

Los wireframes definitivos se desarrollarán en una fase posterior, una vez esté más avanzado el diseño técnico y funcional de la aplicación.

<br>

## 4. Modelo de Datos

Esta sección presenta las entidades que formarán parte de la base de datos del sistema, así como sus atributos principales y relaciones entre ellas. Es un primer paso hacia el diseño de la estructura lógica de la aplicación.

## **Entidad: Web_User**

La entidad `Web_User` representa a cualquier persona registrada en la plataforma web "El Refugio". Estos usuarios tienen la capacidad de gestionar su perfil, acceder a funciones personalizadas y realizar interacciones como apadrinar un animal, ofrecerse para ser voluntarios o acogedores. Los campos como `foster`, `volunteer`, y `sponsor` no se incluyen en esta entidad, ya que serán gestionados a través de la entidad `Camp_User` si el usuario decide interactuar con el refugio en esas áreas.

Esta entidad se utiliza únicamente para la autenticación y el acceso a las funcionalidades que le correspondan según su rol en la plataforma.

| Campo          | Tipo de dato | Descripción |
|----------------|--------------|-------------|
| `id_user`      | int          | Clave primaria autogenerada por Laravel |
| `first_name`   | string       | Nombre de pila del usuario |
| `last_name`    | string       | Apellidos del usuario |
| `email`        | string       | Correo electrónico (único) |
| `password`     | string       | Contraseña cifrada (bcrypt) |
| `role`         | string       | Tipo de usuario: `admin`, `volunteer`, `user`, etc. Por defecto será `user` |
| `created_at`   | timestamp    | Fecha de creación del registro (autogenerado) |
| `updated_at`   | timestamp    | Fecha de última modificación (autogenerado) |

---

## **Entidad: Camp_User**

La entidad `Camp_User` representa a cualquier persona relacionada con el refugio que no necesariamente esté registrada en la plataforma web. Esta entidad incluye personas que pueden estar relacionadas con el refugio para funciones como adopciones, acogidas temporales o voluntariado, y cuya información no requiere una cuenta en la web de la aplicación. Los datos de contacto de estas personas se registran para fines administrativos internos del refugio.

La principal diferencia con la entidad `Web_User` es que los `Camp_User` no interactúan directamente con la web, pero sus datos se registran para poder asociarlos a una adopción, acogida, o apadrinamiento, por ejemplo. Estos usuarios no tienen necesidad de autenticarse a través de la plataforma web, pero el refugio necesita almacenarlos para gestión interna.

| Campo            | Tipo de dato   | Descripción |
|------------------|----------------|-------------|
| `id_user`        | int            | Clave primaria autogenerada por Laravel |
| `first_name`     | string         | Nombre del usuario |
| `last_name`      | string         | Apellidos del usuario |
| `dni`            | string         | Documento nacional de identidad (único) |
| `phone`          | string         | Número de teléfono de contacto |
| `address`        | string         | Dirección de residencia del usuario |
| `role`           | string         | Tipo de usuario: `adopter`, `foster`, `volunteer`, etc. |
| `adopted_animal` | string/null    | ID del animal adoptado (si aplica) |
| `foster`         | boolean/null   | Indica si el usuario está interesado en acoger animales |
| `volunteer`      | boolean/null   | Indica si el usuario desea ser voluntario/a |
| `sponsor`        | boolean/null   | Indica si el usuario desea apadrinar animales |
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

La entidad `Adoptions` gestiona el proceso de adopción de los animales en el refugio. Permite vincular a un adoptante (ya sea registrado en la plataforma web o no) con un animal adoptado, y almacenar información sobre la adopción, como la fecha de adopción, el estado de la adopción y las condiciones acordadas para la adopción.

Cada adopción está relacionada con un **`Camp_User`**, que puede ser un usuario registrado en la web o un usuario no registrado. En el caso de que el adoptante esté registrado en la web, se buscará en la tabla **`Web_User`** por el **DNI**, y si existe, se creará un nuevo registro en **`Camp_User`**.

| Field                | Data Type   | Description |
|----------------------|-------------|-------------|
| `id_adoption`        | int         | Primary key, auto-generated by Laravel |
| `id_animal`          | int         | Identifier for the adopted animal (related to the `Animal` entity) |
| `id_user`            | int         | Identifier for the adopter (related to the `Camp_User` entity) |
| `adoption_date`      | date        | Date when the adoption was formalized |
| `adopter_dni`        | string      | National ID of the adopter (used if adopter is not registered in the web platform) |
| `adoption_status`    | string      | Status of the adoption: `pending`, `completed`, `cancelled`, etc. |
| `adoption_conditions`| text/null   | Additional conditions agreed upon for the adoption (e.g., post-adoption follow-up) |
| `created_at`         | timestamp   | Record creation date |
| `updated_at`         | timestamp   | Last modification date |

### **Relación con `Camp_User`**:
El **`id_user`** en **`Adoptions`** siempre hace referencia a un **`id_user`** de **`Camp_User`**. Si el adoptante está registrado en la web, se buscará su **DNI** en la tabla **`Web_User`** y, si se encuentra, se copiará su información en **`Camp_User`** para asociarlo a la adopción. Si el adoptante no está registrado, se creará un nuevo registro en **`Camp_User`** con los datos del adoptante.


---


## **Entidad: Foster**

La entidad `Foster` gestiona las acogidas temporales de los animales en el refugio. Permite a los usuarios ofrecerse para acoger a un animal de manera temporal para comprobar la viabilidad de una adopción. 

Cada acogida está vinculada a un animal y a un usuario. Si el animal es adoptado después de la acogida, el estado se actualizará en la entidad **Adoptions**. Además, las fechas de inicio y fin permiten gestionar el periodo de acogida de manera eficiente.

| Campo          | Tipo de dato   | Descripción |
|----------------|----------------|-------------|
| `id_foster`    | int            | Clave primaria autogenerada por Laravel |
| `id_animal`    | int            | Identificador del animal (relacionado con la entidad `Animal`) |
| `id_user`      | int            | Identificador del usuario (relacionado con la entidad `Camp_User`) |
| `start_date`   | date           | Fecha de inicio de la acogida |
| `end_date`     | date           | Fecha de finalización de la acogida, si corresponde |
| `status`       | string         | Estado de la acogida: `pending` o `fostering` (pendiente de adopción o acogida) |
| `comments`     | text/null      | Comentarios o notas relacionadas con el estado del animal en acogida (como cambio de lugar o vuelta al refugio) |
| `created_at`   | timestamp      | Fecha de creación del registro |
| `updated_at`   | timestamp      | Fecha de última modificación del registro |

### **Relaciones con `Animal` y `Camp_User`**:
- **`id_animal`**: Relaciona la acogida con un animal específico.
- **`id_user`**: Relaciona la acogida con el usuario que ofrece el hogar temporal. **Se registra en `Camp_User`**, ya que no es necesario que esté registrado en la web.

### **Flujos de trabajo**:
1. **Cambio de lugar de acogida**: Si el animal cambia de lugar de acogida, se generará un nuevo registro de acogida, mientras que el anterior se actualizará con una fecha de finalización y observaciones del cambio.
   
2. **Retorno al refugio**: Si el animal regresa al refugio, también se actualizará el registro de acogida con la fecha de finalización y se registrará en las observaciones.

3. **Adopción**: Si el animal es adoptado, se actualizará el estado en la entidad **`Animal`** y se creará un nuevo registro en **`Adoptions`**. Además, el registro de **Foster** se actualizará con la fecha de finalización.


---


<br>

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
