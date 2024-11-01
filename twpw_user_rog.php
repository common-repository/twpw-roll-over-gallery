<?php

/*
Plugin Name: TWPW Roll Over Gallery
Plugin URI: http://thewpwarrior.com
Description: Adds a custom post type to display a Roll Over Gallery with images and text using jQuery UI Tabs. <br /> How Tos: <a href="http://thewpwarrior.com/?faq-group=roll-over-group" target="_blank">http://thewpwarrior.com/?faq-group=roll-over-group</a>
Version: 1.0
Author: Morgan Leetham
Author URI: http://morganleetham.com
License: GPL2
*/

class TWPWROG_Images {

	function __construct() {
		add_shortcode('twpw_show_rog',array(&$this,'displayROGCode'));
		add_action('init',array(&$this,'addROGPostType'));
	}

	function addROGPostType() {
		$labels = array(
			'name' => 'Roll Over Gallery',
			'singular_name' => 'Roll Over Gallery',
			'add_new' => 'Add new Roll Over Gallery',
			'add_new_item' => 'Add new Roll Over Gallery',
			'edit_item' => 'Edit Roll Over Gallery',
			'new_item' => 'New Roll Over Gallery',
			'view_item' => 'View Roll Over Gallery',
			'search_items' => 'Search Items',
			'not_found' => 'No Roll Over Gallery found',
			'not_found_in_trash' => 'No Roll Over Gallery found in trash'
		);

		$args = array(
			'description' => 'Text to be used in roll over images.',
			'public' => true,
			'exclude_from_search' => true,
			'show_in_nav_menus' => false,
			'menu_position' => 5,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'page-attributes'
			),
			'labels' => $labels,
			'taxonomies' => array('rog_categories')
		);

		register_post_type('rog',$args);
		wp_enqueue_style('jquery_ui_tabs_base','http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css');
		$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		wp_enqueue_style('twpw_user_rog',$x.'twpw_user_rog.css');
		add_image_size('rogThumbs',60,100,true);
		
		
		$labels = array(
			'name' => 'Roll Over Gallery Categories',
			'singular_name' => 'Roll Over Gallery Category',
			'search_items' => 'Search Roll Over Gallery Category',
			'all_items' => 'All Roll Over Gallery Category',
			'parent_item' => 'Parent Roll Over Gallery Category',
			'parent_item_colon' => 'Parent Roll Over Gallery Category:',
			'edit_item' => 'Edit Roll Over Gallery Category',
			'update_item' => 'Update Roll Over Gallery Category',
			'add_new_item' => 'Add new Roll Over Gallery Category',
			'new_item_name' => 'New Roll Over Gallery Category'
		);
		$args = array(
			'label' => 'Roll Over Gallery Categories',
			'labels' => $labels,
			'public' => true,
			'hierarchical' => true
		);
		register_taxonomy('rog_categories', 'rog', $args);
	}
	
	
	function displayROGCode($atts, $content) {
		$atts = shortcode_atts(array(
		'categories' => null,
		'exclude' => null
		),$atts);
		
		$atts['categories'] = (empty($atts['categories'])) ? null : array_map('trim',explode(',',$atts['categories']));
		$atts['exclude'] = (empty($atts['exclude'])) ? null : array_map('trim',explode(',',$atts['exclude']));
		ob_start();
		global $post;
		$args = array(
			'post_type' => 'rog',
			'posts_per_page' => -1,
			'nopaging ' => true,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);
		if(!empty($atts['categories'])) {
			foreach($atts['categories'] as $categoryName) {
				$tmp = get_term_by( 'name', $categoryName, 'rog_categories' );
				$catIDs[] =(int) $tmp->term_id;
				unset($tmp);
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'rog_categories',
				'field' => 'id',
				'terms' => $catIDs,
				'operator' => 'IN'
			);
		}
		
		if(!empty($atts['exclude'])) {
			foreach($atts['exclude'] as $excludeName) {
				$tmp = get_term_by( 'name', $excludeName, 'rog_categories' );
				$excludeIDs[] =(int) $tmp->term_id;
				unset($tmp);
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'rog_categories',
				'field' => 'id',
				'terms' => $excludeIDs,
				'operator' => 'NOT IN'
			);
		}

		$query = new WP_Query($args);
		if($query->have_posts()):
			wp_enqueue_script('jquery-ui-tabs');
			$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
			wp_enqueue_script('twpw_user_rog',$x.'twpw_user_rog.js',array('jquery-ui-tabs'),'1',true);
			$count = 1;
			?>
			<div id="tabWrap">
			<div class="tabs">
				<div class="twpw_rog_coloum">
					<?php
					while($query->have_posts()):
						$query->the_post();
						?>
							<div id="tabs-<?php echo $count; ?>" class="twpw_user_bio twpw_bio_wrap twpw_rog_wrap">
								<h2 class="bioTitle"><?php echo the_title(); ?></h2>
								<?php echo the_content(); ?>
							</div>
						<?php
						$count++;
					endwhile;
					$count = 1;
					wp_reset_postdata();
					$query = new WP_Query($args);
					?>
				</div>
				<div class="twpw_rog_coloum">
					<div class="twpw_rog_caption">
						<p><?php echo $content; ?></p>
					</div>
					<ul class="twpw_user_rog twpw_rog_images">
					<?php
					while($query->have_posts()):
						$query->the_post();
						
						$alttag = get_the_content();
						//$alttag = apply_filters('the_content',get_the_content());
						$alttag = strip_shortcodes($alttag);
						$alttag = strip_tags($alttag);
						$alttag = esc_html($alttag);
						$alttag = preg_replace( '/(.?)\[(jwplayer)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', '$1$6', $alttag );
						?>
							<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'rogThumbs'); ?>
							<li><a href="#tabs-<?php echo $count; ?>" ><img src="<?php echo $img[0]; ?>" alt="<?php echo $alttag; ?>" title="<?php the_title_attribute(); ?>" /></a></li>
							<?php // echo get_the_post_thumbnail( $post->ID, 'rogThumbs' ); ?>
						<?php
						$count++;
					endwhile;
					?>
					</ul>
				</div>
			</div>
			</div>
			<div style="clear:both;"></div>
			<?php
		endif;
		wp_reset_postdata();
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
		
}

$TWPW_ROG_Images = new TWPWROG_Images();