<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Cloudstek\PhpLaff\Packer;

final class PackerTest extends TestCase
{
    public $test_boxes= [
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 6, 'width' => '6' , 'height' => 1 ],
      [ 'length' => 6, 'width' => '6' , 'height' => 1 ],
      [ 'length' => 6, 'width' => '6' , 'height' => 1 ],
    ];

    public $perfect_container= [
      'length' => 6, 'width' => 6, 'height' => 6
    ];

    public function testCreatePackerWithNoArguments(): void
    {
        $this->assertInstanceOf(
            Packer::class,
            new Packer()
        );
    }

    public function testCreatePackerWithBoxes(): void
    {
        $this->assertInstanceOf(
            Packer::class,
            new Packer($this->test_boxes)
        );
    }

    public function testCreatePackerWithBoxesAndContainer(): void
    {
        $this->assertInstanceOf(
            Packer::class,
            new Packer($this->test_boxes, $this->perfect_container)
        );
    }

    public function testCreatePackerWithInvalidContainer(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Packer($this->test_boxes, [ ]);
    }
}
