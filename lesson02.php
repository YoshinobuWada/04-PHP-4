<?php
// 以下をfor文を使用して表示してください。
// 表示する際は関数からの戻り値の値を使う事。
// ヒント: if〜elseifを使用
// 2で割り切れる数字は「太字」で表示する事。

// ****1
// ***121
// **12321
// *1234321
// 123454321
// *1234321
// **12321
// ***121
// ****1

function numberLoop($i)
{
    // この関数に判定処理を記述
    $array = [];
    if ($i >= 1 && $i <= 5) {
        for ($a = 1; $a <= 5 - $i; $a++) {
            array_push($array, "*");
        }
        for ($b = 1; $b <= $i; $b++) {
            array_push($array, $b);
        }
        for ($c = $i - 1; $c >= 1; $c--) {
            array_push($array, $c);
        }
        return $array;

    } else if ($i >= 6 && $i <= 9) {
        for ($a = 1; $a <= $i - 5; $a++) {
            array_push($array, "*");
        }
        for ($b = 1; $b <= 10 - $i; $b++) {
            array_push($array, $b);
        }
        for ($c = 9 - $i; $c >= 1; $c--) {
            array_push($array, $c);
        }
        return $array;

    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>ループ表示</title>
</head>

<body>
    <!-- ここに表示例の通り表示 -->
    <?php
    for ($i = 1; $i <= 9; $i++) {

        $subject = numberLoop($i);
        $pattern = array('/2/', '/4/');
        $subject = preg_replace($pattern, '<b>$0</b>', $subject);
        $array = implode("", $subject);
        echo $array;
        echo "<br/>";
    }

    ?>
</body>

</html>