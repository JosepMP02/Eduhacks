<?php
    require_once("./connecta_db_persistent.php");
    session_start();
    if(isset($_POST['username']) && isset( $_POST['password'])){

        $usuarioPost = $_POST['username'];
        $usuario = strtoupper($usuarioPost);
        $paswd = $_POST['password'];
        
        try{
            $sql = 'SELECT iduser,CONCAT(UPPER(SUBSTRING(userFirstName,1,1)),LOWER(SUBSTRING(userFirstName,2))) as userFirstName,CONCAT(UPPER(SUBSTRING(userLastName,1,1)),LOWER(SUBSTRING(userLastName,2))) as userLastName,username,passhash,active 
                    FROM `users` 
                    WHERE (UPPER(username)=:filtre OR UPPER(mail)=:filtre) 
                    LIMIT 1';
            $consulta = $db->prepare($sql);
            $consulta->execute(array(":filtre"=>$usuario,":filtreHash"=>$paswd));

            $res = $consulta->rowCount();
            
            foreach($consulta as $registro){
                $iduser = $registro['iduser'];
                $username = $registro['username'];
                $userFirstName = $registro['userFirstName'];
                $userLastName = $registro['userLastName'];
                $hash = $registro['passhash'];
                $activo = $registro['active'];
            }

            if($res == 1 && password_verify($paswd,$hash)){
                if($activo == 1){
                    $_SESSION['username'] = $username;
                    setcookie('nombre',$userFirstName." ".$userLastName,time()+3600,"/");
                    
                    $sql = 'UPDATE users SET lastSignIn = CURTIME() WHERE iduser = :iduser';
                    $update = $db->prepare($sql);
                    $update->execute(array(":iduser"=>$iduser));

                    header("Location:../home.php");
                }else{
                    header("Location:../index.php?redirected=4");
                }
            }else{
                header("Location:../index.php?redirected=2&username=$usuarioPost");
            }                
        }catch(PDOException $e){}
    }else{
        header("Location:../index.php?redirected=1");
    }
?>
