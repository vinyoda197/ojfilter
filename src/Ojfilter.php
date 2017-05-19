<?php
namespace vinyoda197\Ojfilter;

class OJFilter
{
    protected
                $_rules = [],
                $_options = []
    ;


    public function __construct()
    {
        $rules_folder = dirname(__FILE__) . '/Rules';
        $files = scandir($rules_folder);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $this->_rules[] = rtrim($file, '.php');
        }
    }


    public function check($string, $specific_rule = null)
    {
        $rulesObjs = [];
        
        foreach($this->_rules as $indx => $rule) {
            if ($specific_rule && $rule != ucfirst($specific_rule)) {
                continue;
            }

            require_once("Rules/{$rule}.php");
            $opts = isset($this->_options[strtolower($rule)])
                        ? $this->_options[strtolower($rule)] 
                        : [];
            $rObj = new $rule($opts);            
            $rulesObjs[100 + $rObj->priority() + $indx] = $rObj;

            krsort($rulesObjs);
        }
        
        foreach($rulesObjs as $r) {
            $r->run($string);
        }

        return $string;
    }


    public function options(array $options) {
        $this->_options = $options;
    }

}
