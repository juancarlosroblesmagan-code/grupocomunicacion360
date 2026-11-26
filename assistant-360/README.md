# 360º AI Assistant PRO — 0.2.0-dev-r10

Plugin comercial para WordPress de Grupo Comunicación 360º. Usa OpenAI exclusivamente desde el servidor, con `store: false`, una base de conocimiento aprobable y controles de límite de uso.

## Estado de la entrega

- Código y paquete vigente: `0.2.0-dev-r10`.
- Instalado y activo en producción; la configuración comercial se administra desde **Asistente 360º**.
- Chat y endpoint REST verificados con una consulta comercial controlada.
- La versión continúa siendo de desarrollo: no se declara como `1.0.0`.

## Requisitos y seguridad

- WordPress 6.4+ y PHP 7.4+.
- Define `A360_OPENAI_API_KEY` solo en `wp-config.php` o como variable de entorno del servidor.
- Nunca subas claves, copias de WordPress, bases de datos, exportaciones o información de visitantes al repositorio.

Los documentos se gestionan en **Asistente 360º → Base de conocimiento**; únicamente los aprobados se pueden usar como contexto.
