<?php

/**
 * popular posts widget
 */
class newsportal_authors extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct('popular_posts', __('Authors', 'newsportal'), array(
			'description' => esc_html__('All the authors list of site.')
		) );
	}

	public function widget($args, $instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('The Authors', 'newsportal');
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : esc_html__('3', 'newsportal');

		?>
			<!-- widget content -->
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php echo wp_kses_post($args['before_title']).$title.wp_kses_post($args['after_title']); ?>
		<div class="mm-authors">
			<?php 
                $users = get_users(array(
                    'orderby' => 'post_count',
                    'order'   => 'DESC'
                ));
                foreach($users as $user) :
                    $post_count = count_user_posts( $user->ID );
                    $bio = get_the_author_meta('description', $user->ID);
                    if( $post_count > 0 ) :
			?>

				<div class="mm-author-item">
					<?php if(get_avatar($user->ID)) : ?>
						<a href="<?php echo get_author_posts_url($user->ID); ?>" class="mm-ai-img">
							<?php echo get_avatar($user->ID, 70); ?>
						</a>
					<?php endif; ?>
					<div class="mm-a-text">
						<h6>
							<a href="<?php echo get_author_posts_url($user->ID); ?>">
								<?php echo wp_kses_post($user->display_name); ?>
							</a>
						</h6>
                		<p>
							<i class="fa-regular fa-pen-to-square"></i>
							<?php echo wp_kses_post($post_count).esc_html__(' News Posted'); ?>
						</p>
					</div>
				</div>
			
            <?php endif; endforeach; wp_reset_query(); ?>
			</div>



			<?php echo wp_kses_post($args['after_widget']); ?>
			<!-- widget content -->
		<?php

	}

	public function form($instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('The Authors', 'newsportal') ;
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : esc_html__('3', 'newsportal') ;

		?>

			<p>
				<label for="<?php echo wp_kses_post($this->get_field_id('title')); ?>"><?php echo esc_html__('Title:', 'newsportal'); ?></label>
				<input id="<?php echo wp_kses_post($this->get_field_id('title')); ?>" name="<?php echo wp_kses_post($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" type="text" class="widefat title">
			</p>
			<p>
				<label for="<?php echo wp_kses_post($this->get_field_id('number')); ?>">
					<?php echo esc_html__('Number of items to show:', 'newsportal'); ?>
				</label>
				<input class="tiny-text" id="<?php echo wp_kses_post($this->get_field_id('number')); ?>" name="<?php echo wp_kses_post($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($post_num); ?>">
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

		return $instance;
	}
}

function newsportal_authors_fn(){
	register_widget('newsportal_authors');
}
add_action('widgets_init', 'newsportal_authors_fn');
