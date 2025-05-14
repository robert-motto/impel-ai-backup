<?php
$cards    = $args['cards'] ?? [];
$classes  = $args['classes'] ?? '';
?>

<?php if (!empty($cards)) : ?>
  <div class="cards <?php echo $classes; ?>">
    <?php foreach ($cards as $card) :
      $thumbnail = $card['thumbnail'] ?? '';
      $category = $card['category'] ?? '';
      $title = $card['title'] ?? '';
      $text = $card['text'] ?? '';
      $reading_time = $card['reading_time'] ?? '';
      $link = $card['link'] ?? '';
    ?>
      <?php
        get_component('card', [
          'item' => array(
            'thumbnail' => $card['thumbnail'] ?? '',
            'category' => $card['category'] ?? '',
            'title' => $card['title'] ?? '',
            'text' => $card['text'] ?? '',
            'reading_time' => $card['reading_time'] ?? '',
            'link' => $card['link'] ?? '',
          ),
        ]);
      ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>