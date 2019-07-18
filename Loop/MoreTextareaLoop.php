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
				
			$value='';
			switch($this->getSource()){
				case '0':
				case 'category':
					if($idSource = $this->getSourceId()){
						if(null !== $more = CategoryMoretextareaQuery::create()->filterByLocale($this->getLocale())->filterByCategoryId($idSource)->filterByMoretextareaId($objet->getId())->findOne()){
							$value=$more->getValue();
						}
					}
				break;
				case '1':
				case 'product':
					if($idSource = $this->getSourceId()){
						if(null !== $more = ProductMoretextareaQuery::create()->filterByLocale($this->getLocale())->filterByProductId($idSource)->filterByMoretextareaId($objet->getId())->findOne()){
							$value=$more->getValue();
						}
					}
				break;
				case '2':
				case 'folder':
					if($idSource = $this->getSourceId()){
						if(null !== $more = FolderMoretextareaQuery::create()->filterByLocale($this->getLocale())->filterByFolderId($idSource)->filterByMoretextareaId($objet->getId())->findOne()){
							$value=$more->getValue();
						}
					}
				break;
				case '3':
				case 'content':
					if($idSource = $this->getSourceId()){
						if(null !== $more = ContentMoretextareaQuery::create()->filterByLocale($this->getLocale())->filterByContentId($idSource)->filterByMoretextareaId($objet->getId())->findOne()){
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