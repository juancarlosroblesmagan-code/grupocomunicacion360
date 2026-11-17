# Grupo Comunicación 360º — documentación del proyecto

Última actualización documental: 17 de noviembre de 2026.

## Alcance y estado

Este documento recoge el trabajo realizado en la web de [Grupo Comunicación 360º](https://grupocomunicacion360.com/), las decisiones aprobadas y las comprobaciones pendientes. Es un registro de trabajo, **no una copia completa de WordPress ni una garantía de que la web esté terminada**. Algunos detalles proceden del historial de intervención y deben contrastarse antes de cambios posteriores.

El repositorio es público: no se deben subir contraseñas, claves, copias de bases de datos, configuraciones privadas ni datos personales. Tampoco se publica aquí la dirección de correo en texto plano para no facilitar su extracción automática.

## Plataforma y criterios

- WordPress con tema activo **Brooklyn Child**, hijo de Brooklyn, y maquetación existente con **WPBakery**. No se ha utilizado Elementor.
- Mantener las URLs, la cabecera y el pie existentes salvo cambio expresamente aprobado.
- No inventar servicios, precios, condiciones, resultados ni clientes; identificar como ilustrativas las recreaciones y los montajes.
- Conservar imágenes originales, paquetes y plugins de uso incierto. No borrar medios basándose únicamente en una búsqueda parcial.
- Los cambios descritos se realizaron en producción. Antes de nuevas intervenciones, crear una copia y comprobar la versión vigente: los archivos locales de respaldo no necesariamente reflejan el estado actual.

## Trabajo realizado

### Servicios

- Se publicaron las fichas de servicios enlazadas desde el pie, con contenidos específicos y componentes Brooklyn/WPBakery.
- Se recuperó el diseño anterior de las páginas principales **Diseño Web, Tienda Online, Posicionamiento SEO, Redes Sociales y Logotipos y Diseño Gráfico**, conservando sus URLs y formularios. Las fichas nuevas del pie mantuvieron el diseño aprobado.
- Se preservó el diseño de Marketing Digital; posteriormente solo se retiró un correo antiguo de sus datos estructurados, sin rediseñar su contenido.
- **Camiones** volvió a publicarse como servicio independiente en `/servicios/camiones/`, a partir del paquete específico facilitado. Las cuatro imágenes de ejemplo se identificaron como recreaciones y se conservó el formulario.
- Las imágenes y piezas conceptuales no deben presentarse como trabajos reales sin confirmación.

### Portada y portfolios

- Se corrigió la portada para que mostrara un único H1; los tres botones «Contáctanos» apuntan a `/contacto/`.
- **Sanidentalba**: se ajustó la estructura para hacerla coherente con los demás portfolios.
- **SandraVoz**: se desactivó una cabecera negra vacía.
- La revisión de otros proyectos, su autoría y el permiso de uso de imágenes sigue pendiente de confirmación cuando corresponda.

### Blog

- Se rediseñó `/blog/` con cabecera de dos columnas, imagen facilitada por el cliente, ruta «Inicio / Blog» y tarjetas dinámicas.
- Se empleó una copia optimizada de la imagen, conservando el original. La cabecera se comprobó en escritorio y en una vista estrecha de 375 px; esto no equivale a probar todos los dispositivos.
- Las cuatro etiquetas temáticas de la cabecera son **informativas**, no filtros ni categorías funcionales.
- Se mantienen tres entradas reales. Se corrigieron dos entradas que mostraban texto de relleno, actualizando su contenido y extractos y conservando sus URLs. Se comprobó que los enlaces internos añadidos respondían.
- La entrada «Marketing Digital 360: Cómo Integrar Estrategias para Potenciar tu Negocio» quedó en la papelera; no se documenta como eliminada definitivamente.

### SEO

- Se añadieron meta descripciones a las fichas publicadas bajo `/servicios/`.
- Se añadieron datos estructurados básicos `WebPage` en páginas que carecían de JSON-LD. Las páginas con schemas anteriores los conservaron, salvo la retirada posterior del correo antiguo indicada abajo.
- Se retiró el correo antiguo de los bloques JSON-LD de nueve páginas: Inicio, Nosotros, Contacto, Diseño Web, Tienda Online, Posicionamiento SEO, Redes Sociales, Marketing Digital y Logotipos y Diseño Gráfico. No se incluyó el correo nuevo en esos bloques para limitar su exposición.
- En seis páginas de muestra se comprobó que el JSON-LD seguía siendo JSON válido. Esto no sustituye una validación completa de propiedades ni garantiza resultados enriquecidos o posicionamiento.
- Se añadieron la meta descripción de Blog e Imprenta y la canonical del blog mediante el tema hijo. En las páginas comprobadas apareció una sola descripción y una sola canonical por página. Si cambia la configuración SEO, comprobar compatibilidad y duplicados.

### Formularios y correo

- Contact Form 7 está activo. El formulario principal, ID interno 13, se configuró con la dirección nueva aprobada como destinatario y remitente; `Reply-To` conserva el correo introducido por el visitante.
- Se encontró otro formulario antiguo de ejemplo, ID interno 2037, con direcciones de terceros. Se cambiaron su destinatario y remitente a la dirección aprobada, manteniendo `Reply-To` del visitante; no quedó demostrado que este formulario se use en páginas públicas. El segundo correo automático estaba desactivado.
- El pie muestra la dirección aprobada mediante reconstrucción en JavaScript; sin JavaScript, el enlace alternativo conduce a `/contacto/`. Esto dificulta la extracción simple, pero un bot avanzado puede obtener una dirección visible en el navegador. No es protección absoluta.
- En una muestra de seis páginas se comprobó que el HTML recibido no contenía la dirección antigua ni la nueva en texto plano y que el enlace alternativo apuntaba a Contacto. No se afirma una auditoría exhaustiva de todos los recursos o cachés.
- **No se ha realizado una prueba real de envío ni confirmado recepción o entregabilidad.** También debe verificarse que la cuenta exista, que el servidor pueda enviar usando ese remitente y que las respuestas lleguen al visitante.

### Plugins, caché y medios

- Se eliminó **LiteSpeed Cache** y sus ajustes después de una copia y la aprobación del cliente. **WP Rocket** seguía activo en la última revisión.
- **Slider Revolution** se conservó instalado e inactivo; se comprobó que la portada no lo utilizaba.
- Se revisaron parcialmente 589 imágenes. En el inventario parcial, 173 no presentaban referencias detectadas, pero eso **no demuestra que no se utilicen** en ajustes, estilos, plugins, revisiones o enlaces externos. No se eliminaron.

## Pendientes prioritarios

1. Confirmar que la cuenta de contacto está operativa y, con autorización para la prueba, enviar un mensaje controlado desde el formulario y confirmar recepción, remitente, respuesta y aviso mostrado. Revisar también spam y configuración de correo del dominio si falla.
2. Revisar visualmente páginas, menús, formularios y portfolios en móvil y tablet reales o emulados. La prueba de 375 px fue puntual.
3. Confirmar con el cliente servicios, ubicaciones, teléfonos, precios y condiciones, especialmente en **Planes mensuales** y las páginas restauradas. Revisar coherencia de los datos comerciales de schemas anteriores.
4. Validar semánticamente todos los schemas y vigilar duplicados de metadatos si cambia la configuración SEO.
5. Revisar aviso legal, política de privacidad, cookies, enlaces visibles y mecanismo de consentimiento. La última búsqueda en HTML no encontró enlaces visibles en las páginas examinadas; no constituye una auditoría legal completa.
6. Medir rendimiento con herramientas y condiciones documentadas; revisar accesibilidad, contraste, teclado, etiquetas y formularios. No hay una auditoría completa ni una puntuación garantizada.
7. Crear una copia completa posterior a los últimos cambios, comprobar programación y probar su restauración en un entorno seguro. La copia UpdraftPlus comprobada era del 16 de noviembre a las 21:18 y anterior a cambios posteriores; su restauración no se ha probado.
8. Completar el inventario de medios antes de proponer ningún borrado. Convertir las etiquetas del blog en filtros solo si se decide crear categorías funcionales.

## Revisión adicional del 17 de noviembre de 2026

- Una auditoría Lighthouse de **Contacto**, en las condiciones concretas de esa ejecución, informó de 88/100 en accesibilidad, 100/100 en buenas prácticas y 100/100 en SEO. No incluyó una medición de rendimiento, no es una auditoría integral ni certifica cumplimiento.
- Lighthouse señaló contrastes insuficientes, ausencia de una región principal `main`, enlaces sin nombre accesible y elementos de lista fuera de una lista. Se observaron enlaces de redes con el atributo incorrecto `area-label` y varios enlaces de ejemplo con destino `#`; revisar sus destinos reales y la estructura antes de corregirlos.
- `/politica-de-privacidad/` respondió, pero su contenido observado era la plantilla sugerida de WordPress en inglés. Las rutas `/aviso-legal/` y `/politica-de-cookies/` devolvieron 404; esto no descarta que existan páginas distintas con otras URLs. No se detectaron enlaces legales visibles en el HTML de la muestra revisada. Necesita revisión y redacción adaptadas por quien conozca los datos y tratamientos reales; no se debe deducir cumplimiento legal.
- En una revisión inicial faltaban meta descripción en Blog e Imprenta y canonical en Blog; posteriormente se añadieron y comprobaron como se indica arriba. No se ha enviado ningún formulario.
- Se ajustó el contraste del texto escrito en los campos del formulario de Contacto y se comprobó el color aplicado. Los demás problemas de accesibilidad detectados siguen pendientes y no se ha realizado una auditoría completa posterior.
- El cliente facilitó el nombre fiscal y domicilio fiscal de la sociedad. Deben contrastarse y completarse los datos legales necesarios antes de publicar textos legales o sustituir otras direcciones; una dirección fiscal no implica necesariamente atención presencial.

## Copias y material de trabajo

Se guardaron copias locales anteriores a cambios en páginas de servicios, artículos, ajustes del blog, portfolios, estilos, funciones del tema, pie, formularios y schemas. Hay también un inventario parcial de imágenes y paquetes editoriales originales facilitados por el cliente. Estas copias **no equivalen a un respaldo completo restaurable** y pueden contener datos de configuración: conservarlas fuera de repositorios públicos y revisar su contenido antes de compartirlas.

Una copia completa debe abarcar, como mínimo, base de datos, temas, plugins y subidas; debe conservarse en almacenamiento autorizado y validarse mediante una restauración de prueba. No publicar credenciales ni exportaciones completas en GitHub.
