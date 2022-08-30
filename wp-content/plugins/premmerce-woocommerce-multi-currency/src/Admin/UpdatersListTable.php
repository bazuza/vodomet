<?php

namespace Premmerce\WoocommerceMulticurrency\Admin;

use Premmerce\WoocommerceMulticurrency\Admin\RatesUpdate\AbstractRatesUpdater;
use Premmerce\WoocommerceMulticurrency\Admin\RatesUpdate\RatesUpdateController;


class UpdatersListTable extends \WP_List_Table
{

    /**
     * @var RatesUpdateController
     */
    private $ratesUpdateController;

    /**
     * UpdatersListTable constructor.
     * @param RatesUpdateController $ratesUpdateController
     */
    public function __construct(RatesUpdateController $ratesUpdateController)
    {

        $this->ratesUpdateController = $ratesUpdateController;

        parent::__construct([
            'singular' => __('Exchange rates service', 'premmerce-woocommerce-multicurrency'),
            'plural' => __('Exchange rates services', 'premmerce-woocommerce-multicurrency'),
            'ajax' => false
        ]);

    }

    /**
     * Return table columns list
     *
     * @return array
     */
    function get_columns()
    {
        $columns = [
            'name' => __('Name', 'premmerce-woocommerce-multicurrency'),
            'status' => __('Service status', 'premmerce-woocommerce-multicurrency'),
            'homePage' => __('Service home page', 'premmerce-woocommerce-multicurrency')
        ];

        return apply_filters('premmerce-multicurrency-list-table-rates-sources-columns', $columns);
    }

    /**
     * Render name column content
     *
     * @param AbstractRatesUpdater $updaterItem
     *
     * @return mixed
     */
    public function column_name($updaterItem)
    {
        if ($updaterItem->hasSettings()) {
            $editUpdaterUrl = sprintf('?page=%s&action=%s&updater=%s', 'premmerce_multicurrency', 'edit-updater',
                $updaterItem->getId());
            return '<a href="' . $editUpdaterUrl . '">' . $updaterItem->getPublicName() . '</a>';
        }

        return '<span class="premmerce-multicurrency list-table-updater-title" title="' . __('This service hasn\'t settings') . '">' . $updaterItem->getPublicName() . '</span>';
    }

    /**
     * @param AbstractRatesUpdater $item
     * @param string $column_name
     *
     * @return string
     */
    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'status':
                $statusMessage = __('Updating...', 'premmerce-woocommerce-multicurrency');
                return '<span class="fa fa-refresh premmerce-multicurrency-updater-status" data-updater-id="' . $item->getId() . '"></span> ' . '<span class="premmerce-multicurrency-updater-status-message">' . $statusMessage . '</span>';
            case 'homePage':
                return '<a target="_blank" href="' . $item->getHomePage() . '" class="homepage_url">' . $item->getHomePage() . '</a>';
        }

    }

    /**
     * Return sortable columns list
     *
     * @return array
     */
    function get_sortable_columns()
    {
        return [
            'name' => ['name', false],
            'status' => ['status', false]
        ];
    }

    /**
     * Get and prepare table items
     */
    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];

        $updaters = $this->ratesUpdateController->getAvailableUpdaters();

        usort($updaters, [&$this, 'sortItems']);
        $this->items = $updaters;
    }

    /**
     * Sort table items
     *
     * @param $a
     * @param $b
     *
     * @return int
     */
    function sortItems($a, $b)
    {
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'name';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        $methodName = ('name' === $orderby) ? 'getPublicName' : 'isAlive';
        $result = strcmp(strval($a->{$methodName}()), strval($b->{$methodName}()));

        return $order === 'asc' ? $result : -$result;
    }

    /**
     * Add custom class to table element
     *
     * @return array
     */
    function get_table_classes()
    {
        $classes = parent::get_table_classes();
        $classes[] = 'premmerce-multicurrency-updaters-table';
        return $classes;
    }

}