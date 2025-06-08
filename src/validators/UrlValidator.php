<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 网络地址验证类
 *<B>说明：</B>
 *<pre>
 * 支持http.https 格式
 *  规则格式:
 * ['attrs',[['url','pattern'=>'','validSchemes'=>['https,'http'],'defaultScheme'=>'http']],'message'=>'请输入一个合法的网络地址']
 *</pre>
 */
class UrlValidator extends Validator
{

    /**
     * url 地址正则
     *<B>说明：</B>
     *<pre>
     *  表达式中可用{schemes}　代替http,或https
     *</pre>
     * @var string
     */
    public $pattern = '/^{schemes}:\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i';

    /**
     * 允许的schemes
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var array
     */
    public $validSchemes = ['http', 'https'];

    /**
     * 默认scheme
     *<B>说明：</B>
     *<pre>
     *  如验证值url 没有scheme, 则默认加上
     *</pre>
     * @var array
     */
    public $defaultScheme;

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
    protected function validateValue($value,$name = null):bool
    {
        if ($this->defaultScheme !== null && strpos($value, '://') === false) {
            $value = $this->defaultScheme . '://' . $value;
        }

        if (strpos($this->pattern, '{schemes}') !== false) {
            $pattern = str_replace('{schemes}', '(' . implode('|', $this->validSchemes) . ')', $this->pattern);
        } else {
            $pattern = $this->pattern;
        }

        return preg_match($pattern, $value) === 1;
    }


}
