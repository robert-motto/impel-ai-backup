<?php
$item = $args['item'] ?? [];
$thumbnail = $item['thumbnail'] ?? '';
$category = $item['category'] ?? '';
$reading_time = $item['reading_time'] ?? '';
$title = $item['title'] ?? '';
$text = $item['text'] ?? '';
$link = $item['link'] ?? '';

  // Set fallback image if none is selected
  // TODO: Add category specific images
  if (empty($thumbnail) || !isset($thumbnail['id'])) {
  $fallback_image_path = get_template_directory() . '/screenshot.jpg';
  $fallback_image_uri = get_template_directory_uri() . '/screenshot.jpg';
  if (file_exists($fallback_image_path)) {
    $fallback_attachment = attachment_url_to_postid($fallback_image_uri);
    if ($fallback_attachment) {
      $thumbnail = ['id' => $fallback_attachment];
    } else {
      $thumbnail = [
        'url' => $fallback_image_uri,
        'alt' => wp_strip_all_tags($title ?? 'Shortlist item')
      ];
    }
  }
}
?>

<div class="card">
  <?php if (!empty($link) && !empty($link['url'])) : ?>
    <a href="<?php echo esc_url($link['url']); ?>" class="card__item-link" <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
  <?php endif; ?>

  <div class="card__item-media">
    <?php
      if (!empty($thumbnail['id'])) {
        echo bis_get_attachment_picture(
          $thumbnail['id'],
          [
            560  => [ 400, 250, 1 ],
            1024 => [ 400, 250, 1 ],
            1920 => [ 400, 250, 1 ],
            2800 => [ 800, 500, 1 ],
          ],
          [
            'alt'     => $thumbnail['alt'] ? $thumbnail['alt'] : wp_strip_all_tags($title ?? ''),
            'class'   => 'card__item-img',
            'loading' => 'lazy',
          ],
        );
      } elseif (!empty($thumbnail['url'])) {
        echo '<img class="card__item-img" src="' . esc_url($thumbnail['url']) . '" alt="' . esc_attr($thumbnail['alt']) . '"  />';
      }
    ?>
  </div>

  <div class="card__item-content">
    <div class="card__item-meta">
      <?php if (!empty($category)) : ?>
        <div class="card__item-category">
          <?php echo esc_html($category); ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($reading_time)) : ?>
        <div class="card__item-time">
          <span class="card__item-time-text"><?php echo esc_html($reading_time); ?></span>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($title)) : ?>
      <h3 class="card__item-title">
        <?php echo esc_html($title); ?>
      </h3>
    <?php endif; ?>

    <?php if (!empty($text)) : ?>
      <p class="card__item-text">
        <?php echo esc_html($text); ?>
      </p>
    <?php endif; ?>

    <?php
      get_acf_component('button', [
        'data' => [
          'type' => 'link',
          'size' => 'large',
          'button' => [
            'url' => '',
            'title' => 'Read more',
            'target' => '_self'
          ],
          'has_icon' => 'y',
          'icon_position' => 'right',
        ],
        'classes' => 'card__item-btn',
        'tag' => 'span',
      ]);
    ?>
  </div>

  <?php if (!empty($link) && !empty($link['url'])) : ?>
    </a>
  <?php endif; ?>
</div>
