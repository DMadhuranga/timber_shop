<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/26/2017
 * Time: 5:34 PM
 */
set_error_handler(function() { /* ignore errors */ });
try{
    include_once("sale_support.php");
    include_once("../classes/TimberBundle.php");
    include_once("../classes/TimberStock.php");
    include_once("../dbconnection.php");
}catch(ErrorException $err){

}
restore_error_handler();

if(isset($_REQUEST["timberAvailableData"])){
    $timberType = $_REQUEST["timberType"];
    $stock = getAvailableTimberPieces($dbh,$timberType);
    $return = "";
    if ($stock==null){
        $return = "error";
    }elseif($stock->getBundles()==null){
        $return = "empty";
    }else{
        $return = "<table class='table table-hover' id='resultTable'>
                  <thead>
                    <tr>
                      <th>Stock No</th>
                      <th>Bundle No</th>
                      <th>Shipment ID</th>
                      <th>Arrival Date</th>
                      <th>Dimension</th>
                      <th>Unit Price</th>
                      <th>Piece Length</th>
                      <th>Piece Count</th>
                    </tr>
                  </thead>
                  <tbody>";
        foreach($stock->getBundles() as $bundle){
            $lenghts = "";
            $counts = "";
            $cnt = 0;
            foreach ($bundle->getPieces() as $piece){
                if($cnt!=0){
                    $lenghts = $lenghts."</br>";
                    $counts = $counts."</br>";
                }
                $lenghts = $lenghts.$piece[0];
                $counts = $counts.$piece[1];
                $cnt++;

            }
            $return = $return."<tr onclick='addThisBundle(this)'><td>".$bundle->getStockNo()."</td><td>".$bundle->getBundleNo()."</td><td>".$bundle->getShipmentId()."</td>
            <td>".$bundle->getArrivalDate()."</td><td data-crossSectionId='".$bundle->getCrossSectionId()."'>".$bundle->getThickness()." X ".$bundle->getWidth()."</td><td>".$bundle->getPrice()."</td>
            <td>".$lenghts."</td><td>".$counts."</td></tr>";
        }
        $return = $return."</tbody>
                </table>";
    }
    echo $return;
    exit();
}

if(isset($_REQUEST["makeSale"])){
    $return = "error";
    $cid = $_REQUEST["customer_id"];
    $discount = $_REQUEST["discount"];
    $dataString = $_REQUEST["dataString"];
    $date = date("Y-m-d");
    if($dbh){
        $dbh->beginTransaction();
        $sql = $dbh->prepare("INSERT INTO issue (customer_id,issue_date,discount) VALUES (?,?,?);");
        $sql->execute(array($cid,$date,$discount));
        if($sql){
            $issueId = $dbh->lastInsertId();
            $query = "INSERT INTO issue_pieces (issue_id,stock_no,piece_length,sold_piece_count,total_price) VALUES ";
            $bundles = explode("####",$dataString);
            $pieces = array();
            foreach ($bundles as $item){
                $temp = explode("****",$item);
                if(sizeof($temp)==4){
                    array_push($pieces,$temp);
                }

            }
            $bundles = array();
            $paras = array();
            foreach ($pieces as $item){
                if($item[2]>0){
                    $bundles[$item[0]] = "";
                }
            }
            foreach ($pieces as $item){
                if(array_key_exists($item[0],$bundles)){
                    array_push($paras,$issueId);
                    array_push($paras,$item[0]);
                    array_push($paras,$item[1]);
                    array_push($paras,$item[2]);
                    array_push($paras,$item[3]);
                    $query = $query." ("."?".","."?".","."?".","."?".","."?"."),";
                }
            }
            $query = substr($query,0,strlen($query)-1);
            $sql = $dbh->prepare($query);
            $sql->execute($paras);
            if($sql){
                $dbh->commit();
                if($dbh){
                    $return = $issueId;
                }
            }else{
                $dbh->rollBack();
            }
        }else{
            $dbh->rollBack();
        }
    }
    echo $return;
    exit();
}