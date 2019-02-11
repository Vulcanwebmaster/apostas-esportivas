<?php

namespace app\core;

use app\helpers\Date;
use app\helpers\Number;
use app\models\helpers\ImagensModel;
use app\traits\vo\token;
use app\vo\helpers\ImageVO;
use Exception;

abstract class ValueObject
{

    use token;

    protected $_img_default = 'default.jpg';

    /** @var Model */
    protected $model;

    private $id = 0;
    private $insert;
    private $update;
    private $status = 1;
    private $__values = [];
    private $__imagens;

    function __construct(Model $model, array $values = null)
    {
        $this->defineModel($model);
        $this->defineValue($values);
        $this->__values = $this->toArray() + $this->__values;
    }

    /**
     * @param Model $model
     */
    public function defineModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Seta todos os valores
     * @param array $values
     * @return $this
     */
    public function defineValue(array $values = null)
    {
        if ($values) {
            foreach ($values as $method => $Value) {
                $this->set($method, $Value);
            }
        }
        return $this;
    }

    /**
     * Seta um valor
     * @param string $method
     * @param mixed $value
     * @return $this
     */
    public function set($method, $value = null)
    {

        if ($method) {
            if (is_array($method)) {
                $this->defineValue($method);
            } else {
                if (method_exists($this, "set{$method}")) {
                    $this->{"set{$method}"}($value);
                } else {
                    $this->__values[$method] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * Retorna os valores do objeto em um array
     * @param boolean $format
     * @param boolean $soAlterados
     * @return array
     */
    public function toArray(bool $format = false, bool $soAlterados = false)
    {
        $values = [];

        # Pegandos valores
        foreach (get_class_methods($this) as $method) {
            if (preg_match('/^get[A-Z]/', $method)) {
                $values[strtolower(preg_replace('/^get/', null, $method))] = $this->$method($format);
            }
        }

        # Removendo valores indesejados
        foreach (['table', 'voreference'] as $key) {
            if (isset($values[$key])) {
                unset($values[$key]);
            }
        }

        # Remove valores que não sofreram alteração
        if ($soAlterados) {
            foreach ($values as $key => $value) {

                $default = $this->__values[$key] ?? null;

                if ($value === $default and !in_array($key, ['update'])) {
                    unset($values[$key]);
                }
            }
        }

        return $values;
    }

    /**
     * Alterna o status entre 1 (ativo) e 0 (inativo)
     * @return $this
     */
    function toggleStatus()
    {
        if (in_array($this->getStatus(), [1, 0])) {
            $this->save(['status' => $this->getStatus() == 1 ? 0 : 1]);
        }
        return $this;
    }

    /**
     * @return int
     */
    function getStatus()
    {
        return (int)$this->status;
    }

    /**
     * @param int $status
     * @return $this
     */
    function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Salva os dados do objeto no banco de dados
     * @param array $setValues
     * @param array $ignoreKeys
     * @return $this
     */
    public function save(array $setValues = null, array $ignoreKeys = ['id', 'token'])
    {

        // Ignorando valores
        if ($ignoreKeys and $setValues) {
            foreach ($ignoreKeys as $key) {
                if (isset($setValues[$key])) {
                    unset($setValues[$key]);
                }
            }
        }

        // Definindo valores
        $this->defineValue($setValues);

        // Insert an Update
        if (!$this->getId()) {
            $this->insert = $this->update = date('Y-m-d H:i:s');
        } else {
            $this->update = date('Y-m-d H:i:s');
        }

        // Salvando valores
        if (!Model::save($this)) {
            throw new Exception('Não foi possível salvar o registro');
        }

        // Atualizando VO
        $this->__values = $this->toArray(false, false) + $this->__values;

        return $this;
    }

    /**
     * @return int
     */
    function getId()
    {
        return (int)$this->id;
    }

    /**
     *
     * @param int $id
     * @return $this
     */
    function setId($id)
    {
        if (!$this->getId()) {
            $this->id = (int)$id;
        }
        return $this;
    }

    /**
     * @param bool $formatar
     * @return string
     */
    function getInsert($formatar = false)
    {
        return $this->formatValue($this->insert ?: __NOW__, 'timestamp', $formatar);
    }

    /**
     * @param string $insert
     * @return $this
     */
    function setInsert($insert)
    {
        $this->insert = $insert;
        return $this;
    }

    /**
     * Formata o valor
     * @param mixed $value
     * @param string $type
     * @param boolean $formatar
     * @return mixed
     */
    function formatValue($value, $type, $formatar)
    {
        switch (strtolower($type)) {
            case 'data':
            case 'dt':
            case 'date':
                $value = Date::data((string)$value);
                return $formatar ? Date::formatData($value) : $value;
                break;
            case 'timestamp':
            case 'datatime':
            case 'datetime':
                $value = Date::timestamp((string)$value);
                return $formatar ? Date::formatDataTime($value) : $value;
                break;
            case 'real':
                return $formatar ? Number::real($value) : Number::float($value, 2);
            case 'hide':
                return $formatar ? null : $value;
                break;
            case 'array':
                return $formatar ? stringToArray($value) : arrayToString($value);
                break;
            default:
                return $value;
        }
    }

    /**
     * @param bool $formatar
     * @return string
     */
    function getUpdate($formatar = false)
    {
        return $this->formatValue($this->update, 'timestamp', $formatar);
    }

    /**
     * @param string $update
     * @return $this
     */
    function setUpdate($update)
    {
        $this->update = $update;
        return $this;
    }

    /**
     * Retorna a imagem de capa
     * @param boolean $Default Retorna um default caso ainda não tenha imagem
     * @param string $ADDReference
     * @return null|ImageVO
     */
    function imgCapa($Default = true, $ADDReference = null)
    {
        return $this->__imagens ? $this->__imagens[0] : ImagensModel::Instance()->capa($this->getImageReference($ADDReference), $this->getId(), $Default, $this->_img_default);
    }

    /**
     * Retorna a Referencia da imagem
     * @param string $ADDReference
     * @return string
     */
    private function getImageReference($ADDReference = null)
    {
        $ref = $this->getTable();
        if ($ADDReference) {
            $ADDReference = preg_replace('/^\-/', null, $ADDReference);
            if ($ADDReference) {
                $ref .= '-' . $ADDReference;
            }
        }
        return $ref;
    }

    /**
     * @return string
     */
    function getTable()
    {
        if ($this->voModel())
            return $this->voModel()->getTable();
    }

    /**
     * Retorna a Model do Objeto
     * @return Model
     * @throws Exception
     */
    public function voModel()
    {
        if (!$this->model or !is_a($this->model, Model::class)) {
            throw new Exception(get_class($this) . ': Não possuí uma Model.');
        }

        return $this->model;
    }

    /**
     * Adiciona imagem de capa
     * @param string $FileInputKey
     * @param string $ADDReference
     * @param boolean $excluirSecundarias
     * @return $this
     */
    function imgAddCapa($FileInputKey, $ADDReference = null, $excluirSecundarias = false)
    {
        $this->imgAdd($FileInputKey, false, $ADDReference, $excluirSecundarias);
        return $this;
    }

    /**
     * Adiciona imagem
     * @param string $FileInputKey
     * @param boolean $Last
     * @param string $ADDReference
     * @param boolean $excluirSecundarias
     * @return $this
     */
    function imgAdd($FileInputKey, $Last = true, $ADDReference = null, $excluirSecundarias = false)
    {
        $this->__imagens = null;

        $model = ImagensModel::Instance();

        $img = $model->newValueObject([
            'ref' => $this->getImageReference($ADDReference),
            'refid' => $this->getId(),
        ]);

        $model->salvaImage($img, $FileInputKey, $Last, $excluirSecundarias);

        return $this;
    }

    /**
     * Excluí todas as imagens da VO
     * @return $this
     */
    function imgDeleteAll($ADDReference = null)
    {
        $this->__imagens = null;
        ImagensModel::Instance()->excluirTodasImagens($this->getImageReference($ADDReference), $this->getId());
        return $this;
    }

    /**
     *
     * @param boolean $Default
     * @param string $ADDReference
     * @return ImageVO[]
     */
    function imgList($Default = false, $ADDReference = null)
    {
        return ($this->__imagens and $this->getId()) ? $this->__imagens : ImagensModel::Instance()->getByRef($this->getImageReference($ADDReference), $this->getId(), $Default, true, $this->_img_default);
    }

    /**
     *
     * @param string $Name
     * @param string $MethodKey null | nome metodo da ValueObject
     * @param string $MethodInput POST | GET
     * @return $this
     */
    public function input($Name, $MethodKey = null, $MethodInput = 'POST')
    {
        $function = strtoupper($MethodInput) == 'POST' ? 'inputPost' : 'inputGet';
        $value = call_user_func($function, $Name);
        $Method = 'set' . preg_replace('/^set/', null, ucfirst(strtolower($MethodKey == null ? $Name : $MethodKey)));
        if (method_exists($this, $Method)) {
            $this->$Method($value);
        } else {
            throw new Exception('O método `' . $Method . '` não existe em `' . get_class($this) . '`.');
        }
        return $this;
    }

    /**
     * Retorna um valor get
     * @param string $method
     * @param bool|string $format
     * @return mixed
     */
    public function get($method, $format = false)
    {

        $methodGet = 'get' . $method;

        # Method get
        if (method_exists($this, $methodGet)) {
            if (is_string($format)) {
                return $this->formatValue($this->{$methodGet}(true), $format, true);
            } else {
                return $this->{$methodGet}($format);
            }
        }

        # Valor
        $key = strtolower($method);

        $value = $this->__values[$key] ?? null;

        if ($value !== null and is_string($format)) {
            return $this->formatValue($value, $format, true);
        } else {
            return $value;
        }

    }

    /**
     * Retorna o objecto em uma string
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->toHtml();
        } catch (Exception $ex) {
            return 'Exception: ' . $ex->getMessage();
        }
    }

    /**
     * Retorna os valores do objecto em uma string JSON convertida para HTML
     * @param boolean $format
     * @return string
     */
    public function toHtml($format = true)
    {
        return htmlspecialchars($this->toJson($format));
    }

    /**
     * Retorna os valores do objeto em uma string JSON
     * @param boolean $format
     * @return string
     */
    public function toJson($format = false)
    {
        return json_encode($this->toArray($format));
    }

    /**
     * Retorna o clone do objeto atual
     * @return $this
     */
    public function __clone()
    {
        # ID
        $this->id = 0;

        # Token
        if (method_exists($this, 'setToken'))
            $this->setToken(null);

    }

    /**
     * Excluí o Objeto da base de daods.
     * @return $this
     */
    public function excluir()
    {
        $this->voModel()->excluir($this);
        $this->id = 0;
        return $this;
    }

    /**
     * @return string
     */
    function getVoReference()
    {
        return strtolower('table-' . $this->getTable() . '-id-' . $this->getId());
    }

}
    