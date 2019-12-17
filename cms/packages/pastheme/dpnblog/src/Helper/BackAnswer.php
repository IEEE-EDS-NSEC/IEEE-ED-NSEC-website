<?php

namespace Pastheme\Blog\Helper;

use Pagekit\Application\Exception;

class BackAnswer
{

  /**
  * @example
  * $backanswer = new BackAnswer;
  * try {
  *   if (!$post) {
  *     $backanswer->abort(404 , 'Found Not Post');
  *   }
  *   return $backanswer->success( array() , 'Success Post');
  * } catch (\Exception $e) {
  *   return $backanswer->preturn();
  * }
  */

  public $BackError;

  public $BackMsg;

  /**
  * This helper created for Try and Catch
  * @param error [404 , 400]
  * @param msg [Not Found Category]
  */
  public function abort($error = null , $msg = '')
  {

    if (!empty($error)) {
      $this->BackError = $error;
    }

    if (!empty($msg)) {
      $this->BackMsg = $msg;
    }

    throw new Exception();

  }

  /**
  * This function can return msg that comes from abort
  */
  public function preturn()
  {
    if ( !empty($this->BackError) && !empty($this->BackMsg) ) {
      return [
        'status' => $this->BackError,
        'msg' => $this->BackMsg,
      ];
    }
    return [
      'status' => '400',
      'msg' => __('Not Message')
    ];
  }

  /**
  * This function compiles information that comes from the abort
  * @param msg [Post Saved]
  * @param data array()
  * @param status [default = 200]
  */
  public function success($data = array() , $msg = null , $status = 200)
  {
    if (empty($msg)) {
      $msg = __('Success');
    }

    return [
      'status' => $status,
      'msg' => $msg,
      'data' => $data
    ];
  }

}

?>
