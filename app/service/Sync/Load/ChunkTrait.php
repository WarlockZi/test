<?php

namespace app\service\Sync\Load;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;

trait ChunkTrait
{
    /**
     * @throws Exception
     */
    private function process(): void
    {
        foreach ($this->pricesData as $offer) {
            $this->chunk($offer);
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    function optimizedProcess(): array
    {
        $result    = [];
        $chunkSize = 100;
        $rounds    = 2;

        foreach (array_chunk($this->priceData, $chunkSize) as $i => $chunk) {
            if ($rounds && $rounds < $i) {
                break;
            }
            foreach ($chunk as $offer) {
                $this->chunk($offer);
            }
            unset($chunk);
            gc_collect_cycles();
        }
        return $result;
    }

    /**
     * @throws Exception
     */
    private function chunk($offer): void
    {
        $this->prepareOffer($offer);
        $this->firstOrCreateUnit();
        $this->findProductUpdateInstore();

        $this->updateOrCreatePruductUnit();
//        $this->updateOrCreatePrice();
    }
}