# El_Refugio

## 🌐 Propuesta de Modelo de Proyecto

Proyecto de fin de grado orientado a la gestión integral de un refugio de animales. La aplicación ofrece una API diseñada para cubrir procesos esenciales como adopciones, acogidas, voluntariado, apadrinamientos y gestión interna de animales.

El sistema está concebido para ser escalable, intuitivo y de fácil mantenimiento, de forma que cualquier refugio, independientemente de su tamaño o recursos, pueda utilizarlo como base tecnológica para organizar su trabajo y mejorar la visibilidad de los animales a su cargo.

# 🎯 Objetivo

El propósito del proyecto es desarrollar una API que facilite la gestión integral de un refugio 
de animales, permitiendo centralizar procesos como adopciones, acogidas, voluntariado y 
apadrinamientos. 

Los refugios suelen carecer de herramientas digitales unificadas, operando con hojas de 
cálculo o formularios dispersos que dificultan la trazabilidad y actualización de la 
información. Además, el personal suele estar compuesto por voluntarios sin formación 
técnica, lo que hace inviable mantener una infraestructura compleja o costosa. 

El proyecto busca ofrecer una solución funcional, escalable y de bajo mantenimiento que 
optimice el trabajo administrativo, reduzca la carga de gestión y mejore la visibilidad pública 
de los animales que necesitan ayuda, permitiendo que el tiempo y los recursos se destinen 
prioritariamente al cuidado directo de los mismos. 

# 🧩 ¿Para qué?

## Funcionalidad principal

El proyecto tiene como finalidad desarrollar una API y un panel de administración que 
permitan a un refugio gestionar de forma centralizada la información de los animales y las 
solicitudes de adopción o acogida. 

En la parte pública, los usuarios podrán consultar el listado de animales disponibles y 
acceder a sus fichas individuales. Según el estado de publicación, podrán enviar un 
formulario de adopción o acogida, el cual registrará los datos del solicitante y generará un 
expediente interno asociado al animal. 

El sistema contará con un registro de usuarios con roles diferenciados: **usuario** y 
**administración**. Los usuarios podrán enviar solicitudes y realizar un seguimiento básico, 
mientras que la administración podrá crear, modificar o eliminar fichas de animales, 
gestionar su visibilidad pública y actualizar sus estados (por ejemplo, de “borrador” a 
“publicado” o “reservado”). 

---

## Escalabilidad y evolución del proyecto

El desarrollo se plantea con una visión a largo plazo. La arquitectura y la documentación 
estarán diseñadas para permitir la incorporación progresiva de nuevas funcionalidades, 
como la generación de contratos, el seguimiento de animales, solicitudes de voluntariado, 
método de donaciones puntuales o apadrinamientos recurrentes, las notificaciones 
automatizadas o la ampliación de módulos dedicados a voluntariado y donaciones. 

De esta forma, se garantiza la **escalabilidad del sistema** y la **continuidad del trabajo más allá de la fase inicial**.


# ⚙️ Tecnologías utilizadas

- **Lenguaje principal:** PHP 8+  
- **Framework backend:** Laravel (patrón MVC)  
- **Frontend dinámico:** Blade + Livewire + Alpine.js  
- **JavaScript ES6+:** validaciones, eventos, manipulación del DOM y comunicación asíncrona  
- **Base de datos:** MySQL (migraciones, seeders, relaciones)  
- **Servidor web:** Nginx (producción) / Apache (entorno local)  
- **Contenerización:** Docker + Docker Compose (app, web, db, mail)  
- **Gestión de dependencias:** Composer (PHP) y npm (JS/CSS)  
- **Control de versiones:** Git + GitHub  
- **IDE principal:** Visual Studio Code  
- **Pruebas:** PHPUnit / Pest + pruebas de endpoints (API REST)  

- **Servicios externos:**  

  - Mailtrap (pruebas de correo)  
  - Cloudinary / S3 (almacenamiento de imágenes)  
  - Render / Railway (despliegue en la nube)  

# 📂 Documentación

<!-- Enlaces a la documentacion de las distintas fases etc-->

--- 

# Autoría

Sara Sánchez Camilleri 

I.E.S. Rafael Alberti – Ciclo Formativo DAW  

Tutor:  

Email: sarasanchezcamilleri@gmail.com

Repositorio del proyecto: [GitHub](https://github.com/SSanCam/El_Refugio.git) 

Versión actual : v1.0


