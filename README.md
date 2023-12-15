# Word DB Replacer Plugin for WordPress

Este es un plugin de WordPress llamado "Word DB Replacer" que realiza sustituciones de palabras utilizando una base de datos. A continuación, se explican las diferencias y las nuevas funcionalidades en comparación con la versión anterior del plugin.

## Cambios Principales

### Acceso a la Base de Datos

<details>
<summary>Explicación</summary>

En esta versión, el plugin utiliza una base de datos para almacenar las palabras a sustituir. Se ha agregado una nueva tabla `damJay` en la base de datos de WordPress para almacenar las palabras y sus sustituciones.

```php
function createTable(){
    // ... Código para la creación de la tabla en la base de datos ...
}

add_action( 'plugins_loaded', 'createTable' );
```

La función `createTable` se encarga de crear la tabla `damJay` cuando el plugin se carga. La tabla tiene columnas para almacenar las palabras originales (`cars`) y sus sustituciones (`places`).

</details>

### Sustituciones Dinámicas desde la Base de Datos

<details>
<summary>Explicación</summary>

En lugar de tener un array estático de palabras, el plugin ahora recupera las palabras y sus sustituciones desde la base de datos:

```php
function renym_wordpress_typo_fix($text){
    $words = selectData();
    foreach ($words as $result){
        $cars[] = $result->cars;
        $places[] = $result->places;
    }
    return str_replace($cars, $places, $text);
}

add_filter('the_content', 'renym_wordpress_typo_fix');
```

La función `renym_wordpress_typo_fix` obtiene las palabras y sustituciones de la base de datos utilizando la función `selectData`. Luego, realiza las sustituciones en el contenido utilizando la función `str_replace`.

</details>

### Actualización de la Página de Configuración

<details>
<summary>Explicación</summary>

La página de configuración en el backend ha sido actualizada para reflejar la nueva estructura basada en la base de datos. Ahora, se insertan datos en la base de datos en lugar de utilizar arrays estáticos.

```php
function insertData(){
    // ... Código para insertar datos en la base de datos ...
}

add_action( 'plugins_loaded', 'insertData' );
```

La función `insertData` se ejecuta cuando el plugin se carga y verifica si ya hay datos en la tabla. Si no hay datos, inserta los valores de los arrays de alimentos (`$foods`) y empresas tecnológicas (`$companies`) en la base de datos.

</details>

## Uso del Plugin

1. **Activación del Plugin:**
   - Activa el plugin desde el panel de administración de WordPress.

2. **Configuración:**
   - No se requiere configuración manual. El plugin crea automáticamente la tabla en la base de datos y la llena con datos iniciales.

3. **Funcionamiento:**
   - El plugin sustituye dinámicamente las palabras en el contenido según lo definido en la base de datos.

Este plugin proporciona una forma flexible de gestionar y personalizar las sustituciones de palabras mediante el uso de una base de datos en lugar de arrays estáticos.