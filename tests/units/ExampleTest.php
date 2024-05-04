<?php
namespace Tests\units;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * 默认验证器验证
     */
    public function testDefaultValidators() {

        $this->assertTrue($this->hvalidation->ip('127.0.0.1'));

        $this->assertFalse($this->hvalidation->ip4('127.0.x.1'));
    }


}
