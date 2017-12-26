<?php

/**
 * Created by PhpStorm.
 * User: AVAARM
 * Date: 12/21/2017
 * Time: 11:25 PM
 */
class Timber
{
    var $timber_name;
    var $type_id;
    var $cross_sec_id;
    var $width;
    var $thickness;
    var $price;

    /**
     * @return mixed
     */
    public function getTimberName()
    {
        return $this->timber_name;
    }

    /**
     * @param mixed $timber_name
     */
    public function setTimberName($timber_name)
    {
        $this->timber_name = $timber_name;
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * @return mixed
     */
    public function getCrossSecId()
    {
        return $this->cross_sec_id;
    }

    /**
     * @param mixed $cross_sec_id
     */
    public function setCrossSecId($cross_sec_id)
    {
        $this->cross_sec_id = $cross_sec_id;
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


}