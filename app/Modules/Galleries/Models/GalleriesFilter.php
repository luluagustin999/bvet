<?php

namespace App\Modules\Galleries\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class GalleriesFilter extends GalleriesModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Galleries
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Galleries.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Galleries.labelDay'),
                    2   => '2 ' . lang('Galleries.labelDays'),
                    3   => '3 ' . lang('Galleries.labelDays'),
                    7   => '1 ' . lang('Galleries.labelWeek'),
                    14  => '2 ' . lang('Galleries.labelWeeks'),
                    30  => '1 ' . lang('Galleries.labelMonth'),
                    90  => '3 ' . lang('Galleries.labelMonths'),
                    180 => '6 ' . lang('Galleries.labelMonths'),
                    365 => '1 ' . lang('Galleries.labelYear'),
                    'all' => lang('Galleries.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return GalleriesFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('galleries.*');



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
