<?php

namespace app\models\helpers;

use app\core\Model;
use app\core\ValueObject;
use app\helpers\Utils;
use app\vo\helpers\ArquivoVO;

class ArquivosModel extends Model
{

    public function __construct()
    {
        $this->table = 'sis_arquivos';
        $this->valueObject = ArquivoVO::class;
    }

    /**
     * Envia arquivo para o servidor
     * @param ValueObject $vo
     * @param string $fileKey
     * @param string $ref
     */
    public static function addArquivo(ValueObject $vo, $fileKey, $ref = null)
    {

        $file = !empty($_FILES[$fileKey]) ? $_FILES[$fileKey] : null;

        # Verificando o upload
        if ($file and is_uploaded_file($file['tmp_name'])) {

            # Nome do arquivo
            $filename = uniqid($vo->getTable() . '_') . '.' . Utils::getFileExtension($file['name']);

            # Movendo arquivo
            move_uploaded_file($file['tmp_name'], abs_source_files($filename));

            # Excluíndo arquivo antigo
            $old = self::getArquivo($vo, $ref);
            if ($old) {
                $old->excluir();
            }

            # Salvando o registro
            self::newValueObject()->save([
                'reftable' => $vo->getTable(),
                'ref' => $ref,
                'refid' => $vo->getId(),
                'source' => $filename,
            ]);
        }
    }

    /**
     * Retorna o arquivo pela referência
     * @param ValueObject $vo
     * @param string $ref
     * @return ArquivoVO
     */
    public static function getArquivo(ValueObject $vo, $ref = null)
    {
        return current(self::lista('WHERE a.reftable = :reftable AND (:ref IS NULL AND a.ref IS NULL OR a.ref = :ref) AND a.refid = :refid LIMIT 1', [
            'reftable' => $vo->getTable(),
            'ref' => $ref,
            'refid' => $vo->getId(),
        ]));
    }

}
    