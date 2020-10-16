<?php

require_once 'AdpcCalculator.php';

class AdpcRenderer
{
    const AD_CALC_FORM_ID = '_adpc_value_form';

    /** @var AdpcCalculator */
    private $calculator;

    public function __construct()
    {
        $this->calculator = new AdpcCalculator();
    }

    public function displayForm()
    {
        $errorText = '';
        if (isset($_POST[self::AD_CALC_FORM_ID])) {
            $zip = sanitize_text_field($_POST['zip']);
            $numberOfUnits = sanitize_text_field($_POST['number-of-units']);
            $averageRent = sanitize_text_field($_POST['average-rent']);
            $expenseRatio = sanitize_text_field($_POST['expense-ratio']);
            $age = sanitize_text_field($_POST['age-of-property']);
            $response = $this->processForm($zip, $numberOfUnits, $averageRent, $expenseRatio, $age);
            if ($response instanceof WP_Error) {
                $errorText = $response->get_error_message();
            } else {
                return '<h5 style="text-align: center">Estimated Property Value</h5> <h3 style="text-align: center">$' . $response . '</h3>';
            }
        }
        return include (ADPC_PLUGIN_DIR . '/template/simple-form.phtml');
    }

    private function processForm($zip, $numberOfUnits, $averageRent, $expenseRatio, $age)
    {
        if ($numberOfUnits < 1) {
            return new WP_Error('invalid-number-of-units', 'Number of units is invalid');
        }

        return $this->calculator->calculateValue($zip, $numberOfUnits, $averageRent, $expenseRatio, $age);
    }
}