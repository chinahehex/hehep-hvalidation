<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * ip验证类
 *<B>说明：</B>
 *<pre>
 * 略
 *</pre>
 *<B>示例：</B>
 *<pre>
 *  规则格式:
 * ['attrs',[['ip']],'message'=>'请输入一个合法的IP地址']
 * ['attrs',[['ip','mode'=>'ip4']],'message'=>'请输入一个合法的IP地址']
 * ['attrs',[['ip','mode'=>'ip6']],'message'=>'请输入一个合法的IP地址']
 *</pre>
 */
class IpValidator extends Validator
{

    /**
     * ip正则表达式
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @var string
     */
    protected $pattern = '/^(\d+\.\d+\.\d+\.\d+)$/';

    /**
     * 验证ip 格式
     *<B>说明：</B>
     *<pre>
     *  ip4,ip6
     *</pre>
     * @var string
     */
    protected $mode = '';

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

        if (empty($this->mode)) {
            if ($this->ip4($value) || $this->ip6($value)) {
                return true;
            } else {
                return false;
            }
        }

        if ($this->mode == 'ip4') {
            if ($this->ip4($value)) {
                return true;
            } else {
                return false;
            }
        }

        if ($this->mode == 'ip6') {
            if ($this->ip6($value)) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    protected function ip4($ip)
    {
        $valid = preg_match($this->pattern, $ip);

        return $valid === 1;
    }

    protected function ip6($ip)
    {
        $pattern = '/\A 
        (?: 
        (?: 
        (?:[a-f0-9]{1,4}:){6} 
         
        ::(?:[a-f0-9]{1,4}:){5} 
         
        (?:[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){4} 
         
        (?:(?:[a-f0-9]{1,4}:){0,1}[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){3} 
         
        (?:(?:[a-f0-9]{1,4}:){0,2}[a-f0-9]{1,4})?::(?:[a-f0-9]{1,4}:){2} 
         
        (?:(?:[a-f0-9]{1,4}:){0,3}[a-f0-9]{1,4})?::[a-f0-9]{1,4}: 
         
        (?:(?:[a-f0-9]{1,4}:){0,4}[a-f0-9]{1,4})?:: 
        ) 
        (?: 
        [a-f0-9]{1,4}:[a-f0-9]{1,4} 
         
        (?:(?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\.){3} 
        (?:[0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5]) 
        ) 
         
        (?: 
        (?:(?:[a-f0-9]{1,4}:){0,5}[a-f0-9]{1,4})?::[a-f0-9]{1,4} 
         
        (?:(?:[a-f0-9]{1,4}:){0,6}[a-f0-9]{1,4})?:: 
        ) 
        )\Z/ix';

        $valid = preg_match($pattern, $ip);

        return $valid === 1;
    }

}
