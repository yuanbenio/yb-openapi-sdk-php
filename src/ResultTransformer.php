<?php
namespace Yuanben;

use Yuanben\Contracts\Operable;
use Yuanben\Exceptions\ClientIdNotExistException;

class ResultTransformer
{
    protected $original;
    protected $results;
    protected $class;
    protected $isCollection = false;

    public function __construct(Operable $original, $results)
    {
        $this->original = $original;
        $this->results = $results;
    }

    public function process()
    {
        if ($this->original instanceof Collection) {
            $this->isCollection = true;
            $this->class = $this->original->getClass();
        } else {
            $this->class = get_class($this->original);
        }

        return $this->doProcess();
    }

    public function doProcess()
    {
        switch ($this->class) {
            case 'Yuanben\Article':
                return $this->articleProcess();
            default:
                return null;
        }
    }

    public function articleProcess()
    {
        if ($this->isCollection) {
            foreach ($this->results as $key => $article) {
                $this->transArticle($article);
            }
        } else {
            $this->transArticle($this->results[0]);
        }

        return $this->original;
    }

    public function transArticle($singleData)
    {
        $item = $this->original;
        $status = $singleData['status'];
        $article = $singleData['article'];

        if ($this->isCollection) {
            $item = $this->original->find('client_id', $article['client_id']);
        }

        if (!$item) {
            throw new ClientIdNotExistException();
        }
        
        /**
         * @var Article $item
         */
        
        $item->setSuccess($status['success']);
        $item->setErrorMessage($status['message']);
        
        if($item->isSuccess())
        {
            $item->setPublicKey($article['public_key']);
            $item->setSignature($article['signature']);
            $item->setHash($article['hash']);
            $item->setBlockHash($article['block_hash']);
            $item->setYuanbenId($article['yuanben_id']);
            $item->setShortId($article['short_id']);
            $item->setUrl($article['url']);
            $item->setBadgeHtml($article['badge_html']);
            $item->setBadgeUrl($article['badge_url']);
        }
    }
}
