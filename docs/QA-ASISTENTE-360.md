# QA real — resultados parciales

**Fecha:** 25/11/2026  
**Entorno:** WordPress local limpio, PHP 8.2.12 y MySQL local.  
**Producción:** plugin instalado el 25/11/2026, mantenido inactivo.

## Integridad

- ZIP: `360-ai-assistant-pro-0.2.0-dev.zip`
- SHA-256 comprobado: `88318D657D1BAB5813AD7CF330B822DDC5128E73BC5320A82DEBA146C52BD654`
- Resultado: coincide con la entrega local anterior.

## Ejecutado

- Revisión de `ESTADO-ENTREGA.md` y del código local.
- Sintaxis PHP y JavaScript, activación, tablas, recuperación local, límites, presupuesto, aislamiento de modo pruebas y Responses API simulada: superados según `INFORME-PRUEBAS.md`.
- Sitemap público contrastado: servicios, diseño web, tienda online, marketing digital, SEO/mantenimiento, trabajos, contacto, imprenta y servicios especializados existen como URLs públicas.
- WhatsApp objetivo contrastado: `https://wa.me/34607877289`.
- Primera llamada real controlada a Responses API: superada con `gpt-4.1-mini`, una consulta comercial corta y máximo de 60 tokens de salida. La respuesta confirmó diseño web, enlazó la URL pública correcta y ofreció WhatsApp. No se registró ni mostró la clave.
- Antes de la instalación en producción, UpdraftPlus confirmó una copia completa de archivos y base de datos: “La copia de seguridad se ha realizado correctamente y se ha completado” (25/11/2026 19:54:48).
- Plugin `360º AI Assistant PRO` `0.2.0-dev` instalado en producción desde el ZIP verificado. Se comprobó que está **inactivo**: WordPress ofrece la acción “Activar”, no “Desactivar”. No se configuró clave ni se importó conocimiento en producción.
- Tras la instalación inactiva, Inicio, Planes Mensuales, Contacto y Trabajos cargaron correctamente en producción.
- Se detectó que el ZIP instalado contiene una carpeta raíz con el nombre de desarrollo (`360-ai-assistant-pro-v1-dev`), por lo que WordPress lo alojó dentro de una ruta anidada. No afecta a su estado inactivo actual, pero no es el empaquetado definitivo recomendado.
- Se generó un paquete local corregido, sin cambios de código: `360-ai-assistant-pro-0.2.0-dev-r1.zip`. Contiene una única raíz `360-ai-assistant-pro/`, su cabecera de plugin y 24 entradas. SHA-256: `FC10F0C9967EBE8960A1C5DE267FDED2C1B693930FC1D4002E5D5E2AEC0E9EAD`.
- Validaciones posteriores del paquete local: sintaxis PHP correcta para todos los archivos y sintaxis JavaScript correcta para `assets/public.js`.
- Auditoría local adicional: la clave se obtiene exclusivamente de constante o variable de entorno del servidor; no se hallaron patrones de claves OpenAI en el código ni en el paquete. Las llamadas al proveedor son del lado servidor, usan `store: false` y no exponen la credencial al navegador.
- Corrección local: el límite de las consultas REST se medía en bytes. Se cambió a caracteres UTF-8 para no rechazar prematuramente consultas en español con acentos. Ejemplo validado: 900 caracteres `á` equivalen a 1.800 bytes y se mantienen dentro del límite de 900 caracteres.
- Paquete actualizado con la corrección: `360-ai-assistant-pro-0.2.0-dev-r2.zip`, SHA-256 `1F5B5CDAFD70A17898353CDCC011908D79483C87DDBA62F47AFE8F462EDE1F72`. Contiene una única raíz de plugin y la cabecera de WordPress.
- Documentación técnica reconciliada con las evidencias reales: `ESTADO-ENTREGA.md`, `INFORME-PRUEBAS.md` y `README.md` ya reflejan la llamada real mínima y la instalación inactiva en producción; no afirman pruebas no ejecutadas.
- Paquete final local de esta ronda: `360-ai-assistant-pro-0.2.0-dev-r3.zip`, SHA-256 `8D209E9551878A9720E7287FB78F4A446F8985E82799A133C4A7DB5E433B8CB5`. Sintaxis completa de PHP y JavaScript superada; estructura ZIP comprobada (24 entradas bajo una única raíz de plugin).

## Incidencia de despliegue

- Se solicitó la eliminación desde WordPress de la copia inactiva empaquetada de forma anidada para sustituirla por `r1`. WordPress notificó que se había borrado, pero una recarga desde una pestaña nueva seguía mostrando esa misma copia como instalada e inactiva. No se instaló `r1` en paralelo para evitar duplicados. La causa debe revisarse con acceso al sistema de archivos del hosting (permisos, despliegue o caché de servidor) antes de sustituirla.
- Comprobación posterior de Salud del sitio: WordPress detecta 16 plugins activos y exactamente 1 inactivo, correspondiente al asistente. El directorio temporal de actualizaciones es escribible, por lo que la causa concreta de la persistencia no se puede determinar desde `wp-admin`; se requiere inspección del sistema de archivos del hosting.
- Aislamiento público confirmado: `https://grupocomunicacion360.com/wp-json/a360/v1/bootstrap` responde `404 rest_no_route` mientras el plugin permanece inactivo. No hay endpoint del asistente expuesto ni llamadas a OpenAI desde producción.

## Resolución de sustitución inactiva

- La carpeta antigua se eliminó manualmente desde el Administrador de archivos de Hostinger, siguiendo la ruta indicada para el plugin inactivo.
- Se verificó en WordPress que ya no aparecía ninguna copia de `360º AI Assistant PRO` antes de continuar.
- Se instaló el ZIP verificado `360-ai-assistant-pro-0.2.0-dev-r3.zip` (SHA-256 `8D209E9551878A9720E7287FB78F4A446F8985E82799A133C4A7DB5E433B8CB5`).
- Resultado: instalación correcta y plugin **inactivo**. WordPress ofrece únicamente “Activar” y “Borrar”; no se hizo clic en Activar. No hay clave API ni documentos de conocimiento configurados en producción.
- Verificación final tras `r3`: Inicio y Contacto continúan respondiendo correctamente. El endpoint `wp-json/a360/v1/bootstrap` sigue respondiendo `404`, confirmando que no existe una ruta pública del asistente mientras permanece inactivo.

## Intento de activación bloqueado

- Antes de intentar la activación se completó una nueva copia de seguridad con UpdraftPlus.
- WordPress rechazó la activación de `r3` con el mensaje: “El archivo del plugin no existe.” La activación no llegó a ejecutarse.
- Verificación posterior: el plugin sigue listado como **inactivo** y WordPress ofrece “Activar” y “Borrar”. No se expuso ninguna ruta REST ni se modificó la web pública.
- Esta incidencia es coherente con el comportamiento previo de archivos (instalación/listado visible pero operaciones de archivo inconsistentes). La activación queda bloqueada hasta revisar desde Hostinger la ruta física del plugin y los permisos/propiedad del directorio.
- La inspección visual del Administrador de archivos confirmó la causa: el ZIP `r3` contenía separadores de Windows (`\`). El extractor del hosting los conservó dentro de los nombres de archivo, en vez de crear los subdirectorios del plugin, y WordPress no pudo localizar el archivo principal al activar.
- Se generó el paquete corregido `360-ai-assistant-pro-0.2.0-dev-r4.zip` con 24 entradas y separadores ZIP estándar `/`. SHA-256: `515C9744A87F130A1CB550AD1C9EACF2EFE7E2613DCBF69C8AF5AB8D4E16D7B9`.
- `r3` se eliminó y `r4` se instaló. WordPress reconoce correctamente el archivo principal como `360-ai-assistant-pro/360-ai-assistant-pro.php`.
- Tras una nueva copia completa de UpdraftPlus, el plugin `r4` se activó correctamente. WordPress muestra la acción “Desactivar”.
- Verificación postactivación: Inicio y Contacto cargan correctamente. La interfaz y su configuración pública no se inyectan (`window.A360_PUBLIC` y `.a360-widget` ausentes) porque el plugin sigue por defecto en modo de pruebas, sin secreto API de producción ni documentos aprobados.
- Tras configurar el secreto, la interfaz se cargó y la sesión inicial REST respondió correctamente, pero la conversación devolvió `403 rest_cookie_invalid_nonce`. Se deshabilitó de inmediato la interfaz pública para no dejar un chat defectuoso visible.
- Corrección local preparada: el nonce del asistente usa la cabecera propia `X-A360-Nonce`, evitando la interceptación de autenticación de cookies del núcleo de WordPress. Paquete pendiente de despliegue: `360-ai-assistant-pro-0.2.0-dev-r5.zip`, SHA-256 `D1AE57FB7941D975F76E3B008D7DFC9488C51660DEC78E9BEE5ECF7444C6277C`. Sintaxis PHP y JavaScript superada.
- `r5` desplegado y activado correctamente. Se cargaron nueve documentos comerciales públicos aprobados, se configuró modo Producción y política de privacidad, y se purgó la caché.
- Prueba real final: bootstrap REST `200`; consulta “¿Ofrecéis diseño web?” `200`; respuesta correcta con derivación comercial y URL pública verificada. El chat queda operativo.
- Ajuste visual desplegado en `r6`: el control de consentimiento se posiciona abajo a la izquierda; el asistente se desplaza a la derecha y hacia arriba, con separación específica en móvil para evitar superposición con los controles fijos.
- Salud del sitio (26/11/2026): se instaló el tema de respaldo Twenty Twenty-Five sin activarlo; se ejecutó `wp-cron.php` y desapareció el retraso de `rocket_preload_process_pending`.
- Caché de objetos: se habilitó LiteSpeed Object Cache de Hostinger con Memcached local (`localhost:11211`). La prueba de conexión pasó. LiteSpeed Cache queda con su caché de página explícitamente desactivada; WP Rocket continúa como única caché de página. Salud del sitio muestra “Pruebas completadas”, sin recomendaciones.
- Reversión solicitada: LiteSpeed Cache se desactivó y eliminó por los avisos de incompatibilidad con WP Rocket. Se purgó la caché de WP Rocket y la portada pública continúa cargando correctamente. Vuelve una única recomendación no crítica de Salud del sitio sobre caché de objetos persistente.

## Pendiente / no ejecutado

- Pruebas comerciales reales: dependen de base de conocimiento revisada y llamada real autorizada.
- Brooklyn, WPBakery, Complianz y WP Rocket: están presentes en producción, pero la compatibilidad con el chat activado no se ha validado; no se puede declarar compatibilidad visual o de caché.
- Capturas de chat y panel: el chat permanece sin habilitar hasta configurar privacidad, documentos aprobados y API en modo de pruebas controlado.
- Pruebas de carga, WAF y auditoría de accesibilidad completa: pendientes.

## Riesgos y recomendación

No recomendar activación pública. El proyecto sigue en `0.2.0-dev`; se ha instalado únicamente como preparación reversible. Antes de activar: configurar el secreto exclusivamente en el servidor, aprobar/importar conocimiento, completar QA de compatibilidad con Brooklyn/WPBakery/Complianz/WP Rocket, accesibilidad, abuso y rendimiento, y obtener autorización expresa.
