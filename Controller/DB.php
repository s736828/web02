<?php
class DB
{
    protected $table;
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=db04";
    protected $links;
    protected $pdo;

    function __construct($table)
    {
        $this->table = $table;
        $this->pdo = new PDO($this->dsn, 'root', '');
    }

    // tools
    protected function a2s($array)
    {
        foreach ($array as $key => $val) {
            if ($key != 'id') {
                $tmp[] = "`$key`='$val'";
            }
        }
        return $tmp;
    }

    protected function sql_all($sql, ...$arg)
    {
        if (!empty($arg)) {
            if (isset($arg[0])) {
                if (is_array($arg)) {
                    $tmp = $this->a2s($arg[0]);
                    $sql = $sql . " where " . join(" && ", $tmp);
                } else {
                    $sql = $sql . $arg[0];
                }
            }
            if (isset($arg[1])) {
                $sql = $sql . $arg[1];
            }
        }
        return $sql;
    }
    protected function sql_one($sql, $arg)
    {
        if (is_array($arg)) {
            $tmp = $this->a2s($arg);
            $sql = $sql . " where " . join(" && ", $tmp);
        } else {
            $sql = $sql . " where `id`='$arg'";
        }
        return $sql;
    }

    protected function math($math, $col, ...$arg)
    {
        $sql = "select $math($col) from $this->table ";
        $sql = $this->sql_all($sql, ...$arg);
        return $this->pdo->query($sql)->fetchColumn();
    }
    // function
    function all(...$arg)
    {
        $sql = $this->sql_all(" select * from $this->table ", ...$arg);
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    function count(...$arg)
    {
        $sql = $this->sql_all(" select count(*) from $this->table ", ...$arg);
        return $this->pdo->query($sql)->fetchColumn();
    }

    function find($arg)
    {
        $sql = $this->sql_one(" select * from $this->table ", $arg);
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    // del參數傳
    function del($arg)
    {
        $sql = $this->sql_one(" delete from $this->table ", $arg);
        return $this->pdo->exec($sql);
    }

    //(max,min,sum)參數傳 → math(query($sql)) → sql_all(return $sql) → a2s(return $tmp)
    function max($col, ...$arg)
    {
        return $this->math('max', $col, ...$arg);
    }
    function min($col, ...$arg)
    {
        return $this->math('min', $col, ...$arg);
    }
    function sum($col, ...$arg)
    {
        return $this->math('sum', $col, ...$arg);
    }
    function save($arg)
    {
        if (isset($arg['id'])) {
            // 帶id的話是update
            $tmp = $this->a2s($arg);
            $sql = "update $this->table set " . join(",", $tmp) . " where `id`='{$arg['id']}'";
        } else {
            $keys = array_keys($arg); //返回key值
            $sql = "insert into $this->table(`" . join("`,`", $keys) . "`) values('" . join("','", $arg) . "')";
        }
        return $this->pdo->exec($sql);
    }
    // view
    function view($path, $arg = [])
    {
        extract($arg);
        include($path);
    }

    function paginate($num, $arg = null)
    {
        $total = $this->count($arg);
        $pages = ceil($total / $num);
        $now = $_GET['p'] ?? 1;
        $start = ($now - 1) * $num;
        // $當前頁數的第一筆資料的索引值
        $rows = $this->all($arg, " limit $start,$num");
        $this->links = [
            'total' => $total,
            'pages' => $pages,
            'now' => $now,
            'start' => $start,
            'table' => $this->table,
            'num' => $num
        ];
        return $rows;
    }

    function links($target = null)
    {
        if (is_null($target)) {
            $target = $this->table;
        }

        $html = '';
        if ($this->links['now'] - 1 >= 1) {
            $prev = $this->links['now'] - 1;
            $html .= "<a href='?do=$target&p=$prev'>&lt</a>";
        }

        for ($i = 1; $i <= $this->links['pages']; $i++) {
            $fontsize = ($i == $this->links['now']) ? "24px" : "16px";
            $html .= "<a href='?do=$target&p=$i' style='font-size:$fontsize'>$i</a>";
        }
        if ($this->links['now'] + 1 <= $this->links['pages']) {
            $next = $this->links['now'] + 1;
            $html .= "<a href='?do=$target&p=$next'>&gt</a>";
        }
        return $html;
    }
}

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}