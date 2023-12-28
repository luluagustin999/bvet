<?php

namespace App\Modules\Informasi\Umum\Pelayanan\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class PelayananFilter extends PelayananModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Pelayanan
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Pelayanan.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Pelayanan.labelDay'),
                    2   => '2 ' . lang('Pelayanan.labelDays'),
                    3   => '3 ' . lang('Pelayanan.labelDays'),
                    7   => '1 ' . lang('Pelayanan.labelWeek'),
                    14  => '2 ' . lang('Pelayanan.labelWeeks'),
                    30  => '1 ' . lang('Pelayanan.labelMonth'),
                    90  => '3 ' . lang('Pelayanan.labelMonths'),
                    180 => '6 ' . lang('Pelayanan.labelMonths'),
                    365 => '1 ' . lang('Pelayanan.labelYear'),
                    'all' => lang('Pelayanan.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return PelayananFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('pelayanan.*');



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
