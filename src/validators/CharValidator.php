<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 身份证验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  略
 *</pre>
 */
class CharValidator extends Validator
{

    /**
     * 验证模式
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $mode = 'alpha';

    /**
     * 验证的长度
     *<B>说明：</B>
     *<pre>
     *  ['最小长度','最大长度']
     *</pre>
     * @var string
     */
    protected $len = [];

    protected $patterns = [
            "alpha"=>'/^(?:[a-zA-Z]{point})$/',
            "alphaNum"=>'/^(?:[a-zA-Z0-9]{point})$/',
            "alphaDash"=>'/^(?:[\w-]{point})$/'
    ];

    /**
     * 验证值接口
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param string $value
     * @param string $name 属性名
     * @return boolean
     */
    protected function validateValue($value,$name = null)
    {

        if (empty($this->len)) {
            $point = '+';
        } else {
            if (is_array($this->len)) {
                $point = "{" . $this->len[0] . "," . $this->len[1] ."}";
            } else {
                $point = "{" . $this->len . "}";
            }
        }

        $pattern = $this->patterns[$this->mode];
        $pattern = str_replace('{point}', $point , $pattern);
        $valid = preg_match($pattern, $value);

        return $valid === 1;
    }

}