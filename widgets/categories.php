<?php

/**
 * popular posts widget
 */
class newsportal_np_categories extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct('np_categories', __('Popular Categories', 'newsportal'), array(
			'description' => ' Your site’s most popular Categoires. '
		) );
	}

	public function widget($args, $instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Popular Categories', 'newsportal') ;
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : esc_html__('8', 'newsportal') ;
		$count_visibility = !empty( $instance['count_visibility'] ) ? $instance['count_visibility'] : '' ;
		?>
			<!-- widget content -->
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php echo wp_kses_post($args['before_title']).$title.wp_kses_post($args['after_title']); ?>
			<?php
                $np_categories = get_categories( array(
                    'orderby' => 'count',
                    'parent'  => 0,
                    'order'   => 'ASE',
                    'number'  => $post_num
                ) );
                if($np_categories) :
                foreach ( $np_categories as $category ) :
			?>
                <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="mm-cat-item">
                    <?php echo wp_kses_post($category->name); ?>
                    <?php if($count_visibility) : ?>
                        <span>
                            <?php echo wp_kses_post($category->count); ?>
                        </span>
                    <?php endif; ?>
                </a>			
			<?php endforeach; endif; ?>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<!-- widget content -->
		<?php

	}

	public function form($instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Popular Categories', 'newsportal') ;
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : esc_html__('8', 'newsportal') ;
		$count_visibility = !empty( $instance['count_visibility'] ) ? $instance['count_visibility'] : '' ;

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
				<input class="checkbox" type="checkbox" <?php checked( $count_visibility, 1 ); ?> id="<?php echo wp_kses_post($this->get_field_id('count_visibility')); ?>" name="<?php echo wp_kses_post($this->get_field_name('count_visibility')); ?>" value="1">
				<label for="<?php echo wp_kses_post($this->get_field_id('count_visibility')); ?>">
					<?php echo esc_html__('Display post count?', 'newsportal'); ?>
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
		$instance['count_visibility'] = ( ! empty( $new_instance['count_visibility'] ) ) ? $new_instance['count_visibility'] : '';

		return $instance;
	}
}

function newsportal_np_categories_fn(){
	register_widget('newsportal_np_categories');
}
add_action('widgets_init', 'newsportal_np_categories_fn');
