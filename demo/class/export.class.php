<?php 
   class Export {
      function fileToHex($file) {
         $handle = fopen($file, "r");
         $contents = fread($handle, filesize($file));
         fclose($handle);
         return '0x'.bin2hex($contents);
      }
      function createFile($file_name, $data) {
         if(!file_exists("cache/"))
            mkdir("cache/");
         file_put_contents('cache/'.$file_name, $data);
      }
      public function create($format, $type, $data = null) {
         switch($format) {
            case "jpg":
               switch($type) {
                  case "url":
                    return array(
                        "LabelURL" => "https://playground.courier.khaoscloud.com/samples/images/sample.jpg"
                     );
                  break;
                  case "data":
                     return array(
                        "RawLabelData" => $this->fileToHex('samples/images/sample.jpg')
                     );
                  break;
               }
            break;
            case "gif":
               switch($type) {
                  case "url":
                  return array(
                        "LabelURL" => "https://playground.courier.khaoscloud.com/samples/images/sample.gif"
                     );
                  break;
                  case "data":
                     return array(
                        "RawLabelData" => $this->fileToHex('samples/images/sample.jpg')
                     );
                  break;
               }
            break;
            case "png":
               switch($type) {
                  case "url":
                  return array(
                        "LabelURL" => "https://playground.courier.khaoscloud.com/samples/images/sample.png"
                     );
                  break;
                  case "data":
                     return array(
                        "RawLabelData" => $this->fileToHex('samples/images/sample.jpg')
                     );
                  break;
               }
            break;
            case "pdf":
               switch($type) {
                  case "url":
                  return array(
                        "LabelURL" => "https://playground.courier.khaoscloud.com/samples/pdf/sample.pdf"
                     );
                  break;
                  case "data":
                     return array(
                        "RawLabelData" => $this->fileToHex('samples/images/sample.jpg')
                     );
                  break;
               }
            break;
            case "html":
               switch($type) {
                  case "url":
                     $file_name = 'label'.time().'.html';
                     $_html = file_get_contents("samples/html/sample.html");
                     if($data && is_array($data)) {
                        foreach($data as $key => $value)
                           $_html = str_replace('['.strtoupper($key).']', $value, $_html);
                     }
                     $this->createFile($file_name, mb_convert_encoding($_html, 'UTF-16LE', 'UTF-8'));
                     return array(
                        "LabelURL" => "https://playground.courier.khaoscloud.com/cache/".$file_name
                     );
                  break;
               }
            break;
         }
         throw new Exception("format/type not supported ".$format."/".$type);
      }
   }
?>