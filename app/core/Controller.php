<?php

namespace app\core;

use app\traits\core\view;
use Exception;

abstract class Controller
{

    use view;

    /**
     * Instancia unica da controller
     * @return $this
     */
    public static function instance()
    {
        static $classes = [];
        $class = get_called_class();
        if (!isset($classes[$class])) {
            $classes[$class] = new $class;
        }
        return $classes[$class];
    }

    public function notfoundAction()
    {
        try {
            if (IS_AJAX) {
                return [
                    'message' => 'Ação inválida.',
                    'html' => 'Página não encontrada.',
                    'result' => 1,
                ];
            } else {
                echo 'Página inexistente';
            }
        } catch (Exception $ex) {
            echo 'Página inexistente!';
        }
    }

    function insertAction()
    {
        try {
            if (!method_exists($this, 'save')) {
                throw new Exception('Método Save não foi criado.');
            } else {
                return $this->save($this->voById());
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * Retorna a ValueObject
     * @param int $id
     * @return ValueObject
     * @throws Exception
     */
    function voById($id = null)
    {
        try {
            if (!method_exists($this, 'getModel')) {
                throw new Exception('O método getModel não foi criado.');
            }

            if (!$this->getModel() instanceof Model) {
                throw new Exception('O método getModel deve retorna uma ' . Model::class);
            }

            if ($id !== null) {
                if (!$v = $this->getModel()->getByLabel('id', $id)) {
                    throw new Exception('Registro inválido.');
                }
            } else {
                $v = $this->getModel()->newValueObject();
            }

            return $v;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Atualiza os dados do Registro
     * Envia para a função Save o id ($_POST['id'])
     */
    function updateAction()
    {
        try {

            if (!method_exists($this, 'save')) {
                throw new Exception('Método Save não foi criado.');
            } else {
                return $this->save($this->voById((int)inputPost('id')));
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

}
    