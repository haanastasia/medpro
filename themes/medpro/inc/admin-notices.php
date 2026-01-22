<?php
/**
 * Admin Notices
 * @package medpro
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Проверка плагина Cyr-To-Lat для темы Medpro
 */
add_action('admin_notices', function() {
    if (!defined('CYR_TO_LAT_VERSION')) {
        ?>
<div class="notice notice-warning is-dismissible">
    <p>
        <strong>Medpro:</strong> Для правильного формирования URL рекомендуем установить/активировать плагин
        <a href="<?php echo esc_url(admin_url('plugin-install.php?s=Cyr+To+Lat&tab=search&type=term')); ?>"
            target="_blank">
            Cyr-To-Lat
        </a>.
    </p>
</div>
<?php
    }
});