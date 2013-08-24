<?php

class Sender 
{
    public static function getMessage($items)
    {
        $i = 0;
        $sumprice = 0;
        $model = Tovar::model()->with('customfields')->findAllByPk(array_keys($items));
        foreach ($model as $id => $item) {
            $customs = self::splitCustomFields($item->customfields);
            $string[] = "Название : " . $item->name . ",<br/> Цена : " . $item->price . " р <br/>";
            foreach ($items[$item->id] as $properties) {              
              $string[$i] .= ( isset($properties['param1']) && strlen($properties['param1']) > 0) ? $item->custom1 . " : " . $customs['customfield1'][ $properties['param1']]->name . "<br/>" : '';              
              $string[$i] .= ( isset($properties['param2']) && strlen($properties['param2']) > 0) ? $item->custom2 . " : " . $customs['customfield2'][ $properties['param2']]->name . "<br/>" : '';
              $string[$i] .= ( isset($properties['quantity'])) ? 'Количество : ' . $properties['quantity'] . '<br/>' : '';
            }    
            //$sumprice += $model->price1 * $items[$i]['quantity'];
            $i++;
        }       
        $message = "<b>Заказ</b> >><br/>".implode('<br/>-------------<br/>', $string).".</br><b>Общая стоимость: " . ContentModule::sumprice() . " р</b>";
        return $message;
    }  
    
    protected static function splitCustomFields($customfields)
    {
      $fields = array();
      foreach ($customfields as $custom) {
        ($custom->custom_id == 1) ? $fields['customfield1'][$custom->id] = $custom : $fields['customfield2'][$custom->id] = $custom;
      }
      return $fields;
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
        $response = true;
        $response = smsapi_push_msg_nologin('1905elena@rambler.ru', 'V8Qmvk4', $phone, $message, array('sender_name'  =>  $sender));
        return $response;
    }
    
    public static function Imgrenderer($picture, $subject = ''){
       return CHtml::image($picture, $subject, array ('title' => $subject, 'itemprop'=>'image')); 
    }        
}