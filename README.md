# laboratorio-pedidos — TP Integrador (Unidades 1 y 2)

Sistema de gestión de pedidos de un laboratorio de análisis clínicos.
**PHP Vanilla, sin frameworks, sin Composer.** Corre en XAMPP tal cual está.

> Este repositorio es un fork de [`mds2-utn-formosa/mini-proyecto-laboratorio`](https://github.com/mds2-utn-formosa/mini-proyecto-laboratorio),
> el proyecto de la cátedra con deuda técnica sembrada a propósito.
> Acá está **refactorizado**: se resolvieron los 8 ejercicios guiados del
> [mapa de deudas original](docs/MAPA-DE-DEUDAS.md) aplicando un patrón de
> diseño por rama. El detalle de qué deuda se encontró, qué patrón se
> aplicó y qué consecuencia negativa tiene cada solución está en
> **[`docs/DEUDA-TECNICA.md`](docs/DEUDA-TECNICA.md)**.

---

## Instalación y puesta en marcha

Guía completa para que cualquier otro grupo pueda clonar este repositorio y
levantarlo sin tener que preguntar nada.

### Requisitos previos

- **PHP 8.1 o superior** (el código usa `match`, tipado de propiedades y
  constructor property promotion). Verificar la versión instalada con:
  ```
  php -v
  ```
- **Git** para clonar el repositorio.
- **No hace falta MySQL ni ningún motor de base de datos.** La persistencia
  está simulada en memoria (ver `src/Database/Connection.php`) justamente
  para que el proyecto arranque sin configurar nada — eso **no** es parte de
  la deuda a corregir (ver `docs/MAPA-DE-DEUDAS.md` del proyecto original).
- **No hace falta Composer ni `composer install`.** No hay dependencias de
  terceros: todo el código es PHP vanilla con `require_once` manuales (ver
  `public/index.php`).
- No hace falta ninguna extensión de PHP extra a las que ya vienen
  habilitadas por defecto.

### 1. Clonar el repositorio

```
git clone https://github.com/tomascenturion895-prog/mini-proyecto-laboratorio.git
cd mini-proyecto-laboratorio
```

### 2. Levantarlo (elegir una opción)

#### Opción A — Servidor embebido de PHP (recomendada, no necesita instalar nada más)

Desde la raíz del repositorio:

```
php -S localhost:8000 -t public
```

Dejar la terminal abierta (ahí corre el servidor) y abrir en el navegador:

```
http://localhost:8000/index.php
```

Para cortar el servidor: `Ctrl + C` en esa misma terminal.

#### Opción B — XAMPP

1. Copiar (o clonar directamente) la carpeta `mini-proyecto-laboratorio`
   dentro de `C:\xampp\htdocs\` (Windows) o `/opt/lampp/htdocs/` (Linux).
2. Iniciar **Apache** desde el panel de control de XAMPP. **MySQL no hace
   falta** iniciarlo — el proyecto no lo usa.
3. Abrir en el navegador:
   ```
   http://localhost/mini-proyecto-laboratorio/public/index.php
   ```

### 3. Probar que funciona

Acciones disponibles (agregar el parámetro `accion` a la URL de arriba):

| URL | Qué hace |
|---|---|
| `?accion=crear` | Crea un pedido (acepta `&id=&paciente=&monto=&tipo=`) y muestra el listado |
| `?accion=listar` | Lista pedidos desde la vista |
| `?accion=reporte` | Genera un reporte combinando decoradores |

`tipo` acepta `particular`, `obra_social`, `jubilado` o `prepaga`.

Ejemplo completo (con el servidor embebido de la Opción A):

```
http://localhost:8000/index.php?accion=crear&id=1&paciente=Juan+Perez&monto=15000&tipo=obra_social
```

Si la página muestra una tabla con el pedido creado, quedó levantado
correctamente.

### Problemas comunes

- **`php: command not found`**: PHP no está instalado o no está en el
  `PATH`. Instalarlo (por ejemplo `sudo apt install php-cli` en Linux, o
  descargarlo desde [windows.php.net](https://windows.php.net/download/) en
  Windows) y volver a abrir la terminal.
- **`Failed to listen on localhost:8000`**: el puerto ya está en uso.
  Probar con otro puerto, por ejemplo `php -S localhost:8080 -t public` y
  ajustar la URL.
- **Página en blanco o error de `require`**: verificar que el comando
  `php -S` se ejecutó desde la **raíz del repositorio** (con `-t public`),
  no desde adentro de la carpeta `public/`.

---

## Qué se refactorizó

Cada fila del mapa de deudas original se resolvió en su propia rama y su
propio Pull Request:

| Archivo | Patrón aplicado | Rama |
|---|---|---|
| `src/Pricing/` | Strategy (Ej. 1: `PrepaidStrategy`) | `feat/patron-strategy` |
| `src/Notifications/` | Factory Method (Ej. 2: `WhatsAppNotification`) | `feat/patron-factory` |
| `src/Legacy/LegacyNotifier.php` | Adapter (Ej. 3) | `feat/patron-adapter` |
| `src/Reports/` | Decorator (Ej. 4: Pdf + Watermark) | `feat/patron-decorator` |
| `src/Events/` | Observer (Ej. 5: `SmsObserver`) | `feat/patron-observer` |
| `src/Services/OrderFacade.php` | Facade (Ej. 6) | `feat/patron-facade` |
| `src/Controllers/OrderController.php` | MVC + SRP (Ej. 7) | `feat/patron-mvc-controller` |
| `views/orders.php` | MVC (Ej. 8) | `feat/patron-mvc-vista` |

El detalle de cada refactor (deuda encontrada con línea exacta, patrón
elegido y por qué, y la consecuencia negativa de la propia solución) está
documentado en el Pull Request de cada rama y consolidado en
[`docs/DEUDA-TECNICA.md`](docs/DEUDA-TECNICA.md).

### Qué quedó pendiente (a propósito, fuera de alcance de esta entrega)

- **`src/Models/Order.php`**: todavía persiste y calcula su propio precio
  (`calcularTotal()`, código muerto que ya no llama nadie). Extraerlo a
  `OrderRepository` + `PricingStrategy` no era uno de los 8 ejercicios
  elegidos para esta entrega.
- **`src/Database/Connection.php`**: sigue devolviendo una conexión nueva
  en cada llamada (Singleton pendiente).
- **`public/index.php`**: sigue con `require` manuales, credenciales
  hardcodeadas y ruteo con `if` encadenados (autoload + config externa +
  tabla de rutas, pendiente).

Estos tres quedan identificados en `docs/DEUDA-TECNICA.md` para una
próxima entrega.

---

## Flujo de trabajo de este repositorio

```
main          ●──●──●──●──●──●──●──●──●
               \  \  \  \  \  \  \  \  \
                strategy factory adapter decorator observer facade mvc-controller mvc-vista
```

- Nadie escribe directamente en `main`: una rama por patrón, un Pull
  Request por rama.
- Convención de commits: `feat:`, `fix:`, `refactor:`, `docs:`.
- Cada PR responde en su descripción: qué deuda se encontró (archivo y
  línea), qué patrón se aplicó y por qué ese y no otro, y qué consecuencia
  negativa tiene la propia solución.

---

## Créditos

Proyecto base de la cátedra: **Metodología de Sistemas II — TUP — UTN FRRe
(sede Formosa)**. Consigna completa en [`docs/CONSIGNA-TP.md`](docs/CONSIGNA-TP.md).
