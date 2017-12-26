<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 12/19/2017
 * Time: 3:12 PM
 */
function getTimberTypes($conn){
    if ($conn){
        $sql = 'SELECT timber_name,type_id FROM timber_type WHERE deleted=0 order by timber_name';
        $result=array();
        foreach ($conn->query($sql) as $row) {
            $type=new Timber();
            $type->setTimberName($row['timber_name']);
            $type->setTypeId($row['type_id']);
            array_push($result,$type);
        }
        return $result;
    }
}

function changeTimberName($conn,$id,$new){
    if($conn){
        $sql='UPDATE timber_type SET timber_name=? WHERE type_id=?';
        $query=$conn->prepare($sql);
        if($query->execute(array($new,$id))){
            return 1;
        }
    }
    return -1;

}

function deleteTimberType($conn,$id){
    if ($conn){
        $sql='UPDATE timber_type SET deleted=1 WHERE type_id=?';
        $query=$conn->prepare($sql);
        if($query->execute(array($id))){
            return 1;
        }
    }
    return -1;
}

function addTimberType($conn,$name){
    if($conn){
        $sql1='SELECT count(timber_name) FROM timber_type WHERE deleted=0 AND timber_name=?';
        $query=$conn->prepare($sql1);
        $query->execute(array($name));
        $find=$query->fetch();

        if ($find[0]==0){
            $sql2='INSERT INTO timber_type(timber_name) VALUES(?)';
            $query=$conn->prepare($sql2);
            if ($query->execute(array($name))){
                return 1;
            }
        }
        else{
            return 0;
        }
    }
    return -1;
}

function getTimberSizes($conn){
    if ($conn){
        $sql = 'SELECT * FROM cross_section WHERE deleted=0 order by thickness';
        $result=array();
        foreach ($conn->query($sql) as $row) {
            $timber=new Timber();
            $timber->setCrossSecId($row['cross_section_id']);
            $timber->setWidth($row['width']);
            $timber->setThickness($row['thickness']);
            array_push($result,$timber);
        }
        return $result;
    }
}

function changeTimberSize($conn,$id,$thickness,$width){
    if ($conn){
        $sql="UPDATE cross_section SET thickness=?,width=? WHERE cross_section_id=?";
        $query=$conn->prepare($sql);
        if($query->execute(array($thickness,$width,$id))){
            return 1;
        }
    }
    return -1;
}

function deleteTimberSize($conn,$id){
    if ($conn){
        $sql='UPDATE cross_section SET deleted=1 WHERE cross_section_id=?';
        $query=$conn->prepare($sql);
        if($query->execute(array($id))){
            return 1;
        }
    }
    return -1;
}

function addTimberSize($conn,$thickness,$width){
    if($conn){
        $sql1='SELECT count(cross_section_id) FROM cross_section WHERE deleted=0 AND thickness=? AND width=?';
        $query=$conn->prepare($sql1);
        $query->execute(array($thickness,$width));
        $find=$query->fetch();

        if ($find[0]==0){
            $sql2='INSERT INTO cross_section(thickness,width) VALUES(?,?)';
            $query=$conn->prepare($sql2);
            if ($query->execute(array($thickness,$width))){
                return 1;
            }
        }
        else{
            return 0;
        }
    }
    return -1;
}

function getTimberPrices($conn){
    if($conn){
        $sql="SELECT * FROM timber_type NATURAL JOIN cross_section LEFT OUTER JOIN price USING (type_id,cross_section_id) where deleted=0";
        $result=array();
        foreach ($conn->query($sql) as $row) {
            $timber=new Timber();
            $timber->setTimberName($row['timber_name']);
            $timber->setTypeId($row['type_id']);
            $timber->setCrossSecId($row['cross_section_id']);
            $timber->setPrice($row['price']);
            $timber->setThickness($row['thickness']);
            $timber->setWidth($row['width']);
            array_push($result,$timber);
        }
        return $result;
    }
}

function changeTimberPrice($conn,$typeId,$sizeId,$price,$oldPrice){
    if ($conn){
        if ($oldPrice!='') {
            $sql = "UPDATE price SET price=? WHERE cross_section_id=? AND type_id=?";
            $query = $conn->prepare($sql);
            if ($query->execute(array($price, $sizeId, $typeId))) {
                return 1;
            }
        }
        else{
            $sql2='INSERT INTO price(type_id,cross_section_id,price) VALUES(?,?,?)';
            $query=$conn->prepare($sql2);
            if ($query->execute(array($typeId,$sizeId,$price))){
                return 1;
            }
        }
    }
    return -1;
}