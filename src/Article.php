<?php
namespace YuanBen;

use YuanBen\Contracts\Arrayable;
use YuanBen\Contracts\Operable;
use YuanBen\Exceptions\InvalidDataTypeException;

class Article implements Arrayable, Operable
{
    protected $field = 'articles';
    protected $author;
    protected $license;
    protected $title;
    protected $content;

    public function __construct($title, $content)
    {
        $this->setTitle($title);
        $this->setContent($content);
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(Author $author)
    {
        $this->author = $author;

        return $this;
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function setLicense(License $license)
    {
        $this->license = $license;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->checkEmpty($title, 'title');
        $this->title = $title;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->checkEmpty($content, 'content');
        $this->content = $content;

        return $this;
    }

    public function toArray()
    {
        $article = [
            'title' => $this->title,
            'content' => $this->content
        ];

        if ($this->author instanceof Author) {
            $article = array_merge($article, ['author' => $this->author->toArray()]);
        }

        if ($this->license instanceof License) {
            $article = array_merge($article, ['license' => $this->license->toArray()]);
        }

        return $article;
    }

    public function checkEmpty($content, $field = 'field')
    {
        if (! is_string($content) || trim($content) == '') {
            throw new InvalidDataTypeException("The {$field} must be a string and must not be an empty string.");
        }
    }

    public function getField()
    {
        return $this->field;
    }
}
