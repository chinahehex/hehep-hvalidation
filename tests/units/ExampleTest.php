<?php
namespace Tests\units;
use Tests\TestCase;
use \hehe\core\hvalidation\Validation;

class ExampleTest extends TestCase
{
    /**
     * 默认验证器验证
     */
    public function testDefaultValidators() {

        // 必填验证器
        $this->assertTrue($this->hvalidation->required('admin'));
        $this->assertFalse($this->hvalidation->required(''));

        // 判断是否为空
        $this->assertTrue($this->hvalidation->empty(''));
        $this->assertTrue($this->hvalidation->empty(0));
        $this->assertFalse($this->hvalidation->empty('XXX'));

        // 是否为浮点数
        $this->assertTrue($this->hvalidation->float('1.0'));
        $this->assertTrue($this->hvalidation->float('1'));
        $this->assertTrue($this->hvalidation->float(1));
        $this->assertTrue($this->hvalidation->float(1.0));
        $this->assertFalse($this->hvalidation->float('a1'));

        // 是否整数
        $this->assertTrue($this->hvalidation->float(1.01,['decimalPoint'=>2]));
        $this->assertFalse($this->hvalidation->float(1.011,['decimalPoint'=>2]));
        $this->assertTrue($this->hvalidation->float(-1,['symbol'=>'-']));
        $this->assertFalse($this->hvalidation->float(-1,['symbol'=>'+']));

        // 是否布尔值
        $this->assertTrue($this->hvalidation->boolean(true));
        $this->assertTrue($this->hvalidation->boolean(false));
        $this->assertFalse($this->hvalidation->boolean(1));
        $this->assertFalse($this->hvalidation->boolean('ab'));
        $this->assertFalse($this->hvalidation->boolean('1.0'));


        // 是否为为整型
        $this->assertTrue($this->hvalidation->int(1));
        $this->assertTrue($this->hvalidation->int('1'));
        $this->assertTrue($this->hvalidation->int('0'));
        $this->assertFalse($this->hvalidation->int('1.0'));
        $this->assertFalse($this->hvalidation->int('1.00'));
        $this->assertTrue($this->hvalidation->int(-1,['symbol'=>'-']));
        $this->assertTrue($this->hvalidation->int(1,['symbol'=>'+']));

        // 验证11位手机号
        $this->assertTrue($this->hvalidation->tel('13511111111'));
        $this->assertFalse($this->hvalidation->tel('135fdde1111'));
        $this->assertFalse($this->hvalidation->tel('135111111112'));

        // 验证日期格式
        $this->assertTrue($this->hvalidation->date('2010-1-20'));
        $this->assertFalse($this->hvalidation->date('2010-20-20'));
        $this->assertTrue($this->hvalidation->date('2010-1-20 17:59:59',['format'=>'Y-m-d H:i:s']));

        // 验证日期范围
        $this->assertTrue($this->hvalidation->rangedate('2020-1-20 17:59:59',['min'=>'2019-10-10']));
        $this->assertTrue($this->hvalidation->rangedate('2018-1-20 17:59:59',['max'=>'2019-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2018-1-20 17:59:59',['min'=>'2019-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2023-1-20 17:59:59',['max'=>'2019-10-10']));

        $this->assertTrue($this->hvalidation->rangedate('2023-1-20 17:59:59',['min'=>'2018-10-10','max'=>'2023-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2024-1-20 17:59:59',['min'=>'2018-10-10','max'=>'2023-10-10']));
        $this->assertFalse($this->hvalidation->rangedate('2014-1-20 17:59:59',['min'=>'2018-10-10','max'=>'2023-10-10']));

        // 验证邮箱
        $this->assertTrue($this->hvalidation->email('hehe@163.com'));
        $this->assertFalse($this->hvalidation->email('hehe163.com'));


        // 验证上传文件
        $file = [
            'name'=>'Screen Shot 2016-05-12 at 18.13.24.png',
            'type'=>'image/png',
            'tmp_name'=>'/private/var/tmp/phplVHp3W',
            'error'=>0,
            'size'=>1024 * 1024 * 2,
        ];

        $this->assertTrue($this->hvalidation->file($file,['max_size'=>2]));
        $this->assertTrue($this->hvalidation->file($file,['max_size'=>3]));
        $this->assertFalse($this->hvalidation->file($file,['max_size'=>1,5]));

        $this->assertTrue($this->hvalidation->file($file,['exts'=>['jpg','gif','png']]));
        $this->assertFalse($this->hvalidation->file($file,['exts'=>['jpg','gif']]));

        $this->assertTrue($this->hvalidation->file($file,['mimes'=>['image/gif','image/png']]));
        $this->assertFalse($this->hvalidation->file($file,['mimes'=>['image/gif']]));

        // ip 验证
        $this->assertTrue($this->hvalidation->ip('127.0.0.1'));
        $this->assertFalse($this->hvalidation->ip('127.0.x.1'));
        $this->assertTrue($this->hvalidation->ip4('127.0.1.1'));
        $this->assertFalse($this->hvalidation->ip4('127.0.ab.1'));
        $this->assertTrue($this->hvalidation->ip6('2001:0db8:3c4d:0015:0000:0000:1a2f:1a2b'));
        $this->assertFalse($this->hvalidation->ip6('2001:0db81:3c4d:0015:0000:0000:1a2f:1a2b'));

    }


}
