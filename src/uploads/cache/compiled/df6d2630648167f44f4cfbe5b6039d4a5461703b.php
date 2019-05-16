<?php ( $image = get_field('hero_bg') ); ?>

<section class="page-hero" style="background-image: url('<?php echo e($image['url']); ?>');">
  <div class="container container--flex container--padding">
    <div class="page-hero__content">
      <h2 class="page-hero__heading">
        <?php echo e(the_field('hero_heading')); ?>

      </h2>
      <div class="page-hero__lead">
        <?php echo e(the_field('hero_content')); ?>

      </div>

      <div class="page-hero__cta">
        <?php 
          $course = pkpk_find_closest_course();
          $date = new DateTime($course['start_raw']);
         ?>
        <a href="#cennik" class="btn btn--large btn--green scroll-to-btn">Zapisz się do programu</a>
        <p class="page-hero__closest-course"><?php echo e(esc_html__('Najbliższy program:', 'pkpk')); ?> <?php echo e($date->format('d.m.Y')); ?></p>

      </div>
    </div>
    <div :class="['page-hero__video', { playing: youtubePlaying == true }]">
      <div class="page-hero__video-mask">
        <div class="page-hero__video-play">
          <i class="zmdi zmdi-play"></i>
        </div>
      </div>
      <youtube video-id="<?php echo e(the_field('hero_video_id')); ?>" player-width="100%" player-height="100%" @playing="playing" @ended="end" :player-vars="{controls: 0, iv_load_policy: 3, showinfo: 0, rel: 0}"></youtube>
    </div>
  </div>
</section>
