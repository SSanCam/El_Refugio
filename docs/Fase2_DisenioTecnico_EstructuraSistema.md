# Fase 2 - Diseño Técnico y Estructura del Sistema.

## 🔧 Elementos que se desarrollan en esta fase

### 1. Estructura del proyecto
- Organización de carpetas y namespaces en Laravel.
- Definición de módulos, controladores, modelos, servicios y vistas.
- Implementación del sistema basado en componentes usando **Livewire**.

### 2. Diseño de la base de datos
- Traducción del modelo de datos al esquema relacional.
- Creación de migraciones de Laravel para todas las entidades.
- Definición de relaciones entre tablas (1:N, N:N si aplica).

### 3. Arquitectura del sistema
- Aplicación del patrón MVC (Modelo-Vista-Controlador) propio de Laravel.
- Posible uso de capas de servicio para la lógica de negocio.
- Uso de componentes Livewire para separar responsabilidades frontend.

### 4. Configuraciones iniciales del entorno
- Edición y personalización del archivo `.env` con las variables del entorno local.
- Configuración de la conexión con MySQL en XAMPP.
- Instalación de dependencias clave: Livewire, Alpine.js y opcionalmente Tailwind CSS.
- Definición de rutas iniciales y carga de vistas base (`layouts`, `components`, etc.).

### 5. Seguridad básica y roles
- Configuración de la autenticación (registro, login, logout).
- Protección de rutas mediante `middleware` de Laravel (`auth`, `role`, etc.).
- Inicio de la segmentación de vistas según tipo de usuario (`user`, `admin`).

---