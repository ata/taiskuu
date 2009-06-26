<?php

abstract class Model
{
    const HAS_MANY      =   'has_many';
    const HAS_ONE       =   'has_one';
    const BELONGS_TO    =   'belongs_to';
    protected $db; // PDO object
    protected $tableName; // Nama table, jika tidak di deklarasikan, isikan dengan nama class
    public $id = null;
    public $attributes = array();
    public $metas = array();
    /**     // pada post
     *      $relations = array(
     *          'commments' => array(
     *              'model'         =>  'Comment'
     *              'foreign_key'   =>  'post_id',
     *              'type'          =>  'has_many'
     *           ),
     *          'author'    =>  array(
     *              'model'         =>  'User',
     *              'foreign_key'   =>  'user_id'
     *              'type'          =>  'belong_to'
     *           )
     *          'author'    =>  array(
     *              'model'         =>  'PostLog',
     *              'foreign_key'   =>  'post_id'
     *              'type'          =>  'has_one'
     *           )
     *      );
     */
    public $relations = array();
    private static $models = array();
    
    public function __construct($attributes = null)
    {
        $this->dbsetup();
        $this->setTableName(get_class($this));
        $this->initialFields();
        $this->setup();
        if ($attributes != null) {
            $this->fromArray($attributes);
        }
    }
    public function fromArray($attributes) {
        foreach ($attributes as $key => $value) {
            if(array_key_exists($key, $this->attributes)) {
                $this->attributes[$key]['value'] = $value;
                //aneh ya?
                if(is_array($value)) {
                    if($this->attributes[$key]['type'] == "DATE2") {
                        $this->attributes[$key]['value'] = $value['y'] ."-". $value['m'] ."-". $value['d'];;
                    } else {
                        $this->attributes[$key]['value'] = $value['value'];
                    }
                }
            }
            if($key == 'id') {
                if(!is_array($value)){
                    $this->id = $value;
                }
            }    
        }
    }
    private function dbsetup()
    {
        $config = include('./app/config/main.php');
        $dbstring = $config['db']['connectionString'];
        $dbuser = $config['db']['dbuser'];
        $dbpass = $config['db']['dbpass'];
        $this->db = new PDO($dbstring, $dbuser, $dbpass);
    }
    private function initialFields()
    {
        $statement = $this->query("select * from $this->tableName");
        $count = $statement->columnCount();
        for($i = 0; $i < $count; $i++) {
            $field = $statement->getColumnMeta($i);
            $attribute['type'] = $field['native_type'];
            $attribute['value'] = '';
            $this->attributes[$field['name']] = $attribute;
        }
    }
    abstract public function setup();
    
    public function __set($attribute, $value)
    {
        if (array_key_exists($attribute, $this->attributes)) {
            $this->attributes[$attribute]['value'] = $value;
        } else {
            $this->$attribute = $value;
        }
    }
    
    public function __get($attribute)
    {
        if (array_key_exists($attribute, $this->attributes)) {
            return $this->attributes[$attribute]['value'];
        } else if (array_key_exists($attribute, $this->relations)) {
            return $this->getModel($attribute);
        } else {
            return $this->$attribute;
        }
    } 
    
    private function getModel($mapped)
    {
        $classModel = $this->relations[$mapped]['model'];
        $foreign_key = $this->relations[$mapped]['foreign_key'];
        if(require_once("./app/models/$classModel.class.php")){
            $model = new $classModel();
        }
        if($this->relations[$mapped]['type'] == Model::HAS_MANY) {
            $objects = $model->findQuery("from $classModel where $foreign_key = ?", array($this->id));
            return $objects;
        } else if ($this->relations[$mapped]['type'] == Model::HAS_ONE) {
            $objects = $model->findQuery("from $classModel where $foreign_key = ? LIMIT 0, 1", array($this->id));
            return $objects[0];
        } else if ($this->relations[$mapped]['type'] == Model::BELONGS_TO) {
            $objects = $model->findQuery("from $classModel where id = ?", array($this->$foreign_key));
            return $objects[0];
        }
    }
    
    
    public function find($id)
    {
        $object = $this->findQuery("from $this->tableName where id = ? ", array($id));
        return $object[0];
    }
    public function all($order = 'id asc')
    {
        return $this->findQuery("from $this->tableName order by $order");
    }
    public function last($order = 'id')
    {
        $objects = $this->findQuery("from $this->tableName order by $order desc limit 0,1");
        return $objects[0];
    }
    public function size()
    {
        $st = $this->query("select count(*) as size from $this->tableName");
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['size'];
    }
    public function first($order = 'id')
    {
        $objects = $this->findQuery("from $this->tableName order by $order asc limit 0,1");
        return $objects[0];
    }
    public function select($label, $value = 'id')
    {
        $statement = $this->query("select $value, $label from $this->tableName");
        $options = array();
        foreach($statement->fetchAll(PDO::FETCH_ASSOC) as $data){
            $options[$data[$value]] = $data[$label];
        }
        return $options;
        
    }
    
    public function save()
    {
        if ($this->id == null) {
            $names = array();
            $values = array();
            $attributes = array();
            foreach ($this->attributes as $name => $value) {
                if($name != 'id') {
                    $attributes[$name] = $value['value'];
                }
            }
            foreach ($attributes as $name => $value) {
                $names[] = $name;
                $values[] = ':'.$name;
            }
            $names = join(', ', $names);
            $values = join(', ', $values);
            $query = "INSERT INTO $this->tableName ($names) VALUES ($values)";
            //echo $query;
            //var_dump($attributes);
            try{
                $statement = $this->db->prepare($query);
                $statement->execute($attributes);
                $this->id = $this->db->lastInsertId();
            } catch (PDOException $e) {
                var_dump($e);
            }
        } else {
            $this->update();
        }
    }
    
    private function update()
    {
        $pairs = array();
        $args = array();
        foreach ($this->attributes as $name => $value) {
            if($name != 'id'){
                $pairs[] = "$name = ?";
                $args[] = $value['value'];
            }
        }
        $pairs = join(', ', $pairs);
        $query = "UPDATE $this->tableName SET $pairs WHERE id = ?";
        $args[] = $this->id;
        $statement = $this->db->prepare($query);
        $statement->execute($args);
    }
    
    public function delete($id)
    {
        $this->query("delete from $this->tableName where id = ?", array($id));
    }
    
    /**
     *  
     *  
     * @param object $field
     */
    
    public function findQuery($query,$params = array())
    {   
        if (strtolower(substr($query,0,4)) == 'from'){
            $query = 'select * '.$query;
        }
        $query = str_replace(get_class($this), $this->tableName, $query);
        //echo $query;
        $statement = $this->db->prepare($query);
        $statement->execute($params);
        $self = get_class($this);
        $objects = array();
        while ($attributes = $statement->fetch(PDO::FETCH_ASSOC)) {
            $object = new $self($attributes);
            $object->id = $attributes['id'];
            $objects[] = $object;
        }
        return $objects;
    }
    
    public function query($query, $params = array())
    {
       
        $statement = $this->db->prepare($query);
        $statement->execute($params);
        return $statement;
    }
    
    public static function model($className)
    {
        if(isset(self::$models[$className])) {
            return self::$models[$className];
        } else {
            $model = self::$models[$className] =  new $className();
            return $model;
        }
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
}
