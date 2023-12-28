<?php

namespace App\Modules\Informasi\LayananPpid\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class LayananPpidFilter extends LayananPpidModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of LayananPpid
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('LayananPpid.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('LayananPpid.labelDay'),
                    2   => '2 ' . lang('LayananPpid.labelDays'),
                    3   => '3 ' . lang('LayananPpid.labelDays'),
                    7   => '1 ' . lang('LayananPpid.labelWeek'),
                    14  => '2 ' . lang('LayananPpid.labelWeeks'),
                    30  => '1 ' . lang('LayananPpid.labelMonth'),
                    90  => '3 ' . lang('LayananPpid.labelMonths'),
                    180 => '6 ' . lang('LayananPpid.labelMonths'),
                    365 => '1 ' . lang('LayananPpid.labelYear'),
                    'all' => lang('LayananPpid.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return LayananPpidFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('layananppid.*');



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
