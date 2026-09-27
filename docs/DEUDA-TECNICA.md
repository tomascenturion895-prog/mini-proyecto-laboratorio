# Deuda técnica — laboratorio-pedidos

Evidencia del TP Integrador (Unidades 1 y 2). Cada fila corresponde a una
rama y un Pull Request propios; el detalle completo (qué deuda, qué patrón
y qué consecuencia negativa) está en la descripción de cada PR.

## Deuda de diseño (Unidad 2) — 8/8 ejercicios resueltos

| Síntoma observado | Evidencia (archivo:línea, antes del refactor) | Tipo de deuda | Patrón aplicado | Consecuencia asumida |
|---|---|---|---|---|
| Un `switch` concentraba todos los algoritmos de precio; el descuento `0.7` estaba repetido | `PriceCalculator.php:29-42`, `:50-57` | Diseño (OCP + DRY) | **Strategy** (Ej. 1: `PrepaidStrategy`) | 5 clases nuevas (interfaz + 4 estrategias) por un `switch` de ~14 líneas. No siempre se justifica si el número de variantes es chico y estable. |
| `if` por tipo de notificación repetido en 3 archivos; `enviarEmail()` y `mandarSms()` con firmas distintas | `NotificationSender.php:30-44` | Diseño (OCP + DIP) | **Factory Method** (Ej. 2: `WhatsAppNotification`) | El llamador ya no conoce la clase concreta, pero un tipo de notificación nuevo sigue exigiendo tocar el `match` de la fábrica: Factory no elimina el punto único de cambio, lo concentra. |
| Método `send()` agregado dentro de una clase de terceros + clase con copy-paste del mismo comportamiento | `LegacyNotifier.php:38-41`, `:49-55` | Diseño (DRY + límites del sistema) | **Adapter** (Ej. 3) | Una llamada indirecta más por cada envío (pasa por el adapter), a cambio de aislar en un único archivo lo que pase con el proveedor externo. |
| Banderas booleanas (`boolean trap`): `generate($contenido, true, false, true)` ilegible en el llamador | `ReportGenerator.php:28-33` | Diseño (OCP) | **Decorator** (Ej. 4: `PdfReportDecorator`, `WatermarkDecorator`) | El orden de los decoradores cambia el resultado y no es evidente leyendo el código: firmar y pasar a PDF no es lo mismo que al revés. |
| Avisos encadenados a mano a 3 clases concretas; si uno fallaba, los siguientes no se ejecutaban | `OrderEvents.php:28-40` | Diseño (DIP) | **Observer** (Ej. 5: `SmsObserver`, agregado sin tocar `OrderSubject`) | Se pierde trazabilidad: leyendo `OrderFacade::createOrder()` ya no se ve quién se entera del evento; hay que abrir `OrderSubject` y cada observer. |
| Un método con 6+ responsabilidades, 4 niveles de anidamiento, imprimía HTML desde la capa de servicio | `OrderService.php:34-89` | Diseño (SRP) | **Facade** (Ej. 6: `OrderFacade::createOrder()`, 8 líneas) | Facade no elimina la complejidad, la mueve: para saber qué dispara `createOrder()` hay que abrir 4 archivos más en vez de uno solo. |
| SQL armado a mano, regla de negocio y `echo` sin escapar, todo dentro del controlador | `OrderController.php:30-53` | Diseño (SRP + MVC) | **MVC + SRP** (Ej. 7: `create()` en 2 sentencias) | `create()` ahora depende por completo de `OrderFacade`; testear el controlador exige stubear la fachada en vez de una base de datos. |
| La vista consultaba la base de datos, calculaba el total y no escapaba la salida (XSS) | `views/orders.php:24`, `:43`, `:49` | Diseño (MVC + seguridad) | **MVC** (Ej. 8) | El controlador creció (`OrderController::pedidosDeMuestra()`) porque asumió la responsabilidad que antes tenía, mal aplicada, la vista. |

## Deuda de proceso (Unidad 1)

| Síntoma observado | Evidencia | Tipo de deuda | Práctica aplicada | Consecuencia asumida |
|---|---|---|---|---|
| Historial de un único commit inicial con todo el proyecto adentro | commit `chore: initialize design patterns project` (fork del proyecto de cátedra) | Proceso | Historial real con 8 ramas `feat/patron-*`, cada una con su propio Pull Request (ver sección "Flujo de trabajo obligatorio" del README) | 8 PR para revisar y mergear en vez de un solo commit: más lento de integrar, pero cada cambio queda trazable, revisable y reversible por separado. |
| Credenciales y configuración de base de datos escritas en el código fuente y versionadas | `public/index.php:49-52` (`define('DB_USER', 'root')`, etc.) | Proceso | **Pendiente** — fuera del alcance de los 8 ejercicios elegidos para esta entrega. Requiere extraer a `config/database.php` (agregado a `.gitignore`) + `config/database.example.php` con valores vacíos, y reemplazar los `require` manuales por autoload. | Si se resuelve, cada integrante deberá copiar `config/database.example.php` a `config/database.php` antes de poder levantar el proyecto: un paso manual más que hoy no existe. |

## La medida de la deuda de este proyecto

El descuento de obra social (`0.7`) aparecía en **5 archivos**:
`Order.php`, `PriceCalculator.php` (dos veces), `OrderService.php`,
`OrderController.php` y `views/orders.php`.

Después de este refactor aparece en **1 archivo**: `src/Models/Order.php:103`
(método `calcularTotal()`, que ya no lo llama nadie: `OrderFacade` calcula el
total con `PriceCalculator` + `PricingStrategy` antes de construir el
`Order`). Extraer la persistencia y el cálculo del modelo a un
`OrderRepository` propio es el ejercicio que quedó pendiente (no es uno de
los 8 elegidos para esta entrega — ver tabla de arriba).

**Pregunta de cierre:** ¿cuántos archivos hay que tocar hoy para agregar un
tipo de paciente nuevo? Uno: crear una clase que implemente
`PricingStrategy` en `src/Pricing/` (ver `PrepaidStrategy.php`) y sumar un
`case` en `OrderFacade::calcularTotal()`. Antes del refactor eran, como
mínimo, los 5 archivos de la lista de arriba.
