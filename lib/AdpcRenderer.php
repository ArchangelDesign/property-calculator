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
        if (isset($_POST[self::AD_CALC_FORM_ID])) {
            $html = '<ul>';
            $sums = $this->processForm();
            foreach ($sums as $s) {
                $html .= '<li>' . $s['type'] . ': average rent = <b>$' . $s['average'] . '</b> total value = <b>$' . $s['total'] . '</b></li>';
            }
            $html .= '</ul>';
            return $html;
        }
        return file_get_contents(ADPC_PLUGIN_DIR . '/template/value-form.phtml');
    }

    private function processForm()
    {
        $city = sanitize_text_field($_POST['city']);
        $zip = sanitize_text_field($_POST['zip']);
        $state = sanitize_text_field($_POST['state']);

        $bedsArray = $_POST['beds'];
        $bathsArray = $_POST['baths'];
        $unitsArray = $_POST['units'];

        $result = [];

        foreach ($bedsArray as $key => $bed) {
            $average = $this->calculator->getAverageRent($zip, $city, $state, $bedsArray[$key], $bathsArray[$key]);
            $totalValue = $average * $unitsArray[$key];
            $result[] = [
                'type' => $bedsArray[$key] . ' beds, ' . $bathsArray[$key] . ' baths',
                'average' => $average,
                'total' => $totalValue,
            ];
        }

        return $result;
    }
}