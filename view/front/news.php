<fieldset>
    <legend>目前位置:首頁>最新文章區</legend>
    <table>
        <tr>
            <td width="30%">標題</td>
            <td width="40%">內容</td>
            <td></td>
        </tr>
        <?php
        $rows = $News->paginate(5, ['sh' => 1]);
        foreach ($rows as $row) {
        ?>
            <tr>
                <td width="30%" class="title"><?= $row['title'] ?></td>
                <td width="40%" class="content">
                    <!-- mb_substr(str,開始,長度) -->
                    <div class="short"><?= mb_substr($row['text'], 0, 25) ?>...</div>
                    <div class="all" style="display: none;"><?= $row['text'] ?></div>
                </td>
                <td>
                    <?php
                    if (isset($_SESSION['user'])) {
                        echo "<a href='#' class='goods' data-id='{$row['id']}'>";
                        echo $Log->showGoods($row['id']);
                        echo "</a>";
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
    <div><?= $News->links() ?></div>
</fieldset>

<script>
    $(".title,.content").on("click", function() {
        $(this).parent().find(".short,.all").toggle()
    })
    // 切換

    $(".goods").on("click", function() {
        let news, type
        news = $(this).data("id")
        switch ($(this).text()) {
            case "讚":
                $(this).text("收回讚");
                type = 1;
                break;
            case "收回讚":
                $(this).text("讚");
                type = 2;
                break;
        }
        $.post("./api/goods.php",{news,type})
    })
</script>