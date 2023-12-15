# Word Replacer Plugin for WordPress

Este es un plugin para WordPress cuya funcionalidad principal es reemplazar palabras específicas en el contenido de las publicaciones por términos alternativos. El propósito es ofrecer una manera sencilla de personalizar el lenguaje utilizado en el sitio.


## Configuración de Sustitución de Palabras

<details>
<summary>Explicación</summary>

El array de sustitución se define en el inicio del código y puede ser personalizado según las necesidades del usuario:

```php
$replacement_words = get_option('word_replacer_words', array(
    'mierda' => 'hez',
    'puta' => 'colega',
    'cagar' => 'defecar',
    'follar' => 'comer spaghetti con queso',
    'polla' => 'gallina'
    // Añade más palabras según sea necesario
));
```

Estas palabras y sus respectivos reemplazos se pueden modificar desde la página de configuración en el backend de WordPress.

</details>

## Función de Filtrado en el Contenido

<details>
<summary>Explicación</summary>

El plugin utiliza el hook `the_content` para filtrar el contenido principal de las publicaciones. La función `filter_the_content_in_the_main_loop` realiza la sustitución de palabras malsonantes según el array definido previamente.

```php
add_filter('the_content', 'filter_the_content_in_the_main_loop', 1);

function filter_the_content_in_the_main_loop($content) {
    global $replacement_words;

    // Verifica si estamos dentro del bucle principal en un solo post
    if (is_singular() && in_the_loop() && is_main_query()) {
        // Realiza la sustitución de palabras
        $content = str_replace(array_keys($replacement_words), array_values($replacement_words), $content);

        return $content . esc_html__('Content filtered inside the main loop', 'word-replacer');
    }

    return $content;
}
```

</details>

## Configuración en el Backend

<details>
<summary>Explicación</summary>

El plugin agrega una página de configuración en el backend de WordPress para que los usuarios puedan personalizar las palabras de sustitución. Esto se logra mediante las siguientes funciones:

```php
add_action('admin_menu', 'word_replacer_menu');

function word_replacer_menu() {
    add_menu_page('Word Replacer Settings', 'Word Replacer', 'manage_options', 'word-replacer-settings', 'word_replacer_settings_page');
}

function word_replacer_settings_page() {
    // ... Código para la página de configuración ...
}
```

En la página de configuración, los usuarios pueden ver y editar las palabras de sustitución:

- Las palabras originales se muestran en campos de texto, y los usuarios pueden editar los términos de sustitución.
- Al hacer clic en "Save Changes," las configuraciones se guardan en la base de datos.

</details>

<p></p>
<p></p>


Este plugin proporciona una forma sencilla y flexible de personalizar el lenguaje utilizado en un sitio WordPress, adaptándolo a las preferencias del usuario.