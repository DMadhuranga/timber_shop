<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 12/21/2017
 * Time: 10:10 PM
 */
include_once("../dbconnection.php");
include_once("timber_support.php");

if (isset($_REQUEST["changeTimberName"])){
    $id=$_REQUEST["id"];
    $newName=$_REQUEST["new"];
    $result=changeTimberName($dbh,$id,$newName);
    echo $result;
    exit;
}

if (isset($_REQUEST["deleteTimberName"])){
    $id=$_REQUEST["id"];
    $result=deleteTimberType($dbh,$id);
    echo $result;
    exit;
}

if (isset($_REQUEST["addNewTimberType"])){
    $name=$_REQUEST["name"];
    $result=addTimberType($dbh,$name);
    echo $result;
    exit;
}


if (isset($_REQUEST["changeTimberSize"])){
    $id=$_REQUEST["id"];
    $thickness=$_REQUEST["thickness"];
    $width=$_REQUEST["width"];
    $result=changeTimberSize($dbh,$id,$thickness,$width);
    echo $result;
    exit;
}

if (isset($_REQUEST["deleteTimberSize"])){
    $id=$_REQUEST["id"];
    $result=deleteTimberSize($dbh,$id);
    echo $result;
    exit;
}

if (isset($_REQUEST["addNewTimberSize"])){
    $thickness=$_REQUEST["thickness"];
    $width=$_REQUEST["width"];
    $result=addTimberSize($dbh,$thickness,$width);
    echo $result;
    exit;
}

if (isset($_REQUEST["changeTimberPrice"])){
    $typeId=$_REQUEST["typeId"];
    $sizeId=$_REQUEST["sizeId"];
    $price=$_REQUEST["price"];
    $oldPrice=$_REQUEST["oldPrice"];
    $result=changeTimberPrice($dbh,$typeId,$sizeId,$price,$oldPrice);
    echo $result;
    exit;
}

if (isset($_REQUEST["validateStockNo"])){
    $stockNo=$_REQUEST["stockNo"];
    $result=isStockNumberExists($dbh,$stockNo);
    echo $result;
    exit;
}
if (isset($_REQUEST["purchase"])) {
    $return = "error";
    $bid = $_REQUEST["buyer"];
    $shipment = $_REQUEST["shipment"];
    $invoice = $_REQUEST["invoice"];
    $arrivalDate = $_REQUEST["arrivalDate"];
    $date = date('Y-m-d');


    $vessel = $_REQUEST["vessel"];
    $remarks = $_REQUEST["remarks"];
    $dataString = $_REQUEST["dataString"];



    if ($dbh) {
        $error=false;
        $dbh->beginTransaction();
        $sql = $dbh->prepare("INSERT INTO shipment (buyer_id ,arrival_date,invoice_no,	vessel,shipment_name,remarks ) VALUES (?,?,?,?,?,?);");
        $sql->execute(array($bid,$arrivalDate,$invoice,$vessel,$shipment,$remarks));
        //$lastShipid = $sql->lastInsertID();
        if ($sql) {

            $shipmentId = $dbh->lastInsertId();
            $query = "INSERT INTO bundle (stock_no,bundle_no,shipment_id,cross_section_id,type_id) VALUES (?,?,?,?,?)";
            $data = explode("#####", $dataString);
            $bundles=array();
            $bundlePieces=array();


            //bundle array=> (stockNo ,bundleNo , sizeId , typeId)
            //bundlePieces=> ( [stockno,[length ,pieceCnt],[length2 ,pieceCnt2]])
            for ($i=1; $i<sizeof($data); $i++){
                $bundleData=explode("*****", $data[$i]);
                $tempArray=array();
                $sizeArray=array();
                array_push($sizeArray,$bundleData[0]);
                for ($j=0; $j<2;$j++) {
                    array_push($tempArray, $bundleData[$j]);
                }
                array_push($tempArray, $shipmentId);
                $size=getsizeID($dbh,$bundleData[2],$bundleData[3]);
                array_push($tempArray, $size);

                $type=getTimberID($dbh,$bundleData[4]);
                array_push($tempArray, $type);

                $cnt=5;
                while ($cnt<sizeof($bundleData)){
                    $tempSize=array();
                    //array_push($tempSize, $bundleData[0]);
                    array_push($tempSize, $bundleData[$cnt]);
                    array_push($tempSize, $bundleData[$cnt+1]);
                    array_push($sizeArray,$tempSize);
                    $cnt+=2;
                }

                array_push($bundlePieces,$sizeArray);
                array_push($bundles,$tempArray);
            }

            $sql = $dbh->prepare($query);


            foreach ($bundles as $bundle){
                $sql->execute($bundle);
                if (!$sql) {
                   /* $delete = $sql->prepare("DELETE FROM shipment WHERE id = :id LIMIT 1");
                    $delete->execute(array(':id' => $lastShipid));*/

                    $error=true;
                    $dbh->rollBack();
                }
            }

            if (!$error) {

                $parameters=array();
                for ($i = 0; $i < sizeof($bundlePieces); $i++) {


                    for ($j = 1; $j < sizeof($bundlePieces[$i]); $j++) {
                        $para=array();
                        array_push($para,$bundlePieces[$i][0]);
                        array_push($para,(int)$bundlePieces[$i][$j][0]);
                        array_push($para,(int)$bundlePieces[$i][$j][1]);
                        array_push($parameters,$para);
                        $sql = $dbh->prepare("INSERT INTO bundle_pieces (stock_no,	piece_length,piece_count) VALUES (?,?,?);");
                        $sql->execute($para);
                        if (!$sql) {

                            $error=true;
                            $dbh->rollBack();
                        }
                    }


                }

            }



           /* if (!$error) {
                $dbh->commit();
                if ($dbh) {
                    $return = $shipmentId;
                }
            } else {
                $dbh->rollBack();
            }*/
        } else {
            $error=true;
            $dbh->rollBack();
        }
        if (!$error) {

            $dbh->commit();
            if ($dbh) {
                $return="Shipment added!";
            }
        } else {

            $dbh->rollBack();
            $return = "error";
        }
    }
    echo $return;
    exit();
}