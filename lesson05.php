<?php
// ＜アルゴリズムの注意点＞
// アルゴリズムではこれまでのように調べる力ではなく物事を論理的に考える力が必要です。
// 検索して答えを探して解いても考える力には繋がりません。
// まずは検索に頼らずに自分で処理手順を考えてみましょう。


// 以下はポーカーの役を判定するプログラムです。
// cards配列に格納したカードの役を判定し、結果表示してください。
// cards配列には計5枚、それぞれ絵柄(suit)、数字(numeber)を格納する
// 絵柄はheart, spade, diamond, clubのみ
// 数字は1-13のみ

// 上記以外の絵柄や数字が存在した場合、または同一の絵柄、数字がcards配列に存在した場合、
// 役の判定前に「手札が不正です」と表示してください。
// 役判定は関数に記述し、関数を呼び出して結果表示すること

// <役>
// ワンペア・・・同じ数字２枚（ペア）が１組
// ツーペア・・・同じ数字２枚（ペア）が２組
// スリーカード・・・同じ数字３枚
// ストレート・・・数字の連番５枚（13と1は繋がらない）
// フラッシュ・・・同じマークが５枚
// フルハウス・・・同じ数字３枚が１組＋同じ数字２枚（ペア）が１組
// フォーカード・・・同じ数字４枚
// ストレートフラッシュ・・・数字の連番５枚＋同じマークが５枚
// ロイヤルストレートフラッシュ・・・1, 10, 11, 12, 13で同じマーク
// ※下の方が強い

// ＜POST通信課題について＞
// セレクトボックスで各スートと1~13の番号を選択できる。
// 判定ボタンクリック後にPOST送信でセレクトボックスの値を送信する。
// POST送信された値をPHP側で受け取り、「hand」関数で手札、「judge」関数で役を戻り値で返す事。
// 各関数から戻り値で返した値を表示する。

// 表示例1）
// 手札は 
// heart2 heart5 heart3 heart4 culb1
// 役はストレートです

// 表示例2）
// 手札は 
// heart1 spade2 diamond11 club13 heart9
// 役はなしです

// 表示例3）
// 手札は 
// heart1 heart1 heart3 heart4 heart5
// 手札は不正です
$hand_arr = [];
$handsuit = [];
$handnum = [];

function frashJudge($cards)
{
    $cards_count = count($cards);
    $cards_suit_count = array_count_values($cards);
    $cards_suit_max = max($cards_suit_count);
    if ($cards_suit_max == $cards_count) {
        return true;
    } else {
        return false;
    }
}

function straightJudge($cards)
{
    if ($cards[1] == $cards[0] + 1 && $cards[2] == $cards[0] + 2 && $cards[3] == $cards[0] + 3 && $cards[4] == $cards[0] + 4) {
        return true;
    } else {
        return false;
    }   
}

function tehuda_suit($i){
    $suit_name = filter_input(INPUT_POST, "suit$i");
    return $suit_name;
}

function tehuda_number($i){
    $hand_number = filter_input(INPUT_POST, "number$i");
    return $hand_number;
}

// 手札
function hand($i)
{
    // この関数内に処理を記述
    $a = null;
    $suit_name = filter_input(INPUT_POST, "suit$i");
    $hand_number = filter_input(INPUT_POST, "number$i");
    $a = $suit_name.$hand_number;
    return $a;
}
// 判定
 function judge($handsuit, $handnum, $hand_arr){
// この関数内に処理を記述
// カードの不正チェック
$cards_count1 = array_count_values($hand_arr);
$max = max($cards_count1);
for($i = 0 ; $i <= 4 ; $i ++){   
    if($handnum[$i] <= 0 || $handnum[$i] >= 14 ||  $max > 1){
        return "手札は不正です。";
    }   
    if($handsuit[$i] != 'heart' && $handsuit[$i] != 'spade' && $handsuit[$i] != 'diamond' && $handsuit[$i] != 'club'){
        return "手札は不正です。";
    }
}
    // カードの並び替え
    sort($handnum);

    //　役判定
    $frash = frashJudge($handsuit);
    $straight = straightJudge($handnum);
    $cards_count2 = array_count_values($handnum);
    $cards_count3 = array_count_values($cards_count2);
    $max2 = max($cards_count2);
    $max3 = max($cards_count3);
    $min2 = min($cards_count2);
    if($frash && $handnum[0] == 1 &&$handnum[1] == 10 && $handnum[2] == 11 && $handnum[3] == 12 && $handnum[4] == 13 ){
        return"役はロイヤルストレートフラッシュです";
    }
    if($frash && $straight){
        return "役はストレートフラッシュです";
    }
    if($max2 == 4){
        return "役はフォーカードです";
    }
    if($max2 == 3 && $min2 == 2){
        return "役はフルハウスです";
    }
    if($frash){
        return "役はフラッシュです";
        }
    if($straight){
        return "役はストレートです";
    }
    if($max2 == 3){
        return "役はスリーカードです";
    }
    if($max3 == 2){
        return "役はツーペアです";
    }
    if($max2 == 2){
        return "役はワンペアです";
    } else {
        return "役はなしです";
    }

    // 結果を返す
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" style="text/css" href="./css/style.css">
    <title>ポーカー役判定</title>
</head>

<body>
    <form action="" method="POST" name="formtype">
        <section>
            <div class="flex">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <div class="card">
                        <p>
                            <?php echo $i . ":" ?>
                        </p>
                        <select name= "<?php echo 'suit'.$i; ?>">
                            <option value=""></option>
                            <option value="spade">spade</option>
                            <option value="diamond">diamond</option>
                            <option value="heart">heart</option>
                            <option value="club">club</option>
                        </select>
                        <select name= "<?php echo 'number'.$i; ?>" >
                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                        </select>
                    </div>
                <?php 
                array_push($handsuit, tehuda_suit($i));
                array_push($handnum, tehuda_number($i));
                array_push($hand_arr, hand($i));
                } ?>
                <button type="submit" class="button1" name="submit">判定</button>
            </div>
            <div>
                <!-- 「hand」関数を使用してセレクトボックスで入力した手札を戻り値で取得し、ブラウザー上で表示する。 -->
                <!-- 引数の仕様有無は各自の判断に任せるとする。-->
                <p>手札は<br>
                    <?php
                    $hand_arr2 = implode("　", $hand_arr);
                    echo $hand_arr2;
                    ?>
                </p>
            </div>
            <div>
                <!-- 「judge」関数を使用してセレクトボックスで入力した手札から役を戻り値で取得し、ブラウザー上で表示する。 -->
                <!-- 引数の仕様有無は各自の判断に任せるとする。-->
                <p>
                    <?php
                    echo judge($handsuit, $handnum, $hand_arr);
                    ?>
                </p>
            </div>
        </section>
    </form>
</body>

</html>