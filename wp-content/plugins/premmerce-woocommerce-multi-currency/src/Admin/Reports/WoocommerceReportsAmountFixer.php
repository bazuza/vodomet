<?php namespace Premmerce\WoocommerceMulticurrency\Admin\Reports;

class WoocommerceReportsAmountFixer
{

    /**
     * @var ReportsDataQueryBuilder
     */
    private $reportDataQueryBuilder;

    /**
     * @var array
     */
    private $reportDataRequestArgs = [];

    /**
     * @var string
     */
    private $reportClassName;

    /**
     * @var string
     */
    private $reportName;


    /**
     * WoocommerceReportsAmountFixer constructor.
     *
     * @param ReportsDataQueryBuilder
     */
    public function __construct(ReportsDataQueryBuilder $reportDataQueryBuilder)
    {
        $this->reportDataQueryBuilder = $reportDataQueryBuilder;

        //Save args used to build query and use this args later to build our query.
        //Woocommerce don't give us arguments on 'woocommerce_reports_get_order_report_query' hook, so we need this trick.
        add_filter('wc_admin_reports_path', [$this, 'saveReportName'], 10, 3);
        add_filter('woocommerce_reports_get_order_report_data_args', [$this, 'saveReportDataRequestArgs'], 999);
        add_filter('woocommerce_reports_get_order_report_query', [$this, 'reBuildReportDataQueryParts']);
    }

    /**
     * @param $fileName
     * @param $name
     * @param $class
     *
     * @return string $fileName
     */
    public function saveReportName($fileName, $name, $class){
        $this->reportClassName = $class;
        $this->reportName = $name;

        return $fileName;
    }



    /**
     * Save args will be used for order report data query to re-build query
     *
     * @param $args
     * @return mixed
     */
    public function saveReportDataRequestArgs($args){
        $defaultArgs = [
            'data'                => [],
            'where'               => [],
            'where_meta'          => [],
            'query_type'          => 'get_row',
            'group_by'            => '',
            'order_by'            => '',
            'limit'               => '',
            'filter_range'        => false,
            'nocache'             => false,
            'debug'               => false,
            'order_types'         => wc_get_order_types( 'reports' ),
            'order_status'        => ['completed', 'processing', 'on-hold'],
            'parent_order_status' => false,
        ];


        $this->reportDataRequestArgs = wp_parse_args($args, $defaultArgs);

        //Disable cache for original requests to prevent wrong results after plugin activation before first cache update
        $args['nocache'] = true;

        return $args;
    }

    /**
     * Build query parts to get report data from DB.
     * Based on WC_Admin_Report::get_order_report_data() method.
     *
     * @param array     $originalQuery
     *
     * @return array    $newQuery
     */
    public function reBuildReportDataQueryParts($originalQuery){
        if(! $this->reportDataRequestArgs){
            return $originalQuery;
        }

        $reportData = [
            'reportName' => $this->reportName,
            'reportClassName' => $this->reportClassName
        ];

        return $this->reportDataQueryBuilder->buildNewReportDataQuery($this->reportDataRequestArgs, $reportData);
    }



}