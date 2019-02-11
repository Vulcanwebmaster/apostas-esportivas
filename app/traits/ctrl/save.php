<?php

namespace app\traits\ctrl;

use app\core\ValueObject;
use app\models\HistoricoModel;
use app\modules\admin\Admin;

trait save
{

    public function save(ValueObject $v)
    {
        try {

            $novo = $v->getId() ? "alterou" : "cadastrou";

            $v->save(inputPost());

            if (!empty($_FILES['upimg'])) {
                $v->imgAddCapa('upimg', null, true);
            }

            $user = Admin::getLogged();

            if ($user) {
                HistoricoModel::add("O usuário `{$user->getLogin()}` {$novo} o registro {$v->getTable()} #{$v->getId()}", $v, $user);
            } else {
                HistoricoModel::add("{$novo} o registro {$v->getTable()}", $v);
            }

            return ['result' => 1, 'message' => 'Salvo com sucesso'];
        } catch (\Exception $ex) {
            return $ex;
        }
    }

}