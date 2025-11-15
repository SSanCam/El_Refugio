# Fase 1 - Planificación y Análisis

Este documento corresponde a la primera fase del desarrollo del proyecto "El Refugio". Su objetivo es definir las bases funcionales y estructurales de la aplicación antes de iniciar su implementación técnica. Se analizarán los distintos tipos de usuarios, las funcionalidades clave, los primeros diseños de interfaz (wireframes), y un primer esbozo del modelo de datos.

Los resultados de esta fase servirán como base para el diseño técnico y el desarrollo posterior del sistema.

## Convenciones de Nombres

En este proyecto se ha optado por utilizar una **nomenclatura en inglés** para todos los nombres de campos, tablas y variables en el código. Esta decisión tiene como objetivo hacer el proyecto más **accesible, escalable y compatible** con las mejores prácticas de desarrollo y facilitar la integración con herramientas y bibliotecas externas que comúnmente están en inglés. 

- **Nombres de campos y variables**: Se utilizará inglés para asegurar consistencia y facilitar la comprensión en entornos internacionales.
- **Descripción y comentarios**: Aunque los nombres de los campos y variables están en inglés, las **descripciones** y **comentarios** se mantendrán en **español** para adecuarse al contexto del proyecto, que se desarrollará y presentará en España.
- **Convenciones de nombres en las tablas**: Los campos de las tablas también seguirán esta regla, lo que mejorará la integridad y claridad del modelo de datos.

Este enfoque garantiza que el proyecto sea comprensible tanto para desarrolladores locales como internacionales, sin perder la especificidad que requiere el proyecto en su contexto actual. Además éstas convenciones se aplicarán de manera uniforme a lo largo de todas las fases del proyecto, desde el modelado de datos hasta la implementación del código.

---

## 1. Gestión de Usuarios y Accesos

En esta sección se identifican los distintos perfiles de usuario que interactuarán con la aplicación, así como sus roles y permisos. Esto permitirá establecer qué funcionalidades estarán disponibles para cada uno.

La entidad `User` representa a cualquier persona que interactúa con la plataforma web "El Refugio". Esta tabla unifica tanto a los usuarios registrados en la web como a los usuarios públicos y aquellos vinculados al refugio (trabajadores/voluntarios). La tabla `User` tiene la siguiente estructura:

- **Usuario general**: personas externas al refugio, interesadas en acoger, adoptar o apadrinar animales. También pueden enviar formularios de contacto o solicitudes. Su interacción está limitada a la parte pública de la plataforma o a funcionalidades específicas permitidas por su rol.

- **Administrador**: personal autorizado del refugio. Tiene acceso completo al panel de gestión de la aplicación, pudiendo realizar operaciones CRUD (crear, leer, actualizar y eliminar) sobre los usuarios registrados, animales y solicitudes. También puede gestionar los contenidos de la plataforma o cualquier funcionalidad que se añada posteriormente.

El sistema se encargará de restringir el acceso a ciertas áreas o acciones en función del rol del usuario autenticado. Esta distinción es fundamental para asegurar tanto la seguridad como el correcto funcionamiento interno de la aplicación.

Además de los usuarios registrados, la aplicación contempla un uso parcial sin necesidad de registro. Estos usuarios anónimos pueden acceder libremente a las siguientes funcionalidades públicas:

- Consultar el listado de animales disponibles para adopción o acogida.
- Leer información general sobre el refugio.
- Enviar formularios de contacto.

Estas interacciones no requieren un registro en el sistema, ya que no implican una gestión interna de datos personales persistentes ni el acceso a funcionalidades protegidas. Esta decisión busca facilitar la interacción y colaboración con el refugio sin imponer barreras innecesarias a usuarios puntuales.

---

## 2. Funcionalidades principales

En esta sección se detallan las funcionalidades que debe ofrecer la aplicación web "El Refugio", tanto para los usuarios públicos como para aquellos registrados. Esta separación permite diferenciar claramente qué puede hacer cada tipo de usuario y establecer las bases para la implementación posterior.

### 🔓 Funcionalidades públicas (sin necesidad de registro)

- **Consultar animales disponibles:** cualquier persona puede visualizar el listado de animales que se encuentran en adopción o acogida, filtrando por especie, edad, raza o estado.
    >Se consideran disponibles aquellos con status = sheltered o fostered
- **Ver detalles de un animal:** se podrá acceder a la ficha individual de cada animal con información más específica como comportamiento, salud, fotos o historia.
- **Formulario de contacto:** permite a los usuarios enviar mensajes o consultas generales al refugio sin necesidad de registrarse.
- **Información general del refugio:** acceso a secciones estáticas como misión, historia, ubicación, redes sociales o formas de colaborar.

---

### 🔐 Funcionalidades privadas (requieren cuenta registrada)

#### Para usuarios generales (rol: usuario)

- **Registrarse e iniciar sesión**: Sistema de autenticación para acceder a funcionalidades personalizadas.
- **Actualizar su perfil**: Los usuarios podrán modificar sus datos personales y preferencias.

```
Todas las solicitudes se envían por correo, para que el refugio las gestione manualmente.
Las adopciones o acogidas se cierran presencialmente en el refugio, donde se realiza la firma del contrato y la entrega oficial del animal.
Este procedimiento sigue las prácticas habituales del sector y garantiza que la documentación se complete correctamente antes del cierre del expediente.
``` 
#### Para administradores (rol: admin)

- **Gestión de animales (CRUD)**: Crear, editar, eliminar o actualizar fichas de animales en la base de datos.
- **Gestión de usuarios**: Ver, editar o eliminar usuarios registrados. Cambiar roles si es necesario.
- **Gestión de solicitudes**: Revisar, aprobar o rechazar solicitudes (vía correo y cambio manual de estado del animal).
- **Panel de administración**: Acceso a un panel privado donde se centralizan todas las gestiones internas del refugio.
- **Gestión de contenido adicional**: Modificar textos de la web, datos de contacto o información general del refugio.


Las funcionalidades descritas anteriormente constituyen el alcance mínimo viable (MVP) del proyecto, garantizando una gestión interna completa del refugio, y una interfaz pública accesible para los usuarios externos.

A continuación se muestra el diagrama de flujo general de la aplicación, que representa las acciones disponibles para cada tipo de usuario (público, registrado y administrativo) y la secuencia de interacción entre ellas.

![Diagrama de flujo general](../Diagramas/Diagrama_de_flujo.svg)

### Funcionalidades futuras y ampliaciones propuestas

Aunque el objetivo principal es desarrollar una aplicación web funcional y práctica para la gestión interna del refugio, se contemplan mejoras y funcionalidades adicionales que pueden incorporarse según el tiempo disponible durante el desarrollo o como ampliaciones futuras. Algunas de ellas se consideran especialmente valiosas y están previstas para su implementación si la planificación lo permite:

- **Sistema de gestión de visitas:** permitir que los usuarios interesados puedan solicitar una cita para visitar el refugio o conocer a un animal concreto. Los administradores podrán gestionar estas solicitudes desde el panel interno.

- **Sistema de gestión de voluntariado:** Permite a usuarios interesados (registrados o no) enviar una solicitud a través de un formulario para ejercer un voluntariado en el refugio (limpieza, mantenimiento, reparaciones, etc.)

- **Blog o sección de noticias:** será la página de inicio o landing page de la plataforma, donde se publicarán actualizaciones del refugio, historias de adopción, actividades realizadas y otra información de interés.

- **Historial público de adopciones realizadas:** se mostrará una sección accesible desde la página principal con los animales que han encontrado hogar. Puede actualizarse automáticamente o incluir una descripción personalizada por parte del personal.

- **Seguimiento de apadrinamientos activos:** en el perfil del usuario padrino se podrá gestionar su relación con el animal apadrinado. Si el animal es adoptado, se notificará al padrino para que decida si desea continuar colaborando o finalizar su aportación.

- **Galería multimedia integrada:** cada ficha de animal incluirá fotos y vídeos representativos. No se plantea una galería general, sino contenido enriquecido dentro del perfil de cada animal.

- **Sistema de seguimiento post-adopción:** se considera incorporar una funcionalidad privada y bidireccional entre el adoptante y el refugio para dar seguimiento al bienestar del animal. Esta función quedará como concepto en esta fase.

- **Tienda solidaria (merchandising):** posible incorporación futura donde se puedan vender productos para ayudar económicamente al refugio.

- **Panel de estadísticas para administración:** incluir indicadores clave como número de adopciones, acogidas activas, padrinos registrados, etc., accesible solo desde el panel de administración.

- **Integración con redes sociales (Instagram/Facebook):** permitir que las publicaciones realizadas por los administradores (por ejemplo, al subir un nuevo animal en adopción) se compartan automáticamente en redes sociales del refugio. Esto ayudaría a ampliar el alcance y la visibilidad sin necesidad de duplicar contenido manualmente.

- **Sistema de donaciones puntuales:** se considerará la incorporación de un sistema para gestionar donaciones puntuales realizadas por los usuarios al refugio. Esto permitirá a los donantes realizar contribuciones únicas, sin necesidad de registros recurrentes. Esta funcionalidad será implementada en una fase futura, a medida que se consolide el sistema de pagos.

- **Sistema de donaciones recurrentes (apadrinamiento):** se considera implementar un sistema de donaciones recurrentes para apadrinamientos. Esto permitirá a los usuarios realizar donaciones periódicas a los animales del refugio, asociando cada apadrinamiento a un animal específico. El sistema notificará al usuario si el animal es adoptado y cancelará automáticamente la donación recurrente. Esta funcionalidad será implementada en una fase futura, ya que involucra la integración de un sistema de pagos seguro y su gestión.


A continuación se presentan los diagramas que representan las interacciones y flujos de la aplicación.

![Diagrama UML](../Diagramas/UML.svg)
---

## 3. Modelo de Datos 

El modelo está diseñado para una base de datos **relacional MySQL**, gestionada mediante **migraciones de Laravel**, y sigue las **convenciones de nomenclatura en inglés** definidas previamente.

A continuación se muestra el modelo conceptual de datos, donde se representan las principales entidades del sistema y las relaciones entre ellas.

![Modelo conceptual de datos](../Diagramas/Modelo_Datos_ER.svg)

---

## 4. Entidades Principales del MVP

El modelo de datos de El Refugio se compone de un conjunto de entidades diseñadas para cubrir las necesidades operativas identificadas en la Fase 1, manteniendo una estructura sencilla, coherente y fácilmente ampliable.

### *1. User*

Representa a cualquier persona registrada en la plataforma. Puede tener el rol de user (usuario general) o admin (personal encargado de la gestión interna del refugio).

Los usuarios registrados en la web disponen únicamente de los campos básicos necesarios para su registro en la plataforma. El resto de campos se definen como **opcionales** o **nullables**, de modo que, si un usuario llega a formalizar una adopción o acogida, el refugio completará los datos adicionales requeridos para mantener un *registro* *completo* y actualizado del tutor responsable del animal.

Estos datos ampliados serán privados y accesibles solo para el personal administrativo autorizado.

- Campos principales:

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int | Clave primaria autoincremental |
| `first_name` | string | Nombre del usuario |
| `last_name` | string | Apellidos del usuario |
| `email` | string | Correo electrónico único utilizado para autenticación o contacto. |
| `password` | string | Contraseña cifrada mediante hash seguro. |
| `role` | enum(`admin`, `user`) | Define los permisos del usuario dentro de la plataforma. |
| `national_id` | string/null | Identificación oficial del usuario, en el caso de España el DNI. Se completa manualmente cuando se formaliza una adopción o acogida. |
| `phone` | string/null | Teléfono de contacto. |
| `address` | string/null | Dirección postal. Campo reservado para registro administrativo. |
| `email_verified_at` | timestamp/null | Fecha en la que el correo fue verificado. |
| `last_login_at` | timestamp/null | Último acceso registrado del usuario. |
| `profile_picture` | string/null | Ruta de la imagen de perfil. |
| `created_at` | timestamp | Fecha de creación del registro. |
| `updated_at` | timestamp | Fecha de última modificación. |

---

### *2. Animal*

Almacena la información básica de los animales del refugio, su estado y detalles descriptivos.
La asignación de un tutor no se realiza directamente en esta entidad, sino que se determina a través de los registros administrativos de adopción o acogida activos. De esta forma se mantiene la trazabilidad histórica de cada animal sin alterar su registro principal.

- Campos principales:

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int | Clave primaria |
| `name` | string | Nombre del animal |
| `species` | enum(`dog`, `cat`, `other`) | Especie (perro, gato, etc.) |
| `breed` | string/null | Raza |
| `sex` | enum(`male`, `female`, `unknown`) | Sexo del animal |
| `size` | enum(`small`, `medium`, `large`) | Tamaño estimado |
| `weight` | decimal(5,2)/null | Peso en kg |
| `height` | decimal(5,2)/null | Altura en cm |
| `neutered` | bool DEFAULT FALSE | Indica si el animal está esterilizado |
| `microchip` | string/null | Identificación veterinaria oficial del animal (si dispone de ella) |
| `birth_date` | date/null | Fecha de nacimiento (si se conoce) |
| `status` | enum('unavailable','sheltered','fostered','adopted','deceased') | Indica la situación actual del animal |
| `entry_date` | date | Fecha de entrada al refugio |
| `description` | text/null | Descripción general |
| `observations` | text/null | Observaciones internas, como tratamiento necesario, si aplica |
| `is_featured` | bool | Indica si el animal está destacado |
| `featured_at` | timestamp/null | Fecha en que fue destacado |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de modificación |

---

### *3. AnimalImage*

Gestiona las imágenes asociadas a cada animal.
Cada registro almacena la referencia a un archivo externo, permitiendo múltiples imágenes por animal.
Estas imágenes se alojarán en un servicio externo de almacenamiento (por ejemplo, Cloudinary), garantizando una carga optimizada y un acceso seguro desde la aplicación.

- Campos principales:

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int | Clave primaria |
| `animal_id` | int (FK → animals.id) | Relación con el animal correspondiente |
| `secure_url` | string | URL segura de la imagen |
| `public_id` | string/null | Identificador del recurso en el proveedor |
| `profile_pic`| bool | Si es la imagen principal del animal |
| `alt_text` | string/null | Texto alternativo de la imagen para accesibilidad y SEO |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de modificación |

---

### *4. Adoption*

Registra de forma digital las adopciones formalizadas presencialmente en el refugio.
Esta entidad no se genera de manera automática desde la web pública, sino que se completa manualmente por el personal administrativo una vez que el proceso ha sido validado y el contrato firmado.

Su finalidad es mantener un histórico de adopciones y vincular de forma trazable cada animal con su adoptante.
La creación de un registro en esta tabla actualiza automáticamente el estado del animal a `adopted`, garantizando la coherencia de los datos internos del sistema.

- Campos principales:

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int - autoincremental | Clave primaria  |
| `user_id` | `user.id` FK | Tutor del animal |
| `animal_id` | `animal.id` FK | Animal concreto |
| `adoption_date` | date | Fecha en la que se finalizó el proceso |
| `contract_file` | string/null | URL de la imagen digitalizada del contrato de adopción |
| `comments` | string/null | Observaciones del administrador |
| `created_at`| date | Fecha en la que se realizó el registro |
| `updated_at`| date | Fecha en la que se editó el registro |

La información cruzada entre el animal-tutor, correspondiente a un proceso de adopción finalizado, podría consultarse a través de la creación de vistas en la base de datos.
Además una vez cerrado el procedimiento, el estado (`status`) del animal debe ser actualizado automáticamente a adoptado (`adopted`).

---

### *5. Foster*

Registra de forma digital las acogidas formalizadas presencialmente en el refugio.
Esta entidad no se genera de manera automática desde la web pública, sino que se completa manualmente por el personal administrativo una vez que el proceso ha sido validado y el contrato firmado.

Su finalidad es mantener un histórico de acogidas y vincular de forma trazable cada animal con su tutor temporal.
La creación de un registro en esta tabla actualiza automáticamente el estado del animal a `fostered`, garantizando la coherencia de los datos internos del sistema.

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int - autoincremental | Clave primaria  |
| `user_id` | `user.id` FK | Tutor del animal |
| `animal_id` | `animal.id` FK | Animal concreto |
| `start_date` | date | Fecha en la que comienza el período de acogida |
| `end_date` | date/null | Fecha en la que finaliza el período de acogida, `null` en caso de acogida abierta en la que no se prevee finalización hasta adopción u otro acontecimiento |
| `contract_file` | string/null | URL de la imagen digitalizada del contrato de adopción |
| `comments` | string/null | Observaciones del administrador |
| `created_at`| date | Fecha en la que se realizó el registro |
| `updated_at`| date | Fecha en la que se editó el registro |

La información cruzada entre el animal-tutor temporal, correspondiente a un proceso de acogida finalizado, podría consultarse a través de la creación de vistas en la base de datos.
Además una vez cerrado el procedimiento, el estado (`status`) del animal debe ser actualizado automáticamente a la situación que corresponda (`adopted`, `sheltered`, etc)

---

## 5. Prototipo y Wireframes (Figma)

Enlaces al proyecto en el portal de Figma:

1. [Proyecto completo.](https://www.figma.com/design/GslSd3v3Snkr3ZvqJyNn1V/El_Refugio?m=auto&t=FncHyOSC99XIkyTc-1)
2. [Previsualización del proyecto.](https://www.figma.com/design/GslSd3v3Snkr3ZvqJyNn1V/El_Refugio?node-id=2064-930&t=FncHyOSC99XIkyTc-1)