<?php
namespace MoreTextarea\Loop;

use MoreTextarea\Model\MoretextareaQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\BooleanOrBothType;
use Thelia\Model\ConfigQuery;

use MoreTextarea\Model\CategoryMoretextareaQuery;
use MoreTextarea\Model\ProductMoretextareaQuery;
use MoreTextarea\Model\FolderMoretextareaQuery;
use MoreTextarea\Model\ContentMoretextareaQuery;

class MoreTextareaLoop extends BaseLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('exclure'),
            Argument::createIntListTypeArgument('origine'),
            Argument::createIntListTypeArgument('category'),
            Argument::createIntListTypeArgument('product'),
            Argument::createIntListTypeArgument('folder'),
            Argument::createIntListTypeArgument('content'),
            Argument::createAnyTypeArgument('locale'),
            Argument::createIntListTypeArgument('source_id'),
            Argument::createAnyTypeArgument('source')
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = MoretextareaQuery::create();
		
        $id = $this->getId();
        if ($id) {
            $search->filterById($id, Criteria::IN);
        }

        $exclure = $this->getExclure();
        if ($exclure) {
            $search->filterById($exclure, Criteria::NOT_IN);
        }

        $origine = $this->getOrigine();
        if ($origine) {
            $search->filterByTypobj($origine, Criteria::IN);
        }

        return $search;
    }


    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $objet) {
            $loopResultRow = new LoopResultRow($objet);
            $locale = $this->request->getSession()->getLang()->getLocale();
			$value='';
			$source = $this->getSource();
			$sourceId =  $this->getSourceId();
			if(!$this->getSource()){
				if($this->getCategory()){ $source = 0; $sourceId = $this->getCategory(); }
				if($this->getProduct()){ $source = 1; $sourceId = $this->getProduct(); }
				if($this->getFolder()){ $source = 2; $sourceId = $this->getFolder(); }
				if($this->getContent()){ $source = 3; $sourceId = $this->getContent(); }
			}
			
			
			switch($source){
				case '0':
				case 'category':
					if($sourceId){
						if(null !== $more = CategoryMoretextareaQuery::create()->filterByLocale($locale)->filterByCategoryId($sourceId)->filterByMoretextareaId($objet->getId())->findOne()){
							$value=$more->getValue();
						}
					}
				break;
				case '1':
				case 'product':
					if($sourceId){
						if(null !== $more = ProductMoretextareaQuery::create()->filterByLocale($locale)->filterByProductId($sourceId)->filterByMoretextareaId($objet->getId())->findOne()){
							$value=$more->getValue();
						}
					}
				break;
				case '2':
				case 'folder':
					if($sourceId){
						if(null !== $more = FolderMoretextareaQuery::create()->filterByLocale($locale)->filterByFolderId($sourceId)->filterByMoretextareaId($objet->getId())->findOne()){
							$value=$more->getValue();
						}
					}
				break;
				case '3':
				case 'content':
					if($sourceId){
						if(null !== $more = ContentMoretextareaQuery::create()->filterByLocale($locale)->filterByContentId($sourceId)->filterByMoretextareaId($objet->getId())->findOne()){
							$value=$more->getValue();
						}
					}
				break;
			}
			
			
            $loopResultRow
                ->set('ID', $objet->getId())
                ->set('TITLE', $objet->getTitle())
                ->set('TYPCH', $objet->getTypch())
                ->set('VALUE', $value)
			;
			
            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}