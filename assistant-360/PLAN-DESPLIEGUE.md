# Despliegue y actualización

1. Crear una copia de seguridad verificable.
2. Generar un ZIP con una sola raíz `360-ai-assistant-pro/` y separadores `/`.
3. Sustituir el plugin desde WordPress, activarlo y comprobar que conserva su configuración y documentos.
4. Purgar la caché de WP Rocket.
5. Comprobar `POST /wp-json/a360/v1/bootstrap`, una consulta controlada y el diseño público en escritorio y móvil.
6. Registrar versión, resultado y cualquier incidencia en la documentación de QA.
