<?php
/**
 * @package     Conference
 *
 * @author      Stichting Sympathy <info@stichtingsympathy.nl>
 * @copyright   Copyright (C) 2013 - [year] Stichting Sympathy. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://stichtingsympathy.nl
 */

defined('_JEXEC') or die;

/**
 * Slots view.
 *
 * @package     Conference
 * @since       1.0
 */
class ConferenceViewSlots extends JViewLegacy
{
	/**
	 * The items to display.
	 *
	 * @var    array
	 * @since  1.0.0
	 */
	protected $items;

	/**
	 * The pagination object
	 *
	 * @var    JPagination
	 * @since  1.0.0
	 */
	protected $pagination;

	/**
	 * The user state.
	 *
	 * @var    JObject
	 * @since  1.0.0
	 */
	protected $state;

	/**
	 * Form with filters
	 *
	 * @var    array
	 * @since  1.0.0
	 */
	public $filterForm = array();

	/**
	 * List of active filters
	 *
	 * @var    array
	 * @since  1.0.0
	 */
	public $activeFilters = array();

	/**
	 * Access rights of a user
	 *
	 * @var    JObject
	 * @since  1.0.0
	 */
	protected $canDo;

	/**
	 * The sidebar to show
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $sidebar = '';

	/**
	 * Executes before rendering the page for the Browse task.
	 *
	 * @param   string  $tpl  Subtemplate to use
	 *
	 * @return  boolean  Return true to allow rendering of the page
	 *
	 * @since   1.0
	 */
	public function display($tpl = null)
	{
		// Load the data
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
		$this->state         = $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->canDo         = JHelperContent::getActions('com_conference');

		// Show the toolbar
		$this->toolbar();

		// Render the sidebar
		$helper = new ConferenceHelperConference;
		$helper->addSubmenu('slots');
		$this->sidebar = JHtmlSidebar::render();

		// Display it all
		return parent::display($tpl);
	}

	/**
	 * Displays a toolbar for a specific page.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	private function toolbar()
	{
		JToolbarHelper::title(JText::_('COM_CONFERENCE') . ' - ' . JText::_('COM_CONFERENCE_TITLE_SLOTS'), 'events');

		if ($this->canDo->get('core.create'))
		{
			JToolbarHelper::addNew('slot.add');
		}

		if ($this->canDo->get('core.edit') || $this->canDo->get('core.edit.own'))
		{
			JToolbarHelper::editList('slot.edit');
		}

		if ($this->canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('slots.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('slots.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

		if ($this->canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'slots.delete');
		}
	}
}
