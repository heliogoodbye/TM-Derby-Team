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

class TM_Derby_Team {

    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_custom_fields'));
        add_action('save_post', array($this, 'save_custom_fields'));
        add_action('init', array($this, 'register_taxonomy'));
        add_shortcode('tm_derby_team', array($this, 'shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('admin_menu', array($this, 'settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_media_uploader'));
        add_action('admin_footer', array($this, 'media_uploader_js'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
    }

    public function load_textdomain() {
        load_plugin_textdomain('tm-derby-team', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    public function register_post_type() {
        $labels = array(
            'name' => __('Team Members', 'tm-derby-team'),
            'singular_name' => __('Team Member', 'tm-derby-team'),
            'add_new' => __('Add New', 'tm-derby-team'),
            'add_new_item' => __('Add New Team Member', 'tm-derby-team'),
            'edit_item' => __('Edit Team Member', 'tm-derby-team'),
            'new_item' => __('New Team Member', 'tm-derby-team'),
            'all_items' => __('All Team Members', 'tm-derby-team'),
            'view_item' => __('View Team Member', 'tm-derby-team'),
            'search_items' => __('Search Team Members', 'tm-derby-team'),
            'not_found' => __('No team members found', 'tm-derby-team'),
            'not_found_in_trash' => __('No team members found in Trash', 'tm-derby-team'),
            'menu_name' => __('TM Derby Team', 'tm-derby-team'),
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_position' => 20,
            'supports' => array('title', 'thumbnail'),
            'menu_icon' => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyOC4zLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiMwMTAxMDE7fQ0KPC9zdHlsZT4NCjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0xOC45LDQuMkMxNy41LDEuNywxNC44LDAsMTEuOCwwSDguMkMzLjcsMCwwLDMuOCwwLDguNGMwLDIuNCwxLDQuOSwxLjQsNS44YzIsMCw0LjEsMSw1LjItMC4yDQoJYzEuMywwLjUsMy4yLDEuNywzLjYsMy43Yy0wLjEsMC4xLTAuMSwwLjItMC4xLDAuNHYxYzAsMC41LDAuNCwwLjksMC44LDAuOXMwLjgtMC40LDAuOC0wLjl2LTFjMC0wLjEsMC0wLjMtMC4xLTAuNA0KCWMwLjItMy4zLDAuOC01LjcsMS4zLTdjMC42LTAuMSwxLjMtMC41LDEuOC0xQzE2LjIsOC40LDE4LjMsOC4zLDIwLDhDMjAsOCwxOS42LDUuNSwxOC45LDQuMnogTTUuMiwxMy4xYy0wLjMsMC0wLjUtMC4yLTAuNS0wLjUNCglzMC4yLTAuNSwwLjUtMC41YzAuMywwLDAuNSwwLjIsMC41LDAuNVM1LjQsMTMuMSw1LjIsMTMuMXogTTUuMSwxMC4ybDAuNC0zLjFMMi43LDUuOGwzLTAuNmwwLjMtMy4xbDEuNSwyLjdsMy0wLjZMOC41LDYuNUwxMCw5LjINCglMNy4yLDcuOUw1LjEsMTAuMnogTTEwLjYsMTUuMWMtMC45LTEuMi0yLjMtMS45LTMuMi0yLjRjMC0wLjEsMC4xLTAuMiwwLjEtMC40YzAuMy0xLjUsMS4zLTIuMiwyLjYtMi4yYzAuNCwwLDAuOCwwLjEsMS4yLDAuMw0KCWMwLjEsMC4xLDAuMiwwLjEsMC40LDAuMUMxMS4yLDExLjYsMTAuOCwxMy4xLDEwLjYsMTUuMXogTTEyLjcsOS4zYy0wLjMsMC0wLjUtMC4yLTAuNS0wLjVzMC4yLTAuNSwwLjUtMC41YzAuMywwLDAuNSwwLjIsMC41LDAuNQ0KCVMxMyw5LjMsMTIuNyw5LjN6Ii8+DQo8L3N2Zz4NCg==',
        );
        register_post_type('team_member', $args);
    }

    public function add_custom_fields() {
        add_meta_box(
            'tm_derby_team_custom_fields',
            __('Team Member Custom Fields', 'tm-derby-team'),
            array($this, 'render_custom_fields'),
            'team_member',
            'normal',
            'default'
        );
    }

    public function render_custom_fields($post) {
        wp_nonce_field('tm_derby_team_custom_fields_nonce', 'tm_derby_team_custom_fields_nonce');

        $jersey_number = get_post_meta($post->ID, '_jersey_number', true);
        $position = get_post_meta($post->ID, '_position', true);
        $pronouns = get_post_meta($post->ID, '_pronouns', true);
        $home_team = get_post_meta($post->ID, '_home_team', true);

        ?>
        <p>
            <label for="jersey_number"><?php _e('Jersey Number', 'tm-derby-team'); ?></label>
            <input type="text" name="jersey_number" id="jersey_number" value="<?php echo esc_attr($jersey_number); ?>" />
        </p>
        <p>
            <label for="position"><?php _e('Position', 'tm-derby-team'); ?></label>
            <input type="text" name="position" id="position" value="<?php echo esc_attr($position); ?>" />
        </p>
        <p>
            <label for="pronouns"><?php _e('Pronouns', 'tm-derby-team'); ?></label>
            <input type="text" name="pronouns" id="pronouns" value="<?php echo esc_attr($pronouns); ?>" />
        </p>
        <p>
            <label for="home_team"><?php _e('Home Team', 'tm-derby-team'); ?></label>
            <input type="text" name="home_team" id="home_team" value="<?php echo esc_attr($home_team); ?>" />
        </p>
        <?php
    }

    public function save_custom_fields($post_id) {
        if (!isset($_POST['tm_derby_team_custom_fields_nonce']) || !wp_verify_nonce($_POST['tm_derby_team_custom_fields_nonce'], 'tm_derby_team_custom_fields_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $fields = array('jersey_number', 'position', 'pronouns', 'home_team');

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
            }
        }
    }

    public function register_taxonomy() {
        $labels = array(
            'name' => __('Teams', 'tm-derby-team'),
            'singular_name' => __('Team', 'tm-derby-team'),
            'search_items' => __('Search Teams', 'tm-derby-team'),
            'all_items' => __('All Teams', 'tm-derby-team'),
            'parent_item' => __('Parent Team', 'tm-derby-team'),
            'parent_item_colon' => __('Parent Team:', 'tm-derby-team'),
            'edit_item' => __('Edit Team', 'tm-derby-team'),
            'update_item' => __('Update Team', 'tm-derby-team'),
            'add_new_item' => __('Add New Team', 'tm-derby-team'),
            'new_item_name' => __('New Team Name', 'tm-derby-team'),
            'menu_name' => __('Teams', 'tm-derby-team'),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'team'),
        );

        register_taxonomy('team', array('team_member'), $args);
    }

    public function shortcode($atts) {
        $atts = shortcode_atts(array(
            'team' => '',
            'order' => 'number',
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
            'order' => 'ASC',
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
                            <?php
                            // Ensure a default image is set
                            $default_image = get_option('tm_derby_team_default_image') ? esc_url(get_option('tm_derby_team_default_image')) : plugin_dir_url(__FILE__) . 'images/default-image.jpg';

                            // Check if the post has a featured image
                            if (has_post_thumbnail()) :
                                ?>
                                <div class="tm-derby-team-member-thumbnail">
                                    <?php
                                    // Get the player's name
                                    $player_name = get_the_title();
                                    // Output the full-size image with the alt tag set to the player's name
                                    the_post_thumbnail('full', array('alt' => esc_attr($player_name)));
                                    ?>
                                </div>
                            <?php else : ?>
                                <div class="tm-derby-team-member-thumbnail">
                                    <img src="<?php echo $default_image; ?>" alt="<?php echo esc_attr($player_name); ?>" />
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
                <h2 align="center"><?php _e('No team members found.', 'tm-derby-team'); ?></h2>
            <?php endif; ?>
        </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }

    public function enqueue_styles() {
        wp_enqueue_style( 'tm-derby-team-styles', plugin_dir_url( __FILE__ ) . 'css/tm-derby-team-styles.css' );
    }

    public function settings_page() {
        add_options_page(
            __('TM Derby Team Settings', 'tm-derby-team'),
            __('TM Derby Team', 'tm-derby-team'),
            'manage_options',
            'tm-derby-team',
            array($this, 'render_settings_page')
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('TM Derby Team Settings', 'tm-derby-team'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('tm_derby_team_settings');
                do_settings_sections('tm-derby-team');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('tm_derby_team_settings', 'tm_derby_team_default_image');

        add_settings_section(
            'tm_derby_team_main_settings',
            __('Main Settings', 'tm-derby-team'),
            null,
            'tm-derby-team'
        );

        add_settings_field(
            'tm_derby_team_default_image',
            __('Default Image', 'tm-derby-team'),
            array($this, 'render_default_image_field'),
            'tm-derby-team',
            'tm_derby_team_main_settings'
        );
    }

    public function render_default_image_field() {
        $default_image = get_option('tm_derby_team_default_image');
        ?>
        <input type="text" id="tm_derby_team_default_image" name="tm_derby_team_default_image" value="<?php echo esc_attr($default_image); ?>" />
        <button type="button" class="button" id="tm_derby_team_default_image_button"><?php _e('Upload Image', 'tm-derby-team'); ?></button>
        <?php
    }

    public function enqueue_media_uploader($hook) {
        if ($hook !== 'settings_page_tm-derby-team') {
            return;
        }
        wp_enqueue_media();
        wp_enqueue_script('tm_derby_team_media_uploader', plugin_dir_url(__FILE__) . 'js/media-uploader.js', array('jquery'), null, true);
    }

    public function media_uploader_js() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                var custom_uploader;
                $('#tm_derby_team_default_image_button').click(function(e) {
                    e.preventDefault();
                    if (custom_uploader) {
                        custom_uploader.open();
                        return;
                    }
                    custom_uploader = wp.media.frames.file_frame = wp.media({
                        title: '<?php _e('Choose Image', 'tm-derby-team'); ?>',
                        button: {
                            text: '<?php _e('Choose Image', 'tm-derby-team'); ?>'
                        },
                        multiple: false
                    });
                    custom_uploader.on('select', function() {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        $('#tm_derby_team_default_image').val(attachment.url);
                    });
                    custom_uploader.open();
                });
            });
        </script>
        <?php
    }
}

new TM_Derby_Team();