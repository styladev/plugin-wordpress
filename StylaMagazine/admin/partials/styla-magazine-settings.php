<?php
/**
 * Displays the admin interface for the Styla Magazine Plugin.
 */
?>
<div class="wrap">
    <?php
        echo "<h2>" . __( 'Einstellungen > Styla Magazine' ) . "</h2>";
        if(!empty($_POST) && $_POST['styla_hidden'] == 'Y') {
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

            if ($_POST['styla_magazine_page_slug'] != '') {
                update_option('styla_magazine_page_slug', $_POST['styla_magazine_page_slug']);
            } else {
                delete_option('styla_magazine_page_slug');
            }

            if ($_POST['styla_seo_server'] != '') {
                update_option('styla_seo_server', $_POST['styla_seo_server']);
            } else {
                delete_option('styla_seo_server');
            }

            if ($_POST['styla_content_server'] != '') {
                update_option('styla_content_server', $_POST['styla_content_server']);
            } else {
                delete_option('styla_content_server');
            }

            if ($_POST['styla_version_server'] != '') {
                update_option('styla_version_server', $_POST['styla_version_server']);
            } else {
                delete_option('styla_version_server');
            }

            do_action( 'wpml_register_single_string', "StylaMagazine", "styla_username", $_POST['styla_username'] );
            do_action( 'wpml_register_single_string', "StylaMagazine", "styla_magazine_path", $_POST['styla_magazine_path'] );

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
                    <input type="text" name="styla_username" value="<?php echo isset($_POST['styla_username']) ? $_POST['styla_username'] : get_option('styla_username'); ?>" class="regular-text">
                    <p class="description">Domain name of the magazine (provided by Styla)</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Magazine Root Path" ); ?></th>
                <td>
                    <input type="text" name="styla_magazine_path" value="<?php echo isset($_POST['styla_magazine_path']) ? $_POST['styla_magazine_path'] : get_option('styla_magazine_path'); ?>" class="regular-text">
                    <p class="description">The magazine root path (e.g. "magazine" for example.com/magazine ; leave empty if the magazine is on your front page; default: "")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Magazine Page Slug" ); ?></th>
                <td>
                    <input type="text" name="styla_magazine_page_slug" value="<?php echo isset($_POST['styla_magazine_page_slug']) ? $_POST['styla_magazine_page_slug'] : get_option('styla_magazine_page_slug'); ?>" class="regular-text">
                    <p class="description">Slug of the magazine page. Only required if magazine is shown on the front page (default: "")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("SEO Server" ); ?></th>
                <td>
                    <input type="text" name="styla_seo_server" value="<?php echo isset($_POST['styla_seo_server']) ? $_POST['styla_seo_server'] : get_option('styla_seo_server'); ?>" class="regular-text" placeholder="http://seo.styla.com/clients/">
                    <p class="description">Server address that delivers SEO information for the magazine (default: "http://seo.styla.com/clients/")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Content Server" ); ?></th>
                <td>
                    <input type="text" name="styla_content_server" value="<?php echo isset($_POST['styla_content_server']) ? $_POST['styla_content_server'] : get_option('styla_content_server'); ?>" class="regular-text" placeholder="//client-scripts.styla.com/">
                    <p class="description">Server address that delivers the magazine script and styles (default: "//client-scripts.styla.com/")</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e("Version Server" ); ?></th>
                <td>
                    <input type="text" name="styla_version_server" value="<?php echo isset($_POST['styla_version_server']) ? $_POST['styla_version_server'] : get_option('styla_version_server'); ?>" class="regular-text" placeholder="http://live.styla.com/api/version/">
                    <p class="description">Server address that delivers the current magazine script and styles version number (default: "http://live.styla.com/api/version/")</p>
                </td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
    </form>
</div>
