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

    public function displaySettingsPage()
    {
        include ADPC_PLUGIN_DIR . '/template/settings.phtml';
    }

    private function processForm($zip, $numberOfUnits, $averageRent, $expenseRatio, $age)
    {
        if ($numberOfUnits < 1) {
            return new WP_Error('invalid-number-of-units', 'Number of units is invalid');
        }

        return $this->calculator->calculateValue($zip, $numberOfUnits, $averageRent, $expenseRatio, $age);
    }

    public function optionClassAmin()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_A_MIN . '" id="' . Adpc::OPTION_CLASS_A_MIN . '" value="' . get_option(Adpc::OPTION_CLASS_A_MIN, Adpc::OPTION_DEFAULT_CLASS_A_MIN) . '">';
    }

    public function optionClassBmin()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_B_MIN . '" id="' . Adpc::OPTION_CLASS_B_MIN . '" value="' . get_option(Adpc::OPTION_CLASS_B_MIN, Adpc::OPTION_DEFAULT_CLASS_B_MIN) . '">';
    }

    public function optionClassCmin()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_C_MIN . '" id="' . Adpc::OPTION_CLASS_C_MIN . '" value="' . get_option(Adpc::OPTION_CLASS_C_MIN, Adpc::OPTION_DEFAULT_CLASS_C_MIN) . '">';
    }

    public function optionClassAcapRate()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_A_CAP_RATE . '" id="' . Adpc::OPTION_CLASS_A_CAP_RATE . '" value="' . get_option(Adpc::OPTION_CLASS_A_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_A_CAP_RATE) . '">';
    }

    public function optionClassBcapRate()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_B_CAP_RATE . '" id="' . Adpc::OPTION_CLASS_B_CAP_RATE . '" value="' . get_option(Adpc::OPTION_CLASS_B_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_B_CAP_RATE) . '">';
    }

    public function optionClassCcapRate()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_C_CAP_RATE . '" id="' . Adpc::OPTION_CLASS_C_CAP_RATE . '" value="' . get_option(Adpc::OPTION_CLASS_C_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_C_CAP_RATE) . '">';
    }

    public function optionClassDcapRate()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_D_CAP_RATE . '" id="' . Adpc::OPTION_CLASS_D_CAP_RATE . '" value="' . get_option(Adpc::OPTION_CLASS_D_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_D_CAP_RATE) . '">';
    }

    public function optionClassAmaxAge()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_A_MAX_AGE . '" id="' . Adpc::OPTION_CLASS_A_MAX_AGE . '" value="' . get_option(Adpc::OPTION_CLASS_A_MAX_AGE, Adpc::OPTION_DEFAULT_CLASS_A_MAX_AGE) . '">';
    }

    public function optionClassBmaxAge()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_B_MAX_AGE . '" id="' . Adpc::OPTION_CLASS_B_MAX_AGE . '" value="' . get_option(Adpc::OPTION_CLASS_B_MAX_AGE, Adpc::OPTION_DEFAULT_CLASS_B_MAX_AGE) . '">';
    }

    public function optionClassBminAge()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_B_MIN_AGE . '" id="' . Adpc::OPTION_CLASS_B_MIN_AGE . '" value="' . get_option(Adpc::OPTION_CLASS_B_MIN_AGE, Adpc::OPTION_DEFAULT_CLASS_B_MIN_AGE) . '">';
    }

    public function optionClassCmaxAge()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_C_MAX_AGE . '" id="' . Adpc::OPTION_CLASS_C_MAX_AGE . '" value="' . get_option(Adpc::OPTION_CLASS_C_MAX_AGE, Adpc::OPTION_DEFAULT_CLASS_C_MAX_AGE) . '">';
    }

    public function optionClassCminAge()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_C_MIN_AGE . '" id="' . Adpc::OPTION_CLASS_C_MIN_AGE . '" value="' . get_option(Adpc::OPTION_CLASS_C_MIN_AGE, Adpc::OPTION_DEFAULT_CLASS_C_MIN_AGE) . '">';
    }

    public function optionClassDminAge()
    {
        echo '<input type="number" name="' . Adpc::OPTION_CLASS_D_MIN_AGE . '" id="' . Adpc::OPTION_CLASS_D_MIN_AGE . '" value="' . get_option(Adpc::OPTION_CLASS_D_MIN_AGE, Adpc::OPTION_DEFAULT_CLASS_D_MIN_AGE) . '">';
    }
}