<?php

namespace App\Modules\Informasi\Umum\Sop\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class SopFilter extends SopModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Sop
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Sop.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Sop.labelDay'),
                    2   => '2 ' . lang('Sop.labelDays'),
                    3   => '3 ' . lang('Sop.labelDays'),
                    7   => '1 ' . lang('Sop.labelWeek'),
                    14  => '2 ' . lang('Sop.labelWeeks'),
                    30  => '1 ' . lang('Sop.labelMonth'),
                    90  => '3 ' . lang('Sop.labelMonths'),
                    180 => '6 ' . lang('Sop.labelMonths'),
                    365 => '1 ' . lang('Sop.labelYear'),
                    'all' => lang('Sop.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return SopFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('sop.*');



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
