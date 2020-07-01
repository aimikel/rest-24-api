<?php

namespace App\JsonApi\Transformer;

use App\Entity\Asset;
use WoohooLabs\Yin\JsonApi\Schema\Link\ResourceLinks;
use WoohooLabs\Yin\JsonApi\Schema\Link\Link;
use WoohooLabs\Yin\JsonApi\Schema\Resource\AbstractResource;

/**
 * Asset Resource Transformer.
 */
class AssetResourceTransformer extends AbstractResource
{
    /**
     * {@inheritdoc}
     */
    public function getType($asset): string
    {
        return 'assets';
    }

    /**
     * {@inheritdoc}
     */
    public function getId($asset): string
    {
        return (string)$asset->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta($asset): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks($asset): ?ResourceLinks
    {
        return ResourceLinks::createWithoutBaseUri()->setSelf(new Link('/assets/' . $this->getId($asset)));
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes($asset): array
    {
        return [
            'name' => function (Asset $asset) {
                return $asset->getName();
            },
            'description' => function (Asset $asset) {
                return $asset->getDescription();
            },
            'createdAt' => function (Asset $asset) {
                return $asset->getCreatedAt()->format(DATE_ATOM);
            },
            'updatedAt' => function (Asset $asset) {
                if (is_null($asset->getUpdatedAt())) {
                    return null;
                }

                return $asset->getUpdatedAt()->format(DATE_ATOM);
            },
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultIncludedRelationships($asset): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getRelationships($asset): array
    {
        return [
        ];
    }
}
