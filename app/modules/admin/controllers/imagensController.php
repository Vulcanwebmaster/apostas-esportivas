<?php

namespace app\modules\admin\controllers;

use app\APP;
use app\core\Controller;
use app\helpers\Seo;
use app\models\helpers\ImagensModel;
use app\traits\ctrl\excluir;
use app\traits\ctrl\status;
use app\vo\helpers\ImageVO;
use Exception;

class imagensController extends Controller
{

    /**
     * Abre a página de imagens
     */
    function indexAction()
    {
        if (!IS_AJAX) {
            APP::getInstanceController('index')->Layout('<div class="module" >'
                . '<header>'
                . '<h3>' . (inputGet('title') ? inputGet('title') : 'Imagens') . '</h3>'
                . '</header>'
                . '<div class="module-content" style="margin: 0 0 -5px 0; padding: 10px;" >'
                . '<iframe id="frame-imagens" src="' . url('imagens/iframe', null, null, inputGet()) . '" class="iframe-autosize" style="height: 600px; padding: 0; margin: 0; box-sizing: content-box; border: none; width: 100%;" >'
                . '</iframe>'
                . '</div>'
                . '<footer>'
                . formButton('Nova imagem', 'button', 'btn-primary', null, null, ['onClick' => '_log($("#frame-imagens").contents()[0]);'])
                . '</footer>'
                . '</div>');
        }
    }

    function iframeAction()
    {

        Seo::reset();

        Seo::setTitle('Imagens');

        Seo::addCss("admfiles/plugins/bootstrap/css/bootstrap.min.css");
        Seo::addCss("admfiles/css/custom.css");
        Seo::addCss('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');

        Seo::addJs("cdn/js/jquery.min.js");
        Seo::addJs("admfiles/plugins/jquery-ui/jquery-ui.min.js");
        Seo::addJs("admfiles/plugins/bootstrap/js/bootstrap.min.js");
        Seo::addJs("cdn/js/jquery.form.js");
        Seo::addJs("cdn/js/jquery.serializeObject.js");
        Seo::addJs("cdn/js/jquery.mask.js");
        Seo::addJs("cdn/js/mask.js");
        Seo::addJs("cdn/js/fastclick.js");
        Seo::addJs("cdn/js/modernizr.min.js");
        Seo::addJs("cdn/js/admin.js");

        $this->view('admin/sys/imagens',[
            'vars' => inputGet(),
        ]);
    }

    /**
     * Lista as imagens
     */
    function listAction()
    {

        /* @var $img ImageVO */
        $imagens = ImagensModel::lista('WHERE a.ref = :ref AND ((a.refid = :refid AND a.reftemp IS NULL) OR (a.refid = 0 AND a.reftemp = :reftemp)) AND a.status != 99 ORDER BY a.position ASC', [
            'ref' => inputPost('ref'),
            'refid' => inputPost('refid'),
            'reftemp' => inputPost('reftemp'),
        ]);

        $data = [];

        foreach ($imagens as $img) {
            $data[] = [
                'id' => $img->getId(),
                'status' => $img->getStatus(),
                'source' => $img->Redimensiona(250, 250, 'proporcional'),
                'title' => $img->getTitle(),
                'legenda' => $img->getLegenda(),
            ];
        }

        return $data;
    }

    function uploadAction()
    {
        try {

            /* @var $img ImageVO */
            $img = ImagensModel::newValueObject();

            $img
                ->input('ref')
                ->input('refid')
                ->input('reftemp');

            $img = current($this->getModel()->salvaImage($img, 'imagem', true, false));
            if (!$img) {
                throw new Exception('Não foi possível enviar a imagem.');
            }

            file_put_contents(abs_source('http_x'), @$_SERVER['HTTP_X_REQUESTED_WITH']);

            return [
                'message' => 'Imagem enviada com sucesso.',
                'dados' => [
                    'id' => $img->getId(),
                    'token' => $img->getToken(),
                    'title' => $img->getTitle(),
                    'status' => $img->getStatus(),
                    'legenda' => $img->getLegenda(),
                    'source' => $img->Redimensiona(250, 250, 'proporcional'),
                ],
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return [
                'message' => $ex->getMessage(),
                'result' => 0,
            ];
        }
    }

    /** @return ImagensModel */
    function getModel()
    {
        return ImagensModel::Instance();
    }

    /**
     * Salva uma imagem
     */
    function Save(ImageVO $img)
    {
        try {

            if (!$img->getId()) {
                $img
                    ->input('ref')
                    ->input('refid')
                    ->input('reftemp');
            } else if ($img->getRef() != inputPost('ref') or $img->getRefId() != inputPost('refid')) {
                throw new Exception('Referências inválidas.');
            }

            $img
                ->input('title')
                ->input('legenda');

            $move = $this->getModel()->salvaImage($img, 'imagem', true);

            return [
                'message' => ($move ? 'Imagem enviada com sucesso.' : 'Não foi possível enviar a imagem.'),
                'result' => 1,
            ];
        } catch (Exception $ex) {
            return [
                'message' => $ex->getMessage(),
                'result' => 0,
            ];
        }
    }

    use status;

    /**
     * Ordena as imagens na base de dados
     */
    function ordenarAction()
    {
        $imagens = inputPost()['imagens'];
        if (!empty($imagens) and is_array($imagens)) {
            foreach ($imagens as $pos => $id) {
                $img = $this->getModel()->lista('WHERE a.id = :id AND a.ref = :ref AND a.refid = :refid LIMIT 1', ['id' => $id, 'ref' => inputPost('ref'), 'refid' => inputPost('refid')]);
                if (count($img)) {
                    $img[0]->setPosition($pos + 1);
                    if ($img[0]->getStatus() == 99) {
                        $img[0]->setStatus(0);
                    }
                    $img[0]->save();
                }
            }
        }
    }

    use excluir;

}
    