<?php

namespace Cms\Service;

class RouteCache
{
    protected $cacheFile;

    protected $pageModel;

    public function setCacheFile($file)
    {
        $this->cacheFile = $file;

        return $this;
    }

    public function setPageModel($model)
    {
        $this->pageModel = $model;

        return $this;
    }

    /**
     * Get a list of published routes and cache them in a file
     *
     * @throws \Exception
     */
    public function rebuild()
    {
        // Don't bother if there's no cache file in config
        if (empty($this->cacheFile)) {
            throw new \Exception(
                'Cannot rebuild route cache because no file is provided in config.'
            );
        }
        // Get all published routes
        $routes = $this->pageModel->getPublishedRoutes();

        // Smash them into a pipe-separated string
        $pipedRoutes = implode('|', $routes);

        // Write to the cache file
        try {
            file_put_contents($this->cacheFile, $pipedRoutes);
        } catch (Exception $e) {
            // Bubble it on up
            throw $e;
        }
    }
}
