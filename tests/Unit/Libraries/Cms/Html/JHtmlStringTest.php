<?php

/**
 * @package     Joomla.UnitTest
 * @subpackage  HTML
 *
 * @copyright   (C) 2019 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Tests\Unit\Libraries\Cms\Html;

use JHtmlString;
use Joomla\Tests\Unit\UnitTestCase;

/**
 * Tests for JHtmlString.
 *
 * @package     Joomla.UnitTest
 * @subpackage  HTML
 * @since       3.1
 */
class JHtmlStringTest extends UnitTestCase
{
    /**
     * Test cases for truncate.
     *
     * @return  array
     *
     * @since   3.1
     */
    public function getTestAbridgeData(): array
    {
        return [
            'No change case' => [
                'Plain text',
                50,
                30,
                'Plain text',
            ],
            'Normal case' => [
                'Abridges text strings over the specified character limit. The behavior will insert an ellipsis into the text.',
                50,
                30,
                'Abridges text strings over the...is into the text.',
            ],
        ];
    }

    /**
     * Test cases for truncate.
     *
     * @return  array
     *
     * @since   3.1
     */
    public function getTestTruncateData(): array
    {
        return [
            'No change case' => [
                'Plain text',
                0,
                true,
                true,
                'Plain text',
            ],
            'Plain text under the limit' => [
                'Plain text',
                100,
                true,
                true,
                'Plain text',
            ],
            'Plain text at the limit' => [
                'Plain text',
                10,
                true,
                true,
                'Plain text',
            ],
            'Plain text over the limit by two words' => [
                'Plain text test',
                7,
                true,
                true,
                'Plain...',
            ],
            'Plain text over the limit by one word' => [
                'Plain text test',
                14,
                true,
                true,
                'Plain text...',
            ],
            'Plain text over the limit with short trailing words' => [
                'Plain text a b c d',
                13,
                true,
                true,
                'Plain text...',
            ],
            'Plain text over the limit splitting first word' => [
                'Plain text',
                3,
                false,
                true,
                'Pla...',
            ],
            'Plain text with word split' => [
                'Plain split-less',
                7,
                false,
                false,
                'Plain s...',
            ],
            'Plain html under the limit' => [
                '<span>Plain text</span>',
                100,
                true,
                true,
                '<span>Plain text</span>',
            ],
            'Plain html at the limit' => [
                '<span>Plain text</span>',
                23,
                true,
                true,
                '<span>Plain text</span>',
            ],
            'Plain html over the limit' => [
                '<span>Plain text</span>',
                22,
                true,
                true,
                '<span>Plain</span>...',
            ],
            // The tags by themselves make the string too long.
            'Plain html over the limit by one word' => [
                '<span>Plain text</span>',
                12,
                true,
                true,
                '...',
            ],
            /*
             *  @todo: Check these tests: 'Plain html over the limit splitting first word'
                (duplicate keys, only the last of the duplicates gets executed) Don't return invalid HTML
             */
            'Plain html over the limit splitting first word' => [
                '<span>Plain text</span>',
                1,
                false,
                true,
                '...',
            ],
            /*
             *  @todo: Check these tests: 'Plain html over the limit splitting first word'
                (duplicate keys, only the last of the duplicates gets executed) Don't return invalid HTML
             */
            'Plain html over the limit splitting first word' => [
                '<span>Plain text</span>',
                4,
                false,
                true,
                '...',
            ],
            'Complex html over the limit' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                37,
                true,
                true,
                '<div><span><i>Plain</i> <b>text</b></span></div>...',
            ],
            'Complex html over the limit 2' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                38,
                true,
                true,
                '<div><span><i>Plain</i> <b>text</b></span></div>...',
            ],
            'HTML not allowed, split words' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                8,
                false,
                false,
                'Plain te...',
            ],
            // @todo: Check these tests: 'HTML not allowed, no split' (duplicate keys, only the last of the duplicates gets executed)
            'HTML not allowed, no split' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                4,
                true,
                false,
                '...',
            ],
            'First character is < with a maximum length of 1' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                1,
                true,
                false,
                '...',
            ],
            // @todo: Check these tests: 'HTML not allowed, no split' (duplicate keys, only the last of the duplicates gets executed)
            'HTML not allowed, no split' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                5,
                true,
                false,
                '...',
            ],
            'Text is the same as maxLength, no split, HTML allowed' => [
                '<div><span><i>Plain</i></span></div>',
                5,
                true,
                true,
                '...',
            ],
            // @todo: Check these tests: 'HTML not allowed, no split' (duplicate keys, only the last of the duplicates gets executed)
            'HTML not allowed, no split' => [
                '<div><span><i>Plain</i></span></div>',
                5,
                true,
                false,
                'Plain',
            ],
            'Do not split within a tag' => [
                'Some text is <div class="test"><span><i>Plain</i></span></div>',
                20,
                true,
                true,
                'Some text is...',
            ],

        ];
    }

    /**
     * Test cases for complex truncate.
     *
     * @return  array
     *
     * @since   3.1
     */
    public function getTestTruncateComplexData(): array
    {
        return [

            'No change case' => [
                'Plain text',
                10,
                true,
                'Plain text',
            ],
            'Plain text under the limit' => [
                'Plain text',
                100,
                true,
                'Plain text',
            ],
            'Plain text at the limit' => [
                'Plain text',
                10,
                true,
                'Plain text',
            ],
            'Plain text over the limit by two words' => [
                'Plain text test',
                6,
                true,
                '...',
            ],
            'Plain text over the limit by one word' => [
                'Plain text test',
                13,
                true,
                'Plain text...',
            ],
            'Plain text over the limit with short trailing words' => [
                'Plain text a b c d',
                13,
                true,
                'Plain text...',
            ],
            'Plain text over the limit splitting first word' => [
                'Plain text',
                3,
                false,
                '...',
            ],
            'Plain text with word split' => [
                'Plain split-less',
                7,
                true,
                'Plain...',
            ],
            'Plain text under a short limit' => [
                'Hi',
                3,
                true,
                'Hi',
            ],
            'Plain text with length 1 and a limit of 1' => [
                'H',
                1,
                true,
                'H',
            ],
            'Plain html under the limit' => [
                '<span>Plain text</span>',
                100,
                true,
                '<span>Plain text</span>',
            ],
            'Plain html at the limit' => [
                '<span>Plain text</span>',
                23,
                true,
                '<span>Plain text</span>',
            ],
            'Plain html over the limit but under the text limit' => [
                '<span>Plain text</span>',
                22,
                true,
                '<span>Plain text</span>',
            ],

            'Plain html over the limit by one word' => [
                '<span>Plain text</span>',
                8,
                true,
                '<span>Plain</span>...',
            ],
            /*
             *  @todo: Check these tests: 'Plain html over the limit splitting first word'
                (duplicate keys, only the last of the duplicates gets executed) Don't return invalid HTML
             */
            'Plain html over the limit splitting first word' => [
                '<span>Plain text</span>',
                4,
                false,
                '<span>P</span>...',
            ],
            /*
             *  @todo: Check these tests: 'Plain html over the limit splitting first word'
                (duplicate keys, only the last of the duplicates gets executed) Don't return invalid HTML
             */
            'Plain html over the limit splitting first word' => [
                '<span>Plain text</span>',
                1,
                false,
                '<span></span>...',
            ],
            'Complex html over the limit but under the text limit' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                37,
                true,
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
            ],
            'Complex html over the limit 2' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                38,
                true,
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
            ],
            'Split words' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                8,
                false,
                '<div><span><i>Plain</i> <b>te</b></span></div>...',
            ],
            'No split' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                8,
                true,
                '<div><span><i>Plain</i></span></div>...',
            ],
            'First character is < with a maximum length of 1, no split' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                1,
                true,
                '<div></div>...',
            ],
            'First character is < with a maximum length of 1, split' => [
                '<div><span><i>Plain</i> <b>text</b> foo</span></div>',
                1,
                false,
                '<div></div>...',
            ],
            'Text is the same as maxLength, Complex HTML, no split' => [
                '<div><span><i>Plain</i></span></div>',
                5,
                true,
                '<div><span><i>Plain</i></span></div>',
            ],
            'Text is all HTML' => [
                '<img src="myimage.jpg" />',
                5,
                true,
                '<img src="myimage.jpg" />',
            ],
            'Text with no spaces, split, maxlength 3' => [
                'thisistextwithnospace',
                3,
                false,
                '...',
            ],
            // From issue tracker, was creating infinite loop
            'Complex test from issue tracker' => [
                '<p class="mod-articles-category-introtext"><em>Bestas Review Magazine</em>' .
                ' featured <a href="http://viewer.zmags.com/publication/a1b0fbb9#/a1b0fbb9/28">something</a> else</p>',
                60,
                false,
                '<p class="mod-articles-category-introtext"><em>Bestas Review Magazine</em> ' .
                'featured <a href="http://viewer.zmags.com/publication/a1b0fbb9#/a1b0fbb9/28">something</a> else</p>',
            ],
        ];
    }

    /**
     * Tests the JHtmlString::abridge method.
     *
     * @param   string   $text      The text to truncate.
     * @param   integer  $length    The maximum length of the text.
     * @param   integer  $intro     The maximum length of the intro text.
     * @param   string   $expected  The expected result.
     *
     * @return  void
     *
     * @since         3.1
     * @dataProvider  getTestAbridgeData
     */
    public function testAbridge($text, $length, $intro, $expected)
    {
        $this->assertEquals($expected, \JHtmlString::abridge($text, $length, $intro));
    }

    /**
     * Tests the JHtmlString::truncate method.
     *
     * @param   string   $text         The text to truncate.
     * @param   integer  $length       The maximum length of the text.
     * @param   boolean  $noSplit      Don't split a word if that is where the cutoff occurs (default: true).
     * @param   boolean  $allowedHtml  Allow HTML tags in the output, and close any open tags (default: true).
     * @param   string   $expected     The expected result.
     *
     * @return  void
     *
     * @since         3.1
     * @dataProvider  getTestTruncateData
     */
    public function testTruncate($text, $length, $noSplit, $allowedHtml, $expected)
    {
        $this->assertEquals($expected, \JHtmlString::truncate($text, $length, $noSplit, $allowedHtml));
    }

    /**
     * Tests the JHtmlString::truncateComplex method.
     *
     * @param   string   $html       The text to truncate.
     * @param   integer  $maxLength  The maximum length of the text.
     * @param   boolean  $noSplit    Don't split a word if that is where the cutoff occurs (default: true)
     * @param   string   $expected   The expected result.
     *
     * @return  void
     *
     * @since         3.1
     * @dataProvider  getTestTruncateComplexData
     */
    public function testTruncateComplex($html, $maxLength, $noSplit, $expected)
    {
        $this->assertEquals($expected, \JHtmlString::truncateComplex($html, $maxLength, $noSplit));
    }
}
