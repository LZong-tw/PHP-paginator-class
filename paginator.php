class paginator 
{
    var $sql, $limit, $total, $total_page, $page;
    var $elements = 5;
    var $result = array();
    //Get and set limitation.
    public function __construct($sql, $limit, $page){
        if($page == 0){$page = 1;}
        $this->sql = $sql;
        $cut = stripos($sql, 'FROM');
        $sql = substr($sql, $cut);
        $count = "SELECT count(*) AS count ".$sql;
        $result = mysql_query($count);
        $result = mysql_fetch_assoc($result);
        $this->total = $result['count'];
        $this->page = $page;
        $this->limit = $limit;
        if ( floor($this->total / $limit) == 0 ) {
            $this->total_page = 1;
        }
        else{
            $this->total_page = floor($this->total / $limit) + 1;
        }
        $this->setList($page);
    }
    function setList($page){
        $query = $this->sql . " LIMIT " . strval(( $page - 1 ) * $this->limit) . ", " . strval($this->limit * $page);
        $result = mysql_query($query);
        while($row = mysql_fetch_array($result,MYSQLI_ASSOC)){
            array_push($this->result,$row);
        }
    }
    function getList(){
        return $this->result;
    }
    function showPages(){
        if($this->total_page > 1){
            echo "<a href='".preg_replace('/(&page=\d*)+/', '', $_SERVER['REQUEST_URI'])."&page=1'>First page</a> ";
            $this_page = $this->page == 0 ? 1 : $this->page;
            $limit = $this->total_page < $this->elements ? $this->total_page : $this_page - ( $this_page % $this->elements - 1 ) + $this->elements - 1;
            for ($now = $this_page - ( floor($this_page % $this->elements) - 1); $now <= $limit; $now++) {
                if($now == $this_page){
                    echo " <a>".$now."</a>";
                } 
                else {
                    echo " <a href='".preg_replace('/(&page=\d*)+/', '', $_SERVER['REQUEST_URI'])."&page=".$now."'>".$now."</a>";
                }
            }
            echo " <a href='".preg_replace('/(&page=\d*)+/', '', $_SERVER['REQUEST_URI'])."&page=".$this->total_page."'>Last page</a>";
        }
    }
}
