<?php
/**
 * The file doc comment
 * php version 7.2.10
 * 
 * @category Class
 * @package  Package
 * @author   Original Author <author@example.com>
 * @license  https://www.cedcoss.com cedcoss 
 * @link     link
 */
require_once "../database_connection.php";
/**
 * Template Class Doc Comment
 * 
 * Template Class
 * 
 * @category Template_Class
 * @package  Template_Class
 * @author   Arjun <author@domain.com>
 * @license  https://www.cedcoss.com cedcoss
 * @link     http://localhost/
 */

class tbl_product extends DbConnect
{
   
    public function getMainCategory()
    {
        $sql="SELECT * FROM `tbl_product` WHERE `id`='1' AND `prod_parent_id`='0'";
        $data=$this->connect->query($sql);
        if ($data->num_rows>0) {
            $arr=array();
            while ($row=$data->fetch_assoc()) {
                $arr[]=$row;
            }
            return $arr;
        }
        return false;
    }
    /**
     * Product Description Addition
     *                 
     * @param productname $productname        
     * @param link        $link                  
     * 
     * @return productUpdate()
     */
    public function insertProductBYCategory($productname,$link) 
    {
        $sql="INSERT INTO `tbl_product` (`prod_parent_id`,`prod_name`,`html`,`prod_available`,`prod_launch_date`) 
        VALUES ('1','$productname','$link','1',NOW())";
        $data=$this->connect->query($sql);
        if ($data) {
            return $data;
        }
        return false;
    }
    public function duplicateCategoryCheck($catvalue) {
        $sql="SELECT * FROM `tbl_product` WHERE `prod_parent_id`='1' AND `prod_name` LIKE '$catvalue'";
        $data=$this->connect->query($sql);
        if ($data->num_rows>0) {
            return true;
        } 
        return false;
    }
    /**
     * Update Product Category
     *                
     * @param productname  $productname 
     * @param link         $link        
     * @param availability $availability           
     * @param id           $id                
     * 
     * @return productUpdate()
     */
    public function updateProductByCategory($productname, $link, $availability, $id) 
    {
        $sql="UPDATE `tbl_product` SET `prod_name`='$productname', `html`='$link',`prod_available`='$availability' WHERE `id` = '$id'";
        $data=$this->connect->query($sql);
        if ($data) {
            return true;
        }
        return false;
    }
    /**
     * Show Product         
     * 
     * @return productUpdate()
     */
    public function showProductBYCategory() 
    {
        $sql="SELECT * FROM `tbl_product` WHERE `prod_parent_id`='1'";
        $data=$this->conn->query($sql);
        $arr['data']=array();
        while ($row=$data->fetch_assoc()) {
            if ($row['prod_available']=='1') {
                $available="available";
            } else {
                $available="unavailable";
            }
            $prod_parent_id=$row['prod_parent_id'];
            $sql="SELECT * FROM `tbl_product` WHERE `id`='$prod_parent_id'";
            $roww=$this->connect->query($sql);
            $data1=$roww->fetch_assoc();
            $arr['data'][]=array($data1['prod_name'],$row['prod_name'],$row['html'],$available,$row['prod_launch_date'],"<a href='javascript:void(0)' class='btn btn-outline-info' data-id='".$row['id']."' id='edit-product-by-category' data-toggle='modal' data-target='#exampleModalSignUp'>Edit</a> <a href='javascript:void(0)' class='btn btn-outline-danger' data-id='".$row['id']."' id='delete-product-by-category'>Delete</a>");
        }
        return $arr;
    }
    /**
     * Show Product         
     * 
     * @return productUpdate()
     */
    public function showProductsBYCategory() 
    {
        $sql="SELECT `tbl_product`.*,`tbl_product_description`.* FROM tbl_product JOIN tbl_product_description ON `tbl_product`.`id` = `tbl_product_description`.`prod_id`";
        $data=$this->connect->query($sql);
        $arr['data']=array();
        while ($row=$data->fetch_assoc()) {
            if ($row['prod_available']=='1') {
                $available="available";
            } else {
                $available="unavailable";
            }
            $decoded_description=json_decode($row['description']);
            $webspace=$decoded_description->{'webspace'};
            $bandwidth=$decoded_description->{'bandwidth'};
            $freedomain=$decoded_description->{'freedomain'};
            $languagetechnology=$decoded_description->{'languagetechnology'};
            $mailbox=$decoded_description->{'mailbox'};
            $prod_parent_id=$row['prod_parent_id'];
            $sql="SELECT * FROM `tbl_product` WHERE `id`='$prod_parent_id'";
            $roww=$this->connect->query($sql);
            $data1=$roww->fetch_assoc();
            $arr['data'][]=array($data1['prod_name'],$row['prod_name'],$row['html'],$available,$row['prod_launch_date'],$row['mon_price'],$row['annual_price'],$row['sku'],$webspace,$bandwidth,$freedomain,$languagetechnology,$mailbox,"<a href='javascript:void(0)' class='btn btn-outline-info' data-id='".$row['prod_id']."' id='edit-product-by-category' data-toggle='modal' data-target='#exampleModalSignUp'>Edit</a> <a href='javascript:void(0)' class='btn btn-outline-danger' data-id='".$row['prod_id']."' id='delete-product-by-category'>Delete</a>");
        }
        return json_encode($arr);
    
    }
    /**
     * Manage Product 
     * 
     * @param id     $id                 
     * @param action $action              
     * 
     * @return productUpdate()
     */
    public function manageProductBYCategory($id, $action) 
    {
        if ($action=='edit') {
            $sql="SELECT * FROM `tbl_product` WHERE `id`='$id'";
            $data=$this->connect->query($sql);
            if ($data->num_rows>0) {
                while ($row=$data->fetch_assoc()) {
                    return $row;
                }
            }
            return false;
        }
        if ($action=="delete") {
            $sql="DELETE FROM `tbl_product` WHERE `id`='$id'";
            $this->conn->query($sql);
            $sql="SELECT * FROM `tbl_product` WHERE `prod_parent_id`='$id'";
            $data=$this->connect->query($sql);
            if ($data->num_rows>0) {
                while ($row=$data->fetch_assoc()) {
                    $id=$row['id'];
                    $sql="DELETE FROM `tbl_product_description` WHERE `prod_id`='$id'";
                    $this->connect->query($sql);
                    $sql="DELETE FROM `tbl_product` WHERE `id`='$id'";
                    $this->connect->query($sql);
                }
            }
            return true;
        }
    }
    /**
     * Manage Product By Category
     * 
     * @param id     $id                   
     * @param action $action                  
     * 
     * @return productUpdate()
     */
    public function manageProductsBYCategory($id, $action) 
    {
        if ($action=='edit') {
            $sql="SELECT `tbl_product`.*,`tbl_product_description`.* FROM tbl_product JOIN tbl_product_description ON `tbl_product`.`id` = `tbl_product_description`.`prod_id` WHERE `tbl_product`.`id`='$id'";
            $data=$this->connect->query($sql);            
            if ($data->num_rows>0) {
                $arr=array();
                while ($row=$data->fetch_assoc()) {
                    if ($row['prod_available']=='1') {
                        $available="available";
                    } else {
                        $available="unavailable";
                    }
                    $decoded_description=json_decode($row['description']);
                    $webspace=$decoded_description->{'webspace'};
                    $bandwidth=$decoded_description->{'bandwidth'};
                    $freedomain=$decoded_description->{'freedomain'};
                    $languagetechnology=$decoded_description->{'languagetechnology'};
                    $mailbox=$decoded_description->{'mailbox'};
                    $arr=array(
                        "prod_id"=>$row['prod_id'],
                        "sku"=>$row['sku'],
                        "mon_price"=>$row['mon_price'],
                        "annual_price"=>$row['annual_price'],
                        "prod_parent_id"=>$row['prod_parent_id'],
                        "prod_name"=>$row['prod_name'],
                        "link"=>$row['html'],
                        "available"=>$available,
                        "prod_launch_date"=>$row['prod_launch_date'],
                        "webspace"=>$webspace,
                        "bandwidth"=>$bandwidth,
                        "freedomain"=>$freedomain,
                        "languagetechnology"=>$languagetechnology,
                        "mailbox"=>$mailbox);
                }
                return $arr;
            }
            return false;
        }
        if ($action=="delete") {
            $sql="DELETE FROM `tbl_product_description` WHERE `prod_id`='$id'";
            if ($this->connect->query($sql)) {
                $sql="DELETE FROM `tbl_product` WHERE `id`='$id'";
                if ($this->connect->query($sql)) {
                    return true;
                }
                return false;
            }
            return false;
        }
    }
    /**
     * Show Product         
     * 
     * @return productUpdate()
     */
    public function getSubCategoryNav() 
    {
        $sql="SELECT * FROM `tbl_product` WHERE `prod_parent_id`='1' AND `prod_available`='1'";
        $data=$this->connect->query($sql);
        if ($data->num_rows>0) {
            $arr=array();
            while ($row=$data->fetch_assoc()) {
                $arr[]=$row;
            }
            return $arr;
        }
        return false;
    }
    /**
     * Product Description Addition
     *               
     * @param productcategory    $productcategory    
     * @param productname        $productname        
     * @param pageurl            $pageurl          
     * @param monthlyprice       $monthlyprice       
     * @param annualprice        $annualprice        
     * @param sku                $sku                
     * @param webspace           $webspace           
     * @param bandwidth          $bandwidth          
     * @param freedomain         $freedomain         
     * @param languagetechnology $languagetechnology 
     * @param mailbox            $mailbox            
     * 
     * @return productUpdate()
     */
    public function productDescriptionAddition($productcategory, $productname, $pageurl, $monthlyprice, $annualprice, $sku, $webspace, $bandwidth,  $freedomain, $languagetechnology, $mailbox) 
    {
        $sql="INSERT INTO `tbl_product` (`prod_parent_id`,`prod_name`,`html`,`prod_available`,`prod_launch_date`) 
        VALUES ('$productcategory','$productname','$pageurl','1',NOW())";
        if ($this->connect->query($sql)===true) {
            $last_id = $this->connect->insert_id;
            $description=array(
                "webspace"=>$webspace,
                "bandwidth"=>$bandwidth,
                "freedomain"=>$freedomain,
                "languagetechnology"=>$languagetechnology,
                "mailbox"=>$mailbox
            );
            $description=json_encode($description);
            $sql="INSERT INTO `tbl_product_description`(`prod_id`, `description`, `mon_price`, `annual_price`, `sku`) 
            VALUES ('$last_id','$description','$monthlyprice','$annualprice','$sku')";
            if ($this->connect->query($sql)===true) {
                return true;
            }
            return false;
        }
        return false;
    }
    /**
     * Updating Product
     * 
     * @param id                 $id                 
     * @param productcategory    $productcategory    
     * @param productname        $productname        
     * @param pageurl            $pageurl          
     * @param monthlyprice       $monthlyprice       
     * @param annualprice        $annualprice        
     * @param sku                $sku                
     * @param webspace           $webspace           
     * @param bandwidth          $bandwidth          
     * @param freedomain         $freedomain         
     * @param languagetechnology $languagetechnology 
     * @param mailbox            $mailbox            
     * 
     * @return productUpdate()
     */
    public function productUpdate($id,$productcategory, $productname, $pageurl, $monthlyprice, $annualprice, $sku, $webspace, $bandwidth,  $freedomain, $languagetechnology, $mailbox)
    {
        $sql="UPDATE `tbl_product` SET `prod_parent_id`='$productcategory',`prod_name`='$productname',`html`='$pageurl',`prod_available`='1',`prod_launch_date`=NOW() WHERE `id`='$id'";
        if ($this->conn->query($sql)===true) {
            $last_id = $this->connect->insert_id;
            $description=array(
                "webspace"=>$webspace,
                "bandwidth"=>$bandwidth,
                "freedomain"=>$freedomain,
                "languagetechnology"=>$languagetechnology,
                "mailbox"=>$mailbox
            );
            $description=json_encode($description);
            $sql="UPDATE `tbl_product_description` SET `description`='$description',`mon_price`='$monthlyprice',`annual_price`='$annualprice',`sku`='$sku' WHERE `prod_id`='$productcategory'";
            if ($this->connect->query($sql)===true) {
                return true;
            }
            return false;
        }
        return false;
    }
    public function getCatPageData($id)
    {
        $sql="SELECT `tbl_product`.*,`tbl_product_description`.* FROM tbl_product JOIN tbl_product_description ON `tbl_product`.`id` = `tbl_product_description`.`prod_id` WHERE `tbl_product`.`prod_parent_id`='$id'";
        $data=$this->connect->query($sql);            
        if ($data->num_rows>0) {
            $arr=array();
            while ($row=$data->fetch_assoc()) {
                if ($row['prod_available']=='0') {
                    continue;
                } else {
                    $available="available";
                }
                $decoded_description=json_decode($row['description']);
                $webspace=$decoded_description->{'webspace'};
                $bandwidth=$decoded_description->{'bandwidth'};
                $freedomain=$decoded_description->{'freedomain'};
                $languagetechnology=$decoded_description->{'languagetechnology'};
                $mailbox=$decoded_description->{'mailbox'};
                $arr[]=array(
                    "prod_id"=>$row['prod_id'],
                    "sku"=>$row['sku'],
                    "mon_price"=>$row['mon_price'],
                    "annual_price"=>$row['annual_price'],
                    "prod_parent_id"=>$row['prod_parent_id'],
                    "prod_name"=>$row['prod_name'],
                    "link"=>$row['html'],
                    "available"=>$available,
                    "prod_launch_date"=>$row['prod_launch_date'],
                    "webspace"=>$webspace,
                    "bandwidth"=>$bandwidth,
                    "freedomain"=>$freedomain,
                    "languagetechnology"=>$languagetechnology,
                    "mailbox"=>$mailbox
                );
            }
            return $arr;
        }
        return false;
    }
    public function addToCart($prodid)
    {
        $sql="SELECT `tbl_product`.*,`tbl_product_description`.* FROM tbl_product JOIN tbl_product_description ON `tbl_product`.`id` = `tbl_product_description`.`prod_id` WHERE `tbl_product`.`id`='$prodid'";
        $data=$this->connect->query($sql);            
        if ($data->num_rows>0) {
            $arr=array();
            while ($row=$data->fetch_assoc()) {
                if ($row['prod_available']=='0') {
                    continue;
                } else {
                    $available="available";
                }
                $decoded_description=json_decode($row['description']);
                $webspace=$decoded_description->{'webspace'};
                $bandwidth=$decoded_description->{'bandwidth'};
                $freedomain=$decoded_description->{'freedomain'};
                $languagetechnology=$decoded_description->{'languagetechnology'};
                $mailbox=$decoded_description->{'mailbox'};
                $arr=array(
                    "prod_id"=>$row['prod_id'],
                    "sku"=>$row['sku'],
                    "mon_price"=>$row['mon_price'],
                    "annual_price"=>$row['annual_price'],
                    "prod_parent_id"=>$row['prod_parent_id'],
                    "prod_name"=>$row['prod_name'],
                    "link"=>$row['html'],
                    "available"=>$available,
                    "prod_launch_date"=>$row['prod_launch_date'],
                    "webspace"=>$webspace,
                    "bandwidth"=>$bandwidth,
                    "freedomain"=>$freedomain,
                    "languagetechnology"=>$languagetechnology,
                    "mailbox"=>$mailbox
                );
            }
            return $arr;
        }
        return false;
    }
    public function getPageHeading($id) {
        $sql="SELECT * FROM `tbl_product` WHERE `id`='$id'";
        $data=$this->connect->query($sql);
        if ($data->num_rows>0) {
            return $data->fetch_assoc();
        } else {
            return false;
        }
       
    }
}
?>