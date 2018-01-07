<?php

/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 1/6/2018
 * Time: 3:51 PM
 */
class Shipment
{
    var $shipment_id;
    var $buyer_id;
    var $arrival_date;
    var $invoice_no;
    var $vessel;
    var $shipment_name;
    var $remarks;

    /**
     * @return mixed
     */
    public function getShipmentId()
    {
        return $this->shipment_id;
    }

    /**
     * @param mixed $shipment_id
     */
    public function setShipmentId($shipment_id)
    {
        $this->shipment_id = $shipment_id;
    }

    /**
     * @return mixed
     */
    public function getBuyerId()
    {
        return $this->buyer_id;
    }

    /**
     * @param mixed $buyer_id
     */
    public function setBuyerId($buyer_id)
    {
        $this->buyer_id = $buyer_id;
    }

    /**
     * @return mixed
     */
    public function getArrivalDate()
    {
        return $this->arrival_date;
    }

    /**
     * @param mixed $arrival_date
     */
    public function setArrivalDate($arrival_date)
    {
        $this->arrival_date = $arrival_date;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNo()
    {
        return $this->invoice_no;
    }

    /**
     * @param mixed $invoice_no
     */
    public function setInvoiceNo($invoice_no)
    {
        $this->invoice_no = $invoice_no;
    }

    /**
     * @return mixed
     */
    public function getVessel()
    {
        return $this->vessel;
    }

    /**
     * @param mixed $vessel
     */
    public function setVessel($vessel)
    {
        $this->vessel = $vessel;
    }

    /**
     * @return mixed
     */
    public function getShipmentName()
    {
        return $this->shipment_name;
    }

    /**
     * @param mixed $shipment_name
     */
    public function setShipmentName($shipment_name)
    {
        $this->shipment_name = $shipment_name;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;
    }



}