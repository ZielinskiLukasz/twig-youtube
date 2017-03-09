<?php

namespace AppBundle\Twig;

/**
 * This Twig extension adds new 'youtube' and 'youtubeImage' filters.
 * 'youtube' filter transforms given link to a iframe playable object.
 * 'youtubeImage' displays the main video image.
 * If the link is in the wrong format, filters output the link without changes.
 */
class YoutubeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('youtube', [$this, 'youtubeFilter'], ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('youtubeImage', [$this, 'youtubeImageFilter'], ['is_safe' => ['html']]),
        );
    }

    public function youtubeFilter(string $youtubeLink, $width = 560, $height = 315) : string
    {
        $string = $youtubeLink;
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeLink, $match)) {
            $video_id = $match[1];

            $string = '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $video_id . '" style="border: 0;" allowfullscreen></iframe>';
        }
        return $string;
    }

    public function youtubeImageFilter(string $youtubeLink) : string
    {
        $string = $youtubeLink;
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeLink, $match)) {
            $video_id = $match[1];

            $string = '<img src="https://img.youtube.com/vi/' . $video_id . '/mqdefault.jpg" />';
        }
        return $string;
    }    

    public function getName() : string
    {
        return 'youtube';
    }
}
