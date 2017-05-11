<?php
namespace Yuanben;

use Yuanben\Contracts\Arrayable;
use Yuanben\Contracts\Operable;
use Yuanben\Exceptions\InvalidDataTypeException;

class Article implements Arrayable, Operable
{
    protected $field = 'articles';
    
    /**
     * @var Author $author
     */
    protected $author;
    
    /**
     * @var License $license
     */
    protected $license;
    
    /**
     * @var string $title
     */
    protected $title;
    
    /**
     * @var string $content
     */
    protected $content;
    
    /**
     * @var string $clientId
     */
    protected $clientId;
    
    /**
     * @var string $publicKey
     */
    protected $publicKey;
    
    /**
     * @var string $signature
     */
    protected $signature;
    
    /**
     * @var string $hash
     */
    protected $hash;
    
    /**
     * @var string $blockHash
     */
    protected $blockHash;
    
    /**
     * @var string $yuanbenId
     */
    protected $yuanbenId;
    
    /**
     * @var string $shortId
     */
    protected $shortId;
    
    /**
     * @var string $url
     */
    protected $url;
    
    /**
     * @var string $badgeHtml
     */
    protected $badgeHtml;
    
    /**
     * @var string $badgeUrl
     */
    protected $badgeUrl;
    
    /**
     * @var boolean $success;
     */
    protected $success;
    
    /**
     * @var string $errorMessage;
     */
    protected $errorMessage;

    public function __construct($title, $content)
    {
        $this->setTitle($title);
        $this->setContent($content);
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getClientId()
    {
        return $this->clientId;
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
        $article = array(
            'client_id' => $this->clientId,
            'title' => $this->title,
            'content' => $this->content
        );

        if ($this->author instanceof Author) {
            $article = array_merge($article, array('author' => $this->author->toArray()));
        }

        if ($this->license instanceof License) {
            $article = array_merge($article, array('license' => $this->license->toArray()));
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
    /**
     * @return string $publicKey
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @return string $signature
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return string $hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string $blockHash
     */
    public function getBlockHash()
    {
        return $this->blockHash;
    }

    /**
     * @return string $yuanbenId
     */
    public function getYuanbenId()
    {
        return $this->yuanbenId;
    }

    /**
     * @return string $shortId
     */
    public function getShortId()
    {
        return $this->shortId;
    }

    /**
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string $badgeHtml
     */
    public function getBadgeHtml()
    {
        return $this->badgeHtml;
    }

    /**
     * @return string $badgeUrl
     */
    public function getBadgeUrl()
    {
        return $this->badgeUrl;
    }

    /**
     * @param string $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @param string $blockHash
     */
    public function setBlockHash($blockHash)
    {
        $this->blockHash = $blockHash;
    }

    /**
     * @param string $yuanbenId
     */
    public function setYuanbenId($yuanbenId)
    {
        $this->yuanbenId = $yuanbenId;
    }

    /**
     * @param string $shortId
     */
    public function setShortId($shortId)
    {
        $this->shortId = $shortId;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $badgeHtml
     */
    public function setBadgeHtml($badgeHtml)
    {
        $this->badgeHtml = $badgeHtml;
    }

    /**
     * @param string $badgeUrl
     */
    public function setBadgeUrl($badgeUrl)
    {
        $this->badgeUrl = $badgeUrl;
    }
    /**
     * @return boolean $success
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string $errorMessage
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }


}
