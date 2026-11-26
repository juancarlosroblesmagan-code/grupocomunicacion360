# Configuración de API

Configura en el servidor una variable `A360_OPENAI_API_KEY`, o una constante privada en `wp-config.php` fuera del repositorio:

```php
define( 'A360_OPENAI_API_KEY', 'clave-solo-en-servidor' );
```

No compartas la clave por chat ni la exportes. Usa un proyecto de OpenAI distinto para pruebas y producción, con alertas y límite de gasto.
