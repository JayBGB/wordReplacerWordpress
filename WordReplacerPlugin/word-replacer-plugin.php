<?php
/*
Plugin Name: DAM experimento
Plugin URI: http://www.danielcastelao.org/
Description: Experimentación de varias técnicas para hacer un plugin
Version: 1.0
*/

// Define el array de sustitución (por defecto o desde la base de datos)
$replacement_words = get_option('word_replacer_words', array(
    'mierda' => 'hez',
    'puta' => 'colega',
    'cagar' => 'defecar',
    'follar' => 'comer spaghetti con queso',
    'polla' => 'gallina'
    // Añade más palabras según sea necesario
));

// Hook para reemplazar palabras en el contenido
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

// Añade la página de configuración en el backend
add_action('admin_menu', 'word_replacer_menu');

function word_replacer_menu() {
    add_menu_page('Word Replacer Settings', 'Word Replacer', 'manage_options', 'word-replacer-settings', 'word_replacer_settings_page');
}

// Página de configuración en el backend
function word_replacer_settings_page() {
    global $replacement_words;

    if (isset($_POST['word_replacer_submit'])) {
        // Actualiza las palabras de sustitución en la base de datos
        $replacement_words = array_map('sanitize_text_field', $_POST['replacement_words']);
        update_option('word_replacer_words', $replacement_words);
        echo '<div class="updated"><p>Settings saved</p></div>';
    }

    ?>
    <div class="wrap">
        <h2>Word Replacer Settings</h2>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Replacement Words:</th>
                    <td>
                        <?php foreach ($replacement_words as $bad => $good) : ?>
                            <input type="text" name="replacement_words[<?php echo esc_attr($bad); ?>]" value="<?php echo esc_attr($good); ?>"><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
            <input type="submit" name="word_replacer_submit" class="button-primary" value="Save Changes">
        </form>
    </div>
    <?php
}
