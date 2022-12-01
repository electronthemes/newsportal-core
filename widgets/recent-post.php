<?php

/**
 * recent posts widget
 */
class newsportal_recent_posts extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct('np_recent_posts', __('NP Recent Posts', 'newsportal'), array(
			'description' => ' Your site’s most Recent Posts. '
		) );
	}

	public function widget($args, $instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Recent Posts', 'newsportal') ;
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : esc_html__('3', 'newsportal') ;
		$date_visibility = !empty( $instance['date_visibility'] ) ? $instance['date_visibility'] : '' ;

		?>
			<!-- widget content -->
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php echo wp_kses_post($args['before_title']).$title.wp_kses_post($args['after_title']); ?>
			<?php 
				$recent_posts = new WP_Query( array(
					'post_type'		 => 'post',
					'posts_per_page' => $post_num,
				) );
			?>
			<?php if( $recent_posts -> have_posts() ) : ?>
			<ul class="erecent-post">
				<?php while( $recent_posts -> have_posts() ) : $recent_posts -> the_post(); ?>
				<li class="<?php if(has_post_thumbnail()){ echo 'has_recent_thumb'; } ?>">
					<?php if(has_post_thumbnail()) : ?>
					<div class="erecent-img">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('extra-small'); ?>
						</a>
					</div>
					<?php endif; ?>
					<div class="erecent-text">
						<h5 class="erecent-title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h5>
						<?php if($date_visibility) : ?>
							<div class="erecent-date">
								<i class="fa-regular fa-calendar"></i>
								<?php echo esc_html__(get_the_date('M d, Y'), 'newsportal'); ?>
							</div>
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

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Recent Posts', 'newsportal') ;
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

function newsportal_recent_posts_fn(){
	register_widget('newsportal_recent_posts');
}
add_action('widgets_init', 'newsportal_recent_posts_fn');
