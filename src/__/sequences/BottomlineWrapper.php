<?php

class BottomlineWrapper
{
    /**
     * @var mixed $value
     */
    private $value;

    /**
     * BottomlineWrapper constructor.
     *
     * @param mixed $value the value that is going to be chained
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * dynamically calls bottomline function, prepend the list of parameters with the current collection list
     *
     * @param string $functionName must be a valid bottomline function
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function __call($functionName, $params)
    {
        if (is_callable('__', $functionName)) {
            $params = $params == null ? [] : $params;
            $params = __::prepend($params, $this->value);
            $this->value = call_user_func_array(array('__', $functionName), $params);
            return $this;
        } else {
            throw new \Exception("Invalid function {$functionName}");
        }
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
