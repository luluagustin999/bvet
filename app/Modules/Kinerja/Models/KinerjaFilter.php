<?php

namespace App\Modules\Kinerja\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class KinerjaFilter extends KinerjaModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Kinerja
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Kinerja.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Kinerja.labelDay'),
                    2   => '2 ' . lang('Kinerja.labelDays'),
                    3   => '3 ' . lang('Kinerja.labelDays'),
                    7   => '1 ' . lang('Kinerja.labelWeek'),
                    14  => '2 ' . lang('Kinerja.labelWeeks'),
                    30  => '1 ' . lang('Kinerja.labelMonth'),
                    90  => '3 ' . lang('Kinerja.labelMonths'),
                    180 => '6 ' . lang('Kinerja.labelMonths'),
                    365 => '1 ' . lang('Kinerja.labelYear'),
                    'all' => lang('Kinerja.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return KinerjaFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('kinerja.*');



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
