<?php
namespace hehe\core\hvalidation\annotation;
use hehe\core\hcontainer\ann\base\Annotation;
use Attribute;
/**
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
#[Attribute]
class InlistValid extends Validator
{
    public $numbers;

    public $validator = 'inlist';

    /**
     * 构造方法
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param array $attrs
     */
    public function __construct($value = null,string $on = null,$goon = null,string $name = null,$validator = null,string $numbers = null,string $message = null)
    {
        $values = $this->getArgParams(func_get_args(),'message');
        foreach ($values as $name=>$val) {
            if ($name == 'numbers') {
                if (is_string($val)) {
                    $this->numbers = explode(',',$val);
                } else {
                    $this->numbers = $val;
                }
            } else {
                $this->$name = $val;
            }
        }
    }

}
