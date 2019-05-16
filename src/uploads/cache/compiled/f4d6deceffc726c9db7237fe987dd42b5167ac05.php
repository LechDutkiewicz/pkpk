<?php $__env->startComponent('components.skewy-container', ['variant' => 'gray']); ?>
  <div class="container container--flex flex--wrap container--padding">
    <h2 class="std-heading std-heading--full-width std-heading--center std-heading--testimonials"><?php echo e(__('Co mówią uczestnicy?', 'pkpk')); ?></h2>
    <?php 
      $args = array(
        'post_type' => 'testimonials'
      );
     ?>
    <div class="row--testimonials">
      <slick ref="slick" :options="slickOptions">
        <?php $bladeQuery = new WP_Query($args); ?><?php if ($bladeQuery->have_posts()) : ?><?php while ($bladeQuery->have_posts()) : ?><?php $bladeQuery->the_post(); ?>
          <div class="testimonial">
            <div class="testimonial__content">
              <div class="testimonial__photo">
                <?php 
                  $image = get_field('testimonial_photo');
                  // vars
                  $url = $image['url'];
                	$title = $image['title'];
                	$alt = $image['alt'];
                  // thumbnail
                  $size = 'pkpk_photo_avatar';
                	$thumb_url = $image['sizes'][ $size ];
                 ?>
                <?php if($image): ?>
                  <img src=<?php echo e($thumb_url); ?> alt="<?php echo e($alt); ?>">
                <?php else: ?>
                  <i class="zmdi zmdi-account"></i>
                <?php endif; ?>
              </div>
              <div class="testimonial__content-inner">
                <p class="testimonial__name"><?php echo e(the_title()); ?></p>
                <p class="testimonial__city"><?php echo e(the_field('testimonial_city')); ?></p>
                <div class="testimonial__text"><?php echo e(the_field('testimonial_content')); ?></div>
              </div>
            </div>
          </div>
        <?php endwhile; ?><?php endif; ?>
        <?php (wp_reset_postdata()); ?>
      </slick>
    </div>
  </div>
<?php echo $__env->renderComponent(); ?>
