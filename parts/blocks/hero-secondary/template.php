<?php /*
	Block Name: Hero Secondary
	Block Align: center
	Block Icon: superhero-alt
*/ ?>
<?php if (isset($block['data']['is_preview'])) : ?>
  <?php block_preview(__FILE__); ?>
<?php else : ?>
  <?php
  $group        = blockFieldGroup(__FILE__);
  $caption      = $group['caption'] ?? '';
  $heading      = $group['heading'] ?? '';
  $content_type = $group['content_type'] ?? 'icon_points';
  $paragraph    = $group['paragraph'] ?? '';
  $icon_points  = $group['icon_points'] ?? [];
  $buttons      = $group['buttons_group'] ?? [];
  $media_type   = $group['media_type'] ?? 'image';
  $image        = $group['image'] ?? null;
  $video_group  = $group['video_group'] ?? [];
  $animation_url = $group['animation_url'] ?? '';
  $logotypes    = $group['logotypes'] ?? [];

  // Set fallback image if none is selected and media type is image
  if ($media_type === 'image' && (empty($image) || !isset($image['id']))) {
    $fallback_image_path = get_template_directory() . '/screenshot.jpg';
    $fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
    if (file_exists($fallback_image_path)) {
      $fallback_attachment = attachment_url_to_postid($fallback_image_uri);
      if ($fallback_attachment) {
        $image = ['id' => $fallback_attachment];
      } else {
        $image = [
          'url' => $fallback_image_uri,
          'alt' => wp_strip_all_tags($heading ?? 'Hero secondary image')
        ];
      }
    }
  }

  // Section classes
  $classes = ['js-section', 'l-section', 'l-section--hero-secondary', 'js-hero-secondary'];
  if (!empty($group['section_settings_group']['background_color'])) {
    $classes[] = 'is-' . $group['section_settings_group']['background_color'];
  } else {
    $classes[] = 'is-light';
  }
  ?>
  <section class="<?php echo esc_attr(implode(' ', $classes)); ?> <?php echo section_settings_padding_classes($group); ?>" data-block="hero-secondary">
    <div class="l-wrapper">
      <?php get_component('breadcrumbs', ['classes' => 'hero-secondary__breadcrumbs']); ?>
      <div class="hero-secondary">
        <div class="hero-secondary__content">
          <div class="hero-secondary__text-hld">
            <?php if (!empty($caption)) : ?>
              <div class="hero-secondary__caption">
                <?php echo esc_html($caption); ?>
              </div>
            <?php endif; ?>
            <?php if (!empty($heading)) : ?>
              <h1 class="hero-secondary__heading">
                <?php echo $heading; ?>
              </h1>
            <?php endif; ?>

            <?php if ($content_type === 'paragraph' && !empty($paragraph)) : ?>
              <div class="hero-secondary__paragraph">
                <?php echo $paragraph; ?>
              </div>
            <?php elseif ($content_type === 'icon_points' && !empty($icon_points)) : ?>
              <ul class="hero-secondary__points">
                <?php foreach ($icon_points as $point) : ?>
                  <li class="hero-secondary__point">
                    <div class="hero-secondary__point-icon">
                      <?php get_icon('check-circle'); ?>
                    </div>
                    <span class="hero-secondary__point-text"><?php echo esc_html($point['text']); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

            <?php
            get_acf_components([
              'buttons' => [
                'data'    => $buttons,
                'classes' => 'hero-secondary__btns',
              ],
            ]);
            ?>
          </div>
          <div class="hero-secondary__media-hld">
            <?php if ($media_type === 'image') : ?>
              <?php
              if (!empty($image['id'])) {
                if (function_exists('bis_get_attachment_picture')) {
                  echo bis_get_attachment_picture(
                    $image['id'],
                    [
                      560  => [390 * 2, 772 * 2, 1],
                      1024 => [1024, 1474, 1],
                      1365 => [1400, 760, 1],
                      2800 => [1400 * 2, 760 * 2, 1],
                    ],
                    [
                      'alt'   => $image['alt'] ? $image['alt'] : wp_strip_all_tags($heading ?? ''),
                      'class' => 'hero-secondary__image',
                    ]
                  );
                } else {
                  $img_src = wp_get_attachment_image_url($image['id'], 'large');
                  $img_alt = get_post_meta($image['id'], '_wp_attachment_image_alt', true) ?: wp_strip_all_tags($heading ?? '');
                  echo '<img class="hero-secondary__image" src="' . esc_url($img_src) . '" alt="' . esc_attr($img_alt) . '" />';
                }
              } elseif (!empty($image['url'])) {
                echo '<img class="hero-secondary__image" src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? '') . '" />';
              }
              ?>
            <?php elseif ($media_type === 'video' && !empty($video_group)) : ?>
              <?php
              get_acf_components([
                'video' => [
                  'data'    => $video_group,
                  'classes' => 'hero-secondary__video',
                ]
              ]);
              ?>
            <?php elseif ($media_type === 'animation' && !empty($animation_url)) : ?>
              <div class="hero-secondary__animation">
                <?php echo $animation_url; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php if (!empty($logotypes)) : ?>
          <div class="hero-secondary__logotypes">
            <div class="hero-secondary__logotypes-divider"></div>
            <div class="hero-secondary__logotypes-grid">
              <?php foreach ($logotypes as $logo) : ?>
                <?php if (!empty($logo['logo'])) : ?>
                  <div class="hero-secondary__logotype">
                    <?php if (!empty($logo['logo']['id'])) : ?>
                      <?php
                      if (function_exists('bis_get_attachment_picture')) {
                        echo bis_get_attachment_picture(
                          $logo['logo']['id'],
                          [
                            300 => [120, 60, 0],
                            600 => [120 * 2, 60 * 2, 0],
                          ],
                          [
                            'alt' => !empty($logo['name']) ? esc_attr($logo['name']) . ' logo' : '',
                            'class' => 'hero-secondary__logotype-img',
                          ]
                        );
                      } else {
                        $logo_src = wp_get_attachment_image_url($logo['logo']['id'], 'medium');
                        $logo_alt = !empty($logo['name']) ? esc_attr($logo['name']) . ' logo' : '';
                        echo '<img class="hero-secondary__logotype-img" src="' . esc_url($logo_src) . '" alt="' . esc_attr($logo_alt) . '" />';
                      }
                      ?>
                    <?php elseif (!empty($logo['logo']['url'])) : ?>
                      <img class="hero-secondary__logotype-img" src="<?php echo esc_url($logo['logo']['url']); ?>" alt="<?php echo !empty($logo['name']) ? esc_attr($logo['name']) . ' logo' : ''; ?>" />
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
