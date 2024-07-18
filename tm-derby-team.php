<?php
/*
Plugin Name: TM Derby Team
Description: Organize and display a grid of roller derby team members.
Plugin URI: https://thinmint333.com/wp-plugins/tm-derby-team/
Version: 1.4
Author: Thin Mint
Author URI: https://thinmint333.com/
License: GPL-3.0+
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

// Register custom post type for team members
function tm_derby_team_register_post_type() {
    $labels = array(
        'name'               => 'Team Members',
        'singular_name'      => 'Team Member',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Team Member',
        'edit_item'          => 'Edit Team Member',
        'new_item'           => 'New Team Member',
        'all_items'          => 'All Team Members',
        'view_item'          => 'View Team Member',
        'search_items'       => 'Search Team Members',
        'not_found'          => 'No team members found',
        'not_found_in_trash' => 'No team members found in Trash',
        'menu_name'          => 'TM Derby Team',
    );
    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'menu_position'       => 20,
        'supports'            => array( 'title', 'thumbnail' ),
        'menu_icon'           => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyOC4zLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiMwMTAxMDE7fQ0KPC9zdHlsZT4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xOC45LDQuMkMxNy41LDEuNywxNC44LDAsMTEuOCwwSDguMkMzLjcsMCwwLDMuOCwwLDguNGMwLDIuNCwxLDQuOSwxLjQsNS44YzIsMCw0LjEsMSw1LjItMC4yDQoJYzEuMywwLjUsMy4yLDEuNywzLjYsMy43Yy0wLjEsMC4xLTAuMSwwLjItMC4xLDAuNHYxYzAsMC41LDAuNCwwLjksMC44LDAuOXMwLjgtMC40LDAuOC0wLjl2LTFjMC0wLjEsMC0wLjMtMC4xLTAuNA0KCWMwLjItMy4zLDAuOC01LjcsMS4zLTdjMC42LTAuMSwxLjMtMC41LDEuOC0xQzE2LjIsOC40LDE4LjMsOC4zLDIwLDhDMjAsOCwxOS42LDUuNSwxOC45LDQuMnogTTUuMiwxMy4xYy0wLjMsMC0wLjUtMC4yLTAuNS0wLjUNCglzMC4yLTAuNSwwLjUtMC41YzAuMywwLDAuNSwwLjIsMC41LDAuNVM1LjQsMTMuMSw1LjIsMTMuMXogTTUuMSwxMC4ybDAuNC0zLjFMMi43LDUuOGwzLTAuNmwwLjMtMy4xbDEuNSwyLjdsMy0wLjZMOC41LDYuNUwxMCw5LjINCglMNy4yLDcuOUw1LjEsMTAuMnogTTEwLjYsMTUuMWMtMC45LTEuMi0yLjMtMS45LTMuMi0yLjRjMC0wLjEsMC4xLTAuMiwwLjEtMC40YzAuMy0xLjUsMS4zLTIuMiwyLjYtMi4yYzAuNCwwLDAuOCwwLjEsMS4yLDAuMw0KCWMwLjEsMC4xLDAuMiwwLjEsMC40LDAuMUMxMS4yLDExLjYsMTAuOCwxMy4xLDEwLjYsMTUuMXogTTEyLjcsOS4zYy0wLjMsMC0wLjUtMC4yLTAuNS0wLjVzMC4yLTAuNSwwLjUtMC41YzAuMywwLDAuNSwwLjIsMC41LDAuNQ0KCVMxMyw5LjMsMTIuNyw5LjN6Ii8+DQo8L3N2Zz4NCg==', // Add your SVG icon in base64 format here

    );
    register_post_type( 'team_member', $args );
}
add_action( 'init', 'tm_derby_team_register_post_type' );

// Add custom fields to the custom post type
function tm_derby_team_add_custom_fields() {
    add_meta_box(
        'tm_derby_team_custom_fields',
        'Team Member Custom Fields',
        'tm_derby_team_render_custom_fields',
        'team_member',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'tm_derby_team_add_custom_fields');

// Render custom fields HTML
function tm_derby_team_render_custom_fields($post) {
    // Nonce field for security
    wp_nonce_field('tm_derby_team_custom_fields_nonce', 'tm_derby_team_custom_fields_nonce');

    // Get existing values for fields
    $jersey_number = get_post_meta($post->ID, '_jersey_number', true);
    $position = get_post_meta($post->ID, '_position', true);
    $pronouns = get_post_meta($post->ID, '_pronouns', true);
    $home_team = get_post_meta($post->ID, '_home_team', true);

    // Output custom fields HTML
    ?>
    <p>
        <label for="tm_derby_team_jersey_number">Jersey Number:</label>
        <input type="text" id="tm_derby_team_jersey_number" name="tm_derby_team_jersey_number" value="<?php echo esc_attr($jersey_number); ?>">
    </p>
    <p>
        <label for="tm_derby_team_position">Position:</label>
        <input type="text" id="tm_derby_team_position" name="tm_derby_team_position" value="<?php echo esc_attr($position); ?>">
    </p>
    <p>
        <label for="tm_derby_team_pronouns">Pronouns:</label>
        <input type="text" id="tm_derby_team_pronouns" name="tm_derby_team_pronouns" value="<?php echo esc_attr($pronouns); ?>">
    </p>
        <p>
        <label for="tm_derby_team_home_team">Home Team (for Borderless/Collective teams):</label>
        <input type="text" id="tm_derby_team_home_team" name="tm_derby_team_home_team" value="<?php echo esc_attr($home_team); ?>">
    </p>
    <?php
}

// Save custom fields data
function tm_derby_team_save_custom_fields($post_id) {
    // Check nonce
    if (!isset($_POST['tm_derby_team_custom_fields_nonce']) || !wp_verify_nonce($_POST['tm_derby_team_custom_fields_nonce'], 'tm_derby_team_custom_fields_nonce')) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save custom fields data
    if (isset($_POST['tm_derby_team_jersey_number'])) {
        update_post_meta($post_id, '_jersey_number', sanitize_text_field($_POST['tm_derby_team_jersey_number']));
    }
    if (isset($_POST['tm_derby_team_position'])) {
        update_post_meta($post_id, '_position', sanitize_text_field($_POST['tm_derby_team_position']));
    }
    if (isset($_POST['tm_derby_team_pronouns'])) {
        update_post_meta($post_id, '_pronouns', sanitize_text_field($_POST['tm_derby_team_pronouns']));
    }
    if (isset($_POST['tm_derby_team_home_team'])) {
        update_post_meta($post_id, '_home_team', sanitize_text_field($_POST['tm_derby_team_home_team']));
    }
}
add_action('save_post', 'tm_derby_team_save_custom_fields');

// Register taxonomy for teams
function tm_derby_team_register_taxonomy() {
    $labels = array(
        'name'              => 'Teams',
        'singular_name'     => 'Team',
        'search_items'      => 'Search Teams',
        'all_items'         => 'All Teams',
        'parent_item'       => 'Parent Team',
        'parent_item_colon' => 'Parent Team:',
        'edit_item'         => 'Edit Team',
        'update_item'       => 'Update Team',
        'add_new_item'      => 'Add New Team',
        'new_item_name'     => 'New Team Name',
        'menu_name'         => 'Teams',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'team' ),
    );
    register_taxonomy( 'team', 'team_member', $args );
}
add_action( 'init', 'tm_derby_team_register_taxonomy' );

// Shortcode to display team members grid
function tm_derby_team_shortcode($atts) {
    $atts = shortcode_atts(array(
        'team' => '', // Default to empty, which will display all teams
        'order' => 'number', // Default order is by jersey number
    ), $atts);

    $team_slug = sanitize_title($atts['team']);
    $order = sanitize_text_field($atts['order']);

    // Set default sorting to jersey number
    $meta_key = '_jersey_number';
    $orderby = 'meta_value_num';

    // If order is set to 'name', sort alphabetically by title
    if ($order === 'name') {
        $meta_key = '';
        $orderby = 'title';
    }

    $args = array(
        'post_type' => 'team_member',
        'posts_per_page' => -1,
        'meta_key' => $meta_key,
        'orderby' => $orderby,
        'order' => 'ASC', // Ascending order
    );

    if (!empty($team_slug)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'team',
                'field'    => 'slug',
                'terms'    => $team_slug,
            ),
        );
    }

    $team_members = new WP_Query($args);

    ob_start();
    ?>
    <div class="tm-derby-team">
        <?php if ($team_members->have_posts()) : ?>
            <div class="tm-derby-team-grid">
                <?php while ($team_members->have_posts()) : $team_members->the_post(); ?>
                    <div class="tm-derby-team-member">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="tm-derby-team-member-thumbnail">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                        <?php else : ?>
                            <div class="tm-derby-team-member-thumbnail">
                                <img src="<?php echo esc_url(get_option('tm_derby_team_default_image')); ?>" alt="<?php the_title(); ?>" />
                            </div>
                        <?php endif; ?>
                        <?php
                        // Get jersey number
                        $jersey_number = get_post_meta(get_the_ID(), '_jersey_number', true);
                        if (!empty($jersey_number)) :
                            echo '<h2>' . esc_html($jersey_number) . '</h2>';
                        endif;
                        ?>
                        <h4><?php the_title(); ?></h4>
                        <?php
                        // Get position
                        $position = get_post_meta(get_the_ID(), '_position', true);
                        if (!empty($position)) :
                            echo '<h6><em>' . esc_html($position) . '</em></h6>';
                        endif;
                        ?>
                        <?php
                        // Get pronouns
                        $pronouns = get_post_meta(get_the_ID(), '_pronouns', true);
                        if (!empty($pronouns)) :
                            echo '<p>' . esc_html($pronouns) . '</p>';
                        endif;
                        ?>
                        <?php
                        // Get home team
                        $home_team = get_post_meta(get_the_ID(), '_home_team', true);
                        if (!empty($home_team)) :
                            echo '<p><strong>' . esc_html($home_team) . '</strong></p>';
                        endif;
                        ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <h2 align="center">No team members found.</h2>
        <?php endif; ?>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('tm_derby_team', 'tm_derby_team_shortcode');

// Enqueue styles
function tm_derby_team_enqueue_styles() {
    // Enqueue stylesheet
    wp_enqueue_style( 'tm-derby-team-styles', plugin_dir_url( __FILE__ ) . 'css/tm-derby-team-styles.css' );
}
add_action( 'wp_enqueue_scripts', 'tm_derby_team_enqueue_styles' );

// Add settings page
function tm_derby_team_settings_page() {
    add_options_page(
        'TM Derby Team Settings',
        'TM Derby Team',
        'manage_options',
        'tm-derby-team-settings',
        'tm_derby_team_settings_page_html'
    );
}
add_action('admin_menu', 'tm_derby_team_settings_page');

// Register settings
function tm_derby_team_register_settings() {
    register_setting('tm_derby_team_options', 'tm_derby_team_default_image');
    add_settings_section('tm_derby_team_settings_section', 'Default Image Settings', 'tm_derby_team_settings_section_cb', 'tm_derby_team_settings');
    add_settings_field('tm_derby_team_default_image', 'Default Featured Image', 'tm_derby_team_default_image_cb', 'tm_derby_team_settings', 'tm_derby_team_settings_section');
}
add_action('admin_init', 'tm_derby_team_register_settings');

function tm_derby_team_settings_section_cb() {
    echo '<p>Select a default image to use when a team member does not have a featured image.</p>';
}

function tm_derby_team_default_image_cb() {
    $image_url = get_option('tm_derby_team_default_image');
    ?>
    <input type="text" id="tm_derby_team_default_image" name="tm_derby_team_default_image" value="<?php echo esc_attr($image_url); ?>" />
    <input type="button" class="button-primary" id="tm_derby_team_default_image_button" value="Select Image" />
    <?php
}

function tm_derby_team_settings_page_html() {
    ?>
    <div class="wrap">
        <h1>TM Derby Team Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('tm_derby_team_options');
            do_settings_sections('tm_derby_team_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Enqueue media uploader script
function tm_derby_team_enqueue_media_uploader($hook) {
    if ($hook != 'settings_page_tm-derby-team-settings') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('tm_derby_team_media_uploader', plugin_dir_url(__FILE__) . 'js/media-uploader.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'tm_derby_team_enqueue_media_uploader');

// Add JavaScript for media uploader
function tm_derby_team_media_uploader_js() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('#tm_derby_team_default_image_button').click(function(e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Select Default Featured Image',
                multiple: false
            }).open()
            .on('select', function() {
                var uploaded_image = image.state().get('selection').first();
                var image_url = uploaded_image.toJSON().url;
                $('#tm_derby_team_default_image').val(image_url);
            });
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'tm_derby_team_media_uploader_js');

?>
