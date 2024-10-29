<?php
/**
 * Plugin Name: Affiliate Payday Clickbank Ads
 * Plugin URI: https://afpayday.com
 * Description: A sidebar widget to display affiliate payday members clickbank ads
 * Version: 1.0
 * Author: Affiliate Payday
 * Author URI: https://click-bank.design
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Affiliate Payday Clickbank Ads is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 
 * of the License, or any later version.
 * Affiliate Payday Clickbank Ads is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See 
 * the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with {Plugin Name}. If not, see 
   {License URI}.
 */

  class AFPD_Clickbank_Ads_Widget extends WP_Widget {
    function __construct() {
      $widget_options = array (
        'classname' => 'AFPD_Clickbank_Ads_Widget',
        'description' => 'Add Affilaite Payday Clickbank Ads to your site.'
      );
      parent::__construct( 'AFPD_Clickbank_Ads_Widget', 'AFPD Clickbank Ads', $widget_options );
    }

    //function to output the widget form
    function form( $instance ) {
      $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
      $text = ! empty( $instance['text'] ) ? $instance['text'] : 'Your Affiliate Payday ID';
      $mt = ! empty( $instance['mt'] ) ? $instance['mt'] : '10px';
      $size = ! empty( $instance['size'] ) ? $instance['size'] : '300';
      $acat = ! empty( $instance['acat'] ) ? $instance['acat'] : 'marketing';
      if ($size == '125') {$s1 = 'checked'; $s2 = '';}
      if ($size == '300') {$s1 = ''; $s2 = 'checked';}
      if ($size != '125' && $size != '300') { $s1 = 'checked'; $s2 = ''; }
      if ($acat == 'marketing') { $c1 = 'selected'; $c2 = ''; $c3 = ''; $c4 = ''; }
      if ($acat == 'software')  { $c1 = ''; $c2 = 'selected'; $c3 = ''; $c4 = ''; }
      if ($acat == 'family')    { $c1 = ''; $c2 = ''; $c3 = 'selected'; $c4 = ''; }
      if ($acat == 'mixed')     { $c1 = ''; $c2 = ''; $c3 = ''; $c4 = 'selected'; }
      echo '
        <p>
          <label for="'.$this->get_field_id( 'title').'">Title:</label>
          <input class="widefat" type="text" id="'.$this->get_field_id( 'title' ).'" name="'.$this->get_field_name( 'title' ).'" value="'.esc_attr( $title ).'" />
        </p>
        <p>
          <label for="'.$this->get_field_id( 'text').'">Your Affiliate Payday ID:</label>
 <input class="widefat" type="text" id="'.$this->get_field_id( 'text' ).'" name="'.$this->get_field_name( 'text' ).'" value="'.esc_attr( $text ).'" />
        </p>
        <p>
          <label for="cat">Banner Category:</label><br>
          <select name="'.$this->get_field_name( 'acat').'" style="width:100%">
            <option value="marketing" '.$c1.'>Marketing</option>
            <option value="software" '.$c2.'>Software</option>
            <option value="family" '.$c3.'>Family</option>
            <option value="mixed" '.$c4.'>Mixed</option>
          </select>
<!--        <p>
          <label for="size">Banner Sizes:</label><br>
          <input name="'.$this->get_field_name( 'size').'" type="radio" value="125" '.$s1.'>125px X 125px
          <input name="'.$this->get_field_name( 'size').'" type="radio" value="300" '.$s2.'>300px X 250px
        </p>-->
        <p>
          <label for="'.$this->get_field_id( 'mt').'">Top Margin for widget:</label>
 <input class="widefat" type="text" id="'.$this->get_field_id( 'mt' ).'" name="'.$this->get_field_name( 'mt' ).'" value="'.esc_attr( $mt ).'" />
        </p>
      ';
    }
    function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance['title'] = strip_tags( $new_instance['title'] );
      $instance['text'] = strip_tags( $new_instance['text'] );
      $instance['mt'] = strip_tags( $new_instance['mt'] );
      $instance['size'] = strip_tags( $new_instance['size'] );
      $instance['acat'] = strip_tags( $new_instance['acat'] );
      return $instance;          
    }
    function widget( $args, $instance ) {

    //get IP of visitors
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    //set variables
    $title = apply_filters( 'widget_title', $instance['title'] );
    $text = $instance['text'];
    $link = $instance['link'];
    $mt = $instance['mt'];

    //output code
      echo $args['before_widget'];
      echo '<div class="cta" style="margin-top: '.$mt.'">';
      if ( ! empty( $title ) ) {
        echo $before_title . '<h2 class="widget-title">'.$title.'</h2>' . $after_title;
      };
      echo '<div class="afpd" id="afpd"></div>';
      echo '<script src="https://afpayday.com/wpads.php?u='.$instance['text'].'&s='.$instance['size'].'&ip='.$ip.'&c='.$instance['acat'].'"></script>';
      echo "<script>
        document.addEventListener('click', function (event) {
	  if (event.target.closest('.afpd')) { alert('".$_."'); } ;
        }, false);
      </script>";
      echo '</div>';
      echo $args['after_widget'];
    }
  }

  function AFPD_register_Clickbank_Ads_Widget() {
    register_widget( 'AFPD_Clickbank_Ads_Widget' );
  }
  add_action( 'widgets_init', 'AFPD_register_Clickbank_Ads_Widget' );
