<?php
/**
 * Plugin Name: Car Management test
 * Plugin URI: https://addwebsolution.com
 * Description: This is for car Management.
 * Version: 1.0
 * Author: Darshan Vadher
 * Author URI: https://darshanvadher.com
 * Text Domain: car
 * License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class CarManagement {
   
    public function __construct() {

        // Enqueue Scripts and Styles
        add_action('wp_enqueue_scripts', array( $this, 'custom_scripts_Func' ) );
        
        // Register Custom Post Type - Car
        add_action( 'init', array( $this, 'car_custom_post_type_Func' ) );
        
        // Register Taxonomies (Make, Model, Year, Fuel Type)
        add_action( 'init', array( $this, 'create_car_tax_Func' ) );

        // Shortcode Car Entry Form 
        add_shortcode('car_entry', array( $this, 'car_entry_form_shortcode_Func' ) );
        
        // Shortcode Car List 
        add_shortcode('car-list', array( $this, 'car_list_shortcode_Func' ) );
        
        // Ajax Call - Car Submission
        add_action('wp_ajax_handle_car_entry_form_submission', array( $this, 'car_entry_form_submission_Func') );
        add_action('wp_ajax_nopriv_handle_car_entry_form_submission', array( $this, 'car_entry_form_submission_Func') );
    
    }

    public function custom_scripts_Func(){
        
        // Custom Js File
        wp_enqueue_script('cars-js', 
            plugin_dir_url(__FILE__) . '/js/cars.js', 
            array('jquery'), 
            null, 
            true 
        );

        wp_localize_script('cars-js', 'cars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cars_nonce')
        ));

        // Custom CSS File
        wp_enqueue_style(
            'cars-css',
            plugin_dir_url(__FILE__) . '/css/cars.css',
            array(),
            null
        );
    }

    public function car_custom_post_type_Func() {
        register_post_type('cars',
            array(
                'labels'      => array(
                    'name'          => __( 'Cars', 'car' ),
                    'singular_name' => __( 'Car', 'car' ),
                    'add_new'               => __( 'Add New Car', 'car' ),
                    'add_new_item'          => __( 'Add New Car', 'car' ),
                ),
                'public'      => true,
                'has_archive' => true,
                'supports' => array('title', 'editor', 'thumbnail'),
                'menu_icon' => 'dashicons-car',
            )
        );
    }

    public function create_car_tax_Func() {
        /* Create Make Taxonomy */
        $args = array(
            'label' => __( 'Make', 'car' ),
            'rewrite' => array( 'slug' => 'make' ),
            'hierarchical' => true,
        );

        register_taxonomy( 'make', 'cars', $args );
        
        /* Create Model Taxonomy */
        $args = array(
                'label' => __( 'Model', 'car' ),
                'rewrite' => array( 'slug' => 'model' ),
                'hierarchical' => true,
            );

        register_taxonomy( 'model', 'cars', $args );

        /* Create Year Taxonomy */
        $args = array(
                'label' => __( 'Year', 'car' ),
                'rewrite' => array( 'slug' => 'year' ),
                'hierarchical' => true,
            );

        register_taxonomy( 'year', 'cars', $args );

        /* Create Fuel type Taxonomy */
        $args = array(
                'label' => __( 'Fuel type', 'car' ),
                'rewrite' => array( 'slug' => 'fuel_type' ),
                'hierarchical' => true,
            );

        register_taxonomy( 'fuel_type', 'cars', $args );        
    } 

    public function car_entry_form_shortcode_Func(){
        ob_start();

        // Get taxonomies
        $makes = get_terms(array('taxonomy' => 'make', 'hide_empty' => false));
        
        $models = get_terms(array('taxonomy' => 'model', 'hide_empty' => false));
        
        $years = get_terms(array('taxonomy' => 'year', 'hide_empty' => false));
        
        $fuel_types = get_terms(array('taxonomy' => 'fuel_type', 'hide_empty' => false));
        ?>

        <form id="car-entry-form" action="" method="post" enctype="multipart/form-data" class="wp-block-group" style="position: relative;">
            
            <!-- Loader -->
            <div class="car-loader" style="display: none;"></div>

            <div class="form-field">
                <label for="car_name" class="wp-block-heading">Car Name:</label>
                <input type="text" id="car_name" name="car_name" class="wp-block-input" required>
            </div>

            <div class="form-field">
                <label for="make" class="wp-block-heading">Make:</label>
                <select id="make" name="make" class="wp-block-input" required>
                    <option value="">Select Make</option>
                    <?php foreach ($makes as $make) : ?>
                        <option value="<?php echo esc_attr($make->term_id); ?>"><?php echo esc_html($make->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field">
                <label for="model">Model:</label>
                <select id="model" name="model" required>
                    <option value="">Select Model</option>
                    <?php foreach ($models as $model) : ?>
                        <option value="<?php echo esc_attr($model->term_id); ?>"><?php echo esc_html($model->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field">
                <label for="year">Years:</label>
                <select id="year" name="year" required>
                    <option value="">Select Year</option>
                    <?php foreach ($years as $year) : ?>
                        <option value="<?php echo esc_attr($year->term_id); ?>"><?php echo esc_html($year->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field">
                <label>Fuel Type:</label>
                <?php 
                
                if( !empty($fuel_types) ){

                    foreach ($fuel_types as $fuel_type) : ?>
                
                        <input type="radio" id="fuel_type_<?php echo esc_attr($fuel_type->term_id); ?>" name="fuel_type" value="<?php echo esc_attr($fuel_type->term_id); ?>" required>
                
                        <label for="fuel_type_<?php echo esc_attr($fuel_type->term_id); ?>"><?php echo esc_html($fuel_type->name); ?></label>
                
                    <?php endforeach; 
                
                }

                ?>
            </div>

            <div class="form-field">
                <label for="car_image">Image Upload:</label>
                <input type="file" id="car_image" name="car_image" accept="image/*" required> 
            </div>

            <input type="hidden" name="action" value="handle_car_entry_form_submission">
            <input type="submit" name="submit_car_entry" value="Submit">
        </form>
        <?php
        return ob_get_clean();    
    }

    public function car_entry_form_submission_Func(){
        
        $code = 1;
        $msg = 'Something Wrong';
        
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $car_name = sanitize_text_field($_POST['car_name']);
        $make = intval($_POST['make']);
        $model = intval($_POST['model']);
        $year = intval($_POST['year']);
        $fuel_type = intval($_POST['fuel_type']);
        
        // echo '$car_name--'.$car_name.'---';
        // echo '$make--'.$make.'---';
        // echo '$model--'.$model.'---';
        // echo '$year--'.$year.'---';
        // echo '$fuel_type--'.$fuel_type.'---';

        $post_id = wp_insert_post(array(
            'post_title'   => $car_name,
            'post_type'    => 'cars',
            'post_status'  => 'publish',
        ));

        if ($post_id) {
            
            // Set taxonomies
            wp_set_post_terms($post_id, array($make), 'make');
            wp_set_post_terms($post_id, array($model), 'model');
            wp_set_post_terms($post_id, array($year), 'year');
            wp_set_post_terms($post_id, array($fuel_type), 'fuel_type');
            
            if (!empty($_FILES['car_image']['name'])) {
        
                $uploaded_file = wp_handle_upload($_FILES['car_image'], array('test_form' => false));
            
                // print_r($uploaded_file);
                
                if (!isset($uploaded_file['error'])) {
                    
                    $attachment_id = wp_insert_attachment(array(
                        'guid'           => $uploaded_file['url'],
                        'post_mime_type' => $uploaded_file['type'],
                        'post_title'     => sanitize_file_name($_FILES['car_image']['name']),
                        'post_content'   => '',
                        'post_status'    => 'inherit',
                    ), $uploaded_file['file']);
                    
                    // echo '$attachment_id---'.$attachment_id;
                    
                    $attach_data = wp_generate_attachment_metadata($attachment_id, $uploaded_file['file']);
                    
                    wp_update_attachment_metadata($attachment_id, $attach_data);
                    
                    $post_thumbnail_id = set_post_thumbnail($post_id, $attachment_id);
                }
            
            }
            $code = 0;
            $msg = 'Car details submitted successfully.';
        }
        // die;
        $response = array('code'=> $code, 'msg'=> $msg);
        wp_send_json($response);
        
    }

    public function car_list_shortcode_Func(){
        ob_start();

        $args = array(
            'post_type'      => 'cars',
            'posts_per_page' => 5,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            
            echo '<div class="cars-list">';

                while ($query->have_posts()) {
                    
                    $query->the_post();

                    $car_name = get_the_title();
                    $make = get_the_terms(get_the_ID(), 'make');
                    $model = get_the_terms(get_the_ID(), 'model');
                    $year = get_the_terms(get_the_ID(), 'year');
                    $fuel_type = get_the_terms(get_the_ID(), 'fuel_type');
                    $thumbnail = get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('class' => 'car-image'));

                    echo '<div class="car-item">';
                        
                        echo '<div class="car-image-container">' . $thumbnail . '</div>';
                        
                        echo '<div class="car-details">';
                        echo '<h2>' . esc_html($car_name) . '</h2>';
                        if ($make) {
                            echo '<p><strong>Make:</strong> ' . esc_html(implode(', ', wp_list_pluck($make, 'name'))) . '</p>';
                        }
                        if ($model) {
                            echo '<p><strong>Model:</strong> ' . esc_html(implode(', ', wp_list_pluck($model, 'name'))) . '</p>';
                        }
                        if ($year) {
                            echo '<p><strong>Year:</strong> ' . esc_html(implode(', ', wp_list_pluck($year, 'name'))) . '</p>';
                        }
                        if ($fuel_type) {
                            echo '<p><strong>Fuel Type:</strong> ' . esc_html(implode(', ', wp_list_pluck($fuel_type, 'name'))) . '</p>';
                        }
                        echo '</div>';
                    
                    echo '</div>';
                }

            echo '</div>';

            // Pagination
            $total_pages = $query->max_num_pages;
            
            if ($total_pages > 1) {
                
                $current_page = max(1, get_query_var('paged'));
                
                echo '<div class="pagination">';
                    
                    echo paginate_links(array(
                        'total' => $total_pages,
                        'current' => $current_page,
                        'prev_text' => __('&laquo; ', 'car'),
                        'next_text' => __(' &raquo;', 'car'),
                    ));
                
                echo '</div>';
            }

            wp_reset_postdata();
        
        } else {
            echo '<p>No cars found.</p>';
        }

        return ob_get_clean();
    }   
}

if(class_exists('CarManagement')) { 
    new CarManagement();
}