<?php


class AdpcCalculator
{
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

    private function getElementsByClass(&$parentNode, $tagName, $className) {
        $nodes=array();

        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $nodes[]=$temp;
            }
        }

        return $nodes;
    }
}