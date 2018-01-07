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

function getTimberID($conn,$name){
    if ($conn){
        $sql1='SELECT type_id FROM timber_type WHERE deleted=0 AND timber_name=?';
        $query=$conn->prepare($sql1);
        $query->execute(array($name));
        $id=$query->fetchObject();
        if ($id->type_id==null){
            return -2;
        }
        return $id->type_id;
    }
    return -1;
}

function getsizeID($conn,$thickness,$width){
    if ($conn){
        $sql1='SELECT cross_section_id FROM cross_section WHERE deleted=0 AND thickness=? AND width=?';
        $query=$conn->prepare($sql1);
        $query->execute(array($thickness,$width));
        $id=$query->fetchObject();
        if ($id->cross_section_id==null){
            return -2;
        }
        return $id->cross_section_id;
    }
    return -1;
}

function isStockNumberExists($conn,$num){
    if ($conn){
        $sql="SELECT count(stock_no) FROM bundle WHERE stock_no=? ";
        $query=$conn->prepare($sql);
        $query->execute(array($num));
        $find=$query->fetch();
        if ($find[0]>0){
            return 1;
        }
        return 0;
    }
    return -1;
}

function getShipments($conn){
    if ($conn){
        $sql = 'SELECT * FROM shipment WHERE deleted=0 order by arrival_date DESC';
        $result=array();
        foreach ($conn->query($sql) as $row) {
            $shipment=new Shipment();
            $shipment->setShipmentId($row['shipment_id']);
            $shipment->setBuyerId($row['buyer_id']);
            $shipment->setArrivalDate($row['arrival_date']);
            $shipment->setInvoiceNo($row['invoice_no']);
            $shipment->setVessel($row['vessel']);
            $shipment->setShipmentName($row['shipment_name']);
            $shipment->setRemarks($row['remarks']);
            array_push($result,$shipment);
        }
        return $result;
    }
}

function getBuyerByID($conn,$id){
    if ($conn){
        $sql1='SELECT buyer_name FROM buyer WHERE deleted=0 AND buyer_id=?';
        $query=$conn->prepare($sql1);
        $query->execute(array($id));
        $obj=$query->fetchObject();
        if ($obj->buyer_name==null){
            return -2;
        }
        return $obj->buyer_name;
    }
    return -1;
}

function getShipmentById($conn,$id){
    if ($conn) {
        $sql = $conn->prepare('SELECT * FROM shipment WHERE deleted=0 AND shipment_id=?');
        $sql->execute(array($id));
        if ($sql) {
            $result = $sql->fetchAll();
            if(sizeof($result)>0) {
                $shipment = new Shipment();
                $shipment->setBuyerId($result[0]["buyer_id"]);
                $shipment->setArrivalDate($result[0]["arrival_date"]);
                $shipment->setInvoiceNo($result[0]["invoice_no"]);
                $shipment->setVessel($result[0]["vessel"]);
                $shipment->setShipmentName($result[0]["shipment_name"]);
                $shipment->setRemarks($result[0]["remarks"]);
                return $shipment;
            }
            else{
                return 0;
            }
        }

    }

    return -1;
}

function getBundles($conn,$ship_id){
    if ($conn){
        $sql=$conn->prepare("SELECT * FROM bundle left outer join bundle_pieces using(stock_no) WHERE shipment_id=?");
        $sql->execute(array($ship_id));
        if ($sql){
            $result=array();
            $data = $sql->fetchAll();
            if (sizeof($data)>0) {
                foreach ($data as $row) {
                    $bundle = new TimberBundle();
                    $bundle->setStockNo($row["stock_no"]);
                    $bundle->setBundleNo($row["bundle_no"]);
                    $bundle->setCrossSectionId($row["cross_section_id"]);
                    $bundle->setTypeId($row["type_id"]);
                    $bundle->setLength($row["piece_length"]);
                    $bundle->setCount($row["piece_count"]);
                    array_push($result, $bundle);
                }
                return $result;
            }
            else{
                return 0;
            }
        }
    }

    return -1;
}

function getTypeById($conn,$id){
    if ($conn) {
        $query=$conn->prepare('SELECT timber_name FROM timber_type WHERE deleted=0 AND type_id=?');
        $query->execute(array($id));
        $timber=$query->fetchObject();
        if ($timber->timber_name==null){
            return -2;
        }
        return $timber->timber_name;
    }
    return -1;
}

function getSizeById($conn,$id){
    if ($conn) {
        $query=$conn->prepare('SELECT thickness,width FROM cross_section WHERE deleted=0 AND cross_section_id=?');
        $query->execute(array($id));
        $timber=$query->fetchObject();
        $result=array();
        if ($timber->thickness==null){
            return -2;
        }
        array_push($result,$timber->thickness);
        array_push($result,$timber->width);
        return $result;
    }
    return -1;
}

function getLastShipmentId($conn){
    if ($conn){
        $sql="SELECT shipment_id from shipment order by shipment_id desc limit 1";
        $stmt = $conn->query($sql);
        $row =$stmt->fetchObject();
        return $row->shipment_id;
    }
}