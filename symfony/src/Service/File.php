<?php

namespace App\Service;

use App\Entity\Asset;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;
use Symfony\Component\HttpFoundation\File\Exception\IniSizeFileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TangoMan\CSVReaderBundle\Service\CSVReaderService;

class File implements UploaderInterface
{
    private static $VALID_FILE_EXTENSION = 'text/csv';
    private static $VALID_FILE_SIZE = 5000000;
    private static $UPLOAD_DIR = 'files';
    private $projectDir;
    private $entityManager;

    public function __construct(EntityManagerInterface $em, string $projectDir)
    {
        $this->entityManager = $em;
        $this->projectDir = $projectDir;
    }

    public function handleFile(UploadedFile $file): bool
    {
        $this->checkIsValid($file);

        $file = $file->move($this->getUploadDir(), $this->setFileName());

        return $this->parseFile($file);
    }

    public function checkIsValid(UploadedFile $file): bool
    {
        $this->checkExtension($file);
        $this->checkSize($file);

        return true;
    }

    private function checkExtension(UploadedFile $file): bool
    {
        if (self::$VALID_FILE_EXTENSION !== $file->getClientMimeType()) {
            throw new ExtensionFileException('Non valid file extension');
        }

        return true;
    }

    private function checkSize(UploadedFile $file): bool
    {
        if (self::$VALID_FILE_SIZE < $file->getSize()) {
            throw new IniSizeFileException('File size too big');
        }

        return true;
    }

    public function getUploadDir(): string
    {
        return $this->projectDir . '/' . self::$UPLOAD_DIR;
    }

    public function setFileName(): string
    {
        return sha1('uploadedFile_' . date('m-d-Y_hi')) . '.csv';
    }

    public function parseFile($file): bool
    {
        $assetRepository = $this->entityManager->getRepository(Asset::class);

        $csvReader = new CSVReaderService();
        $csvReader->init($file, true, ';');

        while (false !== ($line = $csvReader->readLine())) {
            if (!$this->validateLine($line)) {
                continue;
            }
            $assetName = trim($line->get("Name"));
            $assetDescription = trim($line->get("Description"));

            $assetEntity = $assetRepository->findOneByName($assetName);

            if (is_null($assetEntity)) {
                $assetEntity = new Asset();
                $assetEntity->setName($assetName);
            }

            $assetEntity->setDescription($assetDescription);

            $this->entityManager->persist($assetEntity);
            $this->entityManager->flush();
        }

        return true;
    }

    private function validateLine($line): bool
    {
        $assetName = trim($line->get("Name"));

        return $assetName && !empty($assetName);
    }
}
