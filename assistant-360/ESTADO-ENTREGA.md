# Estado de entrega — 0.2.0-dev-r10

## Entregado y comprobado localmente

- Arquitectura modular independiente de Brooklyn/WPBakery.
- Activación, desactivación y desinstalación controlada.
- Sesión temporal, nonce REST, límites por sesión/globales y reserva conservadora de presupuesto.
- Cliente de Responses API exclusivamente desde servidor, con `store: false`.
- Manejo interno diferenciado de autenticación y límites del proveedor.
- Base de conocimiento local, manual y aprobable.
- Chat inicial con accesibilidad básica, aviso de IA/privacidad, accesos rápidos y WhatsApp con confirmación de resumen.
- Estadísticas agregadas sin conversaciones ni IPs.
- Pruebas locales de sintaxis, activación, tablas, recuperación, límites, presupuesto, modos y API simulada.
- Una llamada real mínima y controlada a OpenAI con `gpt-4.1-mini`; respuesta comercial correcta sobre diseño web. No se capturaron tokens o coste exacto.
- Instalación de producción realizada tras copia de seguridad verificable.
- Configuración en modo `live`, enlace a la política de privacidad y nueve documentos comerciales públicos aprobados.
- Endpoint de bootstrap y consulta comercial real verificados correctamente.
- Ajuste visual `r10`: el botón cerrado ocupa solo su ancho y se alinea realmente a la derecha; el panel mantiene un ancho compacto al abrirse.

## Pendiente / no autorizado

- Cambios funcionales o visuales adicionales sin nueva QA y autorización.
- Pruebas de regresión completas en todos los dispositivos con Brooklyn, WPBakery, Complianz y WP Rocket.
- Pruebas de carga, WAF y accesibilidad con auditoría completa.
- Revisión jurídica RGPD definitiva.

## Decisión de versión

La entrega permanece en `0.2.0-dev`. No se etiqueta como `1.0.0` hasta completar las pruebas de aceptación, aprobar la configuración de API y autorizar una activación pública controlada.
