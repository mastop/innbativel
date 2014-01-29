<?php

class AntifraudVars {

  public static function getGUID(){
      if (public static function_exists('com_create_guid')){
          return com_create_guid();
      }else{
          mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
          $charid = strtoupper(md5(uniqid(rand(), true)));
          $hyphen = chr(45);// "-"
          $uuid = chr(123)// "{"
              .substr($charid, 0, 8).$hyphen
              .substr($charid, 8, 4).$hyphen
              .substr($charid,12, 4).$hyphen
              .substr($charid,16, 4).$hyphen
              .substr($charid,20,12)
              .chr(125);// "}"
          return $uuid;
      }
  }

  public static function getGUID_semchave(){
      if (public static function_exists('com_create_guid')){
          return com_create_guid();
      }else{
          mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
          $charid = strtoupper(md5(uniqid(rand(), true)));
          $hyphen = chr(45);// "-"
          $uuid = substr($charid, 0, 8).$hyphen
              .substr($charid, 8, 4).$hyphen
              .substr($charid,12, 4).$hyphen
              .substr($charid,16, 4).$hyphen
              .substr($charid,20,12);
          return $uuid;
      }
  }

  public static function generate_order_id(){
      $charid = strtoupper(uniqid(rand(100, 999)));
      $hyphen = chr(45);// "-"
      $uuid = substr($charid, 0, 4).$hyphen
             .substr($charid, 4, 4).$hyphen
             .substr($charid,8, 4).$hyphen
             .substr($charid,12, 16);
      return $uuid;
  }

  $MerchantId                = "{663B1F6B-4B06-4EF0-DAAD-70B14E17FC63}";
  $MerchantIdAF                = "663B1F6B-4B06-4EF0-DAAD-70B14E17FC63";
  $OrgId                     = "1snn5n9w";
  $MerchantReferenceCode     = generate_order_id();

  $ambiente_pagador = 'production';
  $url_transacao = 'https://pagador.com.br/webservice/pagadorTransaction.asmx?WSDL';
  $url_antifraud = 'https://antifraude.braspag.com.br/AntiFraudeWS/AntiFraud.asmx?WSDL';
  $url_boleto = 'https://pagador.com.br/webservices/pagador/Boleto.asmx?WSDL';

  public static function explodeFirstLastName($fullname){
    $names = explode(" ", $fullname);
    echo $pieces[0]; // piece1
    echo $pieces[1]; // piece2
  }

  public static function get_real_ip()
  {
    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
      return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
      return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
      return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
      return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
      return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
      return $_SERVER["REMOTE_ADDR"];
    }
  }

  public static function card_type_2_code($card_type){
    switch ($card_type) {
      case "Visa":
        return 500;
        break;

      case "Mastercard":
        return 501;
        break;

      case "AmericanExpress":
        return 502;
        break;

      case "DinersClub":
        return 503;
        break;

      case "Elo":
        return 504;
        break;

      case "Discover":
        return 543;
        break;

      case "JCB":
        return 544;
        break;

      case "Aura":
        return 545;
        break;
    }
  }

  public static function validateInstallment($installment, $total, $donation){
  		if($installment < 1 || $installment > 12){
  			return false;
  		}

  		$limite_parcelamento = 12;

  		$total += ($donation == true) ? 1 : 0;

  		if($total <= 251){
  			$limite_parcelamento = 3;
  		}
  		else if($total <= 501){
  			$limite_parcelamento = 6;
  		}

  		if($installment > $limite_parcelamento){
  			return false;
  		}
  		else{
  			return true;
  		}
  	}

  public static function antifraud_status_code_2_string($status_code){
    switch ($status_code) {
      case 500:
        return 'iniciado';
        break;

      case 501:
        return 'aprovado';
        break;

      case 502:
        return 'revisao';
        break;

      case 503:
        return 'rejeitado';
        break;

      case 504:
        return 'pendente';
        break;

      case 505:
        return 'nao_finalizado';
        break;

      case 506:
        return 'abortado';
        break;

      default:
        return 'abortado';
        break;
    }
  }

}
