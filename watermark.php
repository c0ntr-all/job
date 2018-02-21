<? 

waterMark($_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'], "watermark.png"); 

function waterMark($original, $watermark) { 
   $original = urldecode($original);
   //получаем размеры оригинала и ватермарка в виде массива, где 0 - ширина, 1 - высота, 2 - тип в числе (1-gif, 2-jpeg,3-png), mime - тип для заголовка image/jpeg например
   $info_o = @getImageSize($original); 
   if (!$info_o) 
         return false; 
   $info_w = @getImageSize($watermark); 
   if (!$info_w) 
         return false;
   $original = @imageCreateFromString(file_get_contents($original)); 
   $watermark = @imageCreateFromString(file_get_contents($watermark)); 
   $water_width = imagesx($watermark);
   $water_height = imagesy($watermark);
   //Задаем параметры ширины и высоты ватермарка в зависимости от оригинала
   $percent_w = $info_o[0] * 0.25;
   $percent_h = $info_o[1] * 0.25;
   $water_stamp = imagecreatetruecolor($percent_w, $percent_h);
   header("Content-type: ".$info_o['mime']);
   //Сохраняем прозрачность ватермарка
   imagealphablending($water_stamp, false);
   imagesavealpha($water_stamp, true);
   //ресайзим ватермарк
   imagecopyresampled($water_stamp, $watermark, 0, 0, 0, 0, $percent_w, $percent_h, $water_width, $water_height);
   //задаем координаты расположения ватермарка от левого края ширина оригинала - ширина ватера - отступ, точно также по высоте начиная с верха
   $x = $info_o[0] - $percent_w - 10;
   $y = $info_o[1] - $percent_h - 10;
   //накладываем ватермарк
   imageCopy($original, $water_stamp, $x, $y, 0, 0, $percent_w, $percent_h);
   //выводим в соответствии с типом файла
   switch ($info_o[2]) { 
      case 1: 
         imageGIF($original); 
         break; 
      case 2: 
         imageJPEG($original); 
         break; 
      case 3: 
         imagePNG($original); 
         break; 
         } 
   //очищаем память
   imageDestroy($original); 
   imageDestroy($watermark);
   imageDestroy($water_stamp); 

   return true; 
   } 

?>