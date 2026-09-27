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

## Cómo levantarlo

1. Copiar la carpeta dentro de `C:\xampp\htdocs\`.
2. Iniciar Apache desde el panel de XAMPP (MySQL **no** hace falta).
3. Abrir: `http://localhost/mini-proyecto-laboratorio/public/index.php`

También corre con el servidor embebido de PHP, sin XAMPP:

```
php -S localhost:8000 -t public
```

Acciones disponibles:

| URL | Qué hace |
|---|---|
| `public/index.php?accion=crear` | Crea un pedido (acepta `?id=&paciente=&monto=&tipo=`) y muestra el listado |
| `public/index.php?accion=listar` | Lista pedidos desde la vista |
| `public/index.php?accion=reporte` | Genera un reporte combinando decoradores |

`tipo` acepta `particular`, `obra_social`, `jubilado` o `prepaga`.

La persistencia sigue simulada en memoria para que el proyecto arranque sin
configurar MySQL — eso **no** es parte de la deuda a corregir (ver
`docs/MAPA-DE-DEUDAS.md` del proyecto original).

**Requisitos:** PHP 8.1 o superior (usa `match`, tipado de propiedades y
constructor property promotion). No requiere ninguna extensión extra ni
`composer install`: no hay dependencias de terceros.

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
