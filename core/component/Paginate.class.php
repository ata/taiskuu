<?php
class Paginate{
    private $count = 20;
    private $first;
    private $size;
    private $page = 1;
    private $model;
    private $lastPage;
    private $query;
    private $url;
    private $tableName;
    private $result;
    public function __construct($model, $url)
    {
        $this->model = $model;
        $this->tableName = get_class($model);
        $this->query = "from $this->tableName";
        $this->size = $this->size();
        $this->lastPage = ceil((float)$this->size / (float)$this->count);
       
        $this->url = $url;
        if(isset($_GET['page'])) {
            $this->page = $_GET['page'];
        }
        
        $this->first = ($this->page - 1) *  $this->count;
        
    }
    
    public function size(){
        $st = $this->model->query("select count(*) as size " . $this->query);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['size'];
    }
    
    public function setQuery($query)
    {
        $this->query = $query;
        $this->size = $this->size();
        $this->lastPage = ceil((float)$this->size / (float)$this->count);
    }
    public function paginate()
    {
        $this->result =  $this->model->findQuery($this->query . " LIMIT $this->first, $this->count");
        return $this->result;
    }
    public function setCount($count){
        $this->count = $count;
    }
    public function navigation()
    {
        $from = $this->first + 1;
        $to = $this->first + count($this->result);
        
        $nav = "$from to $to from $this->size result  | ";
        
        $previous = $this->page - 1;
        if($previous > 0) {
            $nav .= "<a href=\"$this->url&page=$previous\">Previous</a> ";
        }
        
        for($i = 1; $i <= $this->lastPage; $i++) {
            if($i != $this->page) {
                $nav .= "<a href=\"$this->url&page=$i\">$i</a> ";
            } else {
                $nav .= "$i ";
            }
        }
        
        $next = $this->page + 1;
        if($this->page != $this->lastPage) {
            $nav .= "<a href=\"$this->url&page=$next\">Next</a> ";
        }
        
        return $nav;
        
    }
    
    
}