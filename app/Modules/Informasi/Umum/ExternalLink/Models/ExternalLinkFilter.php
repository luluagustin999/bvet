<?php

namespace App\Modules\Informasi\Umum\ExternalLink\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class ExternalLinkFilter extends ExternalLinkModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of ExternalLink
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('ExternalLink.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('ExternalLink.labelDay'),
                    2   => '2 ' . lang('ExternalLink.labelDays'),
                    3   => '3 ' . lang('ExternalLink.labelDays'),
                    7   => '1 ' . lang('ExternalLink.labelWeek'),
                    14  => '2 ' . lang('ExternalLink.labelWeeks'),
                    30  => '1 ' . lang('ExternalLink.labelMonth'),
                    90  => '3 ' . lang('ExternalLink.labelMonths'),
                    180 => '6 ' . lang('ExternalLink.labelMonths'),
                    365 => '1 ' . lang('ExternalLink.labelYear'),
                    'all' => lang('ExternalLink.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return ExternalLinkFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('externallink.*');



        if (
            isset($params['created_at'])
            && !empty($params['created_at'])
            && $params['created_at'] != 'all'
        ) {
            $days = $params['created_at'];
            $this->where('created_at >=', Time::now()->subDays($days)->toDateTimeString());
        }

        return $this;
    }
}
