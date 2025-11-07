# Fase 1 - Planifiación y Análisis

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
- **Ver detalles de un animal:** se podrá acceder a la ficha individual de cada animal con información más específica como comportamiento, salud, fotos o historia.
- **Formulario de contacto:** permite a los usuarios enviar mensajes o consultas generales al refugio sin necesidad de registrarse.
- **Información general del refugio:** acceso a secciones estáticas como misión, historia, ubicación, redes sociales o formas de colaborar.

---

### 🔐 Funcionalidades privadas (requieren cuenta registrada)

#### Para usuarios generales (rol: usuario)

- **Registrarse e iniciar sesión**: Sistema de autenticación para acceder a funcionalidades personalizadas.
- **Consultar el estado de sus solicitudes**: Visualizar el historial y estado actual de adopciones, acogidas y apadrinamientos asociados a su cuenta.
- **Actualizar su perfil**: Los usuarios podrán modificar sus datos personales y preferencias.
- **Consultar el estado de sus solicitudes**: ver el historial y estado actual de las solicitudes enviadas (pendiente, en revisión, concedida o denegada).
```
Las adopciones o acogidas se cierran presencialmente en el refugio, donde se realiza la firma del contrato y la entrega oficial del animal.
Este procedimiento sigue las prácticas habituales del sector y garantiza que la documentación se complete correctamente antes del cierre del expediente.
``` 
#### Para administradores (rol: admin)

- **Gestión de animales (CRUD)**: Crear, editar, eliminar o actualizar fichas de animales en la base de datos.
- **Gestión de usuarios**: Ver, editar o eliminar usuarios registrados. Cambiar roles si es necesario.
- **Gestión de solicitudes**: Revisar, aprobar o rechazar solicitudes.
- **Panel de administración**: Acceso a un panel privado donde se centralizan todas las gestiones internas del refugio.
- **Gestión de contenido adicional**: Modificar textos de la web, datos de contacto o información general del refugio.

### Observaciones / Ideas adicionales

Aunque el objetivo principal es desarrollar una aplicación web funcional y práctica para la gestión interna del refugio, se contemplan mejoras y funcionalidades adicionales que pueden incorporarse según el tiempo disponible durante el desarrollo o como ampliaciones futuras. Algunas de ellas se consideran especialmente valiosas y están previstas para su implementación si la planificación lo permite:

- **Sistema de gestión de visitas:** permitir que los usuarios interesados puedan solicitar una cita para visitar el refugio o conocer a un animal concreto. Los administradores podrán gestionar estas solicitudes desde el panel interno.

- **Sistema de gestión de voluntariado:** Permite a ususarios interesados (registrados o no) enviar una solicitud a través de un formulario para ejercer un voluntariado en el refugio(limpieza, mantenimiento, reparaciones, etc.)

- **Blog o sección de noticias:** será la página de inicio o landing page de la plataforma, donde se publicarán actualizaciones del refugio, historias de adopción, actividades realizadas y otra información de interés.

- **Historial público de adopciones realizadas:** se mostrará una sección accesible desde la página principal con los animales que han encontrado hogar. Puede actualizarse automáticamente o incluir una descripción personalizada por parte del personal.

- **Seguimiento de apadrinamientos activos:** en el perfil del usuario padrino se podrá gestionar su relación con el animal apadrinado. Si el animal es adoptado, se notificará al padrino para que decida si desea continuar colaborando o finalizar su aportación.

- **Galería multimedia integrada:** cada ficha de animal incluirá fotos y vídeos representativos. No se plantea una galería general, sino contenido enriquecido dentro del perfil de cada animal.

- **Sistema de seguimiento post-adopción:** se considera incorporar una funcionalidad privada y bidireccional entre el adoptante y el refugio para dar seguimiento al bienestar del animal. Esta función quedará como concepto en esta fase.

- **Tienda solidaria (merchandising):** posible incorporación futura donde se puedan vender productos para ayudar económicamente al refugio.

- **Panel de estadísticas para administración:** incluir indicadores clave como número de adopciones, acogidas activas, padrinos registrados, etc., accesible solo desde el panel de administración.

- **Integración con redes sociales (Instagram/Facebook):** permitir que las publicaciones realizadas por los administradores (por ejemplo, al subir un nuevo animal en adopción) se compartan automáticamente en redes sociales del refugio. Esto ayudaría a ampliar el alcance y la visibilidad sin necesidad de duplicar contenido manualmente.

Estas funcionalidades no forman parte obligatoria del desarrollo inicial, pero se contemplan como escalables, realistas y de gran valor añadido para la plataforma y su comunidad.

- **Sistema de donaciones puntuales:** se considerará la incorporación de un sistema para gestionar donaciones puntuales realizadas por los usuarios al refugio. Esto permitirá a los donantes realizar contribuciones únicas, sin necesidad de registros recurrentes. Esta funcionalidad será implementada en una fase futura, a medida que se consolide el sistema de pagos.

- **Sistema de donaciones recurrentes (apadrinamiento):** se considera implementar un sistema de donaciones recurrentes para apadrinamientos. Esto permitirá a los usuarios realizar donaciones periódicas a los animales del refugio, asociando cada apadrinamiento a un animal específico. El sistema notificará al usuario si el animal es adoptado y cancelará automáticamente la donación recurrente. Esta funcionalidad será implementada en una fase futura, ya que involucra la integración de un sistema de pagos seguro y su gestión.

---

## 3. Modelo de Datos 

Esta sección presenta el modelo de datos correspondiente al sistema de *El Refugio*.  

Incluye únicamente las entidades necesarias para cubrir las funcionalidades descritas en la **Fase 1**, garantizando una base sólida y escalable para futuras ampliaciones.

El modelo está diseñado para una base de datos **relacional MySQL**, gestionada mediante **migraciones de Laravel**, y sigue las **convenciones de nomenclatura en inglés** definidas previamente.

---

## 4. Entidades Principales del MVP

### **1. User**

Representa a cualquier persona registrada en la plataforma.  
Puede tener rol de **user** (usuario general) o **admin** (administradores, gestión interna del refugio).

**Campos principales:**

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int | Clave primaria autoincremental |
| `first_name` | string | Nombre del usuario |
| `last_name` | string | Apellidos del usuario |
| `email` | string | Correo electrónico único |
| `password` | string | Contraseña cifrada |
| `role` | enum(`admin`, `user`) | Rol del usuario |
| `phone` | string/null | Teléfono de contacto |
| `address` | string/null | Dirección del usuario |
| `email_verified_at` | timestamp/null | Fecha de verificación de correo |
| `last_login_at` | timestamp/null | Fecha del último acceso |
| `profile_picture` | string/null | Ruta de la imagen de perfil |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de modificación |

---

### **2. Animal**

Almacena la información básica de los animales del refugio, su estado y detalles descriptivos.

**Campos principales:**

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int | Clave primaria |
| `name` | string | Nombre del animal |
| `species` | string | Especie (perro, gato, etc.) |
| `breed` | string/null | Raza |
| `sex` | enum(`male`, `female`, `unknown`) | Sexo del animal |
| `size` | enum(`small`, `medium`, `large`) | Tamaño estimado |
| `weight` | decimal(5,2)/null | Peso en kg |
| `height` | decimal(5,2)/null | Altura en cm |
| `birth_date` | date/null | Fecha de nacimiento (si se conoce) |
| `status` | enum(`draft`, `published`, `reserved`, `adopted`) | Estado de publicación/adopción |
| `entry_date` | date | Fecha de entrada al refugio |
| `microchip` | string/null | Número de microchip (si tiene) |
| `description` | text/null | Descripción general |
| `observations` | text/null | Observaciones internas |
| `is_featured` | bool | Indica si el animal está destacado |
| `featured_at` | timestamp/null | Fecha en que fue destacado |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de modificación |

---

### **3. AnimalImage**

Gestiona las imágenes asociadas a cada animal.  
Cada animal puede tener múltiples imágenes, almacenadas externamente (p. ej. Cloudinary).

**Campos principales:**

| Campo | Tipo de dato | Descripción |
|-------|---------------|-------------|
| `id` | int | Clave primaria |
| `animal_id` | int (FK → animals) | Relación con el animal correspondiente |
| `secure_url` | string | URL segura de la imagen |
| `public_id` | string | Identificador del recurso en el proveedor |
| `provider` | string | Origen del almacenamiento (`cloudinary`, `s3`, etc.) |
| `profile_pic` | bool | Indica si es la imagen principal |
| `sort_order` | int | Orden de visualización |
| `created_at` | timestamp | Fecha de creación |
| `updated_at` | timestamp | Fecha de modificación |

---

##  5. Diagramas del proyecto

### A. Modelo Entidad-Relación

### B. Casos de usos

### D. Diagrama de flujo

### E. WireFrame

