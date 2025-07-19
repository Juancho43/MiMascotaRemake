<?php

namespace App\Tests\MiMascota\Images\Domain;

use App\MiMascota\Images\Domain\Image;
use App\MiMascota\Shared\Domain\ValueObject\SoftDelete;
use App\MiMascota\Shared\Domain\ValueObject\TimeStamp;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    public function testCreate()
    {
       $image = Image::create(
            '123',
            'test_image.jpg',
            '/images/test_image.jpg',
            'image/jpeg',
            2048,
            'Pet',
            '456'
        );

        $this->assertInstanceOf(Image::class, $image);
        $this->assertEquals('123', $image->getId());
        $this->assertEquals('test_image.jpg', $image->getName());
        $this->assertEquals('/images/test_image.jpg', $image->getPath());
        $this->assertEquals('image/jpeg', $image->getType());
        $this->assertEquals(2048, $image->getSize());
        $this->assertEquals('Pet', $image->getImageableType());
        $this->assertEquals('456', $image->getImageableId());
        $this->assertInstanceOf(TimeStamp::class,$image->getTimeStamp());
        $this->assertInstanceOf(SoftDelete::class,$image->getSoftDelete());
    }


}
