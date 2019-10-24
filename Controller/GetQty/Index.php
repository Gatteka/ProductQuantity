<?php
namespace Learn\ProductQuantity\Controller\GetQty;

use Magento\Framework\App\ActionInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use  Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\CatalogInventory\Model\Stock\Item;

/**
 * Catalog index page controller.
 */
class Index implements ActionInterface
{
    /** @var StockItemRepository  */
    public $stockItemRepository;

    /** @var Context */
    public $context;

    /** @var ResourceConnection */
    public $connection;

    /** @var JsonFactory */
    private $resultJsonFactory;

    /**
     * Index constructor.
     * @param StockItemRepository $stockItemRepository
     * @param JsonFactory $resultJsonFactory
     * @param ResourceConnection $connection
     * @param Context $context
     */
    public function __construct(
        StockItemRepository $stockItemRepository,
        JsonFactory $resultJsonFactory,
        ResourceConnection $connection,
        Context $context
    ) {
        $this->stockItemRepository = $stockItemRepository;
        $this->connection = $connection->getConnection();
        $this->resultJsonFactory = $resultJsonFactory;
        $this->context = $context;
    }

    /**
     * @return bool|ResponseInterface|Json|ResultInterface
     */
    public function execute()
    {
        $id = $this->context->getRequest()->getParams()['id'];
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData(['success' => $this->getQtyById($id)]);
    }

    /**
     * @param $id
     * @return int
     */
    public function getQtyById($id){
        $select = $this->connection->select()
            ->from(Item::ENTITY, 'qty')
            ->where('product_id = '.$id);

        return intval($this->connection->fetchOne($select));
    }
}
