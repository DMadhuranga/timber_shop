<?php

/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/26/2017
 * Time: 5:39 PM
 */
class TimberStock
{
    var $timberType;
    var $bundles;

    /**
     * @return mixed
     */
    public function getTimberType()
    {
        return $this->timberType;
    }

    /**
     * @param mixed $timberType
     */
    public function setTimberType($timberType)
    {
        $this->timberType = $timberType;
    }

    /**
     * @return mixed
     */
    public function getBundles()
    {
        return $this->bundles;
    }

    /**
     * @param mixed $bundles
     */
    public function addBundle($stockNo,$bundleNo,$shipmentId,$arrivalDate,$crossSectionId,$thickness,$width,$price)
    {
        if($this->bundles==null){
            $this->bundles = array();
        }
        if(!array_key_exists($stockNo,$this->bundles)){
            $obj = new TimberBundle();
            $obj->setStockNo($stockNo);
            $obj->setArrivalDate($arrivalDate);
            $obj->setBundleNo($bundleNo);
            $obj->setCrossSectionId($crossSectionId);
            $obj->setThickness($thickness);
            $obj->setWidth($width);
            $obj->setShipmentId($shipmentId);
            $obj->setPrice($price);
            $obj->setTypeId($this->timberType);
            $this->bundles[$stockNo] = $obj;
        }


    }

    public function addPiece($stockNo,$pieceLength,$pieceCount){
        $this->bundles[$stockNo]->addPiece($pieceLength,$pieceCount);
    }

}