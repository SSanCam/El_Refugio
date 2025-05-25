# `UserController` (Panel de Administración)

Controlador responsable de gestionar usuarios desde el panel de administración.  
Incluye funciones CRUD, asignación de roles, activación y desactivación de cuentas, y filtros personalizados.

## Ruta del archivo

```plaintext
app/Http/Controllers/Admin/UserController.php
```

---

## Métodos principales

### `index(Request $request)`

- Muestra un listado paginado de usuarios con posibilidad de filtrar por distintos criterios (`nombre`, `email`, `rol`, actividad relacionada).
- Paginación establecida en 10 usuarios por página.
- Envuelto en bloque `try-catch` para manejo de errores.
- Si no hay usuarios, se muestra un mensaje informativo.

### `create()`

- Muestra el formulario para registrar un nuevo usuario.
- Control de errores con `try-catch`.

### `store(Request $request)`

- Valida y guarda un nuevo usuario en la base de datos.
- Aplicación de reglas de validación avanzadas:
  - `regex`, `confirmed`, `boolean`, etc.
- Encriptación segura de contraseñas con `bcrypt()`.
- Captura de excepciones específicas:
  - `QueryException`, `\Exception`.
- Registro de errores usando `Log::error()`.

### `show(string $id)`

- Muestra los detalles de un usuario específico.
- Manejo de:
  - `ModelNotFoundException` para IDs inválidos.
  - Errores generales.

### `edit(string $id)`

- Carga el formulario para editar un usuario.
- Control de errores para:
  - Modelo no encontrado (`ModelNotFoundException`).
  - Errores generales en la carga de la vista.

### `update(Request $request, string $id)`

- Actualiza los datos de un usuario.
- Valida los datos recibidos y filtra los campos modificados.
- Encripta la contraseña si ha sido modificada.
- Captura de errores con `try-catch`:
  - `QueryException`, `ModelNotFoundException`, `\Exception`.

### `destroy(string $id)`

- Elimina un usuario del sistema.
- Reglas de seguridad:
  - No permite que un administrador elimine su propia cuenta.
  - Si el usuario tiene relaciones activas (`adoptions`, `fosters`, `sponsorships`), **no se elimina**, se desactiva (`active = false`) en su lugar.
- Se registra el evento con `Log::info()` en casos de desactivación por relaciones activas.
- Captura de excepciones:
  - `ModelNotFoundException` → Usuario no existente.
  - `QueryException` → Error en la base de datos.
  - `\Exception` → Errores generales no previstos.

---

## Funciones administrativas

### `assignRole(Request $request, string $id)`

- Asigna o modifica el rol (`user`, `admin`) de un usuario.
- Valida el campo `role`.
- Uso de `strtolower()` para estandarizar el dato.
- Manejo de errores:
  - `ModelNotFoundException`, `QueryException`, `\Exception`.

### `activateUser(string $id)`

- Activa la cuenta de un usuario (`active = true`).
- Control de errores similar al resto de funciones (`try-catch`).
- Registro de errores y advertencias.

### `deactivateUser(string $id)`

- Desactiva un usuario (`active = false`) si no es el usuario autenticado.
- Previene que un administrador se desactive a sí mismo (`Auth::id()`).
- Registro de errores (`Log::warning`, `Log::error`) y control completo de excepciones (`ModelNotFoundException`, `QueryException`, `\Exception`).


---

## Características técnicas clave

- **Validaciones avanzadas:**
  - Uso de expresiones regulares para correos y contraseñas.
  - Validaciones condicionales (`nullable`, `confirmed`, `boolean`).

- **Manejo de excepciones:**
  - `ModelNotFoundException`: recursos inexistentes.
  - `QueryException`: errores de base de datos.
  - `\Exception`: capturas genéricas.

- **Logging:**
  - `Log::warning()` para advertencias.
  - `Log::error()` para errores críticos.

- **Seguridad:**
  - Impide eliminar o desactivar la cuenta propia.
  - Bloquea eliminación si existen relaciones activas.

- **Buenas prácticas:**
  - Uso de `compact()` para pasar variables a las vistas.
  - `array_filter()` evita sobrescribir datos innecesarios.
  - Mensajes flash de éxito/error (`with('success')`, `with('error')`).

---

