<?php
namespace Selenia\Exceptions\Flash;

class ImageException extends FileException
{

  public static $messages = [
    self::FILE_IS_REQUIRED      => "Tem de seleccionar um ficheiro de imagem.",
    self::FILE_IS_INVALID       => "Tipo de ficheiro não suportado. Por favor seleccione uma imagem no formato JPEG, GIF, PNG ou BMP.",
    self::CAN_NOT_SAVE_FILE     => "Não é possível guardar o ficheiro no servidor. Verifique as permissões da pasta respectiva: ",
    self::FIELD_NOT_FOUND       => "O campo especificado não existe no formulário.",
    self::CAN_NOT_DELETE_FILE   => "Não é possível remover o ficheiro do servidor. Verifique as permissões da pasta respectiva: ",
    self::CAN_NOT_SAVE_TMP_FILE => "Não é possível criar um ficheiro temporário no servidor. Verifique as permissões da pasta temporária e o espaço em disco disponível.",
    self::FILE_TOO_BIG          => "O ficheiro excede o tamanho máximo permitido de "
  ];

  public function __construct ($code, $extra = '')
  {
    parent::__construct (self::$messages[$code] . $extra, self::$statusLookup[$code]);
  }

}
