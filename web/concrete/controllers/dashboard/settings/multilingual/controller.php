<?

defined('C5_EXECUTE') or die("Access Denied.");
Loader::controller('/dashboard/base');

class DashboardSettingsMultilingualController extends DashboardBaseController {

	public $helpers = array('form'); 
	
	public function view() {
		Loader::library('3rdparty/Zend/Locale');
		$languages = Localization::getAvailableInterfaceLanguages();
		if (count($languages) > 0) { 
			array_unshift($languages, 'en_US');
		}
		$locales = array();
		foreach($languages as $lang) {
			$loc = new Zend_Locale($lang);
			$locales[$lang] = Zend_Locale::getTranslation($loc->getLanguage(), 'language', ACTIVE_LOCALE);
		}
		$this->set('LANGUAGE_CHOOSE_ON_LOGIN', Config::get('LANGUAGE_CHOOSE_ON_LOGIN'));
		$this->set('LANGUAGE_MULTILINGUAL_CONTENT_ENABLED', Config::get('LANGUAGE_MULTILINGUAL_CONTENT_ENABLED'));
		$this->set('interfacelocales', $locales);
		$this->set('languages', $languages);
	}
	


	public function interface_settings_saved() {
		$this->set('message', t('Interface settings saved'));
		$this->view();
	}
	public function save_interface_language() {
		if (Loader::helper('validation/token')->validate('save_interface_language')) {
			
			Config::save('SITE_LOCALE', $this->post('SITE_LOCALE'));
			Config::save('LANGUAGE_CHOOSE_ON_LOGIN', $this->post('LANGUAGE_CHOOSE_ON_LOGIN'));
			$this->redirect('/dashboard/settings/multilingual', 'interface_settings_saved');
			
		} else {
			$this->error->add(Loader::helper('validation/token')->getErrorMessage());
		}
		$this->view();
	}
	
}