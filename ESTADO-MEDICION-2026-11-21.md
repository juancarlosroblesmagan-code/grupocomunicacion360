# Medición y consentimiento — 21 de noviembre de 2026

Este registro no es una garantía legal ni una copia de seguridad.

## Estado

- Search Console verificado; sitemap procesado con 100 páginas descubiertas, no necesariamente indexadas. El informe de indexación seguía procesándose.
- GTM GTM-M9TG4B6T versión 2 y GA4 G-PRH69BLZYH publicados. Complianz gestiona el consentimiento y el cargador del tema hijo carga GTM tras aceptar estadísticas. Medición estadística, sin publicidad ni remarketing; medición mejorada y detección de datos proporcionados por usuarios desactivadas según la última revisión.
- Actualizada la política de cookies para reflejar la activación, conservación configurada y referencias de Google sobre transferencias. Continúa pendiente la revisión general de privacidad y proveedores.

## Pruebas de producción

- En visitante aislado sin sesión ni cookies no se observaron solicitudes a GTM ni Analytics antes de elegir ni tras rechazar. Tras aceptar estadísticas se cargó GTM, se observaron cookies GA4 y una solicitud page_view sin parámetros de consulta en URL ni referente.
- Al retirar se observó la desactivación de GA4, eliminación de las dos cookies observadas y recarga sin GTM. No se han comprobado todos los ámbitos de cookies, dispositivos ni envíos pendientes.
- Una simulación de envío exitoso del formulario 13 generó una solicitud generate_lead sin parámetros de consulta en URL ni referente. Simulaciones de formulario inválido, spam, fallo de envío y éxito de otro formulario no generaron otro evento interno. No equivale a un envío real.
- Las solicitudes de prueba mostraron HTTP 204 y también net::ERR_ABORTED. El informe en tiempo real muestra page_view mezclados con pruebas anteriores; generate_lead de producción no se ha identificado todavía en los informes. Un envío real anterior en vista previa sí fue recibido, según confirmó el representante.

## Pendiente

1. Confirmar generate_lead en los informes de producción mediante una prueba autorizada, sin duplicados ni datos personales.
2. Implementar y probar clics de teléfono, correo y navegación comercial con valores fijos y consentimiento vigente; revisar desplazamiento.
3. Revisar políticas, proveedores, transferencias e inventario completo de cookies. GA4 mostraba 2 meses de conservación para eventos y 14 meses para usuarios, con renovación por actividad; no confundir con la duración de cookies.
4. Ampliar pruebas de navegadores, caché, dispositivos y retirada; concretar el tratamiento de copias de consultas, que el representante indica eliminar a los 30 días.
5. Confirmar una copia de seguridad y su restauración: la copia conocida está en el servidor; no se han confirmado restauración ni copias automáticas.

No subir credenciales, datos de formularios, configuraciones privadas ni copias internas a este repositorio público.
