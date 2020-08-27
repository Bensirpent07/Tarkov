<?php
// Create array for ammo types. There's not too many ;)
    $ammoTypes = [
        "7.62x25mm_Tokarev",
        "9x18mm_Makarov",
        "9x19mm_Parabellum",
        "9x21mm_Gyurza",
        ".45_ACP",
        "4.6x30mm_HK",
        "5.7x28mm_FN",
        "5.45x39mm",
        "5.56x45mm_NATO",
        "7.62x39mm",
        "7.62x51mm_NATO",
        "7.62x54mmR",
        "9x39mm",
        ".366_TKM",
        "12.7x55mm_STs-130",
        "12.7x108mm",
        "12x70mm",
        "20x70mm",
        "30x29mm",
        "40x46_mm"
    ];
    //Create empty array for cartridges
    $cartridges = [];

    //Set property variable. Unable call property normally due to property name
    $prop = "*";

    //Set url for API
    $url = "https://escapefromtarkov.gamepedia.com";

    //Go through each ammo type and get each individual cartridge
    foreach($ammoTypes as $ammo){
        $action = "/api.php?action=parse&format=json&page=".$ammo."&prop=wikitext";

        //Submit GET request
        $data = file_get_contents($url.$action);

        //Decode JSON data and run regex
        $return = json_decode($data)->parse->wikitext->$prop;
        $ex = '/!\[\[((?!File).*?)\]\]/m';
        preg_match_all($ex, $return, $matches);

        //Push cartridges to array
        foreach ($matches[1] as $match){
            array_push($cartridges, array('id' => $match));
        }
    }

    //Cycle through each cartridge, collect variables, append to cartridges variable
    foreach ($cartridges as &$cartridge){
        //Set action to parse ammunition page
        $action = "/api.php?action=parse&format=json&page=".urlencode($cartridge['id'])."&redirects=1&prop=wikitext";

        //Submit GET request
        $data = file_get_contents($url.$action);

        //Decode JSON data
        $return = json_decode($data)->parse->wikitext->$prop;

        //Extract caliber
        $ex = '/(\d*\.*\d*\/*x*\d*)/m';
        preg_match($ex, $cartridge['id'], $matches, PREG_OFFSET_CAPTURE, 0);
        $cartridge['caliber'] = str_replace("/", "x", $matches[1][0]);

        //Search for damage
        $ex = '/(?<!armor )damage *?=(\d*)/m';
        preg_match($ex, $return, $matches, PREG_OFFSET_CAPTURE, 0);
        $cartridge['dmg'] = $matches[1][0];

        //Search for pen
        $ex = '/penetration *?=(\d+)/m';
        preg_match($ex, $return, $matches, PREG_OFFSET_CAPTURE, 0);
        $cartridge['pen'] = $matches[1][0];

        //Search for frag
        $ex = '/fragmentation *?=(\d\,*\.*\d*)/m';
        preg_match($ex, $return, $matches, PREG_OFFSET_CAPTURE, 0);
        $cartridge['frag'] = $matches[1][0];

        //Search for ricochet
        $ex = '/ricochet *?=(\d\,*\.*\d*)/m';
        preg_match($ex, $return, $matches, PREG_OFFSET_CAPTURE, 0);
        $cartridge['ric'] = $matches[1][0];

        //Search for bullet velocity
        $ex = '/velocity *?=(\d*)/m';
        preg_match($ex, $return, $matches, PREG_OFFSET_CAPTURE, 0);
        $cartridge['vel'] = $matches[1][0];

    }

    //Connect to MySQL
    $servername = 'localhost';
    $username = 'root';
    $password = '';

    try{
        $conn = new PDO("mysql:host=$servername;dbname=tarkov", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Connection failed, here's why: ".$e->getMessage();
    }

    //Cycle through cartridges and replace data
    //
    $id = 0;
    foreach($cartridges as $cartridge){
        //Prepare variables for SQL string
        $name = $cartridge['id'];
        $caliber = $cartridge['caliber'];
        $dmg = $cartridge['dmg'];
        $pen = $cartridge['pen'];
        $frag = $cartridge['frag'];
        $ric = $cartridge['ric'];
        $vel = $cartridge['vel'];

        /* Move variables into SQL string */
        $sql = "REPLACE INTO ammo (id, ammo_name, caliber, damage, pen, frag, ricochet, speed) VALUES ('$id', '$name', '$caliber', '$dmg', '$pen', '$frag', '$ric', '$vel')";

        /* Update table */
        try{
            $conn->exec($sql);
        }
        catch(PDOException $e){
            echo $sql . "<br>" . $e->getMessage();
        }
        $id++;
    }
    echo "Operation Successful!";
