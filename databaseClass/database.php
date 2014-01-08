<?php

class DB{
    private static $_instance = null;
    private $_connect, $_select, $_query, $_results, $_errors = array(), $_count = 0;

    // connecting to database 
    const HOST = 'localhost';
    const USER = 'root';
    const PASSWORD = 'root';
    const DB  = 'test';
    // singleton desgin pattern
    private function __construct(){
        $this->_connect = mysql_connect(self::HOST, self::USER, self::PASSWORD) or die(mysql_error());
        $this->_select = mysql_select_db(self::DB) or die(mysql_error());
    }

    function __destruct(){
        mysql_close($this->_connect);
    }

    public static function getInstance(){
        if(!self::$_instance){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    // insert('tbl_name',$field = array('column_name' => 'value'));
    public function insert($tbl_name, $fields = array()){
        $keys = array_keys($fields);
        $keys = implode('`,`', $keys);
        $values = '';
        $x = 1;

        foreach ($fields as $field) {
            $values .= $field;
            if($x < count($fields)){
                $values .= "','";
            }
            $x++;

        }
        $sql = "INSERT INTO `{$tbl_name}` (`{$keys}`) VALUES ('{$values}')";
        if($this->_query = mysql_query($sql)){
            echo "Success";
        }else{
            die(mysql_error());
        }


    }// end insert function

    // update($tbl_name, $fields = array('col_name' => 'value'), $id)
    public function update($tbl_name, $fields = array(),$id){

        $set = '';
        $x = 1;
        foreach ($fields as $columns => $values) {
            $set .= "`{$columns}` = '{$values}'";
            if ($x < count($fields)){
                $set .= " , ";
            }
            $x++;
        }
        

        $sql = "UPDATE `{$tbl_name}` SET {$set} WHERE `id`='{$id}' ";
        $this->_query = mysql_query($sql) or die(mysql_error());
    }// end update function

    public function query($action, $tbl_name, $where = array()){
        if(count($where) === 3){
            $column = $where[0];
            $operator = $where[1];
            $value = $where[2];

            $operators = array('=','<','>','<=','>=','<>');

            if(in_array($operator, $operators)){
                $sql = "{$action} FROM `{$tbl_name}` 
                        WHERE `{$column}` {$operator} '{$value}'";

                if($action == 'DELETE'){
                    $this->_query = mysql_query($sql) or die(mysql_error());
                }else{
                    $this->_query = mysql_query($sql) or die(mysql_error());
                    $this->_count = mysql_num_rows($this->_query);
                    return $this->_query;
                }

            }
        }
    }// end query function

    /*
    select($tbl_name, $where = array('column', 'operator', 'value'))
    return value from mysql_query
    that I can use by mysql_fetch functions
    */
    public function select($tbl_name, $where = array()){
        $this->_results = $this->query('SELECT *', $tbl_name, $where);
        return $this->_results;
    }// end select function 
    
    // delete($tbl_name,$where = array('column', 'operator', 'value'))
    // return nothing
    public function delete($tbl_name, $where = array()){
        $this->_results = $this->query('DELETE', $tbl_name, $where);
        return $this->_results;
    }// end delete function

    public function deleteById($tbl_name, $id){
        $id = intval($id);
        $sql = "DELETE FROM `{$tbl_name}` WHERE `id`= '{$id}'";
        $this->_query = mysql_query($sql)  or die(mysql_error());
    }
}
