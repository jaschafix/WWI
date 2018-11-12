<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php include("includes/db_connection.php"); ?>
    </head>
    <body>
    <?php 
    
    $naam = "shirt"; //variabel voor de sql query
    //variabel voor de knop om hem makkelijk toetevoegen in de forms
    $knop = "<button form='" . $naam . 
            "' formmethod='GET' ". 
            "type='submit'". 
            "'>toevoegen aan winkelmand</button>";
    $aantalFormulier = "<input type='text' "
            . "form='". $naam .""
            . "'formmethod='GET' "
            . "name='". $naam .""
            . "'>";
    
    print("<form name=' . $naam . '>");//Formulier maken voor de knop om te testen
    
    //knop die over gekopieerd moet worden
    print($aantalFormulier);
    print($knop);
    
    //geen php injection test voor de waardes van get
    $waardeWinkelmand = filter_input(INPUT_GET, $naam, FILTER_SANITIZE_STRING);
    //if(filter_has_var(INPUT_GET, $naam)){
        print_r($_GET);
    //}
    ?>
    </form>
    </body>
</html>