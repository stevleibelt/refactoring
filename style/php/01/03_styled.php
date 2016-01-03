<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-01-03
 */

class EMail
{
    /** @var string */
    public $content = 'bar';

    /** @var string */
    public $from;

    /** @var string */
    public $header;

    /** @var string */
    private $to;

    /** @var string */
    private $htmlContent;

    /**
     * @param string $header
     * @param null|string $from
     * @param null|string $to
     * @param string $content
     * @param null|string $html
     */
    public function __construct($header, $from = null, $to = null, $content = '', $html = null)
    {
        $fromIsProvided = ($this->isNotNull($from));
        $htmlIsProvided = ($this->isNotNull($html));
        $toIsProvided   = ($this->isNotNull($to));

        $this->content  = $this->castItToString($content);
        $this->header   = $this->castItToString($header);

        if ($fromIsProvided) {
            $this->from = $from;
        }

        if ($htmlIsProvided) {
            $this->htmlContent = $this->castItToString($html);
        }

        if ($toIsProvided) {
            $this->to = $to;
        }
    }

    /**
     * @param string $sender
     */
    public function setFrom($sender)
    {
        $this->from = $this->makeItAValidEmailAddress($sender);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function send()
    {
        //begin of dependencies
        $from           = $this->from;
        $htmlContent    = $this->htmlContent;
        $subject        = $this->header;
        $textContent    = $this->content;
        $to             = $this->to;
        //end of dependencies

        $noTextContentProvided  = ($this->isNull($textContent));
        $noHtmlContentProvided  = ($this->isNull($htmlContent));

        if ($noTextContentProvided) {
            if ($noHtmlContentProvided) {
                throw new Exception('no content');
            } else {
                $mailWasSent = $this->sendTheMail($from, $to, $subject, $htmlContent);
            }
        } else {
            $mailWasSent = $this->sendTheMail($from, $to, $subject, $textContent);
        }

        return $mailWasSent;
    }

    /**
     * @param string $recipient
     */
    public function setTo($recipient)
    {
        $this->to = $recipient;
    }

    /**
     * @param string $textContent
     */
    public function text($textContent)
    {
        $this->content = $this->castItToString($textContent);
    }

    /**
     * @param string $htmlContent
     */
    public function addHtml($htmlContent)
    {
        $noHtmlContentSetSoFar = ($this->isNull($this->htmlContent));

        if ($noHtmlContentSetSoFar) {
            $this->htmlContent = $this->castItToString($htmlContent);
        }
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function castItToString($value)
    {
        return (string) $value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isNotNull($value)
    {
        return (!$this->isNull($value));
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isNull($value)
    {
        return (is_null($value));
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $content
     * @return bool
     */
    private function sendTheMail($from, $to, $subject, $content)
    {
        return mail($to, $subject, $content, 'From: ' . $from);
    }

    /**
     * @param string $emailAddress
     * @return string
     */
    private function makeItAValidEmailAddress($emailAddress)
    {
        $isNotAValidEmailAddress = !(filter_var($emailAddress, FILTER_VALIDATE_EMAIL));

        if ($isNotAValidEmailAddress) {
            $validEmailAddress = filter_var($emailAddress, FILTER_SANITIZE_EMAIL);
        } else {
            $validEmailAddress = $emailAddress;
        }

        return $validEmailAddress;
    }
}
