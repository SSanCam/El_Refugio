# Fase 4 – Implementación de la Interfaz y Diseño Visual

Esta fase recoge la aplicación práctica del diseño visual definido previamente en la Fase 1 – Planificación y Análisis, donde se establecieron la guía de estilos, la paleta de colores, la tipografía, los componentes UI y los prototipos de Figma.

El objetivo de esta fase es asegurar que la interfaz final sigue de forma coherente las decisiones visuales del proyecto.

## 1. Moodboard

El moodboard establece la identidad visual del proyecto y sirve como punto de partida para todas las decisiones estéticas aplicadas a la interfaz. Recoge referencias que transmiten el estilo buscado: una estética natural, cálida y orgánica inspirada en la vida al aire libre, la sostenibilidad y el respeto por los animales y el entorno.

Los tonos terrosos, las ilustraciones con trazo artesanal y las composiciones retro-naturalistas definen la atmósfera visual del proyecto y guían la creación de los componentes, la paleta cromática y la tipografía de la interfaz.

> [Enlace al Moodboard en el proyecto](https://www.figma.com/design/GslSd3v3Snkr3ZvqJyNn1V/El_Refugio?node-id=2023-573&t=zmXMc29VU9ieCcnN-1)

---

## 2. Guía de estilos

La guía de estilos define los elementos visuales fundamentales de la interfaz y garantiza que todas las vistas del sistema mantengan una identidad coherente. En esta fase se aplican los criterios establecidos en el diseño previo: paleta cromática, tipografía, jerarquía visual y componentes básicos.

El diseño se inspira en la estética natural y artesanal del moodboard, trasladando sus valores —calidez, cercanía, sostenibilidad— a cada elemento de la interfaz.
La paleta de tonos terrosos y verdes refuerza la conexión con el entorno natural, mientras que la tipografía Quicksand aporta legibilidad y un carácter amable.

En Figma se han definido:

- **Paleta cromática oficial** del proyecto, con variaciones para fondos, elementos interactivos y estados (hover, disabled…).
- **Tipografía y jerarquía visual** para títulos, subtítulos, texto base y componentes.
- **Componentes UI base**, como tarjetas de animales, botones, inputs y formularios.
- **Variantes claro / oscuro**, aplicadas a todos los elementos principales del sistema.

Estos estilos sirven como referencia para la implementación en el entorno real del proyecto, ya sea mediante CSS modular, utilidades personalizadas o frameworks como Tailwind.

> [Enlace a la guía de estilos](https://www.figma.com/design/GslSd3v3Snkr3ZvqJyNn1V/El_Refugio?node-id=2002-928&t=owjsaTVUHzZElbaL-1)

---

## 3. Wireframe de baja fidelidad

Los wireframes de baja fidelidad representan el diseño inicial de la estructura y disposición de elementos en la aplicación.
Su objetivo es definir la organización general, los flujos principales y la jerarquía visual sin centrarse aún en colores, tipografías o detalles estéticos.

En estos wireframes se establecen:

- La distribución básica de los elementos de la interfaz.
- El recorrido principal del usuario por la parte pública y privada del sistema.
- La organización preliminar del panel de administración.
- La estructura general de formularios, listados y fichas de animales.

Estos diseños sirven como base funcional para la transición hacia los wireframes de alta fidelidad.

> [Wireframe de baja fidelidad](https://www.figma.com/design/GslSd3v3Snkr3ZvqJyNn1V/El_Refugio?node-id=2002-581&t=zmXMc29VU9ieCcnN-1)

---

## 4. Wireframe de alta fidelidad

Los wireframes de alta fidelidad aplican ya la guía visual completa definida para el proyecto:
paleta cromática, tipografía Quicksand, tonos orgánicos, componentes base y modo claro/oscuro.
Corresponden a la representación más cercana a la interfaz final implementada.

En ellos se puede observar:

- Las pantallas del sitio público: inicio, listado de animales, ficha de animal, formularios.
- Las vistas del panel de administración: gestión de animales, usuarios, adopciones y acogidas.
- Componentes reutilizables aplicados (tarjetas, botones, formularios, cabecera, footer).
- Adaptación visual entre modo claro y modo oscuro.
- Ejemplos de comportamiento e interacción previstos para la implementación con Livewire.

Estos diseños guían directamente el desarrollo de la interfaz en Laravel.

> [Wireframe de alta fidelidad](https://www.figma.com/design/GslSd3v3Snkr3ZvqJyNn1V/El_Refugio?node-id=2002-927&t=zmXMc29VU9ieCcnN-1)

---

## 5. Visualización del Prototipo 

El proyecto incluye un prototipo navegable en Figma que permite visualizar de forma interactiva el funcionamiento previsto de la interfaz, tanto en la parte pública como en el panel de administración.

Para acceder a la previsualización:

1. Abrir el enlace a [Wireframes de Alta Fidelidad](https://www.figma.com/design/GslSd3v3Snkr3ZvqJyNn1V/El_Refugio?node-id=2002-927&t=zmXMc29VU9ieCcnN-1).
2. En la esquina superior derecha de Figma, pulsar el botón **Play** (▶). Esto abrirá una **nueva pestaña independiente** con el prototipo.
3. Navegar por el prototipo utilizando las zonas interactivas, botones y enlaces definidos.
4. Cerrar el navegador o la pestaña para salir del modo de previsualización. 

Este modo de visualización permite al tribunal recorrer la interfaz de la aplicación tal como se ha concebido en el diseño, facilitando la evaluación del flujo de usuario, la coherencia visual y la usabilidad general del sistema.

> **Nota:** La navegación interactiva puede requerir unos segundos de carga dependiendo del dispositivo o navegador utilizado.

## 6. Implementación de la interfaz en Laravel (Blade + CSS)

El diseño definido en Figma se ha trasladado a la aplicación mediante una estructura de vistas Blade organizada y una hoja de estilos principal.

### 6.1. Layouts principales

La interfaz se apoya en una jerarquía de layouts Blade:

- `resources/views/layouts/app.blade.php`  
  Layout base con la estructura HTML común: `<head>`, inclusión de fuentes, hoja de estilos principal, scripts globales y contenedor general.

- `resources/views/layouts/public.blade.php`  
  Extiende del layout base y define la estructura de la parte pública: cabecera general, navegación principal, contenedor central de contenido y pie de página.

- `resources/views/layouts/admin.blade.php`  
  Layout específico para el panel de administración: incluye cabecera reducida, barra lateral con navegación para módulos internos, contenedor principal y zona de mensajes de estado.

Las vistas de cada sección (pública y privada) extienden el layout correspondiente mediante `@extends` y definen su contenido con `@section('content')`.

### 6.2. Componentes de interfaz reutilizables

Los elementos visuales definidos en la guía de estilos se han implementado como componentes Blade:

- `resources/views/components/header.blade.php`  
  Cabecera común con logo, menú principal y acceso al login.

- `resources/views/components/footer.blade.php`  
  Pie de página con datos de contacto y enlaces relevantes.

- `resources/views/components/animal-card.blade.php`  
  Tarjeta de animal con imagen principal, nombre, estado y etiquetas de especie/tamaño.

- `resources/views/components/button.blade.php`  
  Botón genérico con variantes (primario, secundario, texto).

- `resources/views/components/alert.blade.php`  
  Mensajes de éxito, error o aviso.

- `resources/views/components/form-field.blade.php`  
  Estructura para campos de formulario (label, input, mensaje de error).

> Algunos componentes visuales se encuentran en proceso de ajuste o evolución, priorizando la coherencia visual y la reutilización efectiva frente a una abstracción excesiva en fases tempranas del desarrollo.

---

## 7. Organización de estilos y aplicación de la guía visual

### 7.1. Hoja de estilos principal

La hoja de estilos se centraliza en:

- `resources/css/app.css`  

En ella se definen:

- Variables CSS para la paleta cromática (colores principales, secundarios, fondos, bordes y estados).
- Estilos globales de tipografía (familia Quicksand, tamaños básicos y jerarquía de títulos).
- Estilos de elementos base (`body`, encabezados, párrafos, enlaces, listas).
- Clases utilitarias básicas para márgenes, paddings, alineaciones y contenedores.

La hoja de estilos se compila e incluye en los layouts mediante `@vite`.

### 7.2. Estilos específicos por secciones

Además de los estilos globales, se utilizan clases específicas:

- Parte pública: `.public-layout`, `.hero`, `.animal-list`, `.animal-filters`.
- Panel de administración: `.admin-layout`, `.admin-sidebar`, `.admin-table`, `.admin-card`.
- Formularios: `.form-section`, `.form-group`, `.form-actions`.

### 7.3. Paleta de colores y estados visuales

Los colores definidos en Figma se han trasladado a variables CSS (por ejemplo: `--color-primary`, `--color-secondary`, `--color-accent`, `--color-bg`, `--color-text`), utilizadas en:

- Botones primarios y secundarios.
- Tarjetas de animales y tarjetas del panel.
- Fondos de secciones y barras de navegación.
- Estados de interacción (`:hover`, `:focus`, `:disabled`) y mensajes de alerta.

### 7.4. Modo claro / oscuro

El diseño contempla variantes claro y oscuro implementadas mediante clases de tema (`.theme-light`, `.theme-dark`) aplicadas dinámicamente al elemento `<body>`.
El cambio de tema se gestiona mediante JavaScript, almacenando la preferencia del usuario en `localStorage` para mantenerla entre sesiones.

- `.theme-light` para fondos claros y textos oscuros.
- `.theme-dark` para fondos oscuros y textos claros.

El layout raíz aplica una de estas clases al `<body>` y los componentes utilizan variables de color compatibles con ambos temas.

---

## 8. Accesibilidad, maquetación y coherencia visual

### 8.1. Accesibilidad básica

En la implementación se aplican criterios básicos:

- Uso de `alt` descriptivo en las imágenes de animales, alineado con el campo `alt_text` de `AnimalImage`.
- Contraste suficiente entre texto y fondo en botones, enlaces y tarjetas.
- Indicadores visibles de foco (`:focus`) en enlaces y controles interactivos.
- Uso coherente de encabezados (`<h1>`, `<h2>`, `<h3>`) para estructurar la información.
- Uso de atributos ARIA (`aria-expanded`) gestionados dinámicamente mediante JavaScript para mejorar la accesibilidad en elementos desplegables.

### 8.2. Maquetación y responsive

La maquetación se basa en:

- Un contenedor principal con ancho máximo definido.
- Rejillas y flexbox para listados de animales, tarjetas y tablas de administración.
- Ajustes responsive para pantallas pequeñas: reordenación de bloques, apilado de tarjetas y simplificación de menús.

En determinados elementos de navegación, la adaptación responsive se apoya en JavaScript para gestionar la visibilidad dinámica de menús y overlays, mejorando la experiencia de uso en dispositivos móviles sin recargar la página.

En dispositivos móviles, la navegación prioriza la visibilidad directa de las acciones principales mediante botones accesibles bajo la cabecera, evitando menús ocultos innecesarios.

### 8.3. Consistencia entre diseño y código

Las decisiones visuales de la guía de estilos se reflejan en:

- Uso de la misma jerarquía tipográfica en encabezados y textos de todas las vistas.
- Reutilización de componentes (tarjetas, botones, alertas) en lugar de copias aisladas.
- Correspondencia entre las pantallas diseñadas en Figma (pública y panel admin) y sus vistas Blade.
