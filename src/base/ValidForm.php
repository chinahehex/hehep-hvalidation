<?php
namespace hehe\core\hvalidation\base;

use ArrayAccess;

class ValidForm implements ArrayAccess
{
    protected $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /** 以下方法为,对象作为数组操作的接口方法 **/
    public function offsetExists($offset):bool
    {
        if (isset($this->data[$offset])) {
            return true;
        } else {
            return false;
        }
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value):void
    {
        $this->data[$offset] = $value;

        return;
    }

    public function offsetUnset($offset):void
    {
        unset($this->data[$offset]);
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function has($name)
    {
        return isset($this->data[$name]);
    }

    public function all()
    {
        return $this->data;
    }
}
