<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 14:18
 */

namespace Useless\Http;


/**
 * Class Response
 * @package Useless\Http
 */
class Response
{
    /**
     * @var
     */
    protected $content;
    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = (string)$content;

        return $this;
    }

    /**
     * @param $header
     * @param $value
     */
    public function addHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     *
     */
    public function send()
    {
        $this->sendHeaders()
            ->sendContent();
    }

    /**
     * @return $this
     */
    protected function sendContent()
    {
        echo $this->content;

        return $this;
    }

    /**
     * @return $this
     */
    protected function sendHeaders()
    {
        foreach ($this->headers as $header => $value) {
            header($header . ':' . $value, false);
        }

        return $this;
    }

    /**
     * @param $to
     */
    public function redirect($to)
    {
        $this->addHeader('Location', $to);

        $this->send();
    }
}