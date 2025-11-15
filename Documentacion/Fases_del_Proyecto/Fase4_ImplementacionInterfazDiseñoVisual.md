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