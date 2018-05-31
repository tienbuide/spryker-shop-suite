<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DemoDataGenerator\Business\Model\ProductConcreteGenerator;

use Generated\Shared\DataBuilder\ProductConcreteBuilder;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Pyz\Zed\DemoDataGenerator\Business\Model\AbstractGenerator;

class ProductConcreteGenerator extends AbstractGenerator implements ProductConcreteGeneratorInterface
{
    const MIN_PRODUCT_BUNDLE_COUNT = 1;
    const MAX_PRODUCT_BUNDLE_COUNT = 5;

    /**
     * @var array
     */
    protected $productAbstractSkus;

    /**
     * @var array
     */
    protected $rows = [];

    /**
     * @param int $rowsNumber
     *
     * @return void
     */
    public function createProductConcreteCsvDemoData(int $rowsNumber): void
    {
        $this->productAbstractSkus = $this->readProductAbstractFromCsv();

        for ($i = 1; $i <= $rowsNumber; $i++) {
            $this->createProductConcreteRow($i);
        }

        $header = array_keys($this->rows[0]);
        $this->writeCsv($header, $this->rows);
    }

    /**
     * @param array $header
     * @param array $rows
     *
     * @return void
     */
    protected function writeCsv(array $header, array $rows): void
    {
        $this->getFileManager()->write($this->getConfig()->getProductConcreteCsvPath(), $header, $rows);
    }

    /**
     * @param int $rowNumber
     *
     * @return void
     */
    protected function createProductConcreteRow(int $rowNumber): void
    {
        $productConcreteTransfer = $this->generateProductConcrete();
        $productAbstractSkuIndex = $rowNumber - 1;
        $productAbstractSku = $this->productAbstractSkus[$productAbstractSkuIndex] ?? '';

        $row = [
            'abstract_sku' => $productAbstractSku,
            'old_sku' => $this->getOldSku($productConcreteTransfer->getSku(), $rowNumber),
            'concrete_sku' => $productConcreteTransfer->getSku(),
            'name.en_US' => '(EN) ' . $productConcreteTransfer->getLocalizedAttributes()[0]->getName(),
            'name.de_DE' => '(DE) ' . $productConcreteTransfer->getLocalizedAttributes()[0]->getName(),
        ];

        $row = array_merge($row, $this->generateAttributes());

        $row = array_merge($row, [
            'icecat_pdp_url' => '',
            'description.en_US' => '(EN) ' . $productConcreteTransfer->getLocalizedAttributes()[0]->getDescription(),
            'description.de_DE' => '(DE) ' . $productConcreteTransfer->getLocalizedAttributes()[0]->getDescription(),
            'is_searchable.en_US' => $productConcreteTransfer->getLocalizedAttributes()[0]->getIsSearchable(),
            'is_searchable.de_DE' => $productConcreteTransfer->getLocalizedAttributes()[0]->getIsSearchable(),
            'icecat_license' => '',
            'bundled' => $this->getRandomBundledProduct(),
        ]);

        $this->rows[] = $row;
    }

    /**
     * @param string $concreteSku
     * @param int $rowNumber
     *
     * @return string
     */
    protected function getOldSku($concreteSku, $rowNumber): string
    {
        $prefix = '';

        if ($rowNumber < 100) {
            $prefix = '0';
        }

        if ($rowNumber < 10) {
            $prefix = '00';
        }

        return $prefix . $rowNumber . '_' . $concreteSku;
    }

    /**
     * @return string
     */
    protected function getRandomBundledProduct(): string
    {
        $withBundleProduct = rand(0, 1);

        if (count($this->rows) && $withBundleProduct) {
            $bundledProductCount = rand(static::MIN_PRODUCT_BUNDLE_COUNT, static::MAX_PRODUCT_BUNDLE_COUNT);

            return $this->getRandomProductSku() . '/' . $bundledProductCount;
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getRandomProductSku(): string
    {
        $maxRowsIndex = max(array_keys($this->rows));
        $randomIndex = rand(0, $maxRowsIndex);

        return $this->rows[$randomIndex]['concrete_sku'];
    }

    /**
     * @return array
     */
    protected function readProductAbstractFromCsv(): array
    {
        return $this->getFileManager()->readColumn($this->getConfig()->getProductAbstractCsvPath());
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    protected function generateProductConcrete(): ProductConcreteTransfer
    {
        return (new ProductConcreteBuilder())
            ->withLocalizedAttributes()
            ->build();
    }

    /**
     * @return array
     */
    protected function generateAttributes(): array
    {
        $attributes = [];

        for ($i = 0; $i < 2; $i++) {
            $attributeIndex = $i + 1;
            $attributes = array_merge($attributes, [
                'attribute_key_' . $attributeIndex => 'att_key_' . $attributeIndex,
                'value_' . $attributeIndex => 'att_val_' . $attributeIndex,
                'attribute_key_' . $attributeIndex . '.en_US' => null,
                'value_' . $attributeIndex . '.en_US' => null,
                'attribute_key_' . $attributeIndex . '.de_DE' => null,
                'value_' . $attributeIndex . '.de_DE' => null,
            ]);
        }

        return $attributes;
    }
}
