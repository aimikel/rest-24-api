<?php

namespace App\JsonApi\Hydrator\Asset;

use App\Entity\Asset;

/**
 * Update Asset Hydrator.
 */
class UpdateAssetHydrator extends AbstractAssetHydrator
{
    /**
     * {@inheritdoc}
     */
    protected function getAttributeHydrator($asset): array
    {
        return [
            'name' => function (Asset $asset, $attribute, $data, $attributeName) {
                $asset->setName($attribute);
            },
            'description' => function (Asset $asset, $attribute, $data, $attributeName) {
                $asset->setDescription($attribute);
            },
            'createdAt' => function (Asset $asset, $attribute, $data, $attributeName) {
                $asset->setCreatedAt(new \DateTime($attribute));
            },
            'updatedAt' => function (Asset $asset, $attribute, $data, $attributeName) {
                $asset->setUpdatedAt(new \DateTime($attribute));
            },
        ];
    }
}
