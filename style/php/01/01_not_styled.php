<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-01-03
 */

class EMail {
  public $header;
public $content = 'bar';
    private $address;
        public $from;
    private $content2;

public function __construct($header, $sender = null, $recipient = null, $content = '', $html = null) {
  $this->header = (string) $header;
$this->content = $content;
        $this->address      = $recipient;
    $this->from = $sender;
    $this->content2 = $html;
}

    /**
     * @param $string
     * @return string
     */
    private function string($string) {
        if ($string == (string) $string)
                return $string;
        else {
            if (filter_var($string, FILTER_VALIDATE_EMAIL))
                return $string;
            else
                return $this->string(filter_var($string, FILTER_SANITIZE_EMAIL));
        }
    }

  public function setFrom($sender) { $this->from = $this->string($sender);}

        public function send() {
            if (is_null($this->content)) {
                if (is_null($this->content2)) throw new Exception('no content');
                else {
                    $good = mail($this->address, $this->header, $this->content2, "From: $this->from");
                }
            } else $good = mail($this->address, $this->header, $this->content, "From: $this->from");

            if (!$good) return false;
        }

public function setTo($recipient)
{
    $this->address = $recipient;
}

   public function text($string) {
      $this->content = (string) $string;
   }

   public function addHtml($HTML) {if(is_null($this->content2)) $this->content2 = $HTML;}}
