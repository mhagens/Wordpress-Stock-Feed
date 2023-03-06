<?php
/*
Plugin Name: Stock Market Updates
Plugin URI: https://www.isthedow.com/
Description: Display Dow market information on your Wordpress site with our Stock Market Widget. Place anywhere on your site using the short code in page/post use [sm_update].
Version: 2.0
Author: Matt Hagens
Author URI: http://isthedow.com
*/



function get_sm_update(){

    echo file_get_contents("https://www.isthedow.com/plugin/widget.php");

}

function display_sm_update($atts){
    $background="#ffffff";
    $quote="Today's Dow Jones";
    extract(shortcode_atts( array(), $atts));
    if(isset($atts)){
        $pull_atts = shortcode_atts( array(
            'background' => '#ffffff',
            'quote' => 'Today\'s Dow Jones',
        ), $atts );

        if(isset($atts['background-color'])){
            $background=$atts['background-color'];

        }
        if(isset($atts['quote'])){
            $quote=$atts['quote'];

        }

    }


    $before_sc="<div class='sm_block' style='padding:2%;display:inline-block;background:$background; float: left;
    margin-right: 20px;'>";
    $before_sc.='<p style="text-align: center">'.$quote.'</p>';
    $after_sc="</div>";
    echo $before_sc;
    get_sm_update();
    echo $after_sc;
}

add_shortcode('sm_update', 'display_sm_update');




class sm_data extends WP_Widget {


    /** constructor */
    function sm_data() {
        parent::__construct(false, $name = 'Stock Market Data');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        global $wpdb;

        $title = apply_filters('widget_title', $instance['title']);
        $background = $instance['background'];
        $before_widget="<div class='widget sm_widget_class' margin-top:10px; style='text-align:center;'>";
        $after_widget="</div>";
        $before_title="<h2 class='widget-title sm_widget_title'>";
        $after_title="</h2>";
        ?>
        <?php echo $before_widget; ?>
        <?php if ( $title )
            echo $before_title . $title . $after_title; ?>
        <div><?php get_sm_update(); ?></div>
        <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['background'] = strip_tags($new_instance['background']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {

        $title = esc_attr($instance['title']);
        $background = esc_attr($instance['background']);
        ?>
        

        <?php
    }


} //
// register message box widget
add_action('widgets_init', create_function('', 'return register_widget("sm_data");'));

function sample_load_color_picker_script() {
    wp_enqueue_script('farbtastic');
}
function sample_load_color_picker_style() {
    wp_enqueue_style('farbtastic');
}
add_action('admin_print_scripts-widgets.php', 'sample_load_color_picker_script');
add_action('admin_print_styles-widgets.php', 'sample_load_color_picker_style');