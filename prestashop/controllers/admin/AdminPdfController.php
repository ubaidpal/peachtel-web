<?php
/*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
ing*
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
*  @version  Release: $Revision: 17889 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class AdminPdfControllerCore extends AdminController
{
	public function postProcess()
	{
		parent::postProcess();

		// We want to be sure that displaying PDF is the last thing this controller will do
		exit;
	}

	public function initProcess()
	{
		parent::initProcess();	
		$access = Profile::getProfileAccess($this->context->employee->id_profile, (int)Tab::getIdFromClassName('AdminOrders'));
		if ($access['view'] === '1' && ($action = Tools::getValue('submitAction')))
			$this->action = $action;
		else
			$this->errors[] = Tools::displayError('You do not have permission to view here.');
	}

	public function processGenerateInvoicePdf()
	{
		if (Tools::isSubmit('id_order'))
			$this->generateInvoicePDFByIdOrder(Tools::getValue('id_order'));
		elseif (Tools::isSubmit('id_order_invoice'))
			$this->generateInvoicePDFByIdOrderInvoice(Tools::getValue('id_order_invoice'));
		else
			die (Tools::displayError('Missing order ID or invoice order ID'));
	}

	public function processGenerateOrderSlipPDF()
	{
		$orderSlip = new OrderSlip((int)Tools::getValue('id_order_slip'));
		$order = new Order((int)$orderSlip->id_order);
		if (!Validate::isLoadedObject($order))
			die(Tools::displayError('Cannot find order in database'));
		$order->products = OrderSlip::getOrdersSlipProducts($orderSlip->id, $order);

		$this->generatePDF($orderSlip, PDF::TEMPLATE_ORDER_SLIP);
	}

	public function processGenerateDeliverySlipPDF()
	{
		if (Tools::isSubmit('id_order'))
			$this->generateDeliverySlipPDFByIdOrder((int)Tools::getValue('id_order'));
		elseif (Tools::isSubmit('id_order_invoice'))
			$this->generateDeliverySlipPDFByIdOrderInvoice((int)Tools::getValue('id_order_invoice'));
		elseif (Tools::isSubmit('id_delivery'))
		{
			$order = Order::getByDelivery((int)Tools::getValue('id_delivery'));
			$this->generateDeliverySlipPDFByIdOrder((int)$order->id);
		}
		else
			die (Tools::displayError('Missing order ID or invoice order ID'));
	}

	public function processGenerateInvoicesPDF()
	{
		$order_invoice_collection = OrderInvoice::getByDateInterval(Tools::getValue('date_from'), Tools::getValue('date_to'));

		if (!count($order_invoice_collection))
			die(Tools::displayError('No invoices found'));

		$this->generatePDF($order_invoice_collection, PDF::TEMPLATE_INVOICE);
	}

	public function processGenerateInvoicesPDF2()
	{
		$order_invoice_collection = array();
		foreach (explode('-', Tools::getValue('id_order_state')) as $id_order_state)
			if (is_array($order_invoices = OrderInvoice::getByStatus((int)$id_order_state)))
				$order_invoice_collection = array_merge($order_invoices, $order_invoice_collection);

		if (!count($order_invoice_collection))
			die(Tools::displayError('No invoices found'));

		$this->generatePDF($order_invoice_collection, PDF::TEMPLATE_INVOICE);
	}

	public function processGenerateOrderSlipsPDF()
	{
		$id_order_slips_list = OrderSlip::getSlipsIdByDate(Tools::getValue('date_from'), Tools::getValue('date_to'));
		if (!count($id_order_slips_list))
			die (Tools::displayError('No order slips found'));

		$order_slips = array();
		foreach ($id_order_slips_list as $id_order_slips)
			$order_slips[] = new OrderSlip((int)$id_order_slips);

		$this->generatePDF($order_slips, PDF::TEMPLATE_ORDER_SLIP);
	}

	public function processGenerateDeliverySlipsPDF()
	{
		$order_invoice_collection = OrderInvoice::getByDeliveryDateInterval(Tools::getValue('date_from'), Tools::getValue('date_to'));

		if (!count($order_invoice_collection))
			die(Tools::displayError('No invoices found'));

		$this->generatePDF($order_invoice_collection, PDF::TEMPLATE_DELIVERY_SLIP);
	}

	public function processGenerateSupplyOrderFormPDF()
	{
		if (!Tools::isSubmit('id_supply_order'))
			die (Tools::displayError('Missing supply order ID'));

		$id_supply_order = (int)Tools::getValue('id_supply_order');
		$supply_order = new SupplyOrder($id_supply_order);

		if (!Validate::isLoadedObject($supply_order))
			die(Tools::displayError('Cannot find this supply order in the database'));

		$this->generatePDF($supply_order, PDF::TEMPLATE_SUPPLY_ORDER_FORM);
	}

	public function generateDeliverySlipPDFByIdOrder($id_order)
	{
		$order = new Order((int)$id_order);
		if (!Validate::isLoadedObject($order))
			throw new PrestaShopException('Can\'t load Order object');

		$order_invoice_collection = $order->getInvoicesCollection();
		$this->generatePDF($order_invoice_collection, PDF::TEMPLATE_DELIVERY_SLIP);
	}

	public function generateDeliverySlipPDFByIdOrderInvoice($id_order_invoice)
	{
		$order_invoice = new OrderInvoice((int)$id_order_invoice);
		if (!Validate::isLoadedObject($order_invoice))
			throw new PrestaShopException('Can\'t load Order Invoice object');

		$this->generatePDF($order_invoice, PDF::TEMPLATE_DELIVERY_SLIP);
	}

	public function generateInvoicePDFByIdOrder($id_order)
	{
		$order = new Order((int)$id_order);
		if (!Validate::isLoadedObject($order))
			die(Tools::displayError('Cannot find order in database'));

		$order_invoice_list = $order->getInvoicesCollection();
		Hook::exec('actionPDFInvoiceRender', array('order_invoice_list' => $order_invoice_list));
		$this->generatePDF($order_invoice_list, PDF::TEMPLATE_INVOICE);
	}

	public function generateInvoicePDFByIdOrderInvoice($id_order_invoice)
	{
		$order_invoice = new OrderInvoice((int)$id_order_invoice);
		if (!Validate::isLoadedObject($order_invoice))
			die(Tools::displayError('Cannot find order invoice in database'));

		Hook::exec('actionPDFInvoiceRender', array('order_invoice_list' => array($order_invoice)));
		$this->generatePDF($order_invoice, PDF::TEMPLATE_INVOICE);
	}

	public function generatePDF($object, $template)
	{
		$pdf = new PDF($object, $template, Context::getContext()->smarty);
		$pdf->render();
	}
}
