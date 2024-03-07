<?php

namespace Cf7CboxAlt;

/**
 * Class CF7Handler
 *
 * This class extends the Contact Form 7 functionality by providing custom form tag handling for checkboxes and radio buttons.
 * It includes methods to define actions for the Contact Form 7 plugin and add custom form tags for handling checkboxes and radio buttons.
 * The custom form tag handler is a modified version of a function from CF7, altered to include SVG code for the input checkbox element.
 */
class CF7Handler {

    /**
     * Define actions for the Contact Form 7 plugin.
     */
    public function actions() {
        remove_action('wpcf7_init', 'wpcf7_add_form_tag_checkbox', 10, 0);
        add_action('wpcf7_init', array($this, 'custom_add_form_tag_datalist'));
    }

    /**
     * Custom form tag handler for checkboxes and radio buttons.
     */
    public function custom_add_form_tag_datalist() {
        wpcf7_add_form_tag(array('checkbox', 'checkbox*', 'radio'),
            array($this, 'custom_datalist_form_tag_handler'),
            array(
                'name-attr' => true,
                'selectable-values' => true,
                'multiple-controls-container' => true,
            )
        );
    }


    
    /**
     * Custom form tag handler for checkboxes and radio buttons.
     * This method is a modified and broken down version of a function from CF7, altered to include SVG code for the input checkbox element.
     * It also includes a TODO comment to add click functionality on the label text.
     *
     * @param object $tag The tag object representing the form tag.
     * @return string The HTML markup for the form tag.
     */
    //TODO: Add click on lable text
    public function custom_datalist_form_tag_handler($tag) {
        // Check if the form tag name is empty.
        if (empty($tag->name)) {
            return '';
        }

        // Get the class for the form control.
        $class = $this->getFormControlsClass($tag);

        // Check for validation error.
        $validation_error = wpcf7_get_validation_error($tag->name);
        $class .= $validation_error ? ' wpcf7-not-valid' : '';

        // Get attributes for the form tag.
        $atts = $this->getFormTagAttributes($tag, $class);

        // Generate HTML for the form tag items.
        $html = $this->generateFormTagItems($tag, $atts);

        // Wrap the form tag items in a span with the form control wrap class.
        return $this->wrapFormTag($tag->name, $atts, $html, $validation_error);
    }

    /**
     * Get the class for the form control.
     *
     * @param object $tag The tag object representing the form tag.
     * @return string The class for the form control.
     */
    private function getFormControlsClass($tag) {
        $class = wpcf7_form_controls_class($tag->type);
        $exclusive = $tag->has_option('exclusive');
        if ($exclusive) {
            $class .= ' wpcf7-exclusive-checkbox';
        }
        return $class;
    }

    /**
     * Get attributes for the form tag.
     *
     * @param object $tag The tag object representing the form tag.
     * @param string $class The class for the form control.
     * @return string The formatted attributes for the form tag.
     */
    private function getFormTagAttributes($tag, $class) {
        $atts = array(
            'class' => $tag->get_class_option($class),
            'id' => $tag->get_id_option(),
        );
        return wpcf7_format_atts($atts);
    }

    /**
     * Generate HTML for the form tag items.
     *
     * @param object $tag The tag object representing the form tag.
     * @param string $atts The formatted attributes for the form tag.
     * @return string The HTML markup for the form tag items.
     */
    private function generateFormTagItems($tag, $atts) {
        $html = '';
        foreach ($tag->values as $key => $value) {
            $html .= $this->generateFormItem($tag, $value, $atts);
        }
        return $html;
    }

    /**
     * Generate HTML for a form tag item.
     *
     * @param object $tag The tag object representing the form tag.
     * @param string $value The value for the form tag item.
     * @param string $atts The formatted attributes for the form tag.
     * @return string The HTML markup for the form tag item.
     */
    private function generateFormItem($tag, $value, $atts) {
        $checked = $this->isChecked($tag, $value);
        $label = $this->getLabel($tag, $value);
        $item_atts = $this->getFormItemAttributes($tag, $value, $checked);
        return $this->formatFormItem($tag, $label, $item_atts);
    }

    /**
     * Check if a form tag item is checked.
     *
     * @param object $tag The tag object representing the form tag.
     * @param string $value The value for the form tag item.
     * @return bool True if the form tag item is checked, false otherwise.
     */
    private function isChecked($tag, $value) {
        $hangover = wpcf7_get_hangover($tag->name, $tag->basetype === 'checkbox' ? array() : '');
        $default_choice = $tag->get_default_option(null, array('multiple' => $tag->basetype === 'checkbox'));
        return $hangover ? in_array($value, (array)$hangover, true) : in_array($value, (array)$default_choice, true);
    }

    /**
     * Get the label for a form tag item.
     *
     * @param object $tag The tag object representing the form tag.
     * @param string $value The value for the form tag item.
     * @return string The label for the form tag item.
     */
    private function getLabel($tag, $value) {
        return isset($tag->labels[$value]) ? $tag->labels[$value] : $value;
    }

    /**
     * Get attributes for a form tag item.
     *
     * @param object $tag The tag object representing the form tag.
     * @param string $value The value for the form tag item.
     * @param bool $checked True if the form tag item is checked, false otherwise.
     * @return string The formatted attributes for the form tag item.
     */
    private function getFormItemAttributes($tag, $value, $checked) {
        $item_atts = array(
            'type' => $tag->basetype,
            'name' => $tag->name . ($tag->basetype === 'checkbox' ? '[]' : ''),
            'value' => $value,
            'checked' => $checked ? 'checked' : '',
            'tabindex' => $tag->get_option('tabindex', 'signed_int', true) ?: '',
        );
        return wpcf7_format_atts($item_atts);
    }

    /**
     * Format a form tag item.
     *
     * @param object $tag The tag object representing the form tag.
     * @param string $label The label for the form tag item.
     * @param string $item_atts The formatted attributes for the form tag item.
     * @return string The HTML markup for the form tag item.
     */
    private function formatFormItem($tag, $label, $item_atts) {
        $chechbox_svg_string = Constants::CHECKBOX_ICO_CHECKED;
        $item = $tag->has_option('label_first')
            ? sprintf('<span class="switched wpcf7-list-item-label">%1$s</span><input %2$s />', esc_html($label), $item_atts)
            : sprintf($chechbox_svg_string . '<input %2$s /><span class="wpcf7-list-item-label">%1$s</span>', esc_html($label), $item_atts);
        return $tag->has_option('use_label_element') ? '<label>' . $item . '</label>' : $item;
    }

    /**
     * Wrap the form tag items in a span with the form control wrap class.
     *
     * @param string $name The name of the form tag.
     * @param string $atts The formatted attributes for the form tag.
     * @param string $html The HTML markup for the form tag items.
     * @param string $validation_error The validation error message.
     * @return string The wrapped HTML markup for the form tag.
     */
    private function wrapFormTag($name, $atts, $html, $validation_error) {
        return sprintf(
            '<span class="wpcf7-form-control-wrap %1$s"><span %2$s>%3$s</span>%4$s</span>',
            sanitize_html_class($name), $atts, $html, $validation_error
        );
    }
}