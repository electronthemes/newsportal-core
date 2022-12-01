<?php

/**
 * popular posts widget
 */
class newsportal_popular_posts extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct('popular_posts', __('AK Popular Posts', 'newsportal'), array(
			'description' => ' Your site’s most popular Posts. '
		) );
	}

	public function widget($args, $instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Popular Posts', 'newsportal') ;
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : esc_html__('3', 'newsportal') ;
		$date_visibility = !empty( $instance['date_visibility'] ) ? $instance['date_visibility'] : '' ;

		?>
			<!-- widget content -->
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php echo wp_kses_post($args['before_title']).$title.wp_kses_post($args['after_title']); ?>
			<?php 
				//// post view count
				function getPostViews2($postID){
				    $count_key = 'post_views_count';
				    $count = get_post_meta($postID, $count_key, true);
				    if($count==''){
					    delete_post_meta($postID, $count_key);
					    add_post_meta($postID, $count_key, '0');
					    return "0 View";
				    }
				    return $count.' Views';
				}

				function setPostViews2($postID) {
				    $count_key = 'post_views_count';
				    $count = get_post_meta($postID, $count_key, true);
				    if($count==''){
					    $count = 0;
					    delete_post_meta($postID, $count_key);
					    add_post_meta($postID, $count_key, '0');
				    }else{
					    $count++;
					    update_post_meta($postID, $count_key, $count);
				    }
				}

				$popular_posts = new WP_Query( array(
					'posts_per_page' => $post_num,
					'meta_key'		 => 'post_views_count',
					'orderby'		 => 'meta_value_num'
				) );
			?>
			<?php if( $popular_posts -> have_posts() ) : ?>
			<ul class="erecent-post">
				<?php while( $popular_posts -> have_posts() ) : $popular_posts -> the_post(); ?>
				<li class="<?php if(has_post_thumbnail()){ echo 'has_recent_thumb'; } ?>">
					<div class="erecent-img">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('extra-small'); ?>
						</a>
					</div>
					<div class="erecent-text">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
						<?php if($date_visibility) : ?>
							<h6 class="erecent-date"><i class="fa fa-calendar mr-2"></i><?php echo esc_html__(get_the_date('d M Y'), 'newsportal'); ?></h6>
							<?php

							?>
						<?php endif; ?>
					</div>
				</li>
				<?php endwhile; wp_reset_query(); ?>
			</ul>
			<?php endif; ?>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<!-- widget content -->
		<?php

	}

	public function form($instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Popular Posts', 'newsportal') ;
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : esc_html__('3', 'newsportal') ;
		$date_visibility = !empty( $instance['date_visibility'] ) ? $instance['date_visibility'] : '' ;

		?>

			<p>
				<label for="<?php echo wp_kses_post($this->get_field_id('title')); ?>"><?php echo esc_html__('Title:', 'newsportal'); ?></label>
				<input id="<?php echo wp_kses_post($this->get_field_id('title')); ?>" name="<?php echo wp_kses_post($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" type="text" class="widefat title">
			</p>
			<p>
				<label for="<?php echo wp_kses_post($this->get_field_id('number')); ?>">
					<?php echo esc_html__('Number of posts to show:', 'newsportal'); ?>
				</label>
				<input class="tiny-text" id="<?php echo wp_kses_post($this->get_field_id('number')); ?>" name="<?php echo wp_kses_post($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($post_num); ?>">
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $date_visibility, 1 ); ?> id="<?php echo wp_kses_post($this->get_field_id('date_visibility')); ?>" name="<?php echo wp_kses_post($this->get_field_name('date_visibility')); ?>" value="1">
				<label for="<?php echo wp_kses_post($this->get_field_id('date_visibility')); ?>">
					<?php echo esc_html__('Display post date?', 'newsportal'); ?>
				</label>
			</p>

	<?php }

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? $new_instance['number'] : '';
		$instance['date_visibility'] = ( ! empty( $new_instance['date_visibility'] ) ) ? $new_instance['date_visibility'] : '';

		return $instance;
	}
}

function newsportal_popular_posts_fn(){
	register_widget('newsportal_popular_posts');
}
add_action('widgets_init', 'newsportal_popular_posts_fn');
