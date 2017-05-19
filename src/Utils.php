<?php 
namespace vinyoda197\Ojfilter;


trait Utils
{
    public function no_whites($txt)
    {
        $white = "\\x00-\\x20";    //all white-spaces and control chars 
        return trim( preg_replace( "/[".$white."]+/" , '' , $txt ) , $white );
    }


    public function space2dash($txt)
    {
        return preg_replace("/ /", '-', $txt);
    }


    public function cutAfter($text, $marker, $occurence)
    {
        $pos = $count = 0;
        $poslast = strlen($text);

        while ($pos = strpos($text, $marker, $pos)) {    
            if (++$count >= $occurence) {
                break;
            }
            $poslast = $pos;
        }

        return substr($text, 0, $poslast);
    }

    public function wrapEach($texts, $start = '/', $end = null)
    {
        return array_map(function($text) use ($start, $end) {
            $end = $end ?: $start;
            return $start . $text . $end;
        }, $texts);
    }

    public function noEmpties($var)
    {
        if (is_array($var)) {
            $var = array_filter($var, function($item) {
                return trim($item) != '';
            });
        }
        return $var;
    }
}