<?php

namespace App\Classe;

use App\Entity\ShopProductSubCategory;
use App\Entity\ShopProductBrand;
use App\Entity\ShopProductSize;

class Search
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var string
     */
    public $q = '';

     /**
     * @var ShopProductSubCategory[]
     */
    public $SubCategory = [];

     /**
     * @var ShopProductBrand[]
     */
    public $brand = [];
     /**
     * @var ShopProductSize[]
     */
    public $size = [];


     /**
     * @var null|integer
     */
    public $max;

     /**
     * @var null|integer
     */
    public $min;

     /**
     * @var boolean
     */
    public $promo = false;

}