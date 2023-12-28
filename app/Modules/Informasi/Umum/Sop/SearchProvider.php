<?php

namespace App\Modules\Informasi\Umum\Sop;

use Bonfire\Search\Interfaces\SearchProviderInterface;
use App\Modules\Informasi\Umum\Sop\Models\SopModel;

class SearchProvider extends SopModel implements SearchProviderInterface
{
    /**
     * Performs a primary search for just this resource.
     *
     * @param string     $term
     * @param int        $limit
     * @param array|null $post
     *
     * @return array
     */
    public function search(string $term, int $limit = 10, array $post = null): array
    {
        // @phpstan-ignore-next-line
        return $this
            ->select('sop.*')
            ->like('title', $term, 'right', true, true)
            ->orlike('content', $term, 'right', true, true)
            ->orderBy('title', 'asc')
            ->findAll($limit);
    }

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    public function resourceName(): string
    {
        return lang('Sop.sop');
    }

    /**
     * Returns a URL to the admin area URL main list
     * for this resource.
     *
     * @return string
     */
    public function resourceUrl(): string
    {
        return ADMIN_AREA . '/sop';
    }

    /**
     * Returns the name of the view to use when
     * displaying the list of results for this
     * resource type.
     *
     * @return string
     */
    public function resultView(): string
    {
        return 'App\Modules\Informasi\Umum\Sop\Views\_search_list';
    }
}
