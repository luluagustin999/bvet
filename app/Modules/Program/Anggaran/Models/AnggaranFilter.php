<?php

namespace App\Modules\Program\Anggaran\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class AnggaranFilter extends AnggaranModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Anggaran
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Anggaran.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Anggaran.labelDay'),
                    2   => '2 ' . lang('Anggaran.labelDays'),
                    3   => '3 ' . lang('Anggaran.labelDays'),
                    7   => '1 ' . lang('Anggaran.labelWeek'),
                    14  => '2 ' . lang('Anggaran.labelWeeks'),
                    30  => '1 ' . lang('Anggaran.labelMonth'),
                    90  => '3 ' . lang('Anggaran.labelMonths'),
                    180 => '6 ' . lang('Anggaran.labelMonths'),
                    365 => '1 ' . lang('Anggaran.labelYear'),
                    'all' => lang('Anggaran.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return AnggaranFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('anggaran.*');



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
