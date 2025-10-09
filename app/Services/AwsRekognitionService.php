<?php

namespace App\Services;

use Aws\Rekognition\RekognitionClient;
use Aws\S3\S3Client;

class AwsRekognitionService
{
    private $rekognition;
    private $s3;
    private $bucket;
    private $collectionId;

    public function __construct()
    {
        $this->bucket = config('filesystems.disks.s3.bucket', env('AWS_BUCKET'));
        $this->collectionId = env('AWS_REKOGNITION_COLLECTION');

        $this->rekognition = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);

        $this->s3 = new S3Client([
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);
    }

    public function uploadToS3($file, $path)
    {
        $key = $path . '/' . uniqid() . '.' . $file->getClientOriginalExtension();

        $this->s3->putObject([
            'Bucket' => $this->bucket,
            'Key' => $key,
            'SourceFile' => $file->getRealPath(),
            // 'ACL' => 'public-read'
        ]);

        return "https://{$this->bucket}.s3.amazonaws.com/{$key}";
    }

    public function indexFace($imageKey, $externalImageId)
    {
        $result = $this->rekognition->indexFaces([
            'CollectionId' => $this->collectionId,
            'Image' => [
                'S3Object' => [
                    'Bucket' => $this->bucket,
                    'Name' => $imageKey,
                ],
            ],
            'ExternalImageId' => (string) $externalImageId,
        ]);

        return $result['FaceRecords'][0]['Face']['FaceId'] ?? null;
    }

    public function searchFace($imageKey)
    {
        $result = $this->rekognition->searchFacesByImage([
            'CollectionId' => $this->collectionId,
            'Image' => [
                'S3Object' => [
                    'Bucket' => $this->bucket,
                    'Name' => $imageKey,
                ],
            ],
            'FaceMatchThreshold' => 85,
            'MaxFaces' => 1,
        ]);

        return $result['FaceMatches'][0] ?? null;
    }

    public function listFaces()
    {
        $result = $this->rekognition->listFaces([
            'CollectionId' => $this->collectionId,
        ]);

        return $result['Faces'];
    }
}
