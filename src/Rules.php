<?php 
namespace vinyoda197\Ojfilter;

class Rules
{
    use Markup;

    protected
            $_priority = 0,
            $_options = [],
            $_hits = 0
    ;

    public function __construct($options = [])
    {
        $this->_options = is_array($options)
                            ? array_merge($this->_options, $options)
                            : $options
                            ;
    }

    public function run(&$txt)
    {
        return $txt;
    }

    public function tag()
    {
        return $this->_tag;
    }

    public function priority()
    {
        return $this->_priority;
    }

    public function hits()
    {
        return $this->_hits;
    }
}