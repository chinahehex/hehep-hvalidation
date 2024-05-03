<?php
namespace hehe\core\hvalidation\annotation;

use  hehe\core\hannotation\base\Annotation;

/**
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
class AnnValidator
{

    public $validator = [];

    public $message;

    public $on;

    public $goon;

    /**
     * 验证的键名
     * @var string
     */
    public $name;

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param array $attrs
     */
    public function __construct($attrs = [])
    {
        // Required
        foreach ($attrs as $attr=>$value) {
            if ($attr == "value") {
                $this->message = $value;
            } else {
                if (property_exists($this,$attr)) {
                    $this->$attr = $value;
                } else {
                    $this->validator[$attr] = $value;
                }
            }

            $this->validator['message'] = $this->message;
        }
    }
}
