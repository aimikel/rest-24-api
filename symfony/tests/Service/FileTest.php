<?php

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\File;

class FileTest extends TestCase
{
    private static $FILES_DIR = '_files';
    /** @var File object */
    private $object;

    public function setUp()
    {
        parent::setUp();

        $em = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->object = new File($em, __DIR__);
    }

    public function testIsValid()
    {
        $invalidFile = new UploadedFile(__DIR__ . '/' . self::$FILES_DIR . '/invalid.xml', 'invalid', 'text/xml');
        $this->assertFalse($this->object->checkIsValid($invalidFile));
    }

    public function testIsNotValid()
    {
        $validFile = new UploadedFile(__DIR__ . '/' . self::$FILES_DIR . '/valid.csv', 'valid', 'text/csv');
        $this->assertTrue($this->object->checkIsValid($validFile));
    }
}