<?php
if (isset($_POST["filecode"])) {
    $noteToSave = $_POST["filecode"];
    $noteNameToSave = $_POST["zapis"];
    //$filteredData = substr($imageData, strpos($imageData, ",") + 1);
    //$unencodedData = base64_decode($filteredData);
    $fp = fopen("data/$noteNameToSave", "w");    // oznaczenie ../ odnosi się do lokalizacji o katalog wyżej
    fwrite($fp, $noteToSave);
    fclose($fp);
   }
?>