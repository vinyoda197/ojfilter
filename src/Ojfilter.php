<?php
namespace vinyoda197\Ojfilter;


class OJFilter
{
    protected
                $_rules = [],
                $_options = [],
                $_rules_path = '',
                $_hits = 0
    ;


    public function __construct($rules_path = '')
    {
        // default rules
        $rules_folder = dirname(__FILE__) . '/Rules';
        $files = scandir($rules_folder);

        if ($rules_path != '') {
            if (file_exists($rules_path)) {
                $this->_rules_path = $rules_path;
                $files = array_merge($files, scandir($rules_path));
            }
        }

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

            $opts = isset($this->_options[strtolower($rule)])
                        ? $this->_options[strtolower($rule)] 
                        : [];

            if ($this->_rules_path !== '') {
                $file = sprintf("%s/%s.php", $this->_rules_path, $rule);
                if (file_exists($file)) {
                    require_once($file);
                }    
            }            

            $rule_class =  'vinyoda197\\Ojfilter\\Rules\\' . $rule;           
            $rObj = new $rule_class($opts);       
            $rulesObjs[100 + $rObj->priority() + $indx] = $rObj;

            krsort($rulesObjs);
        }
        
        foreach($rulesObjs as $r) {
            $hits = $r->run($string); var_dump($hits);
            $this->_hits = $this->_hits + $hits;
        }

        return $string;
    }


    public function options(array $options) {
        $this->_options = $options;
    }


    public function hits()
    {
        return $this->_hits;
    }


}
