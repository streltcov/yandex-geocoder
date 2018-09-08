<?php

namespace streltcov\geocoder\traits;

/**
 * Trait FilterTrait
 *
 * @package streltcov\geocoder\traits
 */
trait FiltersTrait
{

    /**
     * @param array $selected
     * @param string|array $parameters
     * @return array|null
     */
    private function filterId(array $selected, $parameters)
    {

        return array_filter($selected, function ($key) use ($parameters) {
            if (is_array($parameters)) {
                in_array($key, $parameters) ? $answer = true : $answer = false;
                return $answer;
            } else {
                if ($key == $parameters) return true;
            }
        }, ARRAY_FILTER_USE_KEY);

    } // end function



    /**
     * @param array $selected
     * @param string|array $kinds
     * @return array|null
     */
    private function filterKind(array $selected, $kinds)
    {

        $selected = array_filter($selected, function ($item) use ($kinds) {
            if (is_array($kinds)) {
                in_array($item->kind(), $kinds) ? $answer = true : $answer = false;
                return $answer;
            } else {
                if ($item->kind() == $kinds) return true;
            }
        });

        return $selected;

    } // end function

} // end trait
