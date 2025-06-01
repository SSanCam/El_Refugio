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

| Campo        | Tipo de dato | Descripción |
|--------------|--------------|-------------|
| `id_user`    | int          | Clave primaria autogenerada por Laravel |
| `first_name` | string       | Nombre del usuario |
| `last_name`  | string       | Apellidos del usuario |
| `email`      | string       | Correo electrónico único |
| `alias`      | string/null  | Alias opcional del usuario |
| `password`   | string       | Contraseña cifrada |
| `role`       | string       | Rol del usuario: `admin`, `user` |
| `dni`        | string/null  | Documento de identidad |
| `phone`      | string/null  | Teléfono de contacto |
| `address`    | string/null  | Dirección del usuario |
| `status`     | string       | Estado adicional: `voluntario`, `adoptante`, etc. |
| `created_at` | timestamp    | Fecha de creación |
| `updated_at` | timestamp    | Fecha de modificación |

---

## **Entidad: Animal**

La entidad `Animal` almacena toda la información relacionada con los animales del refugio. Incluye datos básicos como el nombre, especie, raza, sexo y tamaño, así como detalles importantes como fecha de entrada, estado actual, peso y altura.

La relación con las imágenes se gestiona a través de la entidad `AnimalImage`. El estado de adopción se representa mediante el campo `status` y la relación con el adoptante se define mediante la entidad `Adoptions`.

**Campos principales:**

| Campo         | Tipo de dato | Descripción |
|---------------|--------------|-------------|
| `id_animal`   | int          | Clave primaria |
| `name`        | string       | Nombre del animal |
| `species`     | string       | Especie (perro, gato...) |
| `breed`       | string       | Raza |
| `sex`         | string       | Sexo |
| `size`        | string       | Tamaño estimado |
| `weight`      | float        | Peso en kg |
| `height`      | float        | Altura en cm |
| `birth_date`  | date         | Fecha de nacimiento (si se conoce) |
| `age`         | string/null  | Edad estimada (si no se conoce fecha exacta) |
| `status`      | string       | Estado: `en adopción`, `acogido`, `adoptado`, etc. |
| `entry_date`  | date         | Fecha de entrada al refugio |
| `microchip`   | string/null  | Número de microchip (si tiene) |
| `description` | text         | Descripción del animal |
| `observations`| text/null    | Observaciones internas |
| `created_at`  | timestamp    | Fecha de creación |
| `updated_at`  | timestamp    | Fecha de última modificación |

---

## **Entidad: AnimalImage**

La entidad `AnimalImage` gestiona la galería multimedia asociada a cada animal. Permite almacenar múltiples imágenes por animal y organizarlas según preferencia.

Se permite añadir múltiples imágenes por animal, visibles en su ficha pública.

**Campos principales:**

| Campo         | Tipo de dato | Descripción |
|---------------|--------------|-------------|
| `id`          | int          | Clave primaria |
| `animal_id`   | int          | Clave foránea hacia `Animal` |
| `path`        | string       | Ruta o nombre del archivo de imagen |
| `created_at`  | timestamp    | Fecha de subida |
| `updated_at`  | timestamp    | Fecha de modificación |

---

## **Entidad: Adoptions**

Gestiona el proceso de adopción. Relaciona a un usuario con un animal, incluyendo información como la fecha de adopción, estado y condiciones asociadas.

**Campos principales:**

| Campo              | Tipo de dato | Descripción |
|--------------------|--------------|-------------|
| `id_adoption`      | int          | Clave primaria |
| `id_animal`        | int          | Animal adoptado |
| `id_user`          | int          | Usuario adoptante |
| `adoption_date`    | date         | Fecha de adopción |
| `adoption_status`  | string       | Estado: `pending`, `completed`, `cancelled` |
| `adoption_conditions` | text/null | Condiciones asociadas |
| `created_at`       | timestamp    | Fecha de creación |
| `updated_at`       | timestamp    | Fecha de modificación |

---

## **Entidad: Foster**

Gestiona las acogidas temporales de animales. Almacena la información sobre el usuario que acoge y las fechas de acogida.

**Campos principales:**

| Campo         | Tipo de dato | Descripción |
|---------------|--------------|-------------|
| `id_foster`   | int          | Clave primaria |
| `id_animal`   | int          | Animal acogido |
| `id_user`     | int          | Usuario que acoge |
| `start_date`  | date         | Fecha de inicio |
| `end_date`    | date/null    | Fecha de finalización |
| `status`      | string       | Estado: `pending`, `fostering`, `finished` |
| `comments`    | text/null    | Comentarios adicionales |
| `created_at`  | timestamp    | Fecha de creación |
| `updated_at`  | timestamp    | Fecha de modificación |

---

## **Entidad: Volunteer_Request**

Almacena las solicitudes públicas de voluntariado.

Puede actualizar automáticamente el status del ``User`` a ``volunteer`` si se acepta la solicitud.

**Campos principales:**

| Campo         | Tipo de dato | Descripción |
|---------------|--------------|-------------|
| `id_request`  | int          | Clave primaria |
| `first_name`  | string       | Nombre del solicitante |
| `last_name`   | string       | Apellidos |
| `email`       | string       | Correo electrónico |
| `phone`       | string       | Teléfono (opcional) |
| `availability`| text         | Disponibilidad para colaborar |
| `motivation`  | text         | Motivación personal |
| `status`      | string       | Estado: `pending`, `reviewed`, `accepted`, etc. |
| `admin_notes` | text/null    | Notas internas |
| `created_at`  | timestamp    | Fecha de creación |
| `updated_at`  | timestamp    | Fecha de modificación |

---

## **Entidad: Sponsorship** *(en pruebas)*

Entidad destinada a gestionar apadrinamientos. Por el momento, se incluye para pruebas locales y como ampliación futura del sistema.

Actualmente se encuentra en fase de pruebas locales. Se prevé activarla de forma oficial cuando se implemente la gestión de pagos recurrentes.

**Campos principales:**

| Campo            | Tipo de dato | Descripción |
|------------------|--------------|-------------|
| `id_sponsorship` | int          | Clave primaria |
| `id_animal`      | int          | Animal apadrinado |
| `id_user`        | int          | Usuario padrino |
| `start_date`     | date         | Fecha de inicio del apadrinamiento |
| `end_date`       | date/null    | Fecha de finalización (si aplica) |
| `amount`         | decimal      | Cantidad donada |
| `status`         | string       | Estado: `active`, `cancelled`, etc. |
| `created_at`     | timestamp    | Fecha de creación |
| `updated_at`     | timestamp    | Fecha de modificación |


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
