# Changelog

## 0.2.0-dev-r10 — 26/11/2026

- Corrección del contenedor cerrado: el lanzador ocupa su ancho real y queda alineado al borde derecho.
- Panel abierto compacto y separación de controles fijos de consentimiento.
- Se conserva el nonce REST propio mediante `X-A360-Nonce` para evitar la colisión con el nonce de cookies de WordPress.

## 0.2.0-dev-r5 a r9 — revisiones de despliegue

- Validación en producción del bootstrap y de una consulta comercial controlada.
- Ajustes de aislamiento de estilos frente a Brooklyn y de espaciado del widget.

## Pendiente — revisión QA local

- El límite de longitud de las consultas REST se mide en caracteres UTF-8, no en bytes; conserva correctamente el margen configurado para texto en español.

## 0.2.0-dev — 24/11/2026

- Reconstrucción local inicial, independiente del prototipo 0.1.0.
- Núcleo modular, activación/desactivación y tablas propias para límites y estadísticas minimizadas.
- Cliente servidor para Responses API sin clave embebida, con `store: false`.
- Endpoint con sesión temporal HttpOnly, nonce, límite global y por visitante seudonimizado.
- Interfaz pública inicial accesible y enlace manual a WhatsApp.
- Estado inicial previo a la activación controlada posterior.
