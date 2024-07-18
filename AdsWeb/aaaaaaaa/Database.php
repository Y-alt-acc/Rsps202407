<?php

    function readRspsDatabase()
    {
        $rspsDatabaseAds = fopen("rspsDatabaseAds.csv", "r");
        while(!feof($rspsDatabaseAds)) {
            fgetcsv($rspsDatabaseAds);
        }
        fclose($rspsDatabaseAds);
    }

    class rspsAds
    {
        // private $rspsDatabaseAds;
        private $name;
        private $filePath;
        private $expiredDate;
        // function __construct()
        // {
        //     $this->rspsDatabaseAds = new rspsDatabase();
        // }
        function add($name, $expiredDate)
        {
            $this->name = $name;
            $this->expiredDate = $expiredDate;
            $this->filePath = $name . date("Y-m-d-h-i-s");
        }
        function changeName($name)
        {
            $this->name = $name;
        }
        function changeExpiredDate($expiredDate)
        {
            $this->expiredDate = $expiredDate;
        }
        function writeImg()
        {
            
        }
        function readImg()
        {
            
        }
    }

?>
