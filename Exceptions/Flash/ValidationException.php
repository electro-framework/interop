<?php
namespace Selenia\Exceptions\Flash;

use Selenia\Exceptions\FlashMessageException;
use Selenia\Exceptions\FlashType;

class ValidationException extends FlashMessageException
{
  const OTHER             = 0;
  const REQUIRED_FIELD    = 1;
  const INVALID_NUMBER    = 2;
  const INVALID_DATE      = 3;
  const PASSWORD_MISMATCH = 4;
  const INVALID_EMAIL     = 5;
  const DUPLICATE_RECORD  = 6;
  const INVALID_DATETIME  = 7;
  const INVALID_VALUE     = 8;

  public static $messages = [
    self::OTHER             => '',
    self::REQUIRED_FIELD    => "Por favor preencha o campo '#'.",
    self::INVALID_NUMBER    => "Por favor introduza um número válido no campo #.",
    self::INVALID_DATE      => "Por favor introduza uma data válida (aaaa-mm-dd) no campo #.",
    self::PASSWORD_MISMATCH => "As senhas não são iguais.",
    self::INVALID_EMAIL     => "Por favor introduza um endereço de e-mail válido no campo #.",
    self::DUPLICATE_RECORD  => "Não é permitida a inserção de um registo duplicado.<br/>Rectifique o campo #.",
    self::INVALID_DATETIME  => "Por favor introduza uma data e hora válidas (aaaa-mm-dd hh:mm:ss) no campo #.",
    self::INVALID_VALUE     => "Valor inválido para o campo #."
  ];

  public $fieldName;

  public function __construct ($code, $fieldName, $msg = null)
  {
    $this->code      = $code;
    $this->fieldName = $fieldName;
    if (is_null ($msg))
      parent::__construct (str_replace ('#', "<b>$fieldName</b>", self::$messages[$code]), FlashType::WARNING);
    else
      parent::__construct ($msg, FlashType::WARNING);
  }

}
