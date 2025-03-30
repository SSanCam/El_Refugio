# 🐾 El Refugio

**Proyecto de Fin de Grado del ciclo DAW – I.E.S. Rafael Alberti, Cádiz**

Aplicación web desarrollada con Laravel para digitalizar y facilitar la gestión integral de un refugio de animales.  
Permite centralizar adopciones, acogidas, apadrinamientos y optimizar el trabajo del personal y voluntariado.


## 📂 Documentación por fases

- [Fase 1 – Planificación y análisis](docs/Fase1_Planificacion_Analisis.md)

- [Fase 2 – Diseño técnico y estructura del sistema](docs/Fase2_DisenioTecnico_EstructuraSistema.md)

- [Fase 3 - Desarrollo de funcionalidades](doc/Fase3_DesarrolloFuncionalidades.md)

- [Fase 4 - Interfaz y diseño visual](docs/Fase4_EstilosInterfaz.md)

- [Fase 5 - Pruebas y documentacion](docs/Fase5_PruebasDocumentacion.md)

- [Manual de instalación](docs/Manual_Instalacion.md)


---

## 📜 Descripción

El objetivo de este proyecto es desarrollar una aplicación web genérica que pueda ser utilizada por cualquier refugio de animales para gestionar adopciones, acogidas y apadrinamientos de manera eficiente. Muchas de las páginas actuales dedicadas a este propósito son poco intuitivas, están desactualizadas y no ofrecen herramientas para facilitar la comunicación y gestión interna. Con esta plataforma, se busca proporcionar una solución moderna, accesible y escalable que permita a los refugios administrar su base de datos de animales, gestionar publicaciones en redes sociales y optimizar el proceso de adopción y acogida.

---

## ⚙️ Tecnologías previstas

- **Framework**: Laravel con Blade
- **Tecnología basada en componentes**: Livewire (libreria nativa a Laravel)
- **Base de datos**: MySQL
- **Servidor Web**: Apache (en XAMPP para desarrollo)
- **Gestión de dependencias**: Composer
- **Control de versiones**: Git + GitHub
- **IDE**: VS Code
- **Contenerización (opcional)**: Docker

---

## 🔑 Funcionalidades

### 🔓 Funcionalidades públicas (sin necesidad de registro)

- **Consultar animales disponibles**: Cualquier persona puede visualizar el listado de animales que se encuentran en adopción o acogida, filtrando por especie, edad, raza o estado.
- **Ver detalles de un animal**: Acceso a la ficha individual de cada animal con información más específica como comportamiento, salud, fotos o historia.
- **Formulario de contacto**: Permite a los usuarios enviar mensajes o consultas generales al refugio sin necesidad de registrarse.
- **Realizar donaciones económicas**: Se ofrecerá un apartado para colaborar económicamente con el refugio sin requerir una cuenta de usuario.
- **Información general del refugio**: Acceso a secciones estáticas como misión, historia, ubicación, redes sociales o formas de colaborar.

---

### 🔐 Funcionalidades privadas (requieren cuenta registrada)

#### Para usuarios generales (rol: usuario)
- **Registrarse e iniciar sesión**: Sistema de autenticación para acceder a funcionalidades personalizadas.
- **Solicitar adopción de un animal**: Formulario para enviar una solicitud de adopción, asociado al usuario autenticado.
- **Solicitar acogida temporal**: Los usuarios pueden ofrecerse como casa de acogida para uno o más animales.
- **Apadrinar un animal**: Funcionalidad para elegir un animal y comprometerse a una ayuda económica periódica o puntual.
- **Actualizar su perfil**: Los usuarios podrán modificar sus datos personales o cambiar sus preferencias (acoger, apadrinar, ser voluntario, etc.).

#### Para administradores (rol: admin)
- **Gestión de animales (CRUD)**: Crear, editar, eliminar o actualizar fichas de animales en la base de datos.
- **Gestión de usuarios**: Ver, editar o eliminar usuarios registrados. Cambiar roles si es necesario.
- **Gestión de solicitudes**: Revisar, aprobar o rechazar solicitudes de adopción, acogida o apadrinamiento.
- **Panel de administración**: Acceso a un panel privado donde se centralizan todas las gestiones internas del refugio.
- **Gestión de contenido adicional**: Modificar textos de la web, datos de contacto o información general del refugio.

---

## 📂 Estructura de la Aplicación

El proyecto está organizado en diferentes módulos que permiten gestionar las funciones del refugio de manera eficiente. El esquema de la base de datos está compuesto por las siguientes entidades principales:

- **Web_User**: Representa a los usuarios registrados en la plataforma web.
- **Camp_User**: Representa a los usuarios vinculados al refugio, pero no necesariamente registrados en la web.
- **Animal**: Almacena toda la información sobre los animales del refugio.
- **Veterinary_History**: Almacena el historial veterinario de cada animal.
- **Animal_Medication**: Registra los tratamientos médicos continuos de los animales.
- **Adoptions**: Gestiona el proceso de adopción de los animales.
- **Foster**: Gestiona las acogidas temporales de los animales.
