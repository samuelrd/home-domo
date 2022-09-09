<?php

namespace App\Utility;

trait Serializer
{
    private $ignored = ["__initializer__", "__cloner__", "__isInitialized__"];

    public function toArray()
    {
        $objVars = get_object_vars($this);
        return array_map(
            function ($element) {
                if (is_object($element)) {
                    return $element->toArray();
                } elseif (is_array($element)) {
                    return array_map(function ($arrayElement) {
                        return $arrayElement->toArray();
                    }, $element);
                }
                return $element;
            },
            array_filter(
                $objVars,
                function ($key) {
                        return ($key != 'ignored') && !in_array($key, $this->ignored);
                    },
                ARRAY_FILTER_USE_KEY
            )
        );
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
