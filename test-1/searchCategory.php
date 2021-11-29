<?php

/**
 * Return flatten tree
 * @param array $tree
 * @return array
 * @example
 * array_filter([1]); // [1];
 * array_filter([1, 2, [3, 4]]); // [1, 2, 3, 4];
 */
function array_flatten(array $tree): array
{
    if (!is_array($tree)) {
        return false;
    }
    $result = [];
    foreach ($tree as $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        } else {
            $result[] = $value;
        }
    }
    return $result;
}

/**
 * Search category by id
 * @param array $categories
 * @param int $id
 * @return string|null
 */
function searchCategory(array $categories, int $id): ?string
{
    if (empty($categories)) {
        return '';
    }

    $searchCategory = array_reduce(
        $categories,
        function ($acc, $item) use ($id, $categories) {
            if ($item === $id) {
                $acc[] = $categories['title'];
            } elseif (is_array($item)) {
                $acc[] = searchCategory($item, $id);
            }
            return array_flatten($acc);
        },
        []
    );

    return implode("", $searchCategory);
}
