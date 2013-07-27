<?php

class Sender 
{
    public static function getMessage($items)
    {
        $i = 0;
        $sumprice = 0;
        $model = Tovar::model()->with('customfield1', 'customfield2')->findAllByPk(array_keys($items));
        foreach ($model as $id => $item) {            
            $string[] = "Название : " . $item->name . ",<br/> Цена : " . $item->price1 . " р <br/>";
            foreach ($item as $properties) {
              $string[$i] .= ( isset($properties['param1'])) ? $item->custom1 . " : " . $item->customfield1[ $properties['param1']]->name . "<br/>" : '';              
              $string[$i] .= ( isset($properties['param2'])) ? $item->custom2 . " : " . $item->customfield2[ $properties['param2']]->name . "<br/>" : '';
              $string[$i] .= ( isset($properties['quantity'])) ? 'Количество : ' . $properties['quantity'] . '<br/>' : '';
            }    
            //$sumprice += $model->price1 * $items[$i]['quantity'];
            $i++;
        }        
        $message = "<b>Заказ</b> >><br/>".implode('<br/>-------------<br/>', $string).".</br><b>Общая стоимость: " . ContentModule::sumprice() . " р</b>";
        return $message;
    }        
    
    public static function sendCartbyMailtoAdmin($items, $model)
    {
      $person = "Контактная информация:<br/>
        Имя :" . $model->person . ",<br/>
        Телефон :" . $model->phone . ",<br/>    
        Эл.почта :" . $model->email . ",<br/>  
        Адрес доставки :" . $model->adress . ",<br/>
        Дополнительная информация :" . $model->additionalinfo . "
        ";
      $orderbody = Sender::getMessage($items);
      $message = $person."<br/><hr><br/>" . $orderbody;
      $subject = Yii::app()->name . ': новый заказ';
      Sender::sendMail(Yii::app()->params['adminEmail'], $subject, $message, Yii::app()->params['adminEmail']);
    }
    
    public static function sendCartbyMailtoUser($recipientemail, $items)
    {
      $message = Sender::getMessage($items).'<br/> <b>Спасибо за Ваш заказ. Мы обязательно с Вами свяжемся в ближайшее время.</b>';
      $subject = 'Ваш заказ на сайте: '.Yii::app()->name;
      Sender::sendMail($recipientemail, $subject, $message, Yii::app()->params['adminEmail']);
    }    
    
    
    public static function sendMail($recipientemail,$subject,$message,$senderemail) {
        $headers = "MIME-Version: 1.0\r\nFrom: ".Yii::app()->name."<$senderemail>\r\nReply-To: $senderemail\r\nContent-Type: text/html; charset=utf-8";
        $message = wordwrap($message, 70);
        $message = str_replace("\n.", "\n..", $message);
        return mail($recipientemail,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
    }  
    
    public static function sendSMS($phone, $message, $sender)
    {
        require_once dirname(__FILE__).'../../sms/sms24x7.php';                
        $response = smsapi_push_msg_nologin('gorillamen@mail.ru', 'RqKh6yw', $phone, $message, array("sender_name"=>$sender));
        return $response;
    }
    
    public static function Imgrenderer($picture, $subject = ''){
       return CHtml::image($picture, $subject, array ('title' => $subject, 'itemprop'=>'image')); 
    }        
}