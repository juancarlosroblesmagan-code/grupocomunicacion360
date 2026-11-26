# Plan de rollback

Desactivar el plugin detiene interfaz y consultas. No borra documentos ni métricas automáticamente. La desinstalación también conserva los datos salvo que el responsable defina explícitamente `A360_REMOVE_DATA_ON_UNINSTALL` como `true`. Para retirada completa, exportar o eliminar deliberadamente las tablas `*_a360_*` y revocar la clave si hubiera exposición.
