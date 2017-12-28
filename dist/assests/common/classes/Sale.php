<?php

/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/28/2017
 * Time: 7:45 PM
 */
class Sale
{
    var $issueId;
    var $customerId;
    var $customer;
    var $issueDate;
    var $discount;
    var $pieces;

    /**
     * @return mixed
     */
    public function getIssueId()
    {
        return $this->issueId;
    }

    /**
     * @param mixed $issueId
     */
    public function setIssueId($issueId)
    {
        $this->issueId = $issueId;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * @param mixed $issueDate
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
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
    public function addPiece($stockNo,$timberType,$thickness,$width,$pieceLength,$pieceCount,$totalPrice)
    {
        if($this->pieces==null){
            $this->pieces = array();
        }
        if(!array_key_exists($stockNo,$this->pieces)){
            $this->pieces[$stockNo] = array();
        }
        $temp = array($timberType,$thickness,$width,$pieceLength,$pieceCount,$totalPrice);
        array_push($this->pieces[$stockNo],$temp);
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        $ttl = 0;
        foreach ($this->pieces as $bundle){
            foreach ($bundle as $piece){
                $ttl+=$piece[5];
            }
        }
        return $ttl;
    }

    /**
     * @param mixed $total
     */
    public function getAmount()
    {
        return $this->getTotal()-$this->getDiscount();
    }



}