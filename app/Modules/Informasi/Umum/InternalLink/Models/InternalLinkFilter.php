<?php

namespace App\Modules\Informasi\Umum\InternalLink\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class InternalLinkFilter extends InternalLinkModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of InternalLink
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('InternalLink.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('InternalLink.labelDay'),
                    2   => '2 ' . lang('InternalLink.labelDays'),
                    3   => '3 ' . lang('InternalLink.labelDays'),
                    7   => '1 ' . lang('InternalLink.labelWeek'),
                    14  => '2 ' . lang('InternalLink.labelWeeks'),
                    30  => '1 ' . lang('InternalLink.labelMonth'),
                    90  => '3 ' . lang('InternalLink.labelMonths'),
                    180 => '6 ' . lang('InternalLink.labelMonths'),
                    365 => '1 ' . lang('InternalLink.labelYear'),
                    'all' => lang('InternalLink.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return InternalLinkFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('internallink.*');



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
