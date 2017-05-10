<?php
namespace Yuanben;

use Yuanben\Contracts\Operable;

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

        if (! $item) {
            dd($singleData, $this->original);
        }

        $this->attachProperties($item, $status);
        $this->attachProperties($item, $article);
    }

    public function attachProperties($entity, $attributes)
    {
        foreach ($attributes as $key => $value) {
            $entity->{$key} = $value;
        }
    }
}
