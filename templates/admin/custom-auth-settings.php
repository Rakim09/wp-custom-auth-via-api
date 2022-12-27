<?php
/**
 * Custom Auth via API
 *
 * @package   custom-auth-via-api
 * @author    R-DEV <office@r-dev.cloud>
 * @copyright 2022 Custom Auth via API
 * @license   MIT
 * @link      https://r-dev.cloud
 */
?>
<?php
/**
 * @see \CustomAuthViaApi\App\Backend\Settings
 */
?>
<div class="wrap">
    <h2><?= $this->plugin->name() ?></h2>
    <form method="POST" action="options.php">
        <?php
        settings_fields('custom-auth-general-settings');
        do_settings_sections('custom-auth-general-settings');
        ?>
        <?php submit_button(); ?>
    </form>
</div>