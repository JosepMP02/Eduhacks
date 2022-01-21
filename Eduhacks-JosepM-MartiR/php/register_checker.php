<?php

require_once('connecta_db_persistent.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["password"]) && isset($_POST["password2"])){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $password = $_POST["password"];
        $vpassword = $_POST["password2"];

        if($password != $vpassword){
            header("Location:../register.php?redirected=2&username=$username&mail=$email&fname=$fname&lname=$lname");
        }else{

            $sql = 'SELECT * FROM users WHERE (UPPER(username)=UPPER(:usrFilt) OR UPPER(mail)=UPPER(:mailFilt))'; 
            $verificaExistent = $db->prepare($sql);
            $verificaExistent->execute(array(":usrFilt"=>$username,":mailFilt"=>$email));
            $NumUsersExistents = $verificaExistent->rowCount();

            if($NumUsersExistents >= 1){
                header("Location:../register.php?redirected=3&username=$username&mail=$email&fname=$fname&lname=$lname");
            }else{

                $passHash = password_hash($password,PASSWORD_DEFAULT);
                
                try{
                    $sql = 'INSERT INTO users (username,mail,userFirstName,userLastName,passHash,creationDate,active) VALUES (:username,:mail,:fname,:lname,:passHash,CURTIME(),:active);';
                    $usuaris = $db->prepare($sql);
                    $usuaris->execute(array(":username"=>$username,":mail"=>$email,":fname"=>$fname,":lname"=>$lname,":passHash"=>$passHash,":active"=>"1"));
                    
                }catch(PDOException $e){
                    echo 'Error amb la BDs: ' . $e->getMessage();
                }
                header("Location:../index.php?redirected=0&username=$username");
            }
        }
    }else{
        header("Location:../register.php?redirected=1");
    }
}else{
    header("Location:../register.php?redirected=1");
}