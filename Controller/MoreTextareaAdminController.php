<?php 

namespace MoreTextarea\Controller ;


use Propel\Runtime\ActiveQuery\Criteria;
use MoreTextarea\Model\MoretextareaQuery;
use MoreTextarea\Model\Moretextarea;
use MoreTextarea\Model\ProductMoretextareaQuery;
use MoreTextarea\Model\ProductMoretextarea;
use Thelia\Log\Tlog;
use Thelia\Core\Event\ActionEvent;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Model\ProductQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Customer\CustomerCreateOrUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Tools\Password;
use Thelia\Core\Event\PdfEvent;
use Thelia\Core\HttpFoundation\Response;

class MoreTextareaAdminController extends BaseAdminController
{
    public function __construct(){}
	public function noAction(){
		$url = ConfigQuery::create()->filterByName('url_site')->findOne();
		return $response = $this->generateRedirect( $url->getValue().'/admin/modules/moretextarea/moretextarea-accueil');
	}
	public function formAction(){
		if(empty($_REQUEST['action']))$_REQUEST['action']='';
		
	//	echo '<pre>'; print_r($_REQUEST); echo '</pre>';exit;

		switch($_REQUEST['action']){
			case 'moretextaea_creation_dialog':
				$text = new Moretextarea();
				$text->setTitle($_REQUEST['name'])->setTypobj($_REQUEST['typobj'])->save();
			break;
			case 'moretextarea_edit_dialog':
				$text = MoretextareaQuery::create()->findPk($_REQUEST['id']);
				$text->setTitle($_REQUEST['name'])->save();
			break;
			case 'moretextarea_supprimer_field':
				if(null !== $texts = ProductMoretextareaQuery::create()->filterByMoretextareaId($_REQUEST['id'])->find()){
					foreach($texts as $text)$text->delete();
				}
				$text = MoretextareaQuery::create()->findPk($_REQUEST['id']);
				$text->delete();
			break;
		}
		if(!empty($_REQUEST["success_url"])) return $response = $this->generateRedirect($_REQUEST["success_url"]);
	}
}
