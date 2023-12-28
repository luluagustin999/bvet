<?php

namespace App\Modules\Informasi\Veteriner\SertifikatHasil\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class SertifikatHasilFilter extends SertifikatHasilModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of SertifikatHasil
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('SertifikatHasil.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('SertifikatHasil.labelDay'),
                    2   => '2 ' . lang('SertifikatHasil.labelDays'),
                    3   => '3 ' . lang('SertifikatHasil.labelDays'),
                    7   => '1 ' . lang('SertifikatHasil.labelWeek'),
                    14  => '2 ' . lang('SertifikatHasil.labelWeeks'),
                    30  => '1 ' . lang('SertifikatHasil.labelMonth'),
                    90  => '3 ' . lang('SertifikatHasil.labelMonths'),
                    180 => '6 ' . lang('SertifikatHasil.labelMonths'),
                    365 => '1 ' . lang('SertifikatHasil.labelYear'),
                    'all' => lang('SertifikatHasil.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return SertifikatHasilFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('sertifikathasil.*');



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
