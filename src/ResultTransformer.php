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
            $collection = new Collection();
            foreach ($this->results as $key => $article) {
                $collection->push($this->transArticle($article));
            }

            return $collection;
        } else {
            return $this->transArticle($this->results[0]);
        }
    }

    public function transArticle($singleData)
    {
        $article = new Article($singleData['title'], $singleData['content']);
        if (isset($singleData['license'])) {
            $license = License::fromJson(json_encode($singleData['license']));
            $article->setLicense($license);
        }

        return $article;
    }
}
