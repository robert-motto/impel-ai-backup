<?php
    function embed_player_id($player, $link){
        if($player === 'youtube'){
            $youtube_id = str_replace('https://www.youtube.com/watch?v=', '', $link);
            if($youtube_id === $link){
                $youtube_id = str_replace('https://youtu.be/', '', $link);
            }
            return $youtube_id;
        }elseif($player === 'vimeo'){
            $vimeo_id = str_replace('https://vimeo.com/', '', $link);
            $vimeo_id = str_replace('?share=copy', '', $vimeo_id);
            return $vimeo_id;
        }
        return null;
    };
