<?php
namespace hehe\core\hvalidation\annotation;
use  hehe\core\hannotation\base\Annotation;
/**
 * @Annotation("hehe\core\hvalidation\annotation\AnnValidatorProcessor")
 */
class NotinValid extends AnnValidator
{

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
        parent::__construct($attrs);
        $this->validator[0] = 'notin';
    }
}
