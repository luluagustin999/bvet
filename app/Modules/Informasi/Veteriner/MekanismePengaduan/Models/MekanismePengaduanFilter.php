<?php

namespace App\Modules\Informasi\Veteriner\MekanismePengaduan\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class MekanismePengaduanFilter extends MekanismePengaduanModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of MekanismePengaduan
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('MekanismePengaduan.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('MekanismePengaduan.labelDay'),
                    2   => '2 ' . lang('MekanismePengaduan.labelDays'),
                    3   => '3 ' . lang('MekanismePengaduan.labelDays'),
                    7   => '1 ' . lang('MekanismePengaduan.labelWeek'),
                    14  => '2 ' . lang('MekanismePengaduan.labelWeeks'),
                    30  => '1 ' . lang('MekanismePengaduan.labelMonth'),
                    90  => '3 ' . lang('MekanismePengaduan.labelMonths'),
                    180 => '6 ' . lang('MekanismePengaduan.labelMonths'),
                    365 => '1 ' . lang('MekanismePengaduan.labelYear'),
                    'all' => lang('MekanismePengaduan.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return MekanismePengaduanFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('mekanismepengaduan.*');



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
