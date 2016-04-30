<?php
namespace phpzeiro;

class Calculator
{
    private function get_delimiter($str)
    {
        if(preg_match('/^\/\/(.)/', $str, $matches) === 1)
        {
            return $matches[1];
        }

        return ',';
    }

    private function has_negativeNumber($numbers)
    {
        $negatives = [];

        foreach ($numbers as $number) {
            if($number < 0)
            {
                $negatives[] = $number;
            }
        }

        if(count($negatives) > 0)
        {
            throw new \Exception('negative not allowed ' . implode(',',$negatives));
        }

        return;
    }


    public function sum_str($str) {
        if($str === '')
        {
            return 0;
        }

        $delimiter = $this->get_delimiter($str);

        $str = str_replace("\n",$delimiter,$str);
        $values = explode($delimiter,$str);
        $this->has_negativeNumber($values);

        $sum = 0;
        foreach ($values as $number)
        {
            $sum += intval($number);
        }

        return $sum;
    }
}
