<?php

namespace Cf7CboxAlt;

use \DOMDocument;
use Cf7CboxAlt\Constants;
use Cf7CboxAlt\CheckboxSVG;

/**
 * Class MC4WPHandler
 *
 * This class extends the Mailchimp for WordPress (MC4WP) functionality by providing custom content and SVG icons for checkboxes and radio buttons.
 */
class MC4WPHandler {

    /**
     * Define filters for the MC4WP integration.
     */
    public function filters() {
        add_filter( 'mc4wp_form_content',  array( $this,'filter_mc4wp_form_content' ), 10, 3 ); 
    }
    
    /**
     * Define actions for the MC4WP integration.
     */
    public function actions() {
        add_action( 'mc4wp_integration_before_checkbox_wrapper', array( $this, 'add_custom_content_before_checkbox_wrapper' ), 10, 1 );
    }

    /**
     * Custom filter for modifying the MC4WP form content.
     *
     * @param string $content The original form content.
     * @param object $form The form object.
     * @param object $element The form element object.
     * @return string The modified form content.
     */
    public function filter_mc4wp_form_content( $content, $form, $element ) { 
        try {
            $domContent = new DOMDocument();
            $domContent->loadHTML($content);
            $inputs = $domContent->getElementsByTagName('input');

            foreach ($inputs as $input) {
                if ($input->getAttribute('value') == 'subscribe' || $input->getAttribute('value') == 'unsubscribe') {
                    $this->processInput($input, $domContent);
                }
            }

            return $domContent->saveHTML();
        } catch (Exception $e) {
            return $content;
        }
    }

    /**
     * Process a single input element.
     *
     * @param DOMElement $input The input element to process.
     * @param DOMDocument $domContent The DOMDocument object.
     */
    private function processInput($input, $domContent) {
        $doHide = '';
        $attr_class_sel = 'rb-box';
        $attr_class_unsel = 'rb-check';
        
        $isSubscribe = $input->getAttribute('value') == 'subscribe';
        $svgAttrsArray = $isSubscribe ? array_merge(Constants::SVG_CLASS_RB_SELECTED, Constants::SVG_ATTRS) : array_merge(Constants::SVG_CLASS_RB_UNSELECTED, Constants::SVG_ATTRS);
        $attrDVal = $isSubscribe ? Constants::CHECKBOX_BOX_D_VAL : Constants::CHECKBOX_CHECK_D_VAl;
        $doHide = $isSubscribe ? '' : ' hide-svg';

        $evg_e = $domContent->createElement('svg');
        $evg_e = $this->addAttrsToElement($svgAttrsArray, $evg_e, $domContent);

        $path = CheckboxSVG::createCheckboxPathElement($domContent, $attr_class_sel, Constants::CHECKBOX_BOX_D_VAL);
        $evg_e->appendChild($path);

        $path = CheckboxSVG::createCheckboxPathElement($domContent, $attr_class_unsel . $doHide, Constants::CHECKBOX_CHECK_D_VAl);
        $evg_e->appendChild($path);

        $firstSibling = $input->parentNode->firstChild;
        $input->parentNode->insertBefore($evg_e, $firstSibling);

        $attribute = $domContent->createAttribute('class');
        $attribute->value = 'cf7-cbrb-alt';
        $input->appendChild($attribute);
    }

    /**
     * Add attributes to an element.
     *
     * @param array $attrs_array The array of attributes to add.
     * @param DOMElement $element The element to add attributes to.
     * @param DOMDocument $domContent The DOMDocument object.
     * @return DOMElement The modified element.
     */
    private function addAttrsToElement($attrs_array, $element, $domContent) {
        foreach ($attrs_array as $a) {
            $t_attr = $domContent->createAttribute($a['name']);
            $t_attr->value = $a['value'];
            $element->appendChild($t_attr);
        }
        return $element;
    }

    /**
     * Adds custom content before the checkbox wrapper in the MC4WP integration.
     *
     * @param string $integration The integration identifier.
     */
    public function add_custom_content_before_checkbox_wrapper( $integration ) {
        $checkbox_svg_string = Constants::CHECKBOX_ICO_CHECKED;
        echo $checkbox_svg_string;
    }
}