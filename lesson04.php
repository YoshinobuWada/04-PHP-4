<?php
// 以下配列の中身をfor文を使用して表示してください。
// 表示はHTMLの<table>タグを使用すること

/**
 * 表示イメージ
 *  _________________________
 *  |_____|_c1|_c2|_c3|横合計|
 *  |___r1|_10|__5|_20|___35|
 *  |___r2|__7|__8|_12|___27|
 *  |___r3|_25|__9|130|__164|
 *  |縦合計|_42|_22|162|__226|
 *  ‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾‾
 */

// $arr = [
//     'r1' => ['c1' => 10, 'c2' => 5, 'c3' => 20],
//     'r2' => ['c1' => 7, 'c2' => 8, 'c3' => 12],
//     'r3' => ['c1' => 25, 'c2' => 9, 'c3' => 130]
// ];
function yokotable($set, $a)
{
    $text = ['<td>'];
    $text1 = null;
    $Wsum = 0;
    $Hsum = 0;
    $arr = [
        'r1' => ['c1' => 10, 'c2' => 5, 'c3' => 20],
        'r2' => ['c1' => 7, 'c2' => 8, 'c3' => 12],
        'r3' => ['c1' => 25, 'c2' => 9, 'c3' => 130]
    ];
    if ($set <= 3 && $set >= 1) {
        $ra = 'r' . $set;
        if ($a <= 3 && $a >= 1) {
            $ca = 'c' . $a;
            for ($i = $arr[$ra][$ca]; $i <= 99; $i = $i * 10) {
                array_push($text, "_");
            }
            array_push($text, $arr[$ra][$ca] . '</td>');
            $text1 = implode("", $text);
        } else if ($a == 4) {
            array_push($text, "__");
            $Wsum = $arr[$ra]['c1'] + $arr[$ra]['c2'] + $arr[$ra]['c3'];
            for ($i = $Wsum; $i <= 99; $i = $i * 10) {
                array_push($text, "_");
            }
            array_push($text, $Wsum . '</td>');
            $text1 = implode("", $text);
        }
    } else if ($set == 4) {
        if ($a <= 3 && $a >= 1) {
            for ($i = 1; $i <= 3; $i++) {
                $y = 'r' . $i;
                $z = 'c' . $a;
                $Hsum = $Hsum + $arr[$y][$z];
            }
            for ($x = $Hsum; $x <= 99; $x = $x * 10) {
                array_push($text, "_");
            }
            array_push($text, $Hsum . '</td>');
            $text1 = implode("", $text);
        } else if ($a == 4) {
            foreach ($arr as $value) {
                foreach ($value as $value1) {
                    $Hsum = $Hsum + $value1;
                }
            }
            array_push($text, '__' . $Hsum . '</td>');
            $text1 = implode("", $text);
        }
    }
    return $text1;
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>テーブル表示</title>
    <style>
        table {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <!-- ここにテーブル表示 -->
    <table>
        <tr>
            <th>_____</th>
            <td>_c1</td>
            <td>_c2</td>
            <td>_c3</td>
            <td>横合計</td>
        </tr>
        <tr>
            <th>___r1</th>
            <?php for ($i = 1; $i <= 4; $i++) {
                echo yokotable(1, $i);
            } ?>
        </tr>
        <tr>
            <th>___r2</th>
            <?php for ($i = 1; $i <= 4; $i++) {
                echo yokotable(2, $i);
            } ?>
        </tr>
        <tr>
            <th>___r3</th>
            <?php for ($i = 1; $i <= 4; $i++) {
                echo yokotable(3, $i);
            } ?>
        </tr>
        <tr>
            <th>総合計</th>
            <?php for ($i = 1; $i <= 4; $i++) {
                echo yokotable(4, $i);
            }
            ?>
        </tr>
    </table>
</body>

</html>