<?php

/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/26/2017
 * Time: 5:40 PM
 */
class TimberBundle
{
    var $stockNo;
    var $bundleNo;
    var $shipmentId;
    var $typeId;
    var $crossSectionId;
    var $thickness;
    var $width;
    var $pieces;
    var $arrivalDate;
    var $price;

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getStockNo()
    {
        return $this->stockNo;
    }

    /**
     * @param mixed $stockNo
     */
    public function setStockNo($stockNo)
    {
        $this->stockNo = $stockNo;
    }

    /**
     * @return mixed
     */
    public function getBundleNo()
    {
        return $this->bundleNo;
    }

    /**
     * @param mixed $bundleNo
     */
    public function setBundleNo($bundleNo)
    {
        $this->bundleNo = $bundleNo;
    }

    /**
     * @return mixed
     */
    public function getShipmentId()
    {
        return $this->shipmentId;
    }

    /**
     * @param mixed $shipmentId
     */
    public function setShipmentId($shipmentId)
    {
        $this->shipmentId = $shipmentId;
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param mixed $typeId
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    /**
     * @return mixed
     */
    public function getCrossSectionId()
    {
        return $this->crossSectionId;
    }

    /**
     * @param mixed $crossSectionId
     */
    public function setCrossSectionId($crossSectionId)
    {
        $this->crossSectionId = $crossSectionId;
    }

    /**
     * @return mixed
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * @param mixed $thickness
     */
    public function setThickness($thickness)
    {
        $this->thickness = $thickness;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getPieces()
    {
        return $this->pieces;
    }

    /**
     * @param mixed $pieces
     */
    public function addPiece($pieceLength,$pieceCount)
    {
        if($this->pieces==null){
            $this->pieces = array();
        }
        array_push($this->pieces,array($pieceLength,$pieceCount));
    }

    /**
     * @return mixed
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * @param mixed $arrivalDate
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
    }

}