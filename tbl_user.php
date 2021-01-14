<?php

require_once ('database_connection.php');

class tbl_user extends DbConnect
{
    /*
    signup paged code start here
    now here create function

    */
   public function signup($name, $email, $mobile, $securityQuestion, $securityAnswer, $password)
    {
        $sql="INSERT INTO `tbl_user` (`email`,`name`,`mobile`,`email_approved`,
        `phone_approved`,`active`,`is_admin`,`sign_up_date`,`password`,
        `security_question`,`security_answer`)
        VALUES ('$email','$name','$mobile','0','0','0','0',NOW(),
        '$password','$securityquestion','$answer')";
        if ($this->connect->query($sql)) {
            return true;
        }
        return false;
    }
    public function uniqueDetail($email, $mobile)
    {
        $sql="SELECT * FROM `tbl_user`";
        $data=$this->connect->query($sql);
        if ($data->num_rows>0) {
            while ($row=$data->fetch_assoc()) {
                if ($row['email']==$email || $row['mobile']==$mobile) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }
    public function login($email, $password)
    {
        $sql = "SELECT * FROM `tbl_user` WHERE `email` = '$email' AND `password` = '$password'";
        $data = $this->connect->query($sql);
        if($data->num_rows>0)
        {
           $row = $data->fetch_assoc();
           if($row['is_admin']== 0 && $row['active']== 1)
           {
            $_SESSION['user']=array($row['email'],$row['id']);
            header('Location:index.php');
           }elseif($row['is_admin']== 1 && $row['active']== 1)
           {
            $_SESSION['admin']=array($row['id'],$row['email'],$row['name']);
            header('Location:admin/');
           }else{
               return $row;
           }
        }
        return false;
    }
    public function verifyEmail($email) {
        $sql="UPDATE `tbl_user` SET `active` = '1',`email_approved`='1' WHERE `email` = '$email'";
        $data=$this->connect->query($sql);
        return true;
    }
    
    public function verifyPhone($phone) {
        $sql="UPDATE `tbl_user` SET `active` = '1',`phone_approved`='1' WHERE `mobile` = '$phone'";
        $data=$this->connect->query($sql);
        return true;
    }
}

?>