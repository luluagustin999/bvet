<?php

namespace App\Modules\Informasi\Umum\Gallery\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class GalleryFilter extends GalleryModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Gallery
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Gallery.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Gallery.labelDay'),
                    2   => '2 ' . lang('Gallery.labelDays'),
                    3   => '3 ' . lang('Gallery.labelDays'),
                    7   => '1 ' . lang('Gallery.labelWeek'),
                    14  => '2 ' . lang('Gallery.labelWeeks'),
                    30  => '1 ' . lang('Gallery.labelMonth'),
                    90  => '3 ' . lang('Gallery.labelMonths'),
                    180 => '6 ' . lang('Gallery.labelMonths'),
                    365 => '1 ' . lang('Gallery.labelYear'),
                    'all' => lang('Gallery.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return GalleryFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('gallery.*');



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
