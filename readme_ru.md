# Ядро для разрадотки плагинов/тем для WP

## Установка
```bash
composer install sau/wp-core
```
Для плагина:
```php
add_action( 'plugins_loaded', function () {
    $debug = true;
    if ( $debug ) {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler( new \Whoops\Handler\PrettyPageHandler );
        $whoops->register();
    }

    $kernel = new Kernel( __DIR__, $debug );
    $kernel->run();
} );
```
Для темы:
```php
// не проверено
```

> Рекомендую разрабатывать плагин а тему писать отдельно опираясь на него 
