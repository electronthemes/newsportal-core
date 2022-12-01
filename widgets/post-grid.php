<?php

/**
 * recent posts widget
 */
class newsportal_post_grid extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct('np_post_grid', __('Post Grid', 'newsportal'), array(
			'description' => ' Your site’s most Recent or Popular Posts. '
		) );
	}

	public function widget($args, $instance){
        $title = null;
        if ( ! empty($instance['title'])){
            $title = apply_filters('widget_title', $instance['title'] );
        }
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : 3;
        $column = !empty( $instance['column'] ) ? $instance['column'] : 2;
		$date = !empty( $instance['date'] ) ? $instance['date'] : '' ;
        $layout = !empty( $instance['layout'] ) ? $instance['layout'] : esc_html__('Grid', 'newsportal');
        $orderby = !empty( $instance['orderby'] ) ? $instance['orderby'] : esc_html__('Order By', 'newsportal');
        

		?>
			<!-- widget content -->
			<?php
                echo wp_kses_post($args['before_widget']);
                if($title)
                    echo wp_kses_post($args['before_title']).$title.wp_kses_post($args['after_title']);
            ?>
			<?php 
				if($orderby == 'popular'){
                    $arguments = array(
                        'post_type'         => 'post',
                        'posts_per_page'    => $post_num,
                        'meta_key' 			=> 'wpmm_postgrid_views',
                        'orderby' 			=> 'meta_value_num',
                        'order' 			=> 'DESC',
                    );
                }elseif($orderby == 'featured'){
                    $arguments = array(
                        'post_type'         => 'post',
                        'posts_per_page'    => $post_num,
                        'meta_query' => array(
                            array(
                                'key'     => 'make_post',
                                'value'   => '"featured"',
                                'compare' => 'LIKE'
                            )
                        )
                    );
                }else{
                    $arguments = array(
                        'post_type'         => 'post',
                        'posts_per_page'    => $post_num
                    );
                }
                
                if( ! empty($instance['category']) ){
                    $cat_data = array();
                    if( !in_array( 'allpost', $instance['category'] ) ){
                        $cat_data[] = array(
                            'taxonomy' 	=> 'category',
                            'field' 	=> 'slug',
                            'terms' 	=> $instance['category']
                        );
                    }
                    $arguments['tax_query'] =  $cat_data;
                }
                
                $data = new WP_Query( $arguments );
			?>
			<?php if( $data -> have_posts() ) : ?>
			<div class="np-pots-grid-widget column-<?php echo wp_kses_post($column); ?>">
				<?php while( $data -> have_posts() ) : $data -> the_post(); ?>
                <?php if ( ! empty( $instance['layout']) && $instance['layout'] == 'grid') : ?>
                <article class="np-post-grid">
                    <div class="np-post-img">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                        <?php
                            $cats = get_the_category();
                            if($cats){
                                echo '<a href="'.esc_url( get_category_link( $cats[0]->term_id)).'" class="post-cat">'.esc_html( $cats[0]->name ).'</a>';
                            }
                        ?>
                    </div>
                    <h6>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h6>
                    <?php if($date) : ?>
                        <div class="date">
                            <i class="fa-regular fa-calendar"></i>
                            <?php echo esc_html__(get_the_date('M d, Y'), 'newsportal'); ?>
                        </div>
                    <?php endif; ?>
                </article>
                <?php elseif( 'horizontal' == $instance['layout'] ) : ?>
                    <div class="card-horizontal">
                        <a href="<?php the_permalink(); ?>" class="card-thumb">
                            <?php the_post_thumbnail('card-small'); ?>
                        </a>
                        <div class="card-details">
                            <h5>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h5>
                            <?php if($date) : ?>
                                <p class="date">
                                    <i class="fa-regular fa-calendar"></i>
                                    <?php echo esc_html__(get_the_date('M d, Y'), 'newsportal'); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
				<?php endif; endwhile; wp_reset_query(); ?>
			</div>
			<?php endif; ?>
			<?php echo wp_kses_post($args['after_widget']); ?>
			<!-- widget content -->
		<?php

	}

	public function form($instance){

        $title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Recent Posts', 'newsportal') ;
		$post_num = !empty( $instance['number'] ) ? $instance['number'] : 3 ;
        $column = !empty( $instance['column'] ) ? $instance['column'] : 2;
		$date = !empty( $instance['date'] ) ? $instance['date'] : '' ;
        $layout = !empty( $instance['layout'] ) ? $instance['layout'] : esc_html__('Grid', 'newsportal');
        $orderby = !empty( $instance['orderby'] ) ? $instance['orderby'] : esc_html__('Order By', 'newsportal');
        

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
				<label for="<?php echo wp_kses_post($this->get_field_id('column')); ?>">
					<?php echo esc_html__('Number of columns:', 'newsportal'); ?>
				</label>
				<input class="tiny-text" id="<?php echo wp_kses_post($this->get_field_id('column')); ?>" name="<?php echo wp_kses_post($this->get_field_name('column')); ?>" type="number" value="<?php echo esc_attr($column); ?>" min="1" max="4">
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $date, 1 ); ?> id="<?php echo wp_kses_post($this->get_field_id('date')); ?>" name="<?php echo wp_kses_post($this->get_field_name('date')); ?>" value="1">
				<label for="<?php echo wp_kses_post($this->get_field_id('date')); ?>">
					<?php echo esc_html__('Display post date?', 'newsportal'); ?>
				</label>
			</p>
            <p>
                <label for="<?php esc_attr_e( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e('Ordered By', 'wp-megamenu'); ?></label>
                <?php
                $options = array(
                    'popular' 	=> 'Popular',
                    'featured' 	=> 'Featured',
                    'latest' 	=> 'Latest'
                );
                if(isset($instance['orderby'])) $orderby = $instance['orderby'];
                ?>
                <select class="widefat" id="<?php esc_attr_e( $this->get_field_id( 'orderby' ) ); ?>" name="<?php esc_attr_e( $this->get_field_name( 'orderby' ) ); ?>">
                    <?php
                    $op = '<option value="%s"%s>%s</option>';
                    foreach ($options as $key=>$value ) {
                        if ($orderby === $key) {
                            printf($op, $key, ' selected="selected"', $value);
                        } else {
                            printf($op, $key, '', $value);
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="<?php esc_attr_e( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e('Layout', 'newsportal'); ?></label>
                <?php
                $options = array(
                    'grid' 	=> 'Grid',
                    'horizontal' 	=> 'Horizontal',
                );
                if(isset($instance['layout'])) $layout = $instance['layout'];
                ?>
                <select class="widefat" id="<?php esc_attr_e( $this->get_field_id( 'layout' ) ); ?>" name="<?php esc_attr_e( $this->get_field_name( 'layout' ) ); ?>">
                    <?php
                    $op = '<option value="%s"%s>%s</option>';
                    foreach ($options as $key=>$value ) {
                        if ($layout === $key) {
                            printf($op, $key, ' selected="selected"', $value);
                        } else {
                            printf($op, $key, '', $value);
                        }
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="<?php esc_attr_e( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e('Select Category', 'newsportal'); ?></label>
                <?php
                $options = array();
                $options['allpost'] = 'All Category';
                $query1 = get_terms( 'category' );
                if( $query1 ){
                    foreach ( $query1 as $post ) {
                        $options[ $post->slug ] = $post->name;
                    }
                }
                if(!empty($instance['category'])){
                    $category = (array) $instance['category'];
                } else {
                    $category = array( 'allpost' );
                }
                ?>
                <select multiple class="widefat" id="<?php esc_attr_e( $this->get_field_id( 'category' ) ); ?>" name="<?php esc_attr_e( $this->get_field_name( 'category' ) ); ?>[]">
                    <?php
                    $op = '<option value="%s"%s>%s</option>';
                    foreach ($options as $key=>$value ) {
                        if (in_array($key,$category)) {
                            printf($op, $key, ' selected="selected"', $value);
                        } else {
                            printf($op, $key, '', $value);
                        }
                    }
                    ?>
                </select>
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
		$instance['date'] = ( ! empty( $new_instance['date'] ) ) ? $new_instance['date'] : '';
		$instance['layout'] = ( ! empty( $new_instance['layout'] ) ) ? $new_instance['layout'] : '';
		$instance['column'] = ( ! empty( $new_instance['column'] ) ) ? $new_instance['column'] : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? $new_instance['category'] : '';
		$instance['orderby'] = ( ! empty( $new_instance['orderby'] ) ) ? $new_instance['orderby'] : '';

		return $instance;
	}

}

function newsportal_post_grid_fn(){
	register_widget('newsportal_post_grid');
}
add_action('widgets_init', 'newsportal_post_grid_fn');



/*-----------------------------------------------------
* 				popular post
*------------------------------------------------------ */
function wpmm_set_postgrid_views($postID) {
    $count_key = 'wpmm_postgrid_views';
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

function wpmm_track_postgrid_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    wpmm_set_postgrid_views($post_id);
}
add_action( 'wp_head', 'wpmm_track_postgrid_views');