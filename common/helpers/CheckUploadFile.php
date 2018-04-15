<?php
 
namespace common\helpers;
use Yii;
use yii\web\UploadedFile;
 
//Хэлпер для сохранения файлов
class CheckUploadFile
{

    public $image_height;
    public $image_width;
    public $image;

	/**
	$maxfilesize - максимально допустимый размер файла
	$fullPath - полный путь до папки где будет сохранён файл
	$tumbWidth - ширина для конечного файла
	$tumbHeight - высота для конечного файла
	$fieldImage - поле из формы через которое отправляется файл
	$defaultName - имя картинки по умолчанию - можно оставить пустым
	**/

	public function checkImage($maxfilesize, $fullPath, $tumbWidth, $tumbHeight, $image,  $fileTypes = ['jpg','jpeg','gif','png'], $defaultName = false)
	{

        //return [0 => 'hi'];

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0775);
        }

		$defaultName = (!$defaultName) ? strtotime("now") : $defaultName;


    	try {

            $tumbWidth2 = $tumbWidth;
            $tumbHeight2 = $tumbHeight;


            $ext = (isset($image->extension)) ? strtolower($image->extension) : strtolower($image['extension']);

            $size = (isset($image->size)) ? $image->size : $image['size'];

            if (!$image){
                        throw new \Exception('Изображение не загружено ' . $image);
            }

            if($size > $maxfilesize){
                        throw new \Exception('Размер картинки превышает 10 мб');
            }

            $nameFile = $defaultName.'.'.$ext;

            $pathFile = $fullPath.$nameFile;

            if (is_object($image)) {
                if (!$image->saveAs($pathFile)){
                    throw new \Exception('Файл не был сохранён');
                }
            } else {

                if (!move_uploaded_file($image['tempFile'], $pathFile)){
                        throw new \Exception('Файл не был сохранён');
                }

            }

            if (!in_array(strtolower($ext), $fileTypes)) {
                    throw new \Exception('Не подходящий формат файла');
            }

            #Определяем размер фотографии — ширину и высоту
            $size = GetImageSize($pathFile);

            #Берём числовое значение ширины фотографии, которое мы получили в первой строке и записываем это число в переменную
            $this->image_width = $size[0];

            #Проделываем ту же операцию, что и в предыдущей строке, но только уже с высотой.
            $this->image_height = $size[1];

            $tumbWidth = (!$tumbWidth) ? $this->image_width : $tumbWidth;

            $tumbHeight = (!$tumbHeight) ? $this->image_height : $tumbHeight;
 
            if ($this->image_width >= $tumbWidth || $this->image_height >= $tumbHeight) {

                if(preg_match('/(GIF)|(gif)$/i', $ext)) {
                        #Создаём новое изображение из «старого»
                        $this->image=ImageCreateFromGIF ($pathFile);
                }
                if(preg_match('/(PNG)|(png)$/i', $ext)) {
                        #Создаём новое изображение из «старого»
                        $this->image=ImageCreateFromPNG ($pathFile);
                }
                if(preg_match('/(JPG)|(jpg)|(jpeg)|(JPEG)$/i', $ext)) {
                        #Создаём новое изображение из «старого»
                        //$this->image=ImageCreateFromJPEG ($pathFile);
                        //лучше так с правильной ориентацией
                        $oriantation = $this->exif_oriantation($pathFile);
                        $this->image = $oriantation[0];

                        //если ориэнтация поменялась меняем ширину на высоту и высоту на ширину
                        if ($oriantation[1]) {
                            $this->image_width = $this->image_height;
                            $this->image_height = $this->image_width;
                            $tumbWidth = $tumbHeight;
                            $tumbHeight = $tumbWidth;
                        }

                        if (!is_resource($this->image)) $this->image = ImageCreateFromJPEG($pathFile);

                }

                //Высчитываем пропорциональное уменьшение - размеры
                $h_o = $tumbWidth / ($this->image_width / $this->image_height);
                $w_o = $tumbHeight / ($this->image_height / $this->image_width);

                // создаём пустую квадратную картинку
                // важно именно truecolor!, иначе будем иметь 8-битный результат
                $dest = ImageCreateTrueColor($w_o, $h_o);

                if(preg_match('/(PNG)|(png)$/i', $ext)) {
                    imageAlphaBlending($dest, false);
                    imageSaveAlpha($dest, true);
                }

                #Данная функция копирует прямоугольную часть изображения в другое изображение, плавно интерполируя пикселные значения таким образом, что, в частности, уменьшение размера изображения сохранит его чёткость и яркость.
                ImageCopyResampled ($dest, $this->image, 0, 0, 0, 0, $w_o, $h_o, $this->image_width, $this->image_height);

                if (file_exists($pathFile)){
                        unlink ($pathFile);
                }


                if(preg_match('/(GIF)|(gif)$/i', $ext)) {
                    $nameFile = $defaultName.".gif";
                    $pathFile = $fullPath.$nameFile;
                    if (file_exists($pathFile)){
                        unlink ($pathFile);
                    }
                    imagepng($dest, $pathFile);
                }
                if(preg_match('/(PNG)|(png)$/i', $ext)) {
                    $nameFile = $defaultName.".png";
                    $pathFile = $fullPath.$nameFile;
                    if (file_exists($pathFile)){
                        unlink ($pathFile);
                    }
                    imagepng($dest, $pathFile);
                }
                if(preg_match('/(JPG)|(jpg)|(jpeg)|(JPEG)$/i', $ext)) {
                    $nameFile = $defaultName.".jpg";
                    $pathFile = $fullPath.$nameFile;
                    if (file_exists($pathFile)){
                        unlink ($pathFile);
                    }
                    imagejpeg($dest, $pathFile, 100);
                }

                return [
                        'namefile' => $nameFile, 
                        'success' => true, 
                        'height' => $h_o, 
                        'width' => $w_o
                ];

            } else {
                throw new \Exception("Минимальный размер фото {$tumbWidth}x{$tumbHeight}px.");
            }

            
        } catch (\Exception $ex) {
            
            return ['error' => $ex->getMessage(), 'success' => false];
        }

	}


    //Делаем правильную ориэнтацию картинки - только для jpg
    public function exif_oriantation($file_path, $bias = false)
    {

        $orientation=0;
        $f=fopen($file_path,'r');
        $tmp=fread($f, 2);
        if ($tmp==chr(0xFF).chr(0xD8)) {
            $section_id_stop=array(0xFFD8,0xFFDB,0xFFC4,0xFFDD,0xFFC0,0xFFDA,0xFFD9);
            while (!feof($f)) {
                $tmp=unpack('n',fread($f,2));
                $section_id=$tmp[1];
                $tmp=unpack('n',fread($f,2));
                $section_length=$tmp[1];
         
                // Началась секция данных, заканчиваем поиск
                if (in_array($section_id, $section_id_stop)) {
                    break;
                }
         
                // Найдена EXIF-секция
                if ($section_id==0xFFE1) {
                    $exif=fread($f,($section_length-2));
                    // Это действительно секция EXIF?
                    if (substr($exif,0,4)=='Exif') {
                        // Определить порядок следования байт
                        switch (substr($exif,6,2)) {
                            case 'MM': {
                                $is_motorola=true;
                                break;
                            }
                            case 'II': {
                                $is_motorola=false;
                                break;
                            }
                        }
                        // Количество тегов
                        if ($is_motorola) {
                            $tmp=unpack('N',substr($exif,10,4));
                            $offset_tags=$tmp[1];
                            $tmp=unpack('n',substr($exif,14,2));
                            $num_of_tags=$tmp[1];
                        }
                        else {
                            $tmp=unpack('V',substr($exif,10,4));
                            $offset_tags=$tmp[1];
                            $tmp=unpack('v',substr($exif,14,2));
                            $num_of_tags=$tmp[1];
                        }
                        if ($num_of_tags==0) { return true; }
         
                        $offset=$offset_tags+8;
         
                        // Поискать тег Orientation
                        for ($i=0; $i<$num_of_tags; $i++) {
                            if ($is_motorola) {
                                $tmp=unpack('n',substr($exif,$offset,2));
                                $tag_id=$tmp[1];
                                $tmp=unpack('n',substr($exif,$offset+8,2));
                                $value=$tmp[1];
                            }
                            else {
                                $tmp=unpack('v',substr($exif,$offset,2));
                                $tag_id=$tmp[1];
                                $tmp=unpack('v',substr($exif,$offset+8,2));
                                $value=$tmp[1];
                            }
                            $offset+=12;
         
                            // Orientation
                            if ($tag_id==0x0112) {
                                $orientation=$value;
                                break;
                            }
                        }
                    }
                }
                else {
                    // Пропустить секцию
                    fseek($f, ($section_length-2), SEEK_CUR);
                }
                // Тег Orientation найден
                if ($orientation) { break; }
            }
        }
        fclose($f);
         
        $image = imagecreatefromjpeg($file_path);
        if ($orientation) {
            switch($orientation) {
                // Поворот на 180 градусов
                case 3: {
                    $image=imagerotate($image,180,0);
                    break;
                }
                // Поворот вправо на 90 градусов
                case 6: {
                    $bias = true;
                    $image=imagerotate($image,-90,0);
                    break;
                }
                // Поворот влево на 90 градусов
                case 8: {
                    $bias = true;
                    $image=imagerotate($image,90,0);
                    break;
                }
            }
        }

        return [$image, $bias];

    }





}