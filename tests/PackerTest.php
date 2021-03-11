<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

use Cloudstek\PhpLaff\Packer;

final class PackerTest extends TestCase
{
    public $test_boxes = [
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 3, 'width' => '3' , 'height' => 3 ],
      [ 'length' => 6, 'width' => '6' , 'height' => 1 ],
      [ 'length' => 6, 'width' => '6' , 'height' => 1 ],
      [ 'length' => 6, 'width' => '6' , 'height' => 1 ],
    ];

    public $perfect_container = [
      'length' => 6, 'width' => 6, 'height' => 6
    ];

    public $undersized_open_container = [
      'length' => 5, 'width' => 5, 'height' => 0
    ];

    public $awkward_container = [
      'length' => 6, 'width' => 4, 'height' => 18
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

    public function testPackBoxesWithoutContainer(): void
    {
        $laff= new Packer($this->test_boxes);
        $laff->pack();

        $this->assertEquals(
            $this->perfect_container,
            $laff->get_container_dimensions()
        );

        $this->assertEmpty($laff->get_remaining_boxes());
    }

    public function testPackBoxesWithPerfectContainer(): void
    {
        $laff= new Packer($this->test_boxes, $this->perfect_container);
        $laff->pack();

        $this->assertEquals(
            $this->perfect_container,
            $laff->get_container_dimensions()
        );

        $this->assertEmpty($laff->get_remaining_boxes());
    }

    public function testPackBoxesWithUndersizedOpenContainer(): void
    {
        $laff= new Packer($this->test_boxes, $this->undersized_open_container);
        $laff->pack();

        $this->assertEquals(
            [ 'length' => 5, 'width' => '5', 'height' => 12 ],
            $laff->get_container_dimensions(),
        );

        // Three boxes won't fit
        $this->assertCount(3, $laff->get_remaining_boxes());
    }

    public function testPackBoxesWithAwkwardContainer(): void
    {
        $laff= new Packer($this->test_boxes, $this->awkward_container);
        $laff->pack();

        $this->assertEquals(
            $this->awkward_container,
            $laff->get_container_dimensions()
        );

        $this->assertEmpty($laff->get_remaining_boxes());
    }

}
