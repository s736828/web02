<div>
    目前位置：首頁 > 分類網誌 > <span id="header">健康新知</span>
</div>
<div style="display: flex;">
    <fieldset style="width: 150px;">
        <legend>分類網誌</legend>
        <div><a href="#" data-type="1" class="cat">健康新知</a></div>
        <div><a href="#" data-type="2" class="cat">菸害防治</a></div>
        <div><a href="#" data-type="3" class="cat">癌症防治</a></div>
        <div><a href="#" data-type="4" class="cat">慢性病防治</a></div>
    </fieldset>

    <fieldset style="width: 550px;">
        <legend>文章列表</legend>
        <div id="lists"></div>
        <div id="post"></div>
    </fieldset>
</div>
<script>
    getList(1);

    $(".cat").on("click", function() {
        $("#header").text($(this).text())
        let type = $(this).data('type')
        getList(type)
    })

    function getList(type) {
        $.get("./api/get_list.php", {
            type
        }, (list) => {
            $("#post").html("");
            $("#lists").html(list);
        })
    }

    function getPost(id) {
        $.get("./api/get_post.php", {
            id
        }, (post) => {
            $("#lists").html("");
            $("#post").html(post);
        })
    }
</script>