<?php

namespace app\traits\ctrl;

use app\core\Model;
use app\core\ValueObject;

trait excluir
{

    public function excluirAction()
    {
        try {

            if (!method_exists($this, 'getModel')) {
                throw new \Exception('O método getModel não foi criado na controller');
            }

            /** @var Model $model */
            $model = $this->getModel();

            $v = $model->getByLabel('token', inputPost('id') ?: inputPost('token'));

            if (!$v instanceof ValueObject) {
                throw new \Exception('Registro inválido');
            }

            $v->Save(['status' => 99]);

            return [
                'message' => 'Registro excluído com sucesso',
                'result' => 1,
            ];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}