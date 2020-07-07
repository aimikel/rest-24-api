<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Service\File as FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TangoMan\CSVReaderBundle\Service\CSVReaderService;

class FileController extends AbstractController
{
    private static $UPLOAD_PATH = '../files';

    /**
     * @Route("/files", name="files_index", methods="POST")
     */
    public function index(Request $request, FileService $fileService): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        try {
            $fileService->checkIsValid($file);
        } catch (\Exception $exc) {
            return Response::create($exc->getMessage(), 422);
        }

        $filename = $fileService->preUpload();
        $file->move(self::$UPLOAD_PATH, $filename);

//        $filePath = self::$UPLOAD_PATH . '/' . $filename;



        //repository load
        $entityManager = $this->getDoctrine()->getManager();
        $assetRepository = $entityManager->getRepository(Asset::class);

        $csvReader= new CSVReaderService();
        $csvReader->init($file, true, ';');

        while (false !== ($line = $csvReader->readLine())) {
            var_dump($line);
            $assetName = $line->get("Column1");
            $assetDescription = $line->get("Column2");

            $assetEntity = $assetRepository->findOneByName($assetName);

            if(is_null($assetEntity)) {
                var_dump('does not exist!');
                $assetEntity = new Asset();
                $assetEntity->setName($assetName);
            }

            $assetEntity->setDescription($assetDescription);

            $entityManager->persist($assetEntity);
            $entityManager->flush();
        }


        return Response::create('File successfully uploaded', 200);
    }


}