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

namespace Sylius\InvoicingPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\InvoicingPlugin\Exception\LineItemsCannotBeMerged;

/** @final */
class LineItem implements LineItemInterface, ResourceInterface
{
    /** @var mixed */
    protected $id;

    /** @var InvoiceInterface */
    protected $invoice;

    /** @var string */
    protected $name;

    /** @var string|null */
    protected $variantName;

    /** @var string|null */
    protected $variantCode;

    /** @var int */
    protected $quantity;

    /** @var int */
    protected $unitPrice;

    /** @var int */
    protected $subtotal;

    /** @var string|null */
    protected $taxRate;

    /** @var int */
    protected $taxTotal;

    /** @var int */
    protected $total;

    /** @var string */
    protected $descriptionTimeSlot;

    public function __construct(
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
    ) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->subtotal = $subtotal;
        $this->taxTotal = $taxTotal;
        $this->total = $total;
        $this->variantName = $variantName;
        $this->variantCode = $variantCode;
        $this->taxRate = $taxRate;
        $this->descriptionTimeSlot = $descriptionTimeSlot;
    }

    public function getId()
    {
        return $this->id();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function invoice(): InvoiceInterface
    {
        return $this->invoice;
    }

    public function setInvoice(InvoiceInterface $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function variantName(): ?string
    {
        return $this->variantName;
    }

    public function variantCode(): ?string
    {
        return $this->variantCode;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function unitPrice(): int
    {
        return $this->unitPrice;
    }

    public function subtotal(): int
    {
        return $this->subtotal;
    }

    public function taxRate(): ?string
    {
        return $this->taxRate;
    }

    public function taxTotal(): int
    {
        return $this->taxTotal;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function descriptionTimeSlot(): ?string
    {
        return $this->descriptionTimeSlot;
    }

    public function merge(LineItemInterface $newLineItem): void
    {
        if (!$this->compare($newLineItem)) {
            throw LineItemsCannotBeMerged::occur();
        }

        $this->quantity += $newLineItem->quantity();
        $this->subtotal += $newLineItem->subtotal();
        $this->total += $newLineItem->total();
        $this->taxTotal += $newLineItem->taxTotal();
    }

    public function compare(LineItemInterface $lineItem): bool
    {
        return
            $this->name() === $lineItem->name() &&
            $this->unitPrice() === $lineItem->unitPrice() &&
            $this->taxRate() === $lineItem->taxRate()
        ;
    }
}
