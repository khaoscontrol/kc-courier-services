<?php
/*
   This is the data received from Khaos Control when the user has assigned a package
   You can do whatever you want with this data, but for this example it will be stored in a TSV file
*/

// Get the POST data
$data = file_get_contents("php://input");
if (strlen($data) == 0) {
   throw new Exception("No POST data was received");
}

//if (!file_exists("output/post.txt")) {
   $fobject = fopen("output/post.txt", "w");
   fwrite($fobject, $data);
   fclose($fobject);
//}

$json = json_decode($data);
$json_error = json_last_error();
if ($json_error != JSON_ERROR_NONE || is_null($json) == true) {
   throw new Exception("JSON error was encountered: " . $json_error);
}

if (property_exists($json, "Items") == false || !$json->Items) {
   throw new Exception("No items were received");
}

// all the checks are in place, lets process them to a TSV file
$file_object = null;
$file_data = array();
$return_items = array();
$return_boxes = array();

// we're given an array of "Items", which contains a list of items, and a list of boxes
$output_file = null;
foreach ($json->Items as $index => $itemArray) {
   if (property_exists($itemArray, "Items") && $itemArray->Items) {
      $output_file = "output/courier_data-item-$index-items.tsv";
      $file_data = array();
      if (!file_exists($output_file)) {
         // create and add to output
         $file_object = fopen($output_file, "w");
         array_push($file_data, "ItemID\tQty\tStockID\tStockDesc\tUnitNet\tUnitTax\tNetTotal\tStockCode\tStockType\tManufCountry\tManufCountryCode3\tManufCountryCode2\tImportRef\tWeight");
      } else {
         $file_object = fopen($output_file, "a");
      }

      // loop through each line of items and add to array
      $return_consignment = array();
      foreach ($itemArray->Items as $i_index => $item) {
         array_push($file_data,
            "$item->ItemID\t" .
            "$item->QtyUser\t" .
            "$item->StockID\t" .
            "$item->StockDesc\t" .
            "$item->UnitNet\t" .
            "$item->UnitTax\t" .
            "$item->NetTotal\t" .
            "$item->StockCode\t" .
            "$item->StockType\t" .
            "$item->ManufCountry\t" . 
            "$item->ManufCountryCode3\t" .
            "$item->ManufCountryCode2\t" .
            "$item->ImportRef\t" .
            "$item->Weight"
         );

         array_push($return_items, array(
            "InvoiceID" => $itemArray->InvoiceID,
            "ItemID" => $item->ItemID,
            "IsSuccess" => true,
            "ConsignmentRef" => "Consignment Ref #$index$i_index",
            "Errors" => [],
            "LabelURL" => "https://api.kreports.io/v1_5/download/pdf?i=ebUn+VbSlzzz9EgTVgu+ieBSDF3eOQFwpmhfkua09/+7AbDoTnRz1uAhPBSX7KqsxhMdoMR6W3hkYdEQFOES3w=="
         ));
      }

      // add to the file
      if (sizeOf($file_data) > 0 && $file_object) {
         fwrite($file_object, implode("\r\n", $file_data));
         fclose($file_object);
      }
   }

   if (property_exists($itemArray, "Boxes") && $itemArray->Boxes) {
      foreach ($itemArray->Boxes as $b_index => $box) {
         $output_file = "output/courier_data-item-$index-box.tsv";
         $file_data = array();
         if (!file_exists($output_file)) {
            // create and add to output
            $file_object = fopen($output_file, "w");
            array_push($file_data, "ItemID\tBoxNote\tBoxNumber\tBoxWidth\tBoxDepth\tBoxHeight\tBoxPackagingWeight\tBoxWeightScaled\tBoxWeightCalculated");
         } else {
            $file_object = fopen($output_file, "a");
         }

         // now write the box information
         array_push($file_data,
            "$box->ItemID\t" .
            "$box->BoxNote\t" .
            "$box->BoxNumber\t" .
            "$box->BoxWidth\t" .
            "$box->BoxDepth\t" .
            "$box->BoxHeight\t" .
            "$box->BoxPackagingWeight\t" .
            "$box->BoxWeightScaled\t" .
            "$box->BoxWeightCalculated\t"
         );

         // store to the file
         if (sizeOf($file_data) > 0 && $file_object) {
            fwrite($file_object, implode("\r\n", $file_data));
            fclose($file_object);
         }

         if (property_exists($box, "items") == true && $box->items) {
            $output_file = "output/courier_data-item-$b_index-box.tsv";
            $file_data = array();
            if (!file_exists($output_file)) {
               // create and add to output
               $file_object = fopen($output_file, "w");
               array_push($file_data, "ItemID\tQty\tStockID\tStockDesc\tUnitNet\tUnitTax\tNetTotal\tStockCode\tStockType\tManufCountry\tManufCountryCode3\tManufCountryCode2\tImportRef\tWeight");
            } else {
               $file_object = fopen($output_file, "a");
            }

            // loop through each line of items and add to array
            foreach ($box->items as $bi_index => $boxitem) {
               array_push($file_data,
                  "$boxitem->ItemID\t" .
                  "$boxitem->QtyUser\t" .
                  "$boxitem->StockID\t" .
                  "$boxitem->StockDesc\t" .
                  "$boxitem->UnitNet\t" .
                  "$boxitem->UnitTax\t" .
                  "$boxitem->NetTotal\t" .
                  "$boxitem->StockCode\t" .
                  "$boxitem->StockType\t" .
                  "$boxitem->ManufCountry\t" . 
                  "$boxitem->ManufCountryCode3\t" .
                  "$boxitem->ManufCountryCode2\t" .
                  "$boxitem->IntrastatCode\t" .
                  "$boxitem->HarmonisationCode\t" .
                  "$boxitem->HarmonisationDesc\t" .
                  "$boxitem->Weight"
               );
            }

            // add to the file
            if (sizeOf($file_data) > 0 && $file_object) {
               fwrite($file_object, implode("\r\n", $file_data));
               fclose($file_object);
            }
         }

         array_push($return_items, array(
            "InvoiceID" => $itemArray->InvoiceID,
            "ItemID" => $box->ItemID,
            "IsSuccess" => true,
            "ConsignmentRef" => "Consignment Ref #B$index$b_index",
            "Errors" => [],
            "LabelURL" => "https://api.kreports.io/v1_5/download/pdf?i=ebUn+VbSlzzz9EgTVgu+ieBSDF3eOQFwpmhfkua09/+7AbDoTnRz1uAhPBSX7KqsxhMdoMR6W3hkYdEQFOES3w=="
         ));
      }
   }
}

$return = array(
   "Items" => $return_items
);

echo json_encode($return);
?>
