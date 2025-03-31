<?php
    $total_number_of_pages = $args['total_number_of_pages'] ?? '';
    $posts_per_page = $args['posts_per_page'] ?? '';
    $classes = $args['classes'] ?? '';

?>
<?php if ($total_number_of_pages > 1) :?>
    <div class="<?php echo $classes; ?> u-pagination">
        <?php
            $last = $total_number_of_pages;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $offset_start = 1;
            $per_page = $posts_per_page;
            $paginate_args = array(
                'total' => $total_number_of_pages,
                'current' => $paged,
                'end_size' => 1,
                'mid_size' => 1,
                'prev_next' => true,
                'before_page_number' => '<span class="text">',
                'after_page_number' => '</span>',
                'prev_text' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none"><path d="M4.58325 11.0028H17.4166M17.4166 11.0028L13.7499 14.6695M17.4166 11.0028L13.7499 7.33618" stroke="#311E04" stroke-width="1.5" stroke-linecap="round"/></svg>',
                'next_text' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none"><path d="M4.58325 11.0028H17.4166M17.4166 11.0028L13.7499 14.6695M17.4166 11.0028L13.7499 7.33618" stroke="#311E04" stroke-width="1.5" stroke-linecap="round"/></svg>',
            );
        ?>
        <?php echo paginate_links($paginate_args); ?>
    </div>
<?php endif; ?>
