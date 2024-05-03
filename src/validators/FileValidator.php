<?php
namespace hehe\core\hvalidation\validators;

use hehe\core\hvalidation\base\Validator;

/**
 * 表单 文件验证类
 *<B>说明：</B>
 *<pre>
 * 规则格式:
 * ['attrs',[['file']],'message'=>'请上传文件']
 *</pre>
 */
class FileValidator extends Validator
{

    /**
     * 大小限制,单位M
     * @var int
     */
    public $max_size = 0;

    /**
     * 文件后缀
     * @var array
     */
    public $exts =  [];

    /**
     * 文件类型
     * @var array
     */
    public $mimes = [];

    /**
     * 验证值接口
     *<B>说明：</B>
     *<pre>
     *　略
     *</pre>
     * @param array $file
     * @param string $name 属性名
     * @return boolean
     */
    protected function validateValue($file,$name = null)
    {
        // 判断是否文件类型
        if (!empty($file) && is_array($file) && isset($file['tmp_name'])) {

            // 检测文件大小
            if (!$this->checkSize($file['size'])) {
                return false;
            }

            // 检测文件类型
            if (!$this->checkMime($file['type'])) {
                return false;
            }
            // 检测文件后缀
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            if (!$this->checkExt($file['name'])) {
                return false;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * 检测文件大小
     * @param int $size
     */
    protected function checkSize(int $size)
    {
        $max_size = $this->max_size * 1024 * 1024;
        if ($max_size === 0 || $size < $max_size) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检查上传的文件后缀是否合法
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param string $ext 文件后缀
     * @return boolean
     */
    protected function checkExt(string $ext):bool
    {
        $ext = strtolower($ext);

        if (count($this->exts) == 0) {
            return true;
        }

        if (in_array($ext, $this->exts)) {
            return true;
        }

        return false;
    }

    /**
     * 检查上传的文件MIME类型是否合法
     *<B>说明：</B>
     *<pre>
     *  略
     *</pre>
     * @param string $mime mimes字符
     * @return boolean true 表示合法 false 表示不合法
     */
    protected function checkMime(string $mime):bool
    {
        if (count($this->mimes) > 0) {
            return in_array(strtolower($mime), $this->mimes);
        } else {
            return true;
        }
    }



}
