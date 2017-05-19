<?php 
namespace vinyoda197\Ojfilter;

trait Markup
{
    protected
                $_tag = '',
                $_certainty = 1
    ;

    public function mark($text)
    {
        return sprintf('<%s certainty="%s">%s</%s>', 
                            $this->_tag, 
                            $this->_certainty, 
                            $text, 
                            $this->_tag);
    }
}