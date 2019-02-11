<?php


namespace app\helpers;


class CDNCurl
{

    private $curl;
    private $info;
    private $result;
    private $files;
    private $url;
    private $postValues;
    private $headers;

    /**
     * CDNCurl constructor.
     * @param $url
     */
    function __construct($url)
    {
        $this->url = $url;
        $this->reset();
    }

    /**
     * Limpa a ultima conexão
     */
    function reset()
    {
        $this->curl = curl_init();
        $this->setOption(CURLOPT_POST, 1);
        $this->setOption(CURLOPT_RETURNTRANSFER, 1);
        $this->setOption(CURLOPT_AUTOREFERER, 1);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, 0);
        $this->setOption(CURLOPT_SSL_VERIFYHOST, 0);
        $this->postValues = null;
        $this->headers = ['Content-type: application/json; charset=UTF-8'];
        $this->files = $this->result = $this->info = null;
    }

    /**
     * @param $option
     * @param $value
     * @return $this
     */
    function setOption($option, $value)
    {
        curl_setopt($this->curl, $option, $value);
        return $this;
    }

    /**
     * Adiciona headers a requisição
     * @param $value
     */
    function addHeader($value)
    {
        $this->headers[] = $value;
    }

    /**
     * @param array $values
     */
    function setPostValues(array $values)
    {
        $this->postValues = $values;
    }

    /**
     * @param array $options
     * @return $this
     */
    function setOptions(array $options)
    {
        curl_setopt_array($this->curl, $options);
        return $this;
    }

    /**
     * Adiciona um arquivo ao envio
     * @param $keyUpload
     * @param $filename
     * @param $postname
     * @throws \Exception
     */
    function uploadFile($keyUpload, $filename, $postname = null)
    {
        if (!file_exists($filename)) {
            throw new \Exception();
        }

        $this->setOption(CURLOPT_UPLOAD, 1);
        $this->files[$keyUpload] = curl_file_create($filename, mime_content_type($filename), $postname ?: basename($filename));
    }

    /**
     * Executa a requisição
     * @return $this
     */
    function execute(array $values = null)
    {
        $post = (array)$this->files + (array)$values + (array)$this->postValues;
        $this->setOption(CURLOPT_HTTPHEADER, $this->headers);
        $this->setOption(CURLOPT_POSTFIELDS, json_encode((array)$post));

        $this->setOption(CURLOPT_URL, $this->url);
        $this->result = curl_exec($this->curl);
        $this->info = curl_getinfo($this->curl);
        curl_close($this->curl);
        return $this;
    }

    /**
     * Código da resposta
     * @return int
     */
    function getResponseCode()
    {
        if ($this->info)
            return $this->info['http_code'];
    }

    /**
     * Informações da resposta
     * @return array
     */
    function getInfo()
    {
        return $this->info;
    }

    /**
     * Resultado
     * @return mixed
     */
    function getResult()
    {
        return $this->result;
    }

}