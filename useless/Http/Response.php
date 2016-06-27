<?php
/**
 * Created by PhpStorm.
 * User: dromazanov
 * Date: 26/06/16
 * Time: 14:18
 */

namespace Useless\Http;


class Response
{
    protected $content;
    protected $headers = [];

    public function setContent($content)
    {
        $this->content = (string)$content;

        return $this;
    }

    public function addHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    public function send()
    {
        $this->sendHeaders()
            ->sendContent();
    }

    protected function sendContent()
    {
        echo $this->content;

        return $this;
    }

    protected function sendHeaders()
    {
        foreach ($this->headers as $header => $value) {
            header($header . ':' . $value, false);
        }

        return $this;
    }

    public function redirect($to)
    {
        $this->addHeader('Location', $to);

        $this->send();
    }
}