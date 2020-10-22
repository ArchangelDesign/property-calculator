<?php


class AdpcCalculator
{
    const CLASS_A = 'A';
    const CLASS_B = 'B';
    const CLASS_C = 'C';
    const CLASS_D = 'D';

    /** @var DOMDocument */
    private $document;

    private function get($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function getRents($zip, $city, $state, $beds, $baths)
    {
        $url = "https://www.apartments.com/apartments/{$city}-{$state}-{$zip}/{$beds}-bedrooms-{$baths}-bathrooms/";
        $this->document = new DOMDocument();
        $rawDoc = $this->get($url);
        @$this->document->loadHTML($rawDoc);
        $prices = $this->getElementsByClass($this->document, 'span', 'altRentDisplay');

        if (empty($prices)) {
            return [];
        }

        $result = [];
        foreach ($prices as $p) {
            $result[] = $p->nodeValue;
        }

        return $result;
    }

    public function getAverageRent($zip, $city, $state, $beds, $baths)
    {
        $city = trim($city);
        $city = str_replace('  ', ' ', $city);
        $city = str_replace(' ', '-', $city);
        $rents = $this->getRents($zip, strtolower($city), strtolower($state), $beds, $baths);
        $validRents = [];
        foreach ($rents as $r) {
            if (strpos($r, '-') !== false) {
                $validRents[] = $r;
            }
        }
        $rents = $validRents;
        $lowSum = 0;
        $highSum = 0;
        $count = count($rents);

        foreach ($rents as $rent) {
            list($low, $high) = explode('-', $rent);
            $low = (int)trim(str_replace(['$', ','], '', $low));
            $high = (int)trim(str_replace(['$', ','], '', $high));
            $lowSum += $low;
            $highSum += $high;
        }

        $averageLow = $lowSum / $count;
        $averageHigh = $highSum / $count;

        return number_format(($averageLow + $averageHigh) / 2, 0, '', '');
    }

    private function getElementsByClass(&$parentNode, $tagName, $className)
    {
        $nodes = array();

        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $nodes[] = $temp;
            }
        }

        return $nodes;
    }

    public function getMedianHouseholdIncome($zipCode)
    {
        $path = ADPC_PLUGIN_DIR . '/data/income-by-zip.csv';
        if (!file_exists($path)) {
            return new WP_Error('no-income-by-zip', 'Income by zip data cannot be loaded. File is missing.');
        }
        $f = fopen($path, 'r');
        $found = false;
        while (!$found) {
            $line = fgets($f);
            if ($line === false) {
                return new WP_Error('zip-not-found', 'Cannot locate zip code ' . $zipCode);
            }
            $columns = explode(';', $line);
            if ($zipCode == $columns[0]) {
                return (int)trim(str_replace(['$', ',', '"'], '', $columns[5]));
            }
        }

        return new WP_Error('panic', 'Unreachable code reached.');
    }

    private function getCapRateClass($zipCode)
    {
        $income = $this->getMedianHouseholdIncome($zipCode);
        if ($income instanceof WP_Error) {
            return $income;
        }
        if ($income >= get_option(Adpc::OPTION_CLASS_A_MIN, Adpc::OPTION_DEFAULT_CLASS_A_MIN)) {
            return self::CLASS_A;
        } elseif ($income >= get_option(Adpc::OPTION_CLASS_B_MIN, Adpc::OPTION_DEFAULT_CLASS_B_MIN)) {
            return self::CLASS_B;
        } elseif ($income >= get_option(Adpc::OPTION_CLASS_C_MIN, Adpc::OPTION_DEFAULT_CLASS_C_MIN)) {
            return self::CLASS_C;
        } else {
            return self::CLASS_D;
        }
    }

    private function adjustCapRate($class, $age)
    {
        $classBmaxAge = get_option(Adpc::OPTION_CLASS_B_MAX_AGE, Adpc::OPTION_DEFAULT_CLASS_B_MAX_AGE);
        $classBminAge = get_option(Adpc::OPTION_CLASS_B_MIN_AGE, Adpc::OPTION_DEFAULT_CLASS_B_MIN_AGE);
        $classCmaxAge = get_option(Adpc::OPTION_CLASS_C_MAX_AGE, Adpc::OPTION_DEFAULT_CLASS_C_MAX_AGE);
        $classCminAge = get_option(Adpc::OPTION_CLASS_C_MIN_AGE, Adpc::OPTION_DEFAULT_CLASS_C_MIN_AGE);
        $classDminAge = get_option(Adpc::OPTION_CLASS_D_MIN_AGE, Adpc::OPTION_DEFAULT_CLASS_D_MIN_AGE);

        switch ($class) {
            case self::CLASS_A:
                return get_option(Adpc::OPTION_CLASS_A_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_A_CAP_RATE);
                if ($age <= get_option(Adpc::OPTION_CLASS_A_MAX_AGE, Adpc::OPTION_DEFAULT_CLASS_A_MAX_AGE)) {
                    return get_option(Adpc::OPTION_CLASS_A_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_A_CAP_RATE);
                } else {
                    return 0.045;
                }
            case self::CLASS_B:
                return get_option(Adpc::OPTION_CLASS_B_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_B_CAP_RATE);
                if ($age >= $classBminAge && $age <= $classBmaxAge) {
                    return get_option(Adpc::OPTION_CLASS_B_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_B_CAP_RATE);
                } else {
                    return 0.05;
                }
            case self::CLASS_C:
                return get_option(Adpc::OPTION_CLASS_C_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_C_CAP_RATE);
                if ($age >= $classCminAge && $age <= $classCmaxAge) {
                    return get_option(Adpc::OPTION_CLASS_C_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_C_CAP_RATE);
                } else {
                    return 0.08;
                }
            case self::CLASS_D:
                return get_option(Adpc::OPTION_CLASS_D_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_D_CAP_RATE);
                if ($age >= $classDminAge) {
                    return get_option(Adpc::OPTION_CLASS_D_CAP_RATE, Adpc::OPTION_DEFAULT_CLASS_D_CAP_RATE);
                } else {
                    return 0.10;
                }
        }
    }

    private function getCapRate($zipCode, $age)
    {
        $class = $this->getCapRateClass($zipCode);
        if ($class instanceof WP_Error) {
            return $class;
        }
        return $this->adjustCapRate($class, $age);
    }

    private function getPercentage($value, $percentage)
    {
        return ($value * $percentage) / 100;
    }

    public function calculateValue($zipCode, $numberOfUnits, $averageRent, $ageOfProperty)
    {
        // 100k => A Class 4%  MAX 20 years
        // 60 - 99k => B Class 4.75%  MAX 45 years  MIN 15 years
        // 40 - 60k => C class 7%  MAX 60 year MIN 43 years
        // < 40k => D class 9.5%   MIN 60 years

        $class = $this->getCapRateClass($zipCode);
        $expenseRatio = $this->getExpenseRatio($class);
        $capRate = $this->getCapRate($zipCode, $ageOfProperty);
        if ($capRate instanceof WP_Error) {
            return $capRate;
        }
        $grossIncome = $numberOfUnits * $averageRent;
        $noi = $grossIncome - $this->getPercentage($grossIncome, $expenseRatio);
        $valueOfProperty = $noi / $capRate;

        return $valueOfProperty . ' (' . $capRate . ')';
    }

    private function getExpenseRatio($class)
    {
        switch ($class) {
            case self::CLASS_A:
                return 45;
            case self::CLASS_B:
                return 50;
            case self::CLASS_C:
                return 55;
            case self::CLASS_D:
                return 60;
        }
        throw new InvalidArgumentException('invalid class provided ' . $class);
    }
}