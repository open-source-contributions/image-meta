<?php
/**
 * @author Peter Gribanov <info@peter-gribanov.ru>
 */

namespace GpsLab\Component\ImageMeta\Tests;

use GpsLab\Component\ImageMeta\DataMeta;
use GpsLab\Component\ImageMeta\ParserMeta;

class ParserMetaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ParserMeta
     */
    protected $parser;

    /**
     * @var string
     */
    protected $filename;

    const IMAGE = 'R0lGODlhAQAFAKIAAPX19e/v7/39/fr6+urq6gAAAAAAAAAAACH5BAAAAAAALAAAAAABAAUAAAMESAEjCQA7';

    protected function setUp()
    {
        $this->parser = new ParserMeta();
        $this->filename = tempnam(sys_get_temp_dir(), 'test');
    }

    protected function tearDown()
    {
        if (file_exists($this->filename)) {
            unlink($this->filename);
        }
    }

    public function testParseNoFile()
    {
        $this->assertNull($this->parser->getMeta($this->filename));
    }

    public function testParseNotImage()
    {
        touch($this->filename);
        $this->assertNull($this->parser->getMeta($this->filename));
    }

    public function testParse()
    {
        file_put_contents($this->filename, base64_decode(self::IMAGE));

        $data = $this->parser->getMeta($this->filename);

        $this->assertInstanceOf(DataMeta::class, $data);
        $this->assertEquals(1, $data->getWidth());
        $this->assertEquals(5, $data->getHeight());
        $this->assertEquals('image/gif', $data->getMime());
    }
}