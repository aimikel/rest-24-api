<?php

namespace App\Controller;

use App\Entity\Asset;
use App\JsonApi\Document\Asset\AssetDocument;
use App\JsonApi\Document\Asset\AssetsDocument;
use App\JsonApi\Hydrator\Asset\CreateAssetHydrator;
use App\JsonApi\Hydrator\Asset\UpdateAssetHydrator;
use App\JsonApi\Transformer\AssetResourceTransformer;
use App\Repository\AssetRepository;
use Paknahad\JsonApiBundle\Controller\Controller;
use Paknahad\JsonApiBundle\Helper\ResourceCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use WoohooLabs\Yin\JsonApi\Exception\DefaultExceptionFactory;

/**
 * @Route("/assets")
 */
class AssetController extends Controller
{
    /**
     * @Route("/", name="assets_index", methods="GET")
     */
    public function index(AssetRepository $assetRepository, ResourceCollection $resourceCollection): ResponseInterface
    {
        $resourceCollection->setRepository($assetRepository);

        $resourceCollection->handleIndexRequest();

        return $this->jsonApi()->respond()->ok(
            new AssetsDocument(new AssetResourceTransformer()),
            $resourceCollection
        );
    }

    /**
     * @Route("/", name="assets_new", methods="POST")
     */
    public function new(ValidatorInterface $validator, DefaultExceptionFactory $exceptionFactory): ResponseInterface
    {
        $entityManager = $this->getDoctrine()->getManager();

        $asset = $this->jsonApi()->hydrate(new CreateAssetHydrator($entityManager, $exceptionFactory), new Asset());

        /** @var ConstraintViolationList $errors */
        $errors = $validator->validate($asset);
        if ($errors->count() > 0) {
            return $this->validationErrorResponse($errors);
        }

        $entityManager->persist($asset);
        $entityManager->flush();

        return $this->jsonApi()->respond()->ok(
            new AssetDocument(new AssetResourceTransformer()),
            $asset
        );
    }

    /**
     * @Route("/{name}", name="assets_show", methods="GET")
     */
    public function show(Asset $asset): ResponseInterface
    {
        return $this->jsonApi()->respond()->ok(
            new AssetDocument(new AssetResourceTransformer()),
            $asset
        );
    }

    /**
     * @Route("/{name}", name="assets_edit", methods="PATCH")
     */
    public function edit(Asset $asset, ValidatorInterface $validator, DefaultExceptionFactory $exceptionFactory): ResponseInterface
    {
        $entityManager = $this->getDoctrine()->getManager();

        $asset = $this->jsonApi()->hydrate(new UpdateAssetHydrator($entityManager, $exceptionFactory), $asset);

        /** @var ConstraintViolationList $errors */
        $errors = $validator->validate($asset);
        if ($errors->count() > 0) {
            return $this->validationErrorResponse($errors);
        }

        $entityManager->flush();

        return $this->jsonApi()->respond()->ok(
            new AssetDocument(new AssetResourceTransformer()),
            $asset
        );
    }

    /**
     * @Route("/{name}", name="assets_delete", methods="DELETE")
     */
    public function delete(Request $request, Asset $asset): ResponseInterface
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($asset);
        $entityManager->flush();

        return $this->jsonApi()->respond()->genericSuccess(204);
    }
}
