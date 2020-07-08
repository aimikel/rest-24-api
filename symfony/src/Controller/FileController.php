<?php

namespace App\Controller;

use App\Service\File as FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    /**
     * @Route("/files", name="files_index", methods="POST")
     */
    public function index(Request $request, FileService $fileService): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        try {
            $fileService->handleFile($file);

            return Response::create();
        } catch (\Exception $exception) {
            return Response::create($exception->getMessage(), 422);
        }
    }
}