<?php
namespace Yuanben;

use Yuanben\Contracts\Arrayable;

class Author implements Arrayable
{
    protected $email;
    protected $pseudonym;

    public function __construct($email, $pseudonym)
    {
        $this->email = $email;
        $this->pseudonym = $pseudonym;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPseudonym()
    {
        return $this->pseudonym;
    }

    public function toArray()
    {
        return array(
            'email' => $this->email,
            'pseudonym' => $this->pseudonym
        );
    }
}
