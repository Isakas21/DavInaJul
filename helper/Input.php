<?php

      /*
       * 
       */
      class Input
      {

          public static function siEnviado($tipo = 'post')
          {
              switch ($tipo)
              {
                  case 'post':
                      return ( ! empty($_POST)) ? true : false;
                      break;
//                  case 'get':
//                      return ( ! empty($_GET)) ? true : false;
//                      break;
                  default:
                      return false;  //aquí no llega
                      break;
              }
          }

          public static function get($dato) //SI
          {
              
              if (isset($_POST[$dato]))
              {                  
                  return $_POST[$dato];
              }                  
//              Si fuera GET
//              if (isset($_GET[$dato]))
//              {
//                  return $_GET[$dato];
//              }
              return "";
          }

      }
      