<?php 

/*

Database 

*/


class database extends \PDO{


    private $host = 'mysql:host=localhost;dbname=sepet';
    private $username = 'root';
    private $password = 'mysql';
    private $table;
    private $select;
    private $where = null;
    private $limit;
    private $islem;
    private $insert;
    private $update;
    private $oder_by;
    

    public function __construct(){

        parent::__construct($this->host, $this->username ,$this->password);
        

    }

    public function table($param){


        $this->table = $param;
        return $this;


    }

    public function select($param){

        $this->islem = "SELECT";

        $this->select = $param;
        
        return $this;

    }

    public function delete($param){

        $this->islem = "DELETE";

        $this->table = $param;
        return $this;

    }

    public function insert($param){

        $this->islem = "INSERT";

        $this->insert = $param;


        return $this;


    }

    public function where($param){
        
        $this->where = 'WHERE ' . key($param) . '=' . $param[key($param)];
        return $this;

    }


    public function update($param){

        $this->islem = "UPDATE";
        


        $this->update = call_user_func_array("array_merge", $param);


        return $this;


    }

    public function limit($param){

        
        if(count($param) == 2){
            
            $this->limit = "LIMIT " . $param[0] . ',' . $param[1];

        }else{

            $this->limit = "LIMIT " . $param;

        }
        return $this;

   }

   public function order_by($param){

    $this->order_by = "ORDER BY " . $param;

    return $this;


   }

    public function run(){

    switch($this->islem){

        case "SELECT":

            $sql = "SELECT $this->select FROM $this->table $this->where $this->order_by $this->limit";

            echo $sql;

            $data = $this->prepare($sql);
            $data->execute();

            return $data->fetchAll(PDO::FETCH_ASSOC);


        break;

        case "INSERT":

            $column = array_keys($this->insert);
            $column = implode(',', $column);

            $sql = "INSERT INTO $this->table ($column) VALUES (?,?,?)";

            $insert = $this->prepare($sql);

            $i = 1;

            foreach($this->insert as $key=> &$value){

                $insert->bindParam($i++, $value, PDO::PARAM_STR);

            }

            $insert->execute();

        break;


        case "UPDATE":

            
            $set = array_keys($this->update);

            
            foreach($set as $key=>$value){

                $set__[] = $value . ' = ' . ":$value";

            }

            $set__ = implode(',', $set__);

            $sql = "UPDATE $this->table SET $set__ $this->where";
          
            $update = $this->prepare($sql);

            $update->execute($this->update);
            

        break;


    }


    }


}
