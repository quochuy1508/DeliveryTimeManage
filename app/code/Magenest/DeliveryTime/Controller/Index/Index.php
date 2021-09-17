<?php
namespace Magenest\DeliveryTime\Controller\Index;

class Index implements \Magento\Framework\App\ActionInterface
{
    protected $_pageFactory;

    protected $_postFactory;

    public function __construct(
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magenest\DeliveryTime\Model\DeliveryTimeFactory $postFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_postFactory = $postFactory;
    }

    public function execute()
    {
        $post = $this->_postFactory->create();
        $collection = $post->getCollection();
        foreach($collection as $item){
            echo "<pre>";
            print_r($item->getData());
            echo "</pre>";
        }
        exit();
//        return $this->_pageFactory->create();
    }
}
