<?php
abstract class Record{
    protected $db; //PDO database handle
    public $table; //name of the table, usually same as the class name
    public $keyField = 'id'; //name of the primary key column
    public $id; //primary key value, regardless of name
    protected $attrs = array(); //table rows
    protected $info = NULL; //contains serialized data of virtual rows
    protected $errors = array(); //validation errors, which will stop creates/updates
   
    function __construct(){
        $this->table = strtolower(get_class($this));
        $this->db = Database::getMain();
    }
   
    function __set($name, $value){
        if ($name == $this->keyField) {
            $this->id = $value;
        } elseif (key_exists($name, $this->attrs)) {
            $this->attrs[$name] = $value;
        } elseif (isset($this->info) && key_exists($name, $this->info)) {
            $this->info[$name] = $value;
        } else {
            trigger_error("Setting new '$name' attribute", E_USER_NOTICE);
            $this->$name = $value;
        }
    }
   
    function __get($name){
        if ($name == $this->keyField) {
            return $this->id;
        } elseif (key_exists($name, $this->attrs)) {
            return $this->attrs[$name];
        } elseif (isset($this->info) && key_exists($name, $this->info)) {
            return $this->info[$name];
        } else {
            trigger_error("Can't get '$name' attribute", E_USER_NOTICE);
        }
    }
   
    function __isset($name){
        if ($name == $this->keyField) {
            return isset($this->id);
        } elseif (key_exists($name, $this->attrs)) {
            return isset($this->attrs[$name]);
        } elseif (isset($this->info) && key_exists($name, $this->info)) {
            return isset($this->info[$name]);
        } else {
            return FALSE;
        }
    }
   
    function __call($name, $attrs){
        if (substr($name, 0, 6) == 'loadBy') {
            $field = strtolower($name[6]).substr($name, 7);
            return $this->loadBy($field, $attrs[0]);
        } elseif (substr($name, 0, 8) == 'selectBy') {
            $field = strtolower($name[8]).substr($name, 9);
            return $this->selectBy($field, $attrs[0], @$attrs[1], @$attrs[2]);
        } elseif (substr($name, 0, 7) == 'countBy') {
            $field = strtolower($name[7]).substr($name, 8);
            return $this->countBy($field, @$attrs[0]);
        } else {
            trigger_error("Method '$name' is not defined", E_USER_ERROR);
        }
    }
   
    private function loadBy($field, $value){
        if (!array_key_exists($field, $this->attrs)) {
            throw new Exception('Trying to load by invalid field');
        }
        return $this->loadWith("* FROM $this->table WHERE $field = ?", array($value));
    }
   
    private function selectBy($field, $value, $pageSize = 0, $page = 0){
        if (!array_key_exists($field, $this->attrs)) {
            throw new Exception("Trying to select by invalid field '$field'");
        }
        return $this->selectWith("* FROM $this->table WHERE $field = ?", array($value), $pageSize, $page);
    }
   
    private function countBy($field, $values = NULL){
        if ($values == array()) {
            return array();
        }
        $list = '('.implode(',', array_pad(array(), sizeof($values), '?')).')';
        $query = "SELECT $field, COUNT(*) as count FROM $this->table";
        if ($values != NULL) {
            $query .= " WHERE $field IN $list";
        }
        $query .= " GROUP BY $field";   
        $statement = $this->db->prepare($query);
        $statement->execute(array_values($values));
       
        $countMap = array();
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $countMap[$row[$field]] = $row['count'];
        }
        return $countMap;
    }
   
    function setAttrs($attrs){ //convenience function to input HTML form data
        foreach ($attrs as $name => $value) {
            if (key_exists($name, $this->attrs)) {
                $this->$name = $value;
            } elseif (isset($this->info)&& key_exists($name, $this->info)) {
                $this->info[$name] = $value;
            } else {
                trigger_error("Can't set '$name' attribute", E_USER_NOTICE);
            }
        }
    }
   
    protected function getDbAttrs(){ //converts the object to a hash that matches DB fields
        $attrs = array();
        if (isset($this->info)) {
            $attrs['info'] = Ori::fold($this->info, Ori::NO_NULLS | Ori::UNBRACE);
        }
        foreach ($this->attrs as $name => $value) {
            $methodName = 'get'.$name.'ForDb';
            if (method_exists($this, $methodName)) {
                $attrs[$name] = $this->$methodName();
            } else {
                $attrs[$name] = $value;
            }
        }
        $attrs[$this->keyField] = $this->id;
        return $attrs;
    }
   
    protected function setDbAttrs($attrs){ //Inverse of getDbAttrs
        if (isset($this->info) && isset($attrs['info'])) {
            foreach ((array) Ori::unfold($attrs['info'], Ori::BRACE) as $key => $value) {
                $this->info[$key] = $value;
            }
            unset($attrs['info']);
        }
        foreach ($attrs as $name => $value) {
            $methodName = 'set'.$name.'FromDb';
            if (method_exists($this, $methodName)) {
                $this->$methodName($value);
            } else {
                $this->$name = $value;
            }
        }
    }
   
    protected function check(){ //validation method, called before writing to DB
    }
   
    function create(){
        $this->check();
        if (!empty($this->errors)) {
            throw new Exception(join("\n", $this->errors));
        }
       
        $attrs = $this->getDbAttrs();
        $names = array();
        $values = array();
        foreach ($attrs as $name => $value) {
            $names[] = $name;
            $values[] = ':'.$name;
        }
        $names = join(', ', $names);
        $values = join(', ', $values);
        $query = "INSERT INTO $this->table ($names) VALUES ($values)";
        $statement = $this->db->prepare($query);
        $statement->execute($attrs);
        $id = $this->db->lastInsertId();
        if (!empty($id)) { $this->id = $id; }
    }
   
    function update(){
        $this->check();
        if (!empty($this->errors)) {
            throw new Exception(join("\n", $this->errors));
        }
       
        $attrs = $this->getDbAttrs();
        $pairs = array();
        $args = array();
        foreach ($attrs as $name => $value) {
            $pairs[] = "$name = ?";
            $args[] = $value;
        }
        $pairs = join(', ', $pairs);
        $query = "UPDATE $this->table SET $pairs WHERE $this->keyField = ?";
        $args[] = $this->id;
        $statement = $this->db->prepare($query);
        $statement->execute($args);
    }
 
    function load($id){
        return $this->loadWith("* FROM $this->table WHERE $this->keyField=?", array($id));
    }
   
    function loadWith($query, $params = array()){
        $statement = $this->db->prepare('SELECT '.$query);
        $statement->execute($params);
        $attrs = $statement->fetch(PDO::FETCH_ASSOC);
        if ($attrs == NULL) {
            throw new Exception(get_class($this)." did not load");
        }
        $this->setDbAttrs($attrs);
    }
   
    function selectWith($query, $params = array(), $pageSize = 0, $pageNum = 0){
        $pageSize = (int) $pageSize;
        if ($pageSize > 0) {
            $offset = $pageNum * $pageSize;
            $query .= " LIMIT $pageSize";
            if ($offset > 0) {
                $query .= " OFFSET $offset";
            }
        }
        $statement = $this->db->prepare('SELECT '.$query);
        $statement->execute($params);
        $self = get_class($this);
        $objects = array();
        while ($attrs = $statement->fetch(PDO::FETCH_ASSOC)) {
            $object = new $self();
            $object->setDbAttrs($attrs);
            $objects[] = $object;
        }
        return $objects;
    }
   
    function selectAll($pageSize = 0, $pageNum = 0){
        return $this->selectWith("* FROM $this->table", NULL, $pageSize, $pageNum);
    }
   
    function delete($id){
        return $this->deleteWhere("$this->keyField = ?", array($id));;
    }
   
    function deleteWhere($where, $params = array()){
        $query = "DELETE FROM $this->table WHERE $where";
        $statement = $this->db->prepare($query);
        $statement->execute($params);
        return $statement->rowCount();
    }
   
    function count($where = NULL, $params = array()){
        $query = "SELECT COUNT(*) FROM $this->table";
        if (!empty($where)) {
            $query .= " WHERE ".$where;
        }
        $statement = $this->db->prepare($query);
        $statement->execute($params);
        $row = $statement->fetch(PDO::FETCH_NUM);
        return $row[0];
    }
   
    function exists($id){
        return $this->count("$this->keyField = ?", array($id));
    }
   
    //in: array(2, 5, 7) => out: array(objectWithId2, objectWithId5, objectWithId7)
    function resolve($mappedIds){
        if (empty($mappedIds)) {
            return array();
        }
        $list = '('.implode(',', array_pad(array(), sizeof($mappedIds), '?')).')';
        $objects = $this->selectWith("* FROM $this->table
            WHERE $this->keyField IN $list", array_values($mappedIds));
        $objectMap = array();
        foreach ($objects as $object) {
            $objectMap[$object->id] = $object;
        }
        return $objectMap;
    }
}