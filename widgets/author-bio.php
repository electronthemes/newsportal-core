<?php
/**
 * author biography widget
 */
class newsportal_author_bio extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct('author_bio', __('AK Author Bio', 'newsportal'), array(
			'description' => 'This is an author bio/info widget'
		) );
	}

	public function widget($args, $instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('About Me', 'newsportal') ;

		?>
			<!-- widget content -->
			<?php echo wp_kses_post($args['before_widget']); ?>
			<?php echo wp_kses_post($args['before_title']).$title.wp_kses_post($args['after_title']); ?>
			<div class="author-bio text-center">
		        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="authorimg">
		        	<img src="<?php echo esc_url(get_avatar_url(get_the_author_meta('ID'), array("size"=>260))); ?>" alt="<?php echo esc_html__(get_the_author_meta('display_name'), 'newsportal'); ?>">
		        </a>
		        <h4>
		        	<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="author-name">
		        		<?php echo esc_html__(get_the_author_meta('display_name'), 'newsportal'); ?>
		        	</a>
		        </h4>
		        <p><?php echo esc_html__(get_the_author_meta('description'), 'newsportal'); ?></p>
		    	
                <?php 
                    $curauth = get_userdata(1);
                    $user_url = $curauth->user_url;
                    $author_id = get_the_author_meta('ID');
                    if(function_exists('get_field')){
                        $p_i1 = get_field('author_profile_icon1', 'user_'.$author_id);
                        $p_l1 = get_field('author_profile_link1', 'user_'.$author_id);
                        $p_i2 = get_field('author_profile_icon2', 'user_'.$author_id);
                        $p_l2 = get_field('author_profile_link2', 'user_'.$author_id);
                        $p_i3 = get_field('author_profile_icon3', 'user_'.$author_id);
                        $p_l3 = get_field('author_profile_link3', 'user_'.$author_id);
                        $p_i4 = get_field('author_profile_icon4', 'user_'.$author_id);
                        $p_l4 = get_field('author_profile_link4', 'user_'.$author_id);
                    }
                ?>
                <?php if($p_i1 || $p_i2 || $p_i3 || $p_i4 || $user_url) : ?>
                <ul class="social-icon">
                    <?php if($p_i1) : ?>
                    <li><a href="<?php echo wp_kses_post($p_l1); ?>" target="_blank"><i class="fa fa-<?php echo wp_kses_post($p_i1); ?>"></i></a></li>
                    <?php endif; ?>
                    <?php if($p_i2) : ?>
                    <li><a href="<?php echo wp_kses_post($p_l2); ?>" target="_blank"><i class="fa fa-<?php echo wp_kses_post($p_i2); ?>"></i></a></li>
                    <?php endif; ?>
                    <?php if($p_i3) : ?>
                    <li><a href="<?php echo wp_kses_post($p_l3); ?>" target="_blank"><i class="fa fa-<?php echo wp_kses_post($p_i3); ?>"></i></a></li>
                    <?php endif; ?>
                    <?php if($p_i4) : ?>
                    <li><a href="<?php echo wp_kses_post($p_l4); ?>" target="_blank"><i class="fa fa-<?php echo wp_kses_post($p_i4); ?>"></i></a></li>
                    <?php endif; ?>
                    <?php if($user_url) : ?>
                        <li><a href="<?php echo esc_url($user_url); ?>" target="_blank"><i class="fa fa-globe"></i></a></li>
                    <?php endif; ?>                                    
                </ul>
                <?php endif; ?>
			</div>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<!-- widget content -->
		<?php

	}

	public function form($instance){

		$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('About Me', 'newsportal') ;

		?>

			<p>
				<label for="<?php echo wp_kses_post($this->get_field_id('title')); ?>"><?php echo esc_html('Title:', 'newsportal'); ?></label>
				<input id="<?php echo wp_kses_post($this->get_field_id('title')); ?>" name="<?php echo wp_kses_post($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" type="text" class="widefat title">
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

		return $instance;
	}

}

function author_biography(){
	register_widget('newsportal_author_bio');
}
add_action('widgets_init', 'author_biography');