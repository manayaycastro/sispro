<?php

require_once 'conexion.php';

class formulacion {

    private $form_id;
    private $form_identificacion;
    private $form_campo1;
    private $form_campo2;
    private $tipsem_id;
    private $usr_id;
    private $estado;
    private $fecha_creacion;
    private $objPdo;

    public function __construct( //producción 2019
            $form_id = NULL, 
            $form_identificacion = '', 
            $form_campo1 = '', 
            $form_campo2 = '', 
            $tipsem_id = '', 
            $usr_id = '', 
            $estado = '', 
            $fecha_creacion = ''
    ) {
        $this->form_id = $form_id;
        $this->form_identificacion = $form_identificacion;
        $this->form_campo1 = $form_campo1;
        $this->form_campo2 = $form_campo2;
        $this->tipsem_id = $tipsem_id;
        $this->usr_id = $usr_id;
        $this->estado = $estado;
        $this->fecha_creacion = $fecha_creacion;


        $this->objPdo = new Conexion();
    }

    
    
    
    
    public function consultar() { //producción 2019
        $stmt = $this->objPdo->prepare("
select form.* , tip.tipsem_titulo --, maq.maq_nombre
from PROFORMULACION form
inner join PROTIPOSEMITERMINADO tip  on tip.tipsem_id = form.tipsem_id
 --inner join PROMGMAQUINA maq on maq.maq_id = form.form_campo1
where form.eliminado= '0'
                
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    }
    
    
    
    

    public function obtenerxId($form_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT form_id, form_identificacion, form_campo1, 
     form_campo2, tipsem_id, usr_id, estado
 
   FROM PROFORMULACION WHERE form_id = :form_id');
        $stmt->execute(array('form_id' => $form_id));
        $formulacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($formulacion as $form) {
            $this->setForm_id ($form['form_id']);
            $this->setForm_identificacion($form['form_identificacion']);
            $this->setForm_campo1($form['form_campo1']);
            $this->setForm_campo2($form['form_campo2']);
            $this->setTipsem_id($form['tipsem_id']);
            $this->setUsr_id($form['usr_id']);
            $this->setEstado($form['estado']);

        }
        return $this;
    }

     public function insertar() {  //producción 2019
        $stmt = $this->objPdo->prepare('INSERT INTO PROFORMULACION 
            (form_identificacion, form_campo1, form_campo2, tipsem_id, usr_id,  estado) 
                                        VALUES(:form_identificacion,
                                               :form_campo1,
                                               :form_campo2,
                                               :tipsem_id,
                                               :usr_id,
                                               :estado)');
        $rows = $stmt->execute(array(
            'form_identificacion' => $this->form_identificacion,
            'form_campo1' => $this->form_campo1,
            'form_campo2' => $this->form_campo2,
            'tipsem_id' => $this->tipsem_id,
            'usr_id' => $this->usr_id,
            'estado' => $this->estado));
    }
    
public function modificar() { //producción 2019
        $stmt = $this->objPdo->prepare("UPDATE PROFORMULACION SET 
            form_identificacion=:form_identificacion, 
            form_campo1=:form_campo1, 
            form_campo2=:form_campo2, 
            tipsem_id=:tipsem_id, 
            usr_id=:usr_id, 
            estado=:estado, 
            fecha_creacion = SYSDATETIME()         
            WHERE form_id = :form_id");
        $rows = $stmt->execute(array(
            'form_identificacion' => $this->form_identificacion,
            'form_campo1' => $this->form_campo1,
            'form_campo2' => $this->form_campo2,
            'tipsem_id' => $this->tipsem_id,
            'usr_id' => $this->usr_id,
            'estado' => $this->estado,
            'form_id' => $this->form_id));
    }


    
      public function eliminar($form_id) { //producción 2019
        $stmt = $this->objPdo->prepare("update  PROFORMULACION set eliminado = '1' WHERE form_id=:form_id");
        $rows = $stmt->execute(array('form_id' => $form_id));
        return $rows;
    }

           public function listarformulaciondet($id,$id_form) { //producción 2019
        $stmt = $this->objPdo->prepare("
  
select *
from (
select form.form_id, item.itemform_id  as itemform_id2, item.itemform_descripcion,item.itemform_pocision, item.tipsem_id--, valoritem.*
from PROFORMULACION  form
left join PROITEMFORMULACION item on item.tipsem_id = form.tipsem_id
--left join PROVALITEMFORM valoritem on valoritem.form_id = form.form_id
where form.form_id = '$id_form' and form.tipsem_id = '$id' ) as tabla01
 left join PROVALITEMFORM valoritem on valoritem.itemform_id = tabla01.itemform_id2 and valoritem.form_id = '$id_form'

                
                ");
        $stmt->execute();
        $formdet = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $formdet;
    }
    
    
        
        public function listarformulaciondetV01($id,$id_form) { //producción 2019
        $stmt = $this->objPdo->prepare("
  
select item.itemform_id  as itemform_id2, item.itemform_descripcion,item.itemform_pocision, item.tipsem_id, valoritem.*
from PROITEMFORMULACION item
left join PROVALITEMFORM valoritem on valoritem.itemform_id = item.itemform_id
where item.tipsem_id = '$id'  and form_id = '$id_form'

                
                ");
        $stmt->execute();
        $formdet = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $formdet;
    }
    
  
       public function insertarvaloresformul($valitemform_valor,$form_id, $itemform_id, $estado, $usuario){
        $stmt = $this->objPdo->prepare("INSERT INTO PROVALITEMFORM 
                                         (valitemform_valor, form_id, itemform_id, estado, usr_id ) 
                                     VALUES('$valitemform_valor', '$form_id', '$itemform_id', '$estado','$usuario')");
        $rows = $stmt->execute();

    }
    

    

    
    
    
    
    
    
    
     public function deletevaloresforml ($itemform_id,$form_id){
        $stmt = $this->objPdo->prepare("
    delete from PROVALITEMFORM
where itemform_id = '$itemform_id' and  form_id = '$form_id'


                ");
        $rows = $stmt->execute();

    }
    
    
    
       public function consultarporSemiterm($id) { //producción 2019
        $stmt = $this->objPdo->prepare("
select form.* , tip.tipsem_titulo--, maq.maq_nombre
from PROFORMULACION form
inner join PROTIPOSEMITERMINADO tip  on tip.tipsem_id = form.tipsem_id
 --inner join PROMGMAQUINA maq on maq.maq_id = form.form_campo1
where form.eliminado= '0'  and form.tipsem_id = '$id'
                
                ");
        $stmt->execute();
        $form = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $form;
    } 
    
    

 

    
    
    function getForm_id() {
        return $this->form_id;
    }

    function getForm_identificacion() {
        return $this->form_identificacion;
    }

    function getForm_campo1() {
        return $this->form_campo1;
    }

    function getForm_campo2() {
        return $this->form_campo2;
    }

    function getTipsem_id() {
        return $this->tipsem_id;
    }

    function getUsr_id() {
        return $this->usr_id;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    function getObjPdo() {
        return $this->objPdo;
    }

    function setForm_id($form_id) {
        $this->form_id = $form_id;
    }

    function setForm_identificacion($form_identificacion) {
        $this->form_identificacion = $form_identificacion;
    }

    function setForm_campo1($form_campo1) {
        $this->form_campo1 = $form_campo1;
    }

    function setForm_campo2($form_campo2) {
        $this->form_campo2 = $form_campo2;
    }

    function setTipsem_id($tipsem_id) {
        $this->tipsem_id = $tipsem_id;
    }

    function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    function setObjPdo($objPdo) {
        $this->objPdo = $objPdo;
    }


    
  
    
    
    
}

?>
