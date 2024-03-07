<?php

namespace Cf7CboxAlt;

/**
 * Class CheckboxSVG
 *
 * Contains methods for creating SVG elements for checkboxes.
 */
class CheckboxSVG {
  
    /**
     * Create a path element for a checkbox SVG.
     *
     * @param \DOMDocument $svgDocument The SVG document to which the path element will be added.
     * @param string $classAttribute The value for the 'class' attribute of the path element.
     * @param string $dAttributeValue The value for the 'd' attribute of the path element.
     * @return \DOMElement The created path element.
     */
    public static function createCheckboxPathElement(&$svgDocument, $classAttribute, $dAttributeValue) {
        $path = $svgDocument->createElement('path', "");
        
        $classAttr = $svgDocument->createAttribute('class');
        $classAttr->value = $classAttribute;
        
        $path->appendChild($classAttr);
        
        $dAttr = $svgDocument->createAttribute('d');
        $dAttr->value = $dAttributeValue;
        
        $path->appendChild($dAttr);
        
        return $path;
    }
}