<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/26/2017
 * Time: 5:33 PM
 */
set_error_handler(function() { /* ignore errors */ });
try{
    include_once("../classes/TimberBundle.php");
    include_once("../classes/TimberStock.php");
    include_once("../classes/Sale.php");
    include_once("../dbconnection.php");
}catch(ErrorException $err){

}
restore_error_handler();

function getAvailableTimberPieces($dbh,$timber_type){
    if ($dbh) {
        $sql = $dbh->prepare("SELECT * FROM shipment NATURAL JOIN bundle NATURAL JOIN bundle_pieces JOIN cross_section USING(cross_section_id) NATURAL LEFT OUTER JOIN price WHERE (bundle.type_id=? AND shipment.deleted='0') AND bundle.stock_no NOT IN (SELECT issue_pieces.stock_no FROM issue NATURAL JOIN issue_pieces WHERE issue.deleted='0') ORDER BY cross_section_id,stock_no,piece_length");
        $sql->execute(array($timber_type));
        if ($sql) {
            $result = $sql->fetchAll();
            $stock = new TimberStock();
            $stock->setTimberType($timber_type);
            foreach ($result as $item){
                $stock->addBundle($item["stock_no"],$item["bundle_no"],$item["shipment_id"],$item["arrival_date"],$item["cross_section_id"],$item["thickness"],$item["width"],$item["price"]);
                $stock->addPiece($item["stock_no"],$item["piece_length"],$item["piece_count"]);
            }
            return $stock;
        }
    }
    return null;
}

function getTimberTypes($dbh){
    if ($dbh) {
        $sql = $dbh->query("SELECT * FROM timber_type WHERE timber_type.deleted='0'");
        if ($sql) {
            $timber_types = array();
            foreach ($sql as $item){
                array_push($timber_types,array($item['type_id'],$item['timber_name']));
            }
            return $timber_types;
        }
    }
    return -1;
}

function doesCustomerExist($dbh,$customer_id){
    if ($dbh) {
        $sql = $dbh->prepare("SELECT * FROM customer WHERE customer_id=? AND deleted='0'");
        $sql->execute(array($customer_id));
        if ($sql) {
            $result = $sql->fetchAll();
            if(sizeof($result)==1){
                return true;
            }else{
                return false;
            }
        }
    }
    die("Connection error");
}

function getSale($dbh,$issueId){
    if ($dbh) {
        $sql = $dbh->prepare("SELECT * FROM (SELECT * FROM issue NATURAL JOIN issue_pieces WHERE issue.issue_id=? AND issue.deleted='0') AS iap NATURAL JOIN bundle_pieces NATURAL JOIN bundle JOIN timber_type USING(type_id) JOIN cross_section USING(cross_section_id)");
        $sql->execute(array($issueId));
        if ($sql) {
            $result = $sql->fetchAll();
            if(sizeof($result)>0){
                $sale = new Sale();
                $sale->setIssueId($result[0]["issue_id"]);
                $sale->setCustomerId($result[0]["customer_id"]);
                $sale->setIssueDate($result[0]["issue_date"]);
                $sale->setDiscount($result[0]["discount"]);
                foreach ($result as $piece){
                    $sale->addPiece($piece["stock_no"],$piece["timber_name"],$piece["thickness"],$piece["width"],$piece["piece_length"],$piece["sold_piece_count"],$piece["total_price"]);
                }
                return $sale;
            }else{
                return null;
            }
        }
    }
    die("Connection error");
}