<?php 
namespace vinyoda197\Ojfilter;

trait Spelling
{
    protected
            $_pspell = null
    ;

    public function spell_check($string, $exclude = [])
    {
        if(false == extension_loaded('pspell')) {
            return $string;
        }

        $this->_pspell = $this->_pspell ?: pspell_new('en');

        return preg_replace_callback('/\b\w+\b/', 
            function($word) use ($exclude) {
                $word = $word[0];
                if (!in_array(strtolower($word), $exclude)) {
                    if (false === pspell_check($this->_pspell, $word)) {
                        return $this->mark($word);
                    }
                }
                return $word;
            },
            $string
        );
    }
}