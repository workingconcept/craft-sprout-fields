<?php
namespace barrelstrength\sproutfields;

use Craft;
use yii\base\Event;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use yii\base\Component;

use barrelstrength\sproutfields\helpers\SproutFieldsInstallHelper;
use barrelstrength\sproutfields\models\SettingsModel;

use barrelstrength\sproutfields\fields\Hidden            as HiddenField;
use barrelstrength\sproutfields\fields\Phone             as PhoneField;
use barrelstrength\sproutfields\fields\Email             as EmailField;
use barrelstrength\sproutfields\fields\EmailSelect       as EmailSelectField;
use barrelstrength\sproutfields\fields\Invisible         as InvisibleField;
use barrelstrength\sproutfields\fields\Link              as LinkField;
use barrelstrength\sproutfields\fields\Notes             as NotesField;
use barrelstrength\sproutfields\fields\RegularExpression as RegularExpressionField;
use barrelstrength\sproutfields\services\PhoneService;

class SproutFields extends \craft\base\Plugin
{
	/**
	 * Enable use of SproutFields::$plugin-> in place of Craft::$app->
	 *
	 * @var [type]
	 */
	public static $api;

	public function init()
	{
		parent::init();

		self::$api = $this->get('api');

		Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES, function(RegisterComponentTypesEvent $event) {
				$event->types[] = HiddenField::class;
				$event->types[] = PhoneField::class;
				$event->types[] = EmailField::class;
				$event->types[] = EmailSelectField::class;
				$event->types[] = InvisibleField::class;
				$event->types[] = LinkField::class;
				$event->types[] = NotesField::class;
				$event->types[] = RegularExpressionField::class;
			}
		);
	}

	/**
	 * @param string $message
	 * @param array  $params
	 *
	 * @return string
	 */
	public static function t($message, array $params = [])
	{
		return Craft::t('sproutFields', $message, $params);
	}

	/**
	 * Returns settings model with custom properties
	 *
	 * @return SettingsModel
	 */
	public function createSettingsModel()
	{
		return new SettingsModel();
	}

	public function settingsHtml()
	{
		return Craft::$app->getView()->renderTemplate(
			'sproutfields/_cp/settings',
			[
				'settings' => $this->getSettings()
			]
		);
	}

	public function afterInstall()
	{
		$helper = new SproutFieldsInstallHelper();
		$helper->installDefaultNotesStyles();
	}
}


