<?php
namespace hvalidation\tests\units;
use hehe\core\hcontainer\ContainerManager;
use hehe\core\hvalidation\annotation\AnnValidatorProcessor;
use hehe\core\hvalidation\Validation;

use hvalidation\tests\common\User;
use hvalidation\tests\TestCase;

/**
 * 注解测试
 * Class AnnTest
 * @package hvalidation\tests\units
 */
class AnnTest extends TestCase
{
    /**
     * @var \hehe\core\hcontainer\ContainerManager
     */
    protected $hcontainer;



    protected function setUp()
    {
        parent::setUp();
        $this->hcontainer = new ContainerManager();
        $this->hcontainer->addScanRule(\hvalidation\tests\TestCase::class,Validation::class)
            ->startScan();
    }

    // 验证基本规则
    public function testValidRule()
    {
        // 验证数据
        $data = [
            'name'=>"hehe",// 用户姓名
            'age'=>2,// 年龄
            'userType'=>4,// 用户类型
            'tel'=>'13811111111',// 联系方式
        ];

        // 校验规则
        $rules = Validation::getRule(User::class);

        $validationResult = $this->hvalidation->validate($rules,$data);

        $this->assertTrue($validationResult->getResult());
    }


    public function testValidRuleMethod()
    {
        // 验证数据
        $data = [
            'name'=>"hehe",// 用户姓名
            'age'=>2,// 年龄
            'userType'=>4,// 用户类型
            //'tel'=>'13811111111',// 联系方式
            'tel'=>'0898-15212532',// 联系方式
        ];

        // 校验规则
        $rules = Validation::getRule(User::class.'@add');

        $validationResult = $this->hvalidation->validate($rules,$data);

        $this->assertTrue($validationResult->getResult());
    }

    public function testValidRuleMethod1()
    {
        // 验证数据
        $data = [
            'name'=>"hehe",// 用户姓名
            'age'=>2,// 年龄
            'userType'=>4,// 用户类型
            'tel'=>'0898-12452652',// 联系方式
        ];

        // 校验规则
        $rules = Validation::getRule(User::class.'@add1');
        $validationResult = $this->hvalidation->validate($rules,$data);

        $this->assertTrue($validationResult->getResult());
    }


}
