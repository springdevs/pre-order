<?php

namespace SpringDevs\PreOrder\Illuminate;

/**
 * Class Helper
 * @package SpringDevs\PreOrder\Illuminate
 */
class Helper
{
    static public function has_preorder(Int $product_id)
    {
        return get_post_meta($product_id, '_has_preorder', true) ? true : false;
    }
}
