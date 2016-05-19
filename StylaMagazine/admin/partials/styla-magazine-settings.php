<?php
/**
 * Displays the admin interface for the Styla Magazine Plugin.
 */
?>
<div class="wrap">
    <?php
        echo "<h2>" . __( 'Einstellungen > Styla Magazine' ) . "</h2>";
        if($_POST['styla_hidden'] == 'Y') {
            if ($_POST['styla_username'] != '') {
                update_option('styla_username', $_POST['styla_username']);
            } else {
                delete_option('styla_username');
            }
            if ($_POST['styla_magazine_path'] != '') {
                update_option('styla_magazine_path', $_POST['styla_magazine_path']);
            } else {
                delete_option('styla_magazine_path');
            }
            if ($_POST['styla_content_server'] != '') {
                update_option('styla_content_server', $_POST['styla_content_server']);
            } else {
                delete_option('styla_content_server');
            }
    ?>
            <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
    <?php
        }
    ?>
    <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" novalidate="novalidate">
        <input type="hidden" name="styla_hidden" value="Y">
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e("Domain" ); ?></th>
                <td>
                    <input type="text" name="styla_username" value="<?php echo get_option('styla_username'); ?>" class="regular-text">
                    <p class="description">Domain of the magazine (e.g. "ludwigbeck")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Magazine Root Path" ); ?></th>
                <td>
                    <input type="text" name="styla_magazine_path" value="<?php echo get_option('styla_magazine_path'); ?>" class="regular-text">
                    <p class="description">The magazine root path (default: "")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("SEO Server" ); ?></th>
                <td>
                    <input type="text" name="styla_seo_server" value="<?php echo get_option('styla_seo_server'); ?>" class="regular-text" placeholder="http://seo.styla.com/">
                    <p class="description">Server address that delivers SEO information for the magazine (default: "http://seo.styla.com/")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Content Server" ); ?></th>
                <td>
                    <input type="text" name="styla_content_server" value="<?php echo get_option('styla_content_server'); ?>" class="regular-text" placeholder="http://cdn.styla.com/">
                    <p class="description">Server address that delivers the magazine script and styles (default: "http://cdn.styla.com/")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Version Server" ); ?></th>
                <td>
                    <input type="text" name="styla_version_server" value="<?php echo get_option('styla_version_server'); ?>" class="regular-text" placeholder="http://live.styla.com/api/version/">
                    <p class="description">Server address that delivers the current magazine script and styles version number (default: "http://live.styla.com/api/version/")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Enable Caching" ); ?></th>
                <td>
                    <input type="checkbox" name="styla_caching_enabled" value="<?php echo get_option('styla_caching_enabled'); ?>">
                    <p class="description">Enable caching of SEO and version information (default: enabled)</p>
                </td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="&Auml;nderungen &uuml;bernehmen"></p>
    </form>
</div>
