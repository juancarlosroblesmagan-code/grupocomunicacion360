# Informe de pruebas — 0.2.0-dev

## Ejecutadas

| Prueba | Resultado | Evidencia |
|---|---|---|
| Sintaxis PHP | Superada | `php -l` con PHP 8.2.12 en todos los archivos PHP del plugin. |
| Sintaxis JavaScript | Superada | `node --check assets/public.js` con Node 24.21.0. |
| Instalación/activación local | Superada | Plugin activado en WordPress local limpio. |
| Tablas de activación | Superada | Creadas `g360dev_a360_limits` y `g360dev_a360_stats`. |
| Tabla de conocimiento | Superada | Creada `g360dev_a360_knowledge` tras actualizar el plugin local. |
| Recuperación local | Superada | Documento aprobado temporal recuperado por una consulta y eliminado al terminar. |
| Límite y reserva de presupuesto | Superada | Límite persistente y reserva de 0,001 USD comprobados en la base local. |
| Desinstalación controlada | Revisada estáticamente | Conserva datos por defecto; exige constante explícita para borrarlos. Ejecución destructiva pendiente de autorización específica. |
| Aislamiento de modo pruebas | Superada | Con clave ficticia local: `test` no habilita el recurso público y `live` sí; llamadas API: 0. |
| Responses API simulada | Superada | `pre_http_request` devolvió una respuesta Responses válida; el cliente extrajo el texto esperado; llamadas externas: 0. |
| Error de autenticación API simulado | Superada | Una respuesta HTTP 401 se clasifica internamente como `a360_auth`; al visitante se le devuelve un error genérico; llamadas externas: 0. |
| Llamada real a OpenAI | Superada | Una consulta mínima con `gpt-4.1-mini`, máximo de 60 tokens de salida; respuesta correcta. Coste/tokens exactos no capturados. |
| UI, caché, Brooklyn/WPBakery, accesibilidad y responsive | Pendiente | No se ha validado el chat activado con estos componentes en un staging equivalente. |

No se declara superada ninguna prueba pendiente.
