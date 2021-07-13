<?php

require_once 'conexion.php';

class Usuario {

    private $usr_id;
    private $usr_nickname;
    private $usr_password;
    private $usr_estado;
    private $usr_fechinicio;
    private $emp_id;
    private $per_id;
    private $dep_id;
    private $depa_id;
    private $area;
    private $nombres;
    private $objPdo;

    public function __construct($usr_nickname = '', $usr_password = '', $usr_estado = '', $usr_fechinicio = '', $emp_id = '', $per_id = '', $dep_id = null, $depa_id = NULL,$area = '', $nombres = '', $usr_id = NULL) {
        $this->usr_id = $usr_id;
        $this->usr_nickname = $usr_nickname;
        $this->usr_password = $usr_password;
        $this->usr_estado = $usr_estado;
        $this->usr_fechinicio = $usr_fechinicio;
        $this->emp_id = $emp_id;
        $this->per_id = $per_id;
        $this->dep_id = $dep_id;
        $this->depa_id = $depa_id;
        $this->area = $area;
        $this->nombres = $nombres;
        
        $this->objPdo = new Conexion();
    }
    
    
    public function obtenerxId($usr_id) { //producción 2019
        $stmt = $this->objPdo->prepare('SELECT * FROM PROMGUSUARIOS WHERE usr_id = :usr_id');
        $stmt->execute(array('usr_id' => $usr_id));
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($usuarios)) {
            foreach ($usuarios as $usuario) {
                $this->setUsr_nickname($usuario['usr_nickname']);
                $this->setUsr_password($usuario['usr_password']);
                $this->setUsr_estado($usuario['usr_estado']);
                $this->setUsr_fechinicio($usuario['usr_fechinicio']);
                $this->setEmp_id($usuario['emp_id']);
                $this->setPer_id($usuario['per_id']);
                $this->setUsr_id($usuario['usr_id']);
            }
        }
        return $this;
    }
    
    
    
    
    
    
    
    
    
    
    
    

    public function consultar() {
        $stmt = $this->objPdo->prepare('SELECT u.usr_id, u.usr_nickname, u.usr_password, u.usr_estado, u.usr_fechinicio, u.emp_id, u.per_id, dep.depa_descripcion, d.dep_descr 
FROM usuarios1 u 
inner join empleados e on u.emp_id = e.emp_id 
inner join empleado_detalle ed on ed.emp_det_empleado = e.emp_id
inner join dependencias d on  ed.emp_det_cargo = d.dep_id 
inner join departamentos dep on d.depa_id = dep.depa_id
                                        ORDER BY usr_id;');
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    public function insertar() {
        $stmt = $this->objPdo->prepare('INSERT INTO usuarios1(usr_nickname, usr_password, usr_estado, usr_fechinicio, emp_id, per_id) 
            VALUES (:usr_nickname, :usr_password, :usr_estado, :usr_fechinicio, :emp_id, :per_id);');
        $rows = $stmt->execute(array('usr_nickname' => $this->usr_nickname,
            'usr_password' => $this->usr_password,
            'usr_estado' => $this->usr_estado,
            'usr_fechinicio' => $this->usr_fechinicio,
            'emp_id' => $this->emp_id,
            'per_id' => $this->per_id));
    }

    public function eliminar($usr_id) {
        $stmt = $this->objPdo->prepare('DELETE FROM usuarios1 WHERE usr_id = :usr_id');
        $rows = $stmt->execute(array('usr_id' => $usr_id));
        return $rows;
    }

//     public function produccion($fecha){
    public function produccion() {
        $sql = 'SELECT u.usr_id, u.usr_nickname, u.usr_password, u.usr_estado, u.usr_fechinicio, u.emp_id, u.per_id, dep.depa_descripcion, d.dep_descr FROM usuarios1 u inner join empleados e on
                                        u.emp_id=e.emp_id inner join dependencias d on 
                                        e.dep_id=d.dep_id inner join departamentos dep on
                                        d.depa_id=dep.depa_id
                                        ORDER BY usr_id;';

        $stmt = $this->objPdo->prepare($sql);


        $stmt->execute();
//		$stmt->execute(array('fecha' => $fecha));

        $lista = $stmt->fetchAll(PDO::FETCH_OBJ);

        //d($observaciones);

        return $lista;
    }

    public function modificar2() {
        $stmt = $this->objPdo->prepare('UPDATE usuarios1 SET usr_nickname=:usr_nickname, usr_password=:usr_password, usr_estado=:usr_estado, emp_id=:emp_id, per_id=:per_id
                                        WHERE usr_id = :usr_id');
        $rows = $stmt->execute(array('usr_nickname' => $this->usr_nickname,
            'usr_password' => $this->usr_password,
            'usr_estado' => $this->usr_estado,
            'emp_id' => $this->emp_id,
            'per_id' => $this->per_id,
            'usr_id' => $this->usr_id));
    }

    public function modificar($nick, $pass, $estado, $empleado, $perfil, $id) {
        $stmt = $this->objPdo->prepare('UPDATE usuarios1 SET usr_nickname=:nick, usr_password=:pass, usr_estado=:estado, emp_id=:empleado, per_id=:perfil
                                        WHERE usr_id = :id');
        $rows = $stmt->execute(array('nick' => $nick,
            'pass' => $pass,
            'estado' => $estado,
            'empleado' => $empleado,
            'perfil' => $perfil,
            'id' => $id));
    }

    
 /*  SELECT *, u.usr_id  
                FROM PROMGUSUARIOS u 
                inner join   PROMGEMPLEADOS e on u.emp_id=e.emp_id 
                WHERE u.usr_nickname = '$user'  AND u.usr_password = '$pass' AND u.usr_estado = '1' */
    
    
        public function validarID($user, $pass) {
//se borro esta line  u.usr_id  ,
        $sql = " 
            SELECT u.*, e.*,  direc.apellidopaterno, direc.apellidomaterno, direc.primernombre, direc.segundonombre, direc.nroid,  ar.descripcion as area, ar.codarea , car.descripcion as cargo
                FROM PROMGUSUARIOS u 
                inner join   ". $_SESSION['server_vinculado']."RHEMPLEADO e on u.emp_id=e.codempl
                    inner join  ". $_SESSION['server_vinculado']."MGDIRECTORIO direc on direc.coddir = e.codempl
                    INNER JOIN  ". $_SESSION['server_vinculado']."RHINFLABORAL INF ON INF.codempl = E.codempl
                    INNER JOIN  ". $_SESSION['server_vinculado']."RHAREA ar on ar.codarea = INF.tipoarea
                    inner join  ". $_SESSION['server_vinculado']."rhcargo car on  car.codcargo = INF.cargo
                WHERE u.usr_nickname = '$user'  AND u.usr_password = '$pass' AND u.usr_estado = '1'

                    
                " ;

        $getvalidar = $this->objPdo->prepare($sql);
        $getvalidar->execute();
        $validar2 = $getvalidar->fetchAll(PDO::FETCH_ASSOC);
        

        if (count($validar2)>0) {
           foreach ($validar2 as $usuario) {
                $this->setUsr_id($usuario['usr_id']);
                $this->setUsr_nickname($usuario['usr_nickname']);
                $this->setUsr_password($usuario['usr_password']);
                $this->setUsr_estado($usuario['usr_estado']);
                $this->setUsr_fechinicio($usuario['usr_fechinicio']);
                $this->setEmp_id($usuario['codempl']);
                $this->setPer_id($usuario['per_id']);
                
              $this->setArea($usuario['codarea']);
              $datos = $usuario['apellidopaterno'].' '.$usuario['apellidomaterno'].' '.$usuario['primernombre'];
              $this->setNombres($datos);
            }
            return true;
        } else {
            return false;
        }
    }

    
    
    public function validarID2($user, $pass) {

        $sql = " 
            SELECT *, u.usr_id  
                FROM PROMGUSUARIOS u 
                inner join   ". $_SESSION['server_vinculado']."RHEMPLEADO e on u.emp_id=e.codigo
                WHERE u.usr_nickname = '$user'  AND u.usr_password = '$pass' AND u.usr_estado = '1'

                    
                "
                ;

        $getvalidar = $this->objPdo->prepare($sql);
        $getvalidar->execute();
        $validar2 = $getvalidar->fetchAll(PDO::FETCH_NUM);


        if (count($validar2)>0) {
           foreach ($validar2 as $usuario) {
                $this->setUsr_id($usuario[0]);
                $this->setUsr_nickname($usuario[1]);
                $this->setUsr_password($usuario[2]);
                $this->setUsr_estado($usuario[3]);
                $this->setUsr_fechinicio($usuario[4]);
           //     $this->setEmp_id($usuario[5]);
                $this->setPer_id($usuario[6]);
                
              //  $this->setDep_id($usuario[]);
               // $this->setDepa_id($usuario[]);
            }
            return true;
        } else {
            return false;
        }
    }

    

    public function obtenerDependencia($user_id) {
        $stmt = $this->objPdo->prepare('SELECT emp.dep_id
                                        FROM usuarios1 usu
                                        INNER JOIN empleados emp
                                        ON usu.emp_id = emp.emp_id
                                        WHERE usu.usr_id = :usr_id;');
        $stmt->execute(array('usr_id' => $user_id));

        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $usuarios[0]->dep_id;
    }

    public function obtenerFoto($user_id) {
        $stmt = $this->objPdo->prepare('SELECT emp.emp_foto
                                        FROM usuarios1 usu
                                        INNER JOIN empleados emp
                                        ON usu.emp_id = emp.emp_id
                                        WHERE usu.usr_id = :usr_id;');
        $stmt->execute(array('usr_id' => $user_id));

        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $usuarios[0]->emp_foto;
    }

    public function buscarxNombre($nombre) {
        $nombrec = "%" . $nombre . "%";
        $stmt = $this->objPdo->prepare("SELECT * FROM usuarios1 WHERE usr_nickname LIKE :nombrec;");
        $stmt->execute(array('nombrec' => $nombrec));
        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    public function restaurar_contrasena($id, $clave) {
        $stmt = $this->objPdo->prepare("UPDATE usuarios1 SET  usr_password = '$clave'
                                        WHERE usr_id = $id ");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    public function usuario_nombre($usuario) {
        $stmt = $this->objPdo->prepare("select u.usr_id,(e.emp_nombres||' '||e.emp_appaterno||' '||e.emp_apmaterno)as fullname from usuarios1 u
                                       INNER JOIN empleados e ON  e.emp_id = u.emp_id
                                       WHERE u.usr_nickname = '$usuario'");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    public function consultardpto() {
        $stmt = $this->objPdo->prepare('select * from dpto order by coddpto');
        $stmt->execute();
        $dpto = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $dpto;
    }

    public function getprovincia($depa_id) {
        $sql = "select * from provincia  where coddpto =:depa_id order by codprovi";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute(array('depa_id' => $depa_id));


        $provincias = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $provincias;
    }

    public function getdistrito($prov_id) {
        $sql = "select * from distrito where codprovi =:prov_id order by coddistri";

        $stmt = $this->objPdo->prepare($sql);

        $stmt->execute(array('prov_id' => $prov_id));


        $provincias = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $provincias;
    }
    
    
    function getArea() {
        return $this->area;
    }

    function getNombres() {
        return $this->nombres;
    }

    function setArea($area) {
        $this->area = $area;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    
    public function getUsr_id() {
        return $this->usr_id;
    }

    public function setUsr_id($usr_id) {
        $this->usr_id = $usr_id;
    }

    public function getUsr_nickname() {
        return $this->usr_nickname;
    }

    public function setUsr_nickname($usr_nickname) {
        $this->usr_nickname = $usr_nickname;
    }

    public function getUsr_password() {
        return $this->usr_password;
    }

    public function setUsr_password($usr_password) {
        $this->usr_password = $usr_password;
    }

    public function getUsr_estado() {
        return $this->usr_estado;
    }

    public function setUsr_estado($usr_estado) {
        $this->usr_estado = $usr_estado;
    }

    public function getUsr_fechinicio() {
        return $this->usr_fechinicio;
    }

    public function setUsr_fechinicio($usr_fechinicio) {
        $this->usr_fechinicio = $usr_fechinicio;
    }

    public function getEmp_id() {
        return $this->emp_id;
    }

    public function setEmp_id($emp_id) {
        $this->emp_id = $emp_id;
    }

    public function getPer_id() {
        return $this->per_id;
    }

    public function setPer_id($per_id) {
        $this->per_id = $per_id;
    }

    public function getDep_id() {
        return $this->dep_id;
    }

    public function setDep_id($dep_id) {
        $this->dep_id = $dep_id;
    }

    public function getDepa_id() {
        return $this->depa_id;
    }

    public function setDepa_id($depa_id) {
        $this->depa_id = $depa_id;
    }

}

?>
