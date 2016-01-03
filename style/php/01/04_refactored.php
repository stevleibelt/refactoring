<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-01-03
 */

class Mail
{
    /** @var string */
    private $content;

    /** @var string */
    private $from;

    /** @var string */
    private $subject;

    /** @var string */
    private $to;

    /**
     * @param string $content
     * @param string $from
     * @param string $subject
     * @param string $to
     * @throws InvalidArgumentException
     */
    public function __construct($content, $from, $subject, $to)
    {
        $this->setContentOrThrowInvalidArgumentException($content);
        $this->setFromOrThrowInvalidArgumentException($from);
        $this->setSubjectOrThrowInvalidArgumentException($subject);
        $this->setToOrThrowInvalidArgumentException($to);
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function from()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function subject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function to()
    {
        return $this->to;
    }

    /**
     * @param string $content
     * @throws InvalidArgumentException
     */
    private function setContentOrThrowInvalidArgumentException($content)
    {
        if ($this->isScalar($content)) {
            $this->content = $this->castItToString($content);
        } else {
            throw new InvalidArgumentException(
                'content must be of type string'
            );
        }
    }

    /**
     * @param string $from
     * @throws InvalidArgumentException
     */
    private function setFromOrThrowInvalidArgumentException($from)
    {
        if ($this->isValidEmailAddress($from)) {
            $this->from = $from;
        } else {
            throw new InvalidArgumentException(
                'from must be a valid email address'
            );
        }
    }

    /**
     * @param string $subject
     * @throws InvalidArgumentException
     */
    private function setSubjectOrThrowInvalidArgumentException($subject)
    {
        if ($this->isScalar($subject)) {
            $this->subject = $this->castItToString($subject);
        } else {
            throw new InvalidArgumentException(
                'subject must be of type string'
            );
        }
    }

    /**
     * @param string $to
     * @throws InvalidArgumentException
     */
    private function setToOrThrowInvalidArgumentException($to)
    {
        if ($this->isValidEmailAddress($to)) {
            $this->to = $to;
        } else {
            throw new InvalidArgumentException(
                'to must be a valid email address'
            );
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
    private function isScalar($value)
    {
        return is_scalar($value);
    }

    private function isValidEmailAddress($emailAddress)
    {
        $isValid = (filter_var($emailAddress, FILTER_VALIDATE_EMAIL));

        return $isValid;
    }
}

class MailDispatcher
{
    /**
     * @param Mail $mail
     */
    public function tryToSendTheMailOrThrowARuntimeException(Mail $mail)
    {
        $couldNotSent = (!mail($mail->to(), $mail->subject(), $mail->content(), 'From: ' . $mail->from()));

        if ($couldNotSent) {
            throw new RuntimeException(
                'could not sent the mail' . PHP_EOL .
                'values: ' . var_export($mail, true)
            );
        }
    }
}
