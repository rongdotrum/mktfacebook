<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GBaseBusinessProcess
 *
 * @author 060007HDN
 */
abstract class GBaseBusinessProcess {
    const BL_RET_SUCCESS=0;
    const BL_RET_ERROR=1;
    
    protected $dba;
    
    protected $params;//Array of parameters    
    protected $form;//Posted form object
    
    private $models=array();//Return model
    private $modelCnt=0;
    private $_errorcnt=0;//Count number of error
    private $_errors=array();	// attribute name => array of errors
    
    private $isTransactionBegun=false;
    private $transaction=null;
    
    /*
     * Khoi tao lay doi ung truy cap du lieu
     * Khoi tao doi tuong transation
     */
    public function __construct(){
        //Get db access object
        $this->dba=Yii::app()->db;
        $this->transaction=new CDbTransaction($this->dba);        
    }
    
    /*
     * Thiet lap mang tham so cho xu ly
     */
    public function setParams($params){
        $this->params=$params;
    }
    
    /*
     * Thiet lap doi tuong form input
     */
    public function setForm($form){
        $this->form=$form;
    }
    
    /*
     * Lay doi tuong model tra ve de trinh dien view
     * mang chua 0..n model object
     */
    public function getReturnModels(){
        return array_values($this->models);
    }
    
    /*
     * Set doi tuong model, ket qua cua xu ly nghiep vu
     */
    protected function setReturnModel($model){
        array_push($this->models,$model);
    }
    
     /*
     * Set doi tuong models, ket qua cua xu ly nghiep vu
      * @models phai la mot array
     */
    protected function setReturnModels($models){
        array_push($this->models,$models);
    }
    
    //Transation Control Section
    /*
     * Start transaction
     */
    protected function beginTrans(){
        $this->transaction=$this->dba->beginTransaction();
        $this->isTransactionBegun=true;
    }
    
    /*
     * Commit transaction
     */
    protected function commitTrans(){
        if($this->isTransactionBegun==false){
            throw new CException('Transaction not started, cannot commit. Please call beginTrans to start transaction');
        }
        $this->transaction->commit();
        $this->isTransactionBegun=false;
    }
    /*
     * Rollback transaction
     */
    protected function rollbackTrans(){
        if($this->isTransactionBegun==false){
            throw new CException('Transaction not started, cannot rollback. Please call beginTrans to start transaction');
        }
        $this->transaction->rollback();
        $this->isTransactionBegun=false;
    }
    //Transation Control Section
    
    /*
     * Ham thuc thi chinh cua class xu ly nghiep vu
     * duoc goi chinh tu action
     */
    public function execute(){
        try{        
            //Thuc thi ham abstract theo do thuc thi xu ly cua lop trien khai
            $retCode = $this->executeProcess();
            
        }catch(CDbException $dbex){
            $this->errorAdd($dbex->getMessage());
            Yii::log('Business Process execution error happened.'.$dbex->getMessage());
            return self::BL_RET_ERROR;
        }catch(CException $ex){
            $this->errorAdd($ex->getMessage());
            Yii::log('Business Process execution error happened.'.$ex->getMessage());
            return self::BL_RET_ERROR;
        }
        return $retCode;
    }
    
    /*
     * Add error string
     */
    protected function errorAdd($error){
        //array_merge($this->errors,array('error'=>$error));
        $this->_errors['error']=$error;
        $this->_errorcnt++;
    }
    
    /*
     * Get error list
     */
    public function getErrors(){
        return $this->_errors['error'];
    }
    
    /*
     * Phuong thuc abstract can duoc trien khai o class ke thua
     * chua dung xu ly nghiep vu
     */
    protected abstract function executeProcess();
}

?>
