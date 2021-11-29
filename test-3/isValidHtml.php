<?php

/**
 * Valid html structure
 * @param array $tags
 * @return bool
 */
function isValidHtml(array $tags): bool
{
    $openTags = [];
    $pattern = "</";

    foreach ($tags as $tag) {
        if (strpos($tag, $pattern) === false) {
            $openTags[] = $tag;
        } else {
            $closeTag = array_pop($openTags);
            $checkTags = str_replace("/", "", $tag);

            if ($closeTag !== $checkTags) {
                return false;
            }
        }
    }

    return (count($openTags) === 0);
}
