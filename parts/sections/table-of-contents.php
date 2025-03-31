<section class="l-section l-section--table-of-contents is-light l-pt-3xl l-pb-lg js-table-of-contents-scope js-anim" data-anim-type="none">
	<div class="l-wrapper post-content">
		<div class="post-content__aside">
			<div class="sticky-wrapper">
				<div class="table-of-contents js-table-of-contents">
					<span class="table-of-contents__title t-heading t-heading--h6"><?php _e('Table of Contents', get_option('template')); ?></span>
				</div>
			</div>
		</div>
		<div class="post-content__main">
			<?php
				the_content();
			?>
		</div>
	</div>
</section>
