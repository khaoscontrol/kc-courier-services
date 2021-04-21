<?php
   require "error.php";
   require "class/export.class.php";
   http_response_code(200);
   $json = null;
   try {  
      if(isset($_GET['q'])) {
         $page = explode("/",  $_GET['q']);
         $controller = $page[0];
         $action = @$page[1];
         $subaction = $page[2];
         if($action == "shipping")
            $action = "html";
         switch($controller) {
            case "user":
               $json = array("result" => "success");
            break; 
            case "shipping":
            case "export":
               $_data = file_get_contents('php://input');
               // debug
               $file = fopen("post.txt", 'w');
                fwrite($file, json_encode($_GET).'\r\n');
               fwrite($file, $_data);
               fclose($file);
               $data = mb_convert_encoding(
                  $_data,
                  "HTML-ENTITIES",
                  "UTF-8"
               );
               $data = (array) json_decode($data, true);
               $json = array(
                  "Items" => array()
               );
               $chars = "abcdefghijklmnopqrstuvwxyz";
               foreach($data["Items"] as $consignment) {
                  $consignment = (array) $consignment;
                  $boxes = sizeOf($consignment["Boxes"]);
                  if(!$boxes)
                     $boxes = 1;
                  for($i = 0; $i < $boxes; $i++) {
                     // response
                     $ref = "";
                     $track = "";
                     $x = strlen($chars)-1;
                     for($i = 0; $i < 12; $i++) {
                        $ref .= $chars[rand(0, $x)]; // rand ref
                        $track .= $chars[rand(0, $x)];
                     }
                     $export = new Export();
                     $output = $export->create($action, $subaction, array(
                        "ConsignmentRef" => $ref,
                        'INVOICECODE' => $consignment["InvoiceCode"], 
                        'SORDERCODE' => $consignment["SOrderCode"],
                        'FORENAME' => $consignment["DeliveryAddress"]["Forename"],
                        'SURNAME' => $consignment["DeliveryAddress"]["Surname"],
                        'ADDRESS1' =>  $consignment["DeliveryAddress"]["Address1"],
                        'ADDRESS2' => $consignment["DeliveryAddress"]["Address2"],
                        'TOWN' => $consignment["DeliveryAddress"]["Town"],
                        'COUNTY' => $consignment["DeliveryAddress"]["County"],
                        'ADDRTEL' => $consignment["DeliveryAddress"]["AddrTel"]
                        
                     ));
                     array_push($json["Items"], array_merge((array) $output, array(
                        "InvoiceID" => $consignment['InvoiceID'],
                        "ItemID" => "box".$i.'_'.$consignment['InvoiceID'],
                        "IsSuccess" => true,
                        "ConsignmentRef" => $ref.time(),
                        "TrackingNo" => strtoupper($track).time(),
                        "Errors" => []
                     )));
                  }
               }
            break;
            case "import":
               throw new Excpetion("Not supported yet");
            break;
            default:
               throw new Exception("Invalid controller/".$controller);
         }
      }
   } catch(Exception $e) {
      http_response_code(500);
      echo $e->getMessage();
      handleError("EX", $e->getMessage(), $e->getFile(), $e->getLine());
      exit;
   }
   if(isset($json)) {
      echo json_encode($json);
      $file = fopen("return.txt", 'w');
      fwrite($file, json_encode($json));
      fclose($file);
   }
   exit;
?>