<?php
/**
 * PHPWord
 *
 * Copyright (c) 2014 PHPWord
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @copyright  Copyright (c) 2014 PHPWord
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    0.9.0
 */

namespace PhpOffice\PhpWord\Style;

use PhpOffice\PhpWord\Shared\XMLWriter;

/**
 * Tab style
 */
class Tab
{
    /**
     * Tab Stop Type
     *
     * @var string
     */
    private $_val;

    /**
     * Tab Leader Character
     *
     * @var string
     */
    private $_leader;

    /**
     * Tab Stop Position
     *
     * @var int
     */
    private $_position;

    /**
     * Tab Stop Type
     *
     * @var array
     * @link http://www.schemacentral.com/sc/ooxml/a-w_val-26.html Tab Stop Type
     */
    private static $_possibleStopTypes = array(
        'clear', // No Tab Stop
        'left', // Left Tab Stop
        'center', // Center Tab Stop
        'right', // Right Tab Stop
        'decimal', // Decimal Tab
        'bar', // Bar Tab
        'num' // List tab
    );

    /**
     * Tab Leader Character
     *
     * @var array
     * @link http://www.schemacentral.com/sc/ooxml/a-w_leader-1.html Tab Leader Character
     */
    private static $_possibleLeaders = array(
        'none', // No tab stop leader
        'dot', // Dotted leader line
        'hyphen', // Dashed tab stop leader line
        'underscore', // Solid leader line
        'heavy', // Heavy solid leader line
        'middleDot' // Middle dot leader line
    );

    /**
     * Create a new instance of Tab. Both $val and $leader
     * must conform to the values put forth in the schema. If they do not
     * they will be changed to default values.
     *
     * @param string $val Defaults to 'clear' if value is not possible.
     * @param int $position Must be an integer; otherwise defaults to 0.
     * @param string $leader Defaults to NULL if value is not possible.
     */
    public function __construct($val = null, $position = 0, $leader = null)
    {
        // Default to clear if the stop type is not matched
        $this->_val = (self::isStopType($val)) ? $val : 'clear';

        // Default to 0 if the position is non-numeric
        $this->_position = (is_numeric($position)) ? intval($position) : 0;

        // Default to NULL if no tab leader
        $this->_leader = (self::isLeaderType($leader)) ? $leader : null;
    }

    /**
     * Creates the XML DOM for the instance of Tab.
     *
     * @param \PhpOffice\PhpWord\Shared\XMLWriter &$xmlWriter
     */
    public function toXml(XMLWriter &$xmlWriter = null)
    {
        if (isset($xmlWriter)) {
            $xmlWriter->startElement("w:tab");
            $xmlWriter->writeAttribute("w:val", $this->_val);
            if (!is_null($this->_leader)) {
                $xmlWriter->writeAttribute("w:leader", $this->_leader);
            }
            $xmlWriter->writeAttribute("w:pos", $this->_position);
            $xmlWriter->endElement();
        }
    }

    /**
     * Test if attribute is a valid stop type.
     *
     * @param string $attribute
     * @return bool True if it is; false otherwise.
     */
    private static function isStopType($attribute)
    {
        return in_array($attribute, self::$_possibleStopTypes);
    }

    /**
     * Test if attribute is a valid leader type.
     *
     * @param string $attribute
     * @return bool True if it is; false otherwise.
     */
    private static function isLeaderType($attribute)
    {
        return in_array($attribute, self::$_possibleLeaders);
    }
}