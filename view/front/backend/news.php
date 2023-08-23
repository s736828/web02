<form action="./api/news_admin.php" method="post">
    <table class="ct" style="width: 75%; margin:auto">
        <tr>
            <td>編號</td>
            <td>標題</td>
            <td>顯示</td>
            <td>刪除</td>
        </tr>
        <?php
        foreach ($rows as $key => $row) {
        ?>
            <tr>
                <td><?= $start + $key ?></td>
                <td><?= $row['title'] ?></td>
                <td>
                    <input type="checkbox" name="sh[]" value="<?=$row['id']?>">
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
</form>