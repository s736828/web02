<style>
    .all{
        background: rgba(51,51,51,0.8);
        color: #FFF;
        width: 300px;
        position: fixed;
        display: none;
        overflow: auto;
        /* 捲軸 */
        padding: 15px;
        border-radius: 10px;
        box-shadow: 2px 2px 10px #999;
        height: 400px;
        /* z-index: 9999; */
        /* min-height: 100px; */
    }
</style>
<fieldset>
    <legend>目前位置：首頁 > 人氣文章區</legend>
<table>
    <tr>
        <td width="30%">標題</td>
        <td width="40%">內容</td>
        <td>人氣</td>
    </tr>
    <?php
$rows = $News->paginate(5, ['sh' => 1], " order by goods desc");
foreach ($rows as $row) {
    ?>
        <tr>
            <td width="30%" class="title"><?=$row['title']?></td>
            <td width="40%" class="content">
                <div class="short"><?=mb_substr($row['text'], 0, 25)?>...</div>
                <div class="all">
                    <h2 style="color:aqua"><?=$News->type($row['type'])?></h2>
                    <div><?=$row['text']?></div>
                </div>
            </td>
            <td>
                <span class="amount"><?=$row['goods']?></span>個人說<div class="good"></div>
<?php
if (isset($_SESSION['user'])) {
        echo "-<a href='#' class='goods' data-id='{$row['id']}'>";
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
<div><?=$News->links("pop");?></div>
</fieldset>
<script>
$(".title,.content").hover(
    function() {
        $(this).parent().find(".all").show()
    },
    function() {
        $(this).parent().find(".all").hide()
    }
)
// 將一個或多個事件的事件處理函數附加到所選元素。
$(".goods").on("click", function() {
    let news, type
    news = $(this).data("id")
    switch ($(this).text()) {
        case "讚":
            $(this).text("收回讚");
            type = 1;
        break;
        case "收回讚":
            $(this).text("讚")
            type = 2;
        break;
    }
    $.post("./api/goods.php",{news,type},()=>{
        location.reload()
    })
})



</script>