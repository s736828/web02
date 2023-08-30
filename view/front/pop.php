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
    <div class="list"></div>
</fieldset>
<script>
    getPop();

    function getPop() {
        $(".list").load("./api/pop.php", () => {

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
                    getPop()
                })
            })

        })
    }
</script>