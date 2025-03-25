# Fase 1 - Analisis

Este documento corresponde a la primera fase del desarrollo del proyecto "El Refugio". Su objetivo es definir las bases funcionales y estructurales de la aplicación antes de iniciar su implementación técnica. Se analizarán los distintos tipos de usuarios, las funcionalidades clave, los primeros diseños de interfaz (wireframes), y un primer esbozo del modelo de datos.


## 1. Tipos de Usuario

En esta sección se identifican los distintos perfiles de usuario que interactuarán con la aplicación, así como sus roles y permisos. Esto permitirá establecer qué funcionalidades estarán disponibles para cada uno.

## 👤 Entidad: Usuario

| Campo        | Tipo de dato | Descripción |
|--------------|--------------|-------------|
| `id`         | int          | Clave primaria autogenerada por Laravel |
| `nombre`     | string       | Nombre de pila del usuario |
| `apellidos`  | string       | Apellidos del usuario |
| `dni`        | string       | Documento nacional de identidad (único) |
| `email`      | string       | Correo electrónico (único) |
| `telefono`   | string       | Número de teléfono de contacto |
| `direccion`  | string       | Dirección de residencia del usuario |
| `rol`        | string       | Tipo de usuario: `admin`, `voluntario`, `usuario` |
| `password`   | string       | Contraseña cifrada (bcrypt) |
| `acoge`      | boolean/null | Indica si el usuario está interesado en acoger animales |
| `voluntario` | boolean/null | Indica si el usuario desea ser voluntario/a |
| `apadrina`   | boolean/null | Indica si el usuario desea apadrinar animales |
| `created_at` | timestamp    | Fecha de creación del registro (autogenerado) |
| `updated_at` | timestamp    | Fecha de última modificación (autogenerado) |


## 2. Funcionalidades principales

Aquí se listan las funcionalidades que debe ofrecer la aplicación, tanto para la parte pública (usuarios visitantes) como para el área privada (usuarios registrados con permisos específicos). Estas funcionalidades guiarán el desarrollo y el diseño de la estructura interna de la app.

## 3. WildFrames iniciales

Los wireframes son bocetos que representan la estructura visual y de navegación de la aplicación. Aunque no definen el diseño final, sirven como base para imaginar el flujo de pantallas y la disposición de los elementos principales.


## 4. Modelo de Datos

Esta sección presenta las entidades que formarán parte de la base de datos del sistema, así como sus atributos principales y relaciones entre ellas. Es un primer paso hacia el diseño de la estructura lógica de la aplicación.


## 5. Observaciones/ideas adicionales


Aquí se anotan ideas complementarias, posibles mejoras futuras o funcionalidades opcionales que no forman parte de la versión inicial, pero que podrían ser interesantes para el crecimiento del proyecto.

