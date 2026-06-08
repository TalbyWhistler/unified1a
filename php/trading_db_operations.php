<?php 
    
    function fetchCities()
    {
        include 'trading_db_connect.php';
        $stmt=$conn->prepare("select distinct city from commodity");
        $returnMessage='';
        $stmt=$conn->prepare("select distinct city from commodities");
        $outputArray=[];
        if ($stmt->execute())
            {
               // $returnMessage='data';
                $results=$stmt->get_result();
                while ($row=$results->fetch_assoc())
                    {
                        $returnMessage=$returnMessage.' '.$row["city"];
                        array_push($outputArray,$row["city"]);
                    }
                return $outputArray;
            }
            else 
                {
                    $returnMessage='no data';
                }
       
        
        return $returnMessage;
    }

    function fetchCommodities()
    {
        include 'trading_db_connect.php';
        $stmt=$conn->prepare("select distinct commodity from commodity");
        $returnMessage='';
        $stmt=$conn->prepare("select distinct commodity from commodities");
        $outputArray=[];
        if ($stmt->execute())
            {
                //$returnMessage='data';
                $results=$stmt->get_result();
                while ($row=$results->fetch_assoc())
                    {
                        $returnMessage=$returnMessage.' '.$row["commodity"];
                        array_push($outputArray,$row["commodity"]);
                    }
                return $outputArray;
            }
            else 
                {
                    $returnMessage='no data';
                }
       
        
        return $returnMessage;
    }

    function fetchCityInfo($city)
    {
        include 'trading_db_connect.php';
        $stmt=$conn->prepare("select commodity,buyingprice,sellingprice from commodities where city=?");
        $stmt->bind_param("s",$city);
        $returnMessage='';
        $outputArray=[];
        
        if ($stmt->execute())
            {
                $returnMessage='fetch city statement executed';
                $results=$stmt->get_result();
                while ($row=$results->fetch_assoc())
                    {
                        $unitArray=['commodity'=>$row["commodity"],'buyingPrice'=>$row["buyingprice"],'sellingPrice'=>$row["sellingprice"]];
                        array_push($outputArray,$unitArray);
                    }
                return $outputArray;
            }
            else 
                {
                    $returnMessage='fetch city no data';
                }
        return $returnMessage;
    }

    function fetchCommodityInfo($commodity)
    {
        include 'trading_db_connect.php';
        $stmt=$conn->prepare("select city,buyingprice,sellingprice from commodities where commodity=?");
        $stmt->bind_param("s",$commodity);
        $returnMessage='';
        $outputArray=[];
        if ($stmt->execute())
            {
                $results=$stmt->get_result();
                while ($row=$results->fetch_assoc())
                    {
                        $unitArray=['city'=>$row["city"],'buyingPrice'=>$row["buyingprice"],'sellingPrice'=>$row["sellingprice"]];
                        array_push($outputArray,$unitArray);
                    }
                return $outputArray;
            }
            else 
                {
                    $returnMessage="Didn't execute";
                }
        return $returnMessage;

    }

    function inputRecord($city,$commodity,$buyingPrice,$sellingPrice)
    {
        include 'trading_db_connect.php';
        $stmt=$conn->prepare('delete from commodities where city=? and commodity=?');
        $stmt->bind_param("ss",$city,$commodity);
        $stmt->execute();
        $stmt=$conn->prepare("insert into commodities values(?,?,?,?)");
        $stmt->bind_param("ssii",$city,$commodity,$buyingPrice,$sellingPrice);
        if ($stmt->execute())
            {
                $returnMessage='Record updated';
            }
            else 
                {
                    $returnMessage='Record update failed';
                }
        return $returnMessage;
    }


    function getTradeRouteByCity($city)
    {
        include 'trading_db_connect.php';
        $returnMessage='getTradeRoutesByCity '.$city;
        $outputArray=[];
        
        $stmt=$conn->prepare
        ('
            select c1.commodity "commodity",c2.city "from",c1.city "to",c1.buyingPrice-c2.sellingPrice "profit"   
                from commodities c1
                join commodities c2 
                ON
                c1.commodity=c2.commodity 
                where c1.buyingPrice>c2.sellingPrice 
                and not c1.city=c2.city 
                and not c2.sellingPrice=0
                and c2.city=? -- c2 city that trading is from c1 is trading to
                order by profit desc;
        ');
        $stmt->bind_param("s",$city);
        if ($stmt->execute())
            {
                $returnMessage='statment executed';
                $results=$stmt->get_result();
                while ($row=$results->fetch_assoc())
                    {
                        $unitArray=['commodity'=>$row["commodity"],'from'=>$row["from"],'to'=>$row["to"],'profit'=>$row["profit"]];
                        array_push($outputArray,$unitArray);
                    }
                //$returnMessage=$outputArray;
                $stmt=$conn->prepare
                ('
                    select c1.commodity "commodity",c2.city "from",c1.city "to",c1.buyingPrice-c2.sellingPrice "profit"   
                        from commodities c1
                        join commodities c2 
                        ON
                        c1.commodity=c2.commodity 
                        where c1.buyingPrice>c2.sellingPrice 
                        and not c1.city=c2.city 
                        and not c2.sellingPrice=0
                        and c1.city=? -- c2 city that trading is from c1 is trading to
                        order by profit desc;
                ');
                $stmt->bind_param("s",$city);
                if ($stmt->execute())
                    {
                        $results=$stmt->get_result();
                        while ($row=$results->fetch_assoc())
                            {
                                $unitArray=['commodity'=>$row["commodity"],'from'=>$row["from"],'to'=>$row["to"],'profit'=>$row["profit"]];
                                array_push($outputArray,$unitArray);
                            }
                        $returnMessage=$outputArray;
                    }

                    }
                    else 
                        {
                            $returnMessage='didn\'t execute';
                        }
        return $returnMessage;
    }

    function getTradeRouteByCommodity($commodity)
    {
        include 'trading_db_connect.php';
        $returnMessage='getTradeRoutesByCommodity '.$commodity;
        $outputArray=[];
        $stmt=$conn->prepare(
            '
            select 
                    c1.city "from",
                    c2.city  "to",
                    c2.buyingPrice-c1.sellingPrice "profit"
                from commodities c1 
                join commodities c2
                on c1.commodity=c2.commodity 
                where 
                c1.sellingPrice<c2.buyingPrice 
                and 
                not c1.sellingPrice=0
                and c2.commodity=?
                order by profit desc
            '
        );
        $stmt->bind_param("s",$commodity);
        if ($stmt->execute())
            {
                $returnMessage='routes by commodity statment 1 executed';
                $results=$stmt->get_result();
                while ($row=$results->fetch_assoc())
                    {
                        $unitArray=['from'=>$row["from"],'to'=>$row["to"],'profit'=>$row["profit"]];
                        array_push($outputArray,$unitArray);
                    }
                $returnMessage=$outputArray;
            }
            else 
                {
                    $returnMessage='routes by commodity statement 1 failed';
                }
        return $returnMessage;
    }

?>