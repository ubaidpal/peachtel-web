<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @version  Release: $Revision: 7040 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AdminScenesControllerCore extends AdminController
{
	public function __construct()
	{
	 	$this->table = 'scene';
		$this->className = 'Scene';
	 	$this->lang = true;
	 	$this->addRowAction('edit');
	 	$this->addRowAction('delete');

		$this->identifier = 'id_scene';
		$this->fieldImageSettings = array(
			array('name' => 'image', 'dir' => 'scenes'),
			array('name' => 'thumb', 'dir' => 'scenes/thumbs')
		);

		$this->fields_list = array(
			'id_scene' => array(
				'title' => $this->l('ID'),
				'align' => 'center',
				'width' => 25
			),
			'name' => array(
				'title' => $this->l('Image Maps'),
				'filter_key' => 'b!name'
			),
			'active' => array(
				'title' => $this->l('Activated'),
				'width' => 70,
				'align' => 'center',
				'active' => 'status',
				'type' => 'bool',
				'orderby' => false
			)
		);

		parent::__construct();
	}

	protected function afterImageUpload()
	{
		/* Generate image with differents size */
		if (!($obj = $this->loadObject(true)))
			return;

		if ($obj->id && (isset($_FILES['image']) || isset($_FILES['thumb'])))
		{
			$base_img_path = _PS_SCENE_IMG_DIR_.$obj->id.'.jpg';
			$images_types = ImageType::getImagesTypes('scenes');

			foreach ($images_types as $k => $image_type)
			{
				if ($image_type['name'] == 'scene_default' && isset($_FILES['image']))
					ImageManager::resize(
						$base_img_path,
						_PS_SCENE_IMG_DIR_.$obj->id.'-'.stripslashes($image_type['name']).'.jpg',
						(int)$image_type['width'],
						(int)$image_type['height']
					);
				else if ($image_type['name'] == 'm_scene_default')
				{
					if (isset($_FILES['thumb']) && !$_FILES['thumb']['error'])
						$base_thumb_path = _PS_SCENE_THUMB_IMG_DIR_.$obj->id.'.jpg';
					else
						$base_thumb_path = $base_img_path;
					ImageManager::resize(
						$base_thumb_path,
						_PS_SCENE_THUMB_IMG_DIR_.$obj->id.'-'.stripslashes($image_type['name']).'.jpg',
						(int)$image_type['width'],
						(int)$image_type['height']
					);
				}
			}
		}

		return true;
	}

	public function renderForm()
	{
		$this->initFieldsForm();

		if (!($obj = $this->loadObject(true)))
			return;

		$this->tpl_form_vars['products'] = $obj->getProducts(true, $this->context->language->id, false, $this->context);

		return parent::renderForm();
	}

	public function initToolbar()
	{
		parent::initToolbar();

		if (in_array($this->display, array('add', 'edit')))
			$this->toolbar_btn = array_merge(array('save-and-stay' => array(
				'short' => 'SaveAndStay',
				'href' => '#',
				'desc' => $this->l('Save and stay'),
			)), $this->toolbar_btn);
	}

	public function initFieldsForm()
	{
		$obj = $this->loadObject(true);
		$scene_image_types = ImageType::getImagesTypes('scenes');
		$large_scene_image_type = null;
		$thumb_scene_image_type = null;
		foreach ($scene_image_types as $scene_image_type)
		{
			if ($scene_image_type['name'] == 'scene_default')
				$large_scene_image_type = $scene_image_type;
			if ($scene_image_type['name'] == 'm_scene_default')
				$thumb_scene_image_type = $scene_image_type;
		}
		$fields_form = array(
			'legend' => array(
				'title' => $this->l('Image Maps'),
				'image' => '../img/admin/photo.gif',
				),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			),
			'input' => array(
				array(
					'type' => 'description',
					'name' => 'description',
					'label' => $this->l('How to map products in the image:'),
					'text' => $this->l('When a customer hovers over the image with the mouse, a pop-up appears displaying a brief description of the product.').
						$this->l('The customer can then click to open the product\'s full product page.').
						$this->l('To achieve this, please define the \'mapping zone\' that, when hovered over, will display the pop-up.').
						$this->l('Left-click with your mouse to draw the four-sided mapping zone, then release.').
						$this->l('Then, begin typing the name of the associated product. A list of products appears.').
						$this->l('Click the appropriate product, then click OK. Repeat these steps for each mapping zone you wish to create.').
						$this->l('When you have finished mapping zones, click Save Image Map.')
				),
				array(
					'type' => 'text',
					'label' => $this->l('Image map name:'),
					'name' => 'name',
					'lang' => true,
					'size' => 48,
					'required' => true,
					'hint' => $this->l('Invalid characters:').' <>;=#{}'
				),
				array(
					'type' => 'radio',
					'label' => $this->l('Status:'),
					'name' => 'active',
					'required' => false,
					'class' => 't',
					'is_bool' => true,
					'values' => array(
						array(
							'id' => 'active_on',
							'value' => 1,
							'label' => $this->l('Enabled')
						),
						array(
							'id' => 'active_off',
							'value' => 0,
							'label' => $this->l('Disabled')
						)
					)
				),
			),
		);
		$this->fields_form = $fields_form;

		$image_to_map_desc = '';
		$image_to_map_desc .= $this->l('Format:').' JPG, GIF, PNG. '.$this->l('File size:').' '
				.(Tools::getMaxUploadSize() / 1024).''.$this->l('kB max.').' '
				.sprintf($this->l('If larger than the image size setting, the image will be reduced to %1$d x %2$dpx (width x height).'),
				$large_scene_image_type['width'], $large_scene_image_type['height'])
				.$this->l('If smaller than the image size setting, a white background will be added in order to achieve the correct image size.').'<br />'.
				$this->l('Note: To change image dimensions, please change the \'large_scene\' image type settings to the desired size (in Back Office > Preferences > Images).');
		if ($obj->id && file_exists(_PS_SCENE_IMG_DIR_.$obj->id.'-scene_default.jpg'))
		{
			$this->addJqueryPlugin('autocomplete');
			$this->addJqueryPlugin('imgareaselect');
			$this->addJs(_PS_JS_DIR_.'admin-scene-cropping.js' );
			$image_to_map_desc .= '<br /><img id="large_scene_image" style="clear:both;border:1px solid black;" alt="" src="'.
				_THEME_SCENE_DIR_.$obj->id.'-scene_default.jpg" /><br />';

			$image_to_map_desc .= '
						<div id="ajax_choose_product" style="display:none; padding:6px; padding-top:2px; width:600px;">
							'.$this->l('Begin typing the first letters of the product name, then select the product from the drop-down list:').'
								<br /><input type="text" value="" id="product_autocomplete_input" /> 
								<input type="button" class="button" value="'.$this->l('OK').'" onclick="$(this).prev().search();" />
								<input type="button" class="button" value="'.$this->l('Delete').'" onclick="undoEdit();" />
						</div>
				';

			if ($obj->id && file_exists(_PS_SCENE_IMG_DIR_.'thumbs/'.$obj->id.'-thumb_scene.jpg'))
				$image_to_map_desc .= '<br/>
					<img id="large_scene_image" style="clear:both;border:1px solid black;" alt="" src="'._THEME_SCENE_DIR_.'thumbs/'.$obj->id.'-m_scene_default.jpg" />
					<br />';

			$img_alt_desc = '';
			$img_alt_desc .= $this->l('If you want to use a thumbnail other than one generated from simply reducing the mapped image, please upload it here.')
				.'<br />'.$this->l('Format:').' JPG, GIF, PNG. '
				.$this->l('Filesize:').' '.(Tools::getMaxUploadSize() / 1024).''.$this->l('kB max.').' '
				.sprintf($this->l('Automatically resized to %1$d x %2$dpx (width x height).'),
				$thumb_scene_image_type['width'], $thumb_scene_image_type['height']).'.<br />'
				.$this->l('Note: To change image dimensions, please change the \'thumb_scene\' image type settings to the desired size (in Back Office > Preferences > Images).');

			$input_img_alt = array(
				'type' => 'file',
				'label' => $this->l('Alternative thumbnail:'),
				'name' => 'thumb',
				'desc' => $img_alt_desc
			);

			$selected_cat = array();
			if (Tools::isSubmit('categories'))
				foreach (Tools::getValue('categories') as $row)
					$selected_cat[] = $row;
			else if ($obj->id)
				foreach (Scene::getIndexedCategories($obj->id) as $row)
					$selected_cat[] = $row['id_category'];

			$root_category = Category::getRootCategory();
			if (!$root_category->id_category)
			{
				$root_category->id_category = 0;
				$root_category->name = $this->l('Root');
			}
			$root_category = array('id_category' => $root_category->id_category, 'name' => $root_category->name);
			$trads = array(
							'Root' => $root_category,
							'selected' => $this->l('selected'),
							'Check all' => $this->l('Check all'),
							'Check All' => $this->l('Check All'),
							'Uncheck All'  => $this->l('Uncheck All'),
							'Collapse All' => $this->l('Collapse All'),
							'Expand All' => $this->l('Expand All'),
							'search' => $this->l('Search a category')

						);
			$this->fields_form['input'][] = array(
					'type' => 'categories',
					'label' => $this->l('Categories:'),
					'name' => 'categories',
					'values' => array('trads' => $trads,
						'selected_cat' => $selected_cat,
						'input_name' => 'categories[]',
						'use_radio' => false,
						'use_search' => true,
						'disabled_categories' => array(4),
						'top_category' => Category::getTopCategory(),
						'use_context' => true,
					)
				);
		}
		else
			$image_to_map_desc .= '<br/><span class="bold">'.$this->l('Please add a picture to continue mapping the image.').'</span><br/><br/>';

		if (Shop::isFeatureActive())
		{
			$this->fields_form['input'][] = array(
				'type' => 'shop',
				'label' => $this->l('Shop association:'),
				'name' => 'checkBoxShopAsso',
			);
		}

		$this->fields_form['input'][] = array(
			'type' => 'file',
			'label' => $this->l('Image to be mapped:'),
			'name' => 'image',
			'display_image' => true,
			'desc' => $image_to_map_desc,
		);

		if (isset($input_img_alt))
			$this->fields_form['input'][] = $input_img_alt;
	}

	public function postProcess()
	{
		if (Tools::isSubmit('save_image_map'))
		{
			if (!Tools::isSubmit('categories') || !count(Tools::getValue('categories')))
				$this->errors[] = Tools::displayError('You should select at least one category');
			if (!Tools::isSubmit('zones') || !count(Tools::getValue('zones')))
				$this->errors[] = Tools::displayError('You should make at least one zone');
		}

		parent::postProcess();
	}
}


