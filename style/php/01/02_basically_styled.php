<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-01-03
 */

class EMail
{
    /** @var string */
    public $header;

    /** @var string */
    public $content = 'bar';

    /** @var string */
    public $from;

    /** @var string */
    private $address;

    /** @var string */
    private $content2;

    /**
     * @param string $header
     * @param null|string $sender
     * @param null|string $recipient
     * @param string $content
     * @param null|string $html
     */
    public function __construct($header, $sender = null, $recipient = null, $content = '', $html = null)
    {
        $this->address  = $recipient;
        $this->content  = $content;
        $this->content2 = $html;
        $this->from     = $sender;
        $this->header   = (string) $header;
    }

    /**
     * @param string $sender
     */
    public function setFrom($sender)
    {
        $this->from = $this->string($sender);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function send()
    {
        if (is_null($this->content)) {
            if (is_null($this->content2)) {
                throw new Exception('no content');
            } else {
                $good = mail($this->address, $this->header, $this->content2, "From: $this->from");
            }
        } else {
            $good = mail($this->address, $this->header, $this->content, "From: $this->from");
        }

        if (!$good) {
            return false;
        }
    }

    /**
     * @param string $recipient
     */
    public function setTo($recipient)
    {
        $this->address = $recipient;
    }

    /**
     * @param string $string
     */
    public function text($string)
    {
        $this->content = (string) $string;
    }

    /**
     * @param string $HTML
     */
    public function addHtml($HTML)
    {
        if (is_null($this->content2)) {
            $this->content2 = $HTML;
        }
    }

    /**
     * @param string $string
     * @return string
     */
    private function string($string)
    {
        if($string == (string) $string) {
            return $string;
        } else {
            if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
                return $string;
            } else {
                return $this->string(filter_var($string, FILTER_SANITIZE_EMAIL));
            }
        }
    }
}
