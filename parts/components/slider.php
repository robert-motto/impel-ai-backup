<?php
$slides = $args['slides'] ?? '';
$button = $args['button'] ?? '';
$classes = $args['classes'] ?? '';
$slider_settings = $args['slider_settings'] ?? [];
$autoplay_speed = $slider_settings['autoplay_speed'] ?? '';
$pause_on_hover = $slider_settings['pause_on_hover'] ?? '';
$slides_per_view = $slider_settings['slides_per_view'] ?? '';
$show_progressbar = $slider_settings['show_progressbar'] ?? '';
?>

<?php if (!empty($slides)) : ?>
  <div class="slider__carousel-container <?php echo esc_attr($classes); ?>">
    <div class="slider__carousel js-slider swiper"
      data-autoplay="<?php echo esc_attr($autoplay_speed); ?>"
      data-pause-hover="<?php echo esc_attr($pause_on_hover ? 'true' : 'false'); ?>"
      data-slides-per-view="<?php echo esc_attr($slides_per_view); ?>"
      data-show-progressbar="<?php echo esc_attr($show_progressbar ? 'true' : 'false'); ?>">
      <div class="swiper-wrapper">

        <?php foreach ($slides as $index => $slide) : ?>
          <div class="slider__item swiper-slide" data-index="<?php echo esc_attr($index); ?>">
            <?php echo $slide; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="slider__navigation">
      <div class="slider__buttons">
        <button class="slider__button-prev js-slider-prev" aria-label="<?php echo esc_attr__('Previous', 'impel-ai'); ?>"><?php get_icon('swiper-arrow-right'); ?></button>
        <div class="slider__buttons-divider"></div>
        <button class="slider__button-next js-slider-next" aria-label="<?php echo esc_attr__('Next', 'impel-ai'); ?>"><?php get_icon('swiper-arrow-right'); ?></button>
      </div>

      <?php if ($show_progressbar) : ?><div class="slider__progressbar js-slider-progressbar"></div><?php endif; ?>
      <?php if ($button && $button['button']):
        get_acf_component('button', [
          'data' => $button,
        ]);
      endif; ?>
    </div>

  </div>
<?php endif; ?>