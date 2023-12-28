<?php

namespace App\Modules\Downloads\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class DownloadsFilter extends DownloadsModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Downloads
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Downloads.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Downloads.labelDay'),
                    2   => '2 ' . lang('Downloads.labelDays'),
                    3   => '3 ' . lang('Downloads.labelDays'),
                    7   => '1 ' . lang('Downloads.labelWeek'),
                    14  => '2 ' . lang('Downloads.labelWeeks'),
                    30  => '1 ' . lang('Downloads.labelMonth'),
                    90  => '3 ' . lang('Downloads.labelMonths'),
                    180 => '6 ' . lang('Downloads.labelMonths'),
                    365 => '1 ' . lang('Downloads.labelYear'),
                    'all' => lang('Downloads.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return DownloadsFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('downloads.*');



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
