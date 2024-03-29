<?php

namespace Cf7CboxAlt;

class Constants {

    const SVG_ATTRS = array( 
        array("name"=>"version", "value"=>"1.1"), 
        array("name"=>"xmlns", "value"=>"http://www.w3.org/2000/svg"), 
        array("name"=>"xmlns:xlink", "value"=>"http://www.w3.org/1999/xlink"),
        array("name"=>"x", "value"=>"0px"),
        array("name"=>"y", "value"=>"0px"),
        array("name"=>"viewBox", "value"=>"0 0 360 360"), 
        array("name"=>"style", "value"=>"enable-background:new 0 0 360 360;"),
        array("name"=>"xml:space", "value"=>"preserve") 
    );

    const SVG_CLASS_RB_SELECTED = array(
        array("name"=>"class", "value"=>"rb-selected"),
        array("name"=>"selected", "value"=>"true") 
    );
    
    const SVG_CLASS_RB_UNSELECTED = array(array("name"=>"class", "value"=>"rb-unselected"));	

    const CHECKBOX_BOX_D_VAL = 'M303.118,0H56.882C25.516,0,0,25.516,0,56.882v246.236C0,334.484,25.516,360,56.882,360h246.236
    C334.484,360,360,334.484,360,303.118V56.882C360,25.516,334.484,0,303.118,0z M322.078,303.118c0,10.454-8.506,18.96-18.959,18.96
    H56.882c-10.454,0-18.959-8.506-18.959-18.96V56.882c0-10.454,8.506-18.959,18.959-18.959h246.236
    c10.454,0,18.959,8.506,18.959,18.959V303.118z';
    
    const CHECKBOX_CHECK_D_VAl = 'M249.844,106.585c-6.116,0-11.864,2.383-16.19,6.71l-84.719,84.857l-22.58-22.578c-4.323-4.324-10.071-6.706-16.185-6.706
    c-6.115,0-11.863,2.382-16.187,6.705c-4.323,4.323-6.703,10.071-6.703,16.185c0,6.114,2.38,11.862,6.703,16.184l38.77,38.77
    c4.323,4.324,10.071,6.706,16.186,6.706c6.112,0,11.862-2.383,16.19-6.71L266.03,145.662c8.923-8.926,8.922-23.448,0-32.374
    C261.707,108.966,255.958,106.585,249.844,106.585z';

    const CHECKBOX_BOX = '<path class="cb-box" d="'.self::CHECKBOX_BOX_D_VAL.'"/>';
    
    /* class "hide-svg" to hide it by default */
    const CHECKBOX_CHECK = ' <path class="cb-check hide-svg" d="'.self::CHECKBOX_CHECK_D_VAl.'"/>';
    
    const CHECKBOX_ICO_CHECKED = '<svg class="svg-cb cb-check" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 360 360" style="enable-background:new 0 0 360 360;" xml:space="preserve"><g>'.self::CHECKBOX_BOX . self::CHECKBOX_CHECK.'</g></svg>';

    const CHECKBOX_ICO_UNCHECKED = '<svg class="svg-cb cb-box" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"  y="0px" viewBox="0 0 360 360" style="enable-background:new 0 0 360 360;" xml:space="preserve"><g>'.self::CHECKBOX_BOX .'</g></svg>';


}