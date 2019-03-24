<?php 
namespace App\Traits;

/**
 * 
 */
trait StringTrait
{
    public function slug($value, $max = 30)
    {
        $out = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        $out = substr(preg_replace("/[^-\/+|\w ]/", '', $out), 0, $max);
        $out = strtolower(trim($out, '-'));
        $out = preg_replace("/[\/_| -]+/", '-', $out);

        return $out;
    }
}
