<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Serializers\Normalizers\Exception\ExceptionNormalizer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

readonly class ExceptionListener
{
    public function __construct(
        private SerializerInterface $serializer,
        private ExceptionNormalizer $exceptionNormalizer
    )
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $flattenException = FlattenException::createFromThrowable($exception);

        if ($this->exceptionNormalizer->supportsNormalization($flattenException)) {
            $data = $this->exceptionNormalizer->normalize($flattenException);
            $json = $this->serializer->serialize($data, 'json');

            $response = new JsonResponse();
            $response->setContent($json);
            $response->setStatusCode($exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500);

            $event->setResponse($response);
        }
    }
}