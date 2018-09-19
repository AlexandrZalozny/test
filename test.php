<?php

$a = [1, 3, 2, 1, 2, 1, 5, 3, 3, 4, 2];
test($a, 2);
$a = [5, 8];
test($a, 0);
$a = [100, 1, 500];
test($a, 100-1);
$a = [100, 1, 500, 1, 2000];
test($a, 500-1);

$a = [100, 1, 2500, 1, 2000];
test($a, 2000-1);
$a = [100, 1, 2500, 300, 2000, 5000];
test($a, 2500 - 300);
$a = [1000, 1, 2500, 300, 2000, 5000];
test($a, 2500 - 300);
$a = [100000000, 1, 2500, 300, 2000, 5000];
test($a, 5000-1);
$a = [1, 100000000, 1, 1, 1, 1, 1];
test($a, 0);
$a = [1, 100000000, 1, 2, 1, 1, 1];
test($a, 1);

var_dump(round(memory_get_peak_usage()/1024/1024, 2));

/**
 * @param array $A
 *
 * @return int
 */
function solution($A)
{
    $maxLevel = 0;
    $count = count($A);
    $keys = array_keys($A, max($A));
    $B = array_splice($A, $keys[0] - $count);

    $maxLevel = left($A, $maxLevel);
    $maxLevel = right($B, $maxLevel);

    return $maxLevel;
}

/**
 * @param array $A
 * @param int   $maxLevel
 *
 * @return int
 */
function left($A, $maxLevel)
{
    $count = count($A);
    if ($count) {
        $keys = array_keys($A, max($A));
        $B = array_splice($A, $keys[0] - $count);
        $diff = findMaxLevelLeft($B);
        if ($diff > $maxLevel) {
            $maxLevel = $diff;
        }

        $maxLevel = left($A, $maxLevel);
    }

    return $maxLevel;
}

/**
 * @param array $A
 * @param int   $maxLevel
 *
 * @return int
 */
function right($A, $maxLevel)
{
    array_shift($A);
    $count = count($A);

    if ($count) {
        $keys = array_keys($A, max($A));
        $B = array_splice($A, $keys[count($keys) - 1] - $count);
        $diff = findMaxLevelRight($A, $B[0]);
        if ($diff > $maxLevel) {
            $maxLevel = $diff;
        }

        $maxLevel = left($A, $maxLevel);
    }

    return $maxLevel;
}

/**
 * @param array $left
 *
 * @return int
 */
function findMaxLevelLeft($left)
{
    $level = $left[0];
    $maxLevel = 0;
    foreach ($left as $item) {
        $diff = $level - $item;
        if ($diff > $maxLevel) {
            $maxLevel = $diff;
        }
    }

    return $maxLevel;
}

/**
 * @param array $left
 *
 * @return int
 */
function findMaxLevelRight($left, $level)
{
    $maxLevel = 0;
    foreach ($left as $item) {
        $diff = $level - $item;
        if ($diff > $maxLevel) {
            $maxLevel = $diff;
        }
    }

    return $maxLevel;
}

/**
 * @param array $a
 * @param int   $value
 */
function test($a, $value)
{
    $result = solution($a);
    if ($result === $value) {
        echo "OK <br>";
    } else {
        var_dump($a, $value, $result);
    };
}
