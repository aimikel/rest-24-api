<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\NoFileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;
use Symfony\Component\HttpFoundation\File\Exception\IniSizeFileException;
use App\Entity\Asset;

class File
{
//    private static $VALID_FILE_EXTENSION = 'text/csv';
//    private static $VALID_FILE_SIZE = 5000000;
//    private static $DELIMITER = ';';
//
//
//    public function checkIsValid(?UploadedFile $file): bool
//    {
//        $this->checkIsNotNull($file);
//        $this->checkExtension($file);
//        $this->checkSize($file);
//
//        return true;
//    }
//
//    private function checkIsNotNull(?UploadedFile $file)
//    {
//        if (null === $file) {
//            throw new NoFileException('No file given');
//        }
//
//        return true;
//    }
//
//    private function checkExtension(?UploadedFile $file)
//    {
//        if (self::$VALID_FILE_EXTENSION !== $file->getClientMimeType()) {
//            throw new ExtensionFileException('Non valid file extension');
//        }
//
//        return true;
//    }
//
//    private function checkSize(?UploadedFile $file)
//    {
//        if (self::$VALID_FILE_SIZE < $file->getSize()) {
//            throw new IniSizeFileException('File size too big');
//        }
//
//        return true;
//    }
//
//    public function preUpload(): string
//    {
//        return sha1('uploadedFile_' . date('m-d-Y_hi')) . '.csv';
//    }
//
//    public function parseCsvFile(string $file, EntityManager $entityManager): void
//    {
//        //$this->initiateCsvReaderForFile($file);
//        var_dump('i come here');
//        $assetRepository = $entityManager->getRepository(Asset::class);
//
//        var_dump('here');
//        while (false !== ($line = $this->csvReader->readLine())) {
//            $assetName = $line->get("Column1");
//            $assetDescription = $line->get("Column2");
//
//            $assetEntity = $assetRepository->findOneByName($assetName);
//
//            if(is_null($assetEntity)) {
//                $assetEntity = new Asset();
//                $assetEntity->setName($assetName);
//            }
//
//            $assetEntity->setDescription($assetDescription);
//
//            $this->em->persist($assetEntity);
//            $this->em->flush();
//        }
//    }
//
//    private function initiateCsvReaderForFile(string $file): void
//    {
//        $this->csvReader= new CSVReaderService();
//        $this->csvReader->init($file, true, self::$DELIMITER);
//    }
}
