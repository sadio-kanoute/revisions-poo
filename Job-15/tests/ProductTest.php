<?php
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testClothingClassExists()
    {
        $this->assertTrue(class_exists('\\Clothing') || class_exists('App\\Clothing'));
    }

    public function testCanInstantiateClothing()
    {
        if (class_exists('App\\Clothing')) {
            $c = new App\\Clothing();
            $this->assertInstanceOf(App\\Clothing::class, $c);
        } else {
            if (!class_exists('\\Clothing')) {
                $this->markTestSkipped('Clothing class not available');
            }
            $c = new \\Clothing();
            $this->assertInstanceOf(\\Clothing::class, $c);
        }
    }
}
