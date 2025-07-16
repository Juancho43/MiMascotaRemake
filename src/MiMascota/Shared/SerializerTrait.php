<?php
namespace App\MiMascota\Shared;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

trait SerializerTrait
        {
            private ?SerializerInterface $serializer = null;

            /**
             * Initialize the serializer if not already set
             */
            private function ensureSerializer(): SerializerInterface
            {
                if ($this->serializer === null) {
                    $this->serializer = new Serializer([new ObjectNormalizer()],[]);
                }

                return $this->serializer;
            }

            public function serialize(mixed $data, array $context = []): array
            {

              return $this->ensureSerializer()->normalize(
                  $data,
                  null,
                  $context
              );
            }
        }
