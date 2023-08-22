<?php
error_reporting(0);
class Solution
{
    public $s;
    public $sum;
    public $candidates;
    public $ar, $arr;
    public function combinationSum(array $candidates, int $target)
    {
        $this->candidates = $candidates;
        if (in_array($target, $candidates)) {
            $this->arr[] = [$candidates[array_search($target, $candidates)]];
        }


        foreach ($candidates as $key => $value) {
            if ($value < $target) {

                $this->recursive($value, $target);
            }
        }


        return json_encode($this->arr);
    }

    public function recursive($value, $target)
    {

        foreach ($this->candidates as $k => $v) {

            if (($value + $v) <= $target) {
                $this->ar[$value + $v] = [$value, $v];

                if (($value + $v) == $target) {
                    $sum = 0;
                    $i = 0;
                    $array = array();
                    foreach ($this->ar as $key_0 => $value_0) {
                        if ($i == 0) {
                            $sum = $value_0[0] + $value_0[1];
                            $array[] = $value_0[0];
                            $array[] = $value_0[1];
                        } else {
                            $sum += $value_0[1];
                            $array[] = $value_0[1];
                        }


                        $i++;
                    }
                    if ($sum == $target) $this->arr[] = $array;
                    $this->ar = array();
                }

                if (($value + $v) < $target) $this->recursive($value + $v, $target);
            }
        }
    }
    public function calculate($param)
    {
        $this->s = $param;
        for ($i = 0; $i < 10; $i++) {
            $this->parenthesisCheck();
        }
        return $this->sum;
    }

    public function parenthesisCheck()
    {

        if (preg_match('/\([0-9\+\-\*\\/\.]*\)/', $this->s, $matches)) {
            $this->calc($matches[0]);
            $this->s = str_replace($matches[0], $this->sum, $this->s);
        } else {
            $this->calc($this->s);
        }
    }

    function calc($str)
    {
        $str = str_replace(["(", ")",], ["", ""], $str);
        $strToArray = preg_split('/(\+|\*|\-|\/)/', $str, -1, PREG_SPLIT_DELIM_CAPTURE);

        $arr = array();
        if (array_search("*", $strToArray) != "") $arr[] = array_search("*", $strToArray);
        if (array_search("/", $strToArray) != "") $arr[] = array_search("/", $strToArray);

        if (count($arr) > 0) {
            if ($key = array_search($strToArray[min($arr)], $strToArray)) {
                if ($strToArray[min($arr)] == "*") {
                    $strToArray[$key - 1] = $strToArray[$key - 1] * $strToArray[$key + 1];
                    array_splice($strToArray, $key, 2);
                }
                if ($strToArray[min($arr)] == "/") {
                    $strToArray[$key - 1] = $strToArray[$key - 1] / $strToArray[$key + 1];
                    array_splice($strToArray, $key, 2);
                }
                $this->sum = implode("", $strToArray);
            }
        }


        if (array_search("*", $strToArray) || array_search("/", $strToArray)) {

            $this->calc(implode("", $strToArray));
        } else {

            $sToArr = preg_split('/(\+|\-)/', implode("", $strToArray), -1, PREG_SPLIT_DELIM_CAPTURE);
            $i = 0;

            foreach ($sToArr as $value) {

                if ($i == 0) $sum = $value;
                if ($value == "+") $operator = "+";
                else if ($value == "-") $operator = "-";
                if ($value != "+" && $value != "-") {

                    if ($operator == "+") $sum += $value;
                    if ($operator == "-") $sum -= $value;
                }

                $i++;
            }
            $this->sum = $sum;
        }
    }
}

$s = new Solution();
echo "Test 1<br>";
echo $s->combinationSum([2, 3, 5], 8);
echo "<br><br><br>";
echo "Test 2<br>";
echo $s->calculate("(1+(4+5+2)*3)-(6+8)");
echo "<br>";
?>
