# El_Refugio

## 🌐 Propuesta de Modelo de Proyecto

Proyecto de fin de grado orientado a la gestión integral de un refugio de animales. La aplicación es una **web desarrollada con Laravel (patrón MVC)** que cubre los procesos esenciales como adopciones, acogidas y gestión interna de animales, mediante una parte pública y un panel de administración.

El sistema está concebido para ser escalable, intuitivo y de fácil mantenimiento, de forma que cualquier refugio, independientemente de su tamaño o recursos, pueda utilizarlo como base tecnológica para organizar su trabajo y mejorar la visibilidad de los animales a su cargo.

# 🎯 Objetivo

El propósito del proyecto es desarrollar una **aplicación web** que facilite la gestión integral de un refugio de animales, permitiendo centralizar en esta primera versión especialmente los procesos de adopciones, acogidas y gestión de animales.

Los refugios suelen carecer de herramientas digitales unificadas, operando con hojas de cálculo o formularios dispersos que dificultan la trazabilidad y actualización de la información. Además, el personal suele estar compuesto por voluntarios sin formación técnica, lo que hace inviable mantener una infraestructura compleja o costosa.

El proyecto busca ofrecer una solución funcional, escalable y de bajo mantenimiento que optimice el trabajo administrativo, reduzca la carga de gestión y mejore la visibilidad pública de los animales que necesitan ayuda, permitiendo que el tiempo y los recursos se destinen prioritariamente al cuidado directo de los mismos.

# 🧩 ¿Para qué?

## Funcionalidad principal

El proyecto tiene como finalidad desarrollar una **aplicación web con panel de administración** que permita a un refugio gestionar de forma centralizada la información de los animales y las solicitudes de adopción o acogida.

En la parte pública, los usuarios podrán consultar el listado de animales disponibles y
acceder a sus fichas individuales. Según el estado de publicación, podrán enviar un
formulario de adopción o acogida, que se enviará al correo del refugio. La solicitud no
creará registros automáticos en la base de datos: el expediente se revisará de forma
presencial junto con la documentación necesaria y, solo en caso de continuar el proceso,
el personal del refugio registrará manualmente en el sistema los datos relevantes
(usuario, adopción/acogida y actualizaciones del animal).

El sistema contará con un registro de usuarios con roles diferenciados: **usuario** y
**administración**. Los usuarios podrán registrarse para disponer de un perfil básico y
actualizar sus datos personales, mientras que la administración podrá crear, modificar o
eliminar fichas de animales, gestionar su visibilidad pública y actualizar sus estados (por
ejemplo, de “borrador” a “publicado” o “reservado”).

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
- **Pruebas:** PHPUnit / Pest (pruebas de funcionalidades clave y flujos críticos de la aplicación web)

- **Servicios externos:**  
  - Mailtrap (pruebas de correo)  
  - Cloudinary / S3 (almacenamiento de imágenes)  
  - Render / Railway (despliegue en la nube)  

--- 

# 📂 Documentación

A continuación se enlazan los documentos de las distintas fases del desarrollo del proyecto, donde se detallan desde el análisis inicial hasta las pruebas finales:

- [Fase 1 - Planificación y análisis](Documentacion/Fases_del_Proyecto/Fase_1_Planificacion_Analisis.md)  
- [Fase 2 - Diseño Técnico y estructura del sistema](Documentacion/Fases_del_Proyecto/Fase2_DisenioTecnico_EstructuraSistema.md)  
- [Fase 3 - Desarrollo de funcionalidades](Documentacion/Fases_del_Proyecto/Fase3_DesarrolloFuncionalidades.md)  
- [Fase 4 - Implementación de interfaz y diseño visual](Documentacion/Fases_del_Proyecto/Fase4_ImplementacionInterfazDiseñoVisual.md)
- [Fase 5 - Pruebas, evaluación y depuración](Documentacion/Fases_del_Proyecto/Fase5_PruebasEvaluacionDepuracion.md)







--- 

# Autoría

Sara Sánchez Camilleri 

I.E.S. Rafael Alberti – Ciclo Formativo DAW  

Tutor:  

Email: sarasanchezcamilleri@gmail.com

Repositorio del proyecto: [GitHub](https://github.com/SSanCam/El_Refugio.git) 

Versión actual : v1.0