<?php
declare(strict_types=1);
namespace App\Controllers\API;

use App\Models\Service;

final class ServiceApiController
{
    /** GET /api/menu/services -> mega menu (category + services: title, slug) */
    public function menu(): void
    {
        header('Cache-Control: public, max-age=300');

        json_response([
            'success' => true,
            'data'    => Service::publishedMenu(),
        ]);
    }

    /** GET /api/services/grouped -> services page (category + services with short description) */
    public function grouped(): void
    {
        header('Cache-Control: public, max-age=300');

        json_response([
            'success' => true,
            'data'    => Service::publishedGrouped(),
        ]);
    }

    /** GET /api/services/{slug} -> service details page */
    public function show(string $slug): void
    {
        $service = Service::findPublishedBySlug($slug);

        if ($service === null) {
            json_response(['success' => false, 'message' => 'Service not found'], 404);
        }

        json_response([
            'success' => true,
            'data'    => $service,
        ]);
    }
}