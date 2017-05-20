<?php
namespace vinyoda197\Ojfilter\Rules;

use \vinyoda197\Ojfilter\Rules as Rules;
use \vinyoda197\Ojfilter\Utils as Utils;


class Keyword extends Rules
{
    use Utils;

    protected
                $_tag = 'keyword',
                $_certainty = 1,
                $_options = []
    ;

    public function run(& $txt)
    {
        if (empty($this->_options)) {
            return $this->_hits;
        }

        $options = $this->_options;

        if (is_string($options)) {
            if (file_exists($options)) {
                if ($contents = file_get_contents($options)) {
                    $options = $this->noEmpties(explode("\n", $contents));
                }
            }
        }
        
        if (is_array($options)) {
            $patterns = $this->wrapEach($options, '/', '/i');

            $txt = preg_replace_callback($patterns, 
                                            function($match) {
                                                $this->_hits++;
                                                return $this->mark($match[0]);
                                            }, 
                                            $txt
                                        );
        }
        
        return $this->_hits;
    }
}