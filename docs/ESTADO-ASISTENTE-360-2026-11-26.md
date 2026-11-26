# Estado final — 26 de noviembre de 2026

## Asistente 360º

- Versión de código y paquete vigente: `0.2.0-dev-r10`.
- Plugin instalado y activo en producción.
- Modo `live`, política de privacidad configurada y nueve documentos comerciales públicos aprobados.
- Prueba REST real completada: bootstrap `200` y consulta comercial `200` con respuesta correcta.
- La clave de OpenAI permanece exclusivamente en `wp-config.php`; no forma parte de este directorio, del ZIP ni del repositorio.

## Caché y salud del sitio

- WP Rocket continúa como única caché de página.
- LiteSpeed Cache y su configuración de objetos fueron retirados por incompatibilidad administrativa con WP Rocket.
- La portada pública se comprobó después de la retirada y carga correctamente.
- Salud del sitio mantiene una única recomendación no crítica: habilitar una caché de objetos persistente. No se aplica para evitar mezclar soluciones de caché.

## Material que se conserva

- `360-ai-assistant-pro-v1-dev/`: fuente vigente.
- `360-ai-assistant-pro-0.2.0-dev-r10.zip`: paquete de despliegue vigente.
- Documentación de configuración, seguridad, despliegue, rollback y QA.

No se incluyen copias completas de WordPress, bases de datos, credenciales, paquetes de revisiones anteriores ni archivos temporales en el repositorio.
