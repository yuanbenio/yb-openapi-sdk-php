<?php
namespace Yuanben;

use Masterminds\HTML5;

class ArticleContentProcessor
{
    /**
     * @var Client $client
     */
    protected $client;
    
    /**
     * @param Client $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }
    
    public function processArticleContent($content)
    {
        $imageBaseName = $this->client->getClientImageBaseName();
        
        if($imageBaseName == '')
        {
            return $content;
        }
            
        $html5 = new HTML5();
        
        $dom = $html5->loadHTML($content);
        
        $images = $dom->getElementsByTagName('img');
        
        if(count($images) == 0)
        {
            return $content;
        }
        
        foreach($images as $image)
        {
            $src = $image->getAttribute('src');
        
            if(!preg_match('/^(http|https)/', $src))
            {
                $src = $imageBaseName. $src;
            }
            
            $image->setAttribute('src', $src);
        }
        
        return $html5->saveHTML($dom->documentElement->childNodes);
    }
}