<?php /*
	Block Name: Hero Secondary
	Block Align: center
	Block Icon: superhero-alt
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
  <?php block_preview(__FILE__); ?>
<?php else : ?>
  <?php
  $group               = blockFieldGroup(__FILE__);
  $color_mode          = $group['section_settings_group']['mode'] ?? 'light';
  $color_mode_variant  = $group['mode_variant'] ?? 'regular';
  $heading             = $group['heading_box_group'] ?? '';
  $buttons             = $group['action_group_group'] ?? [];
  $show_breadcrumbs    = $group['show_breadcrumbs'] ?? false;
  $custom_breadcrumbs  = $group['custom_breadcrumbs_links'] ?? [];
  $custom_media       = $group['custom_media'] ?? 'n';
  $media_type          = $group['media_type'] ?? 'image';
  $media_position      = $group['media_position'] ?? 'background';
  $text_position      = $group['text_position'] ?? 'left';
  $image               = $group['image'] ?? null;
  $image_mobile       = $group['image_mobile'] ?? null;
  $video_group         = $group['video_group'] ?? [];
  $show_logos_slider   = $group['show_logos_slider'] ?? false;
  $use_global_logos   = $group['use_global_logos'] ?? false;
  $slider_bg           = $group['slider_bg'] ?? 'white';
  $logos_slider       = $group['logos_slider'] ?? [];

  // Section classes
  $classes = ['js-section', 'l-section', 'l-section--hero', 'l-section--hero-secondary', "color-mode-{$color_mode}", "color-mode-variant-{$color_mode_variant}", "media-position-{$media_position}", "text-position-{$text_position}"];
  if (!empty($group['section_settings_group']['background_color'])) {
    $classes[] = 'is-' . $group['section_settings_group']['background_color'];
  } else {
    $classes[] = 'is-light';
  }
  ?>
  <section class="<?php echo esc_attr(implode(' ', $classes)); ?>" data-block="hero">
    <div class="l-wrapper">
      <?php if ($show_breadcrumbs) : ?>
        <?php
        $current_page_title = get_the_title();
        ?>
        <nav class="hero__breadcrumbs" aria-label="<?php esc_attr_e('Breadcrumb', 'impel-ai'); ?>">
          <ol class="hero__breadcrumbs-list">
            <li class="hero__breadcrumbs-item">
              <a href="<?php echo esc_url(home_url('/')); ?>" class="hero__breadcrumbs-link"><?php esc_html_e('Homepage', 'impel-ai'); ?></a>
            </li>
            <?php if (!empty($custom_breadcrumbs)) : ?>
              <?php foreach ($custom_breadcrumbs as $breadcrumb) : ?>
                <?php $link = $breadcrumb['breadcrumb_link'] ?? null; ?>
                <?php if ($link && !empty($link['url']) && !empty($link['title'])) : ?>
                  <li class="hero__breadcrumbs-item">
                    <span class="hero__breadcrumbs-separator" aria-hidden="true">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>
                    <a href="<?php echo esc_url($link['url']); ?>" class="hero__breadcrumbs-link" <?php echo ($link['target'] ? 'target="' . esc_attr($link['target']) . '"' : ''); ?>><?php echo esc_html($link['title']); ?></a>
                  </li>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($current_page_title)) : ?>
            <li class="hero__breadcrumbs-item hero__breadcrumbs-item--active">
              <span class="hero__breadcrumbs-separator" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              <span aria-current="page"><?php echo esc_html($current_page_title); ?></span>
            </li>
            <?php endif; ?>
          </ol>
        </nav>
      <?php endif; ?>
      <div class="hero">
        <div class="hero__text-hld">
          <?php
          get_acf_component(
            'heading-box',
            [
              'data' => $heading,
            ],
          );
          ?>
          <?php
          get_acf_component(
            'action-group',
            [
              'data' => $buttons,
              'classes' => 'hero__btns',
            ],
          );
          ?>
        </div>
        <?php if ($custom_media === 'y') : ?>
          <div class="hero__media-hld">
            <?php if ($media_type === 'image') : ?>
              <?php $has_mobile = ($media_position === 'background' && (!empty($image_mobile['id']) || !empty($image_mobile['url']))); ?>
              <picture>
                <?php if ($has_mobile) : ?>
                  <source media="(max-width: 767px)" srcset="<?php echo esc_url(!empty($image_mobile['url']) ? $image_mobile['url'] : (isset($image_mobile['id']) ? wp_get_attachment_url($image_mobile['id']) : '')); ?>">
                <?php endif; ?>
                <?php
                $desktop_src = !empty($image['url']) ? $image['url'] : (isset($image['id']) ? wp_get_attachment_url($image['id']) : '');
                $desktop_alt = $image['alt'] ?? wp_strip_all_tags($heading ?? '');
                $desktop_class = 'hero__image hero__image--desktop' . ($has_mobile ? ' has-mobile-sibling' : '');
                ?>
                <img src="<?php echo esc_url($desktop_src); ?>" alt="<?php echo esc_attr($desktop_alt); ?>" class="<?php echo esc_attr($desktop_class); ?>">
              </picture>
            <?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
              <?php
              get_acf_components([
                'video' => [
                  'data'    => $video_group,
                  'classes' => 'hero__video', // Added specific class for styling
                ]
              ]);
              ?>
            <?php endif; ?>
          </div>
        <?php elseif ($color_mode === 'is-dark') : ?>
          <div class="hero__media-hld">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/parts/blocks/hero-secondary/bg.jpg'); ?>" alt="" class="hero__image hero__image--desktop">
          </div>
        <?php endif; ?>
      </div>
      <?php
      if ($show_logos_slider) :
        $current_logos = [];
        if ($use_global_logos) {
          $options = get_fields('options');
          $current_logos = $options['global_logos_slider'] ?? [];
        } else {
          $current_logos = $logos_slider;
        }

        if (!empty($current_logos)) :
          $logo_slides = [];
          foreach ($current_logos as $logo_item) {
            if (!empty($logo_item['logo'])) {
              $logo_img = $logo_item['logo'];
              $alt_text = !empty($logo_img['alt']) ? $logo_img['alt'] : 'Logo';
              ob_start();
      ?>

            <?php if (!empty($logo_img['id'])) : ?>
              <?php echo bis_get_attachment_picture(
                $logo_img['id'],
                [
                  1920 => [180, 100, 0],
                  2800 => [360, 200, 0],
                ],
                [
                  'alt'     => esc_attr($alt_text),
                  'class'   => 'hero__logos-slider__logo',
                  'loading' => 'lazy',
				  'space_between' => 60,
                ],
              ); ?>
            <?php elseif (!empty($logo_img['url'])) : ?>
              <img class="hero__logos-slider__logo" src="<?php echo esc_url($logo_img['url']); ?>" alt="<?php echo esc_attr($alt_text); ?>" />
            <?php endif; ?>
        <?php
            $logo_slides[] = ob_get_clean();
          }
        }

        $slide_count = count($logo_slides);
        if ($slide_count > 0) {
          $multiplier = ceil(20 / $slide_count);
          $logo_slides = array_merge(...array_fill(0, $multiplier, $logo_slides));
        }
        ?>
        <div class="hero__logos-slider-container hero__logos-slider-container--<?php echo esc_attr($slider_bg); ?>">
          <?php
          get_component('slider', [
            'slides' => $logo_slides,
            'slider_settings' => [
              'show_progressbar' => false,
              'autoplay_speed' => 3000,
              'loop' => true,
              'space_between' => 60,
            ],
            'classes' => 'hero__logos-slider'
          ]); ?>
        </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>
