<?php
// カテゴリごとのブックマークを保存するための連想配列
$bookmarks = [
    '動画' => [],
    '参考' => [],
    '素材' => []
];

// カテゴリ名を保存するための配列
$categories = ['動画', '参考', '素材'];

// POSTリクエストを処理する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームから送信されたデータを取得
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $url = isset($_POST['url']) ? $_POST['url'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    // カテゴリの追加
    if (isset($_POST['newCategory'])) {
        $newCategory = $_POST['newCategory'];
        if (!empty($newCategory)) {
            array_push($categories, $newCategory);
            $bookmarks[$newCategory] = [];
        }
    }

    // 入力値が空でない場合にのみブックマークを保存
    if (!empty($title) && !empty($url) && !empty($category)) {
        // ブックマークを連想配列として保存
        $bookmark = [
            'title' => $title,
            'url' => $url
        ];
        // カテゴリに対応する配列にブックマークを追加
        array_push($bookmarks[$category], $bookmark);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>ブックマークアプリ</title>
</head>

<body>
    <h1>ブックマークアプリ</h1>

    <h2>ブックマークの追加</h2>
    <form method="POST" action="">
        <label for="title">タイトル:</label>
        <input type="text" name="title" id="title" required><br><br>
        <label for="url">URL:</label>
        <input type="text" name="url" id="url" required><br><br>
        <label for="category">カテゴリ:</label>
        <select name="category" id="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <input type="submit" value="追加">
    </form>

    <h2>カテゴリの作成</h2>
    <form method="POST" action="">
        <label for="newCategory">新しいカテゴリ名:</label>
        <input type="text" name="newCategory" id="newCategory" required><br><br>
        <input type="submit" value="カテゴリを追加">
    </form>

    <h2>ブックマーク一覧</h2>
    <?php foreach ($categories as $category): ?>
        <?php if (!empty($bookmarks[$category])): ?>
            <h3>カテゴリ <?php echo $category; ?></h3>
            <ul>
                <?php foreach ($bookmarks[$category] as $bookmark): ?>
                    <li>
                        <a href="<?php echo htmlspecialchars($bookmark['url'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($bookmark['title'], ENT_QUOTES, 'UTF-8'); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>カテゴリ <?php echo $category; ?> のブックマークはありません。</p>
        <?php endif; ?>
    <?php endforeach; ?>

    <div>
        <a href="http://localhost/test1//">HOME</a>
    </div>

</body>

</html>