<?php
  $tabs = $args['tabs'] ?? [];
?>
<div class="tabs__navigation">
  <?php foreach ($tabs as $index => $tab) : ?>
    <button id="tab-button-<?php echo esc_attr($index); ?>"
        class="tabs__nav-button js-tab-button <?php echo $index === 0 ? 'is-active' : ''; ?>"
        aria-controls="tab-content-<?php echo esc_attr($index); ?>"
        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
        tabindex="<?php echo $index === 0 ? '0' : '-1'; ?>"
        role="tab">
      <?php echo esc_html($tab['tab_title']); ?>
    </button>
  <?php endforeach; ?>
</div>