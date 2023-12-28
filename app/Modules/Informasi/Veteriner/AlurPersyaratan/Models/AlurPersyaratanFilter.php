<?php

namespace App\Modules\Informasi\Veteriner\AlurPersyaratan\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class AlurPersyaratanFilter extends AlurPersyaratanModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of AlurPersyaratan
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('AlurPersyaratan.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('AlurPersyaratan.labelDay'),
                    2   => '2 ' . lang('AlurPersyaratan.labelDays'),
                    3   => '3 ' . lang('AlurPersyaratan.labelDays'),
                    7   => '1 ' . lang('AlurPersyaratan.labelWeek'),
                    14  => '2 ' . lang('AlurPersyaratan.labelWeeks'),
                    30  => '1 ' . lang('AlurPersyaratan.labelMonth'),
                    90  => '3 ' . lang('AlurPersyaratan.labelMonths'),
                    180 => '6 ' . lang('AlurPersyaratan.labelMonths'),
                    365 => '1 ' . lang('AlurPersyaratan.labelYear'),
                    'all' => lang('AlurPersyaratan.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return AlurPersyaratanFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('alurpersyaratan.*');



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
