<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\InvoicingPlugin\Factory;

use Sylius\Component\Resource\Exception\UnsupportedMethodException;
use Sylius\InvoicingPlugin\Entity\LineItem;
use Sylius\InvoicingPlugin\Entity\LineItemInterface;

final class LineItemFactory implements LineItemFactoryInterface
{
    private string $className;

    public function __construct(string $className)
    {
        if (!is_a($className, LineItem::class, true)) {
            throw new \DomainException(sprintf(
                'This factory requires %s or its descend to be used as line item resource',
                LineItem::class
            ));
        }

        $this->className = $className;
    }

    public function createNew()
    {
        throw new UnsupportedMethodException('createNew');
    }

    public function createWithData(
        string $name,
        int $quantity,
        int $unitPrice,
        int $subtotal,
        int $taxTotal,
        int $total,
        ?string $variantName = null,
        ?string $variantCode = null,
        ?string $taxRate = null,
        ?string $descriptionTimeSlot = null
    ): LineItemInterface {
        return new $this->className(
            $name,
            $quantity,
            $unitPrice,
            $subtotal,
            $taxTotal,
            $total,
            $variantName,
            $variantCode,
            $taxRate,
            $descriptionTimeSlot
        );
    }
}
