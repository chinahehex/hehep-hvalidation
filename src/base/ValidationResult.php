<?php
/**
 * Created by PhpStorm.
 * User: hehe
 * Date: 20-7-31
 * Time: 下午2:34
 */

namespace hehe\core\hvalidation\base;


class ValidationResult
{
    /**
     * @var ValidateResult[]
     */
    protected $validatorResults = [];

    /**
     * 错误消息
     * @var array
     */
    protected $errors = [];

    /**
     * 首个错误验证结果对象
     * @var ValidateResult
     */
    protected $firstValidResult = null;

    /**
     * 最终验证结果
     * @var bool
     */
    protected $validResult = null;

    /**
     * 获取最终验证结果
     * @return boolean
     */
    public function getResult()
    {

        if (!is_null($this->validResult)) {
            return $this->validResult;
        }

        $validResult = true;

        foreach ($this->validatorResults as $validatorResult) {
            if ($validatorResult->getResult() == false) {
                $validResult = false;
                if (is_null($this->firstValidResult)) {
                    $this->firstValidResult = $validatorResult;
                }
                $this->errors[] = $validatorResult->getMessage();
            }
        }

        $this->validResult = $validResult;

        return $this->validResult;

    }

    /**
     * 获取首个验证器错误消息
     * @return string
     */
    public function getFirstMessage()
    {
        return $this->firstValidResult->getMessage();
    }

    public function getFirstCode()
    {
        return $this->firstValidResult->getCode();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addValidatorResult($validatorResult)
    {

        $this->validatorResults[] = $validatorResult;
    }


}
