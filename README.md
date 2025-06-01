# El Refugio

**Proyecto desarrollado por Sara Sánchez Camilleri como Trabajo Fin de Grado del Ciclo Formativo de Desarrollo de Aplicaciones Web.**

**I.E.S. Rafael Alberti, Cádiz**

Aplicación web desarrollada con Laravel para digitalizar y facilitar la gestión integral de un refugio de animales.  
Permite centralizar adopciones, acogidas, apadrinamientos y optimizar el trabajo del personal y voluntariado.

---

## 📂 Documentación por fases

- [Fase 1 – Planificación y análisis](docs/Fase1_Planificacion_Analisis.md)
- [Fase 2 – Diseño técnico y estructura del sistema](docs/Fase2_DisenioTecnico_EstructuraSistema.md)
- [Fase 3 - Desarrollo de funcionalidades](docs/Fase3_DesarrolloFuncionalidades.md)
- [Fase 4 - Interfaz y diseño visual](docs/Fase4_EstilosInterfaz.md)
- [Fase 5 - Pruebas y documentacion](docs/Fase5_PruebasDocumentacion.md)
- [Manual de instalación](docs/Manual_Instalacion.md)

---

## 📜 Descripción

El objetivo de este proyecto es desarrollar una aplicación web moderna y accesible, dirigida a refugios de animales, para gestionar de manera eficiente las adopciones, acogidas y apadrinamientos. La plataforma busca optimizar la gestión interna del refugio y facilitar la interacción de los usuarios (potenciales adoptantes, voluntarios y colaboradores) con el refugio. La web estará orientada a la administración de los animales disponibles, la gestión de solicitudes de adopción, y la promoción de formas de colaboración, como el apadrinamiento y la acogida temporal.

Además, se pretende que la plataforma ofrezca una experiencia más clara y organizada en comparación con las plataformas actuales, con la integración de funcionalidades como la gestión de redes sociales y un sistema optimizado para las solicitudes de adopción.

---

## ⚙️ Tecnologías previstas

- **Framework backend**: Laravel (PHP 8+) con motor de plantillas **Blade**
- **Tecnología basada en componentes**: Livewire (librería nativa de Laravel)
- **Frontend interactivo**:  
  - **Livewire**  
  - **Alpine.js**

- **Base de datos**: MySQL  
  - En desarrollo: gestionada localmente con **phpMyAdmin** en **XAMPP**  
  - En producción/despliegue: alojada en la nube mediante **[Railway](https://railway.app)**

- **Servidor Web**:  
  - Local: **Apache** mediante **XAMPP**  
  - Producción: compatible con servicios como **Render**

- **Gestión de dependencias**: Composer  
- **Contenerización (opcional)**: Docker  
- **Control de versiones**: Git + GitHub  
- **IDE principal**: Visual Studio Code

---

## 🔑 Funcionalidades

### 🔓 Funcionalidades públicas (sin necesidad de registro en la web)

- **Consultar animales disponibles**: Listado filtrable de animales en adopción o acogida, accesible para cualquier visitante.
- **Ver ficha básica de un animal**: Información general visible sin registro (nombre, especie, estado, características principales).
- **Formulario de contacto**: Envío de mensajes y consultas al refugio.
- **Donaciones puntuales**: Aportaciones económicas sin necesidad de tener cuenta.
- **Información general del refugio**: Secciones estáticas accesibles sobre historia, misión, redes sociales, formas de colaborar.
- **Solicitar adopción o acogida**: Cualquier usuario puede enviar una solicitud. Si esta es aceptada, se registrará a la persona internamente en el sistema.
- **Apadrinar un animal**: Se puede iniciar el proceso sin registro. No obstante, se recomienda crear una cuenta para acceder al seguimiento del animal apadrinado.

---

### 🔐 Funcionalidades privadas (requieren cuenta registrada)

Los usuarios registrados en la plataforma, además de acceder a todas las funcionalidades públicas, podrán:

- **Consultar el estado de sus solicitudes**: Visualizar el historial y estado actual de adopciones, acogidas y apadrinamientos asociados a su cuenta.
- **Recibir actualizaciones de animales apadrinados**: Notificaciones, seguimiento y contenido adicional vinculado al animal.
- **Gestionar su perfil personal**: Actualizar datos, preferencias y tipo de colaboración.
- **Acceder a funcionalidades personalizadas**: Visualización de contenido adaptado al usuario.

#### Para administradores (rol: admin)
- **Gestión de animales (CRUD)**: Crear, editar, eliminar o actualizar fichas de animales en la base de datos.
- **Gestión de usuarios**: Ver, editar o eliminar usuarios registrados. Cambiar roles si es necesario.
- **Gestión de solicitudes**: Revisar, aprobar o rechazar solicitudes de adopción, acogida o apadrinamiento.
- **Panel de administración**: Acceso a un panel privado donde se centralizan todas las gestiones internas del refugio.
- **Gestión de contenido adicional**: Modificar textos de la web, datos de contacto o información general del refugio.

---

## 📂 Estructura de la Aplicación

La aplicación está organizada de manera modular, permitiendo una gestión eficiente de las funciones y procesos del refugio. A continuación, se describen las entidades principales que forman la base de datos de la aplicación:

- **User**: Representa a los usuarios que pueden estar registrados para interactuar con la web o vinculados al refugio para adopciones, acogidas, o apadrinamientos.
- **Animal**: Almacena toda la información sobre los animales del refugio.
- **Adoptions**: Gestiona el proceso de adopción de los animales.
- **Foster**: Gestiona las acogidas temporales de los animales.
- **Volunteer_Request**: Almacena las solicitudes para colaborar como voluntario/a.
- **Sponsorship** *(en pruebas)*: Entidad para gestionar apadrinamientos (prevista para desarrollo local).
- **Animal_Images**: Galería de imágenes asociadas a cada animal.


---

## 🛠️ Observaciones / Implementaciones futuras

- **Sistema de gestión de citas o visitas**: Permitir que los usuarios interesados puedan solicitar una cita para visitar el refugio o conocer a un animal concreto. Los administradores podrán gestionar estas solicitudes desde el panel interno.
- **Blog o sección de noticias**: Página principal donde se publicarán actualizaciones sobre el refugio, historias de adopción, etc.
- **Historial público de adopciones realizadas**: Mostrar un listado de animales que han sido adoptados a través de la web.
- **Seguimiento de apadrinamientos activos**: Gestionar las relaciones de los padrinos con los animales apadrinados.
- **Galería multimedia integrada**: Fichas enriquecidas con imágenes y videos representativos de los animales.
- **Sistema de seguimiento post-adopción**: Funcionalidad privada para hacer seguimiento al bienestar de los animales adoptados.
- **Sistema de donaciones puntuales y recurrentes**: Para financiar el refugio o apadrinar animales.
- **Panel de estadísticas para admins**: Mostrar métricas clave sobre el funcionamiento del refugio (número de animales en adopción, acogida, donaciones recibidas, etc.).

