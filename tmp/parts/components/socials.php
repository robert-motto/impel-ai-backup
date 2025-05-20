<?php
    $socials_additional_class = $args['socials_additional_class'];

      // Go to CMS -> Yoast SEO -> Settings -> Site Representation -> Other Profiles
    $seo_data         = get_option('wpseo_social');
    $twitter_username = $seo_data['twitter_site'];
    $twitter_url      = 'https://twitter.com/' . $twitter_username;
    $facebook_url     = $seo_data['facebook_site'];

    $other_social = $seo_data['other_social_urls'];

    $linkedin  = array_values(find_strpos_in_array($other_social, 'linkedin'));
    $instagram = array_values(find_strpos_in_array($other_social, 'instagram'));
    $youtube   = array_values(find_strpos_in_array($other_social, 'youtube'));

    $socials = [
        [
            'url'   => $linkedin ? $linkedin[0] : null,
            'title' => 'Linkedin',
            'icon'  => 'linkedin'
        ],
        [
            'url'   => $twitter_username ? $twitter_url : null,
            'title' => 'Twitter',
            'icon'  => 'twitter'
        ],
        [
            'url'   => $instagram ? $instagram[0] : null,
            'title' => 'Instagram',
            'icon'  => 'instagram'
        ],
        [
            'url'   => $youtube ? $youtube[0] : null,
            'title' => 'Youtube',
            'icon'  => 'youtube'
        ],
        [
            'url'   => $facebook_url ? $facebook_url : null,
            'title' => 'Facebook',
            'icon'  => 'facebook'
        ]
    ];
?>
<ul class="socials <?php echo $socials_additional_class ? 'socials--'.$socials_additional_class : null; ?>">
    <?php
        foreach ($socials as $social):
            $social_url   = $social['url'];
            $social_title = $social['title'];
            $social_icon  = $social['icon'];
                if ($social_url):
    ?>
        <li class="socials__item">
        <a  class="socials__item__link" target="_blank" rel="noopener noreferrer" href="<?php echo $social_url; ?>" title="<?php _e('Follow us on', get_option('template')); echo $social_title; ?>">
                <?php
                    get_icon($social_icon, [
                        'classes' => 'socials__item__link__icon',
                    ]);
                ?>
            </a>
        </li>
    <?php endif;
        endforeach;
    ?>
</ul>
