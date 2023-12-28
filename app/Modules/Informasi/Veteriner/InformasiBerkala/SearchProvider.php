<?php

namespace App\Modules\Informasi\Veteriner\InformasiBerkala;

use Bonfire\Search\Interfaces\SearchProviderInterface;
use App\Modules\Informasi\Veteriner\InformasiBerkala\Models\InformasiBerkalaModel;

class SearchProvider extends InformasiBerkalaModel implements SearchProviderInterface
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
            ->select('informasiberkala.*')
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
        return lang('InformasiBerkala.informasiberkala');
    }

    /**
     * Returns a URL to the admin area URL main list
     * for this resource.
     *
     * @return string
     */
    public function resourceUrl(): string
    {
        return ADMIN_AREA . '/informasiberkala';
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
        return 'App\Modules\Informasi\Veteriner\InformasiBerkala\Views\_search_list';
    }
}
