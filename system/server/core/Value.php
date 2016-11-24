<?php
namespace server\core;

/**
 * Class Value
 * @package Core
 */
class Value
{
    /**
     * @var
     */
    protected $var;

    /**
     * Value constructor.
     * @param $var
     */
    public function __construct($var=null)
    {
        $this->var=$var;
    }

    /**
     * @return mixed
     */
    public function getVar()
    {
        return $this->var;
    }

    /**
     * @param mixed $var
     */
    public function setVar($var)
    {
        $this->var = $var;
    }

    /**
     * @param string $name
     * @return string
     */
    public function __get(string $name)
    {
        return isset($this->var[$name])?$this->var[$name]:null;
    }

    /**
     * @param string $name
     * @param $value
     * @return mixed
     */
    public function __set(string $name, $value)
    {
        return $this->var[$name]=$value;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name)
    {
        return isset($this->var[$name]);
    }

    /**
     * @param string $name
     * @param $args
     * @return mixed|string
     */
    public function __call(string $name, $args)
    {
        $fmt=isset($this->var[$name])?$this->var[$name]:(isset($args[0])?$args[0]:null);
        if (count($args)>1) {
            $args[0]=$fmt;
            return call_user_func_array('sprintf', $args);
        }
        return $fmt;
    }
}
