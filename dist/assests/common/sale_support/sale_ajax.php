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