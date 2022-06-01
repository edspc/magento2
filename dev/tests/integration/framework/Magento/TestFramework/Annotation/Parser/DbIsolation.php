<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\TestFramework\Annotation\Parser;

use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Annotation\TestCaseAnnotation;
use Magento\TestFramework\Fixture\ParserInterface;
use PHPUnit\Framework\TestCase;

class DbIsolation implements ParserInterface
{
    /**
     * @var string
     */
    private const ANNOTATION = 'magentoDbIsolation';

    /**
     * @inheritdoc
     */
    public function parse(TestCase $test, string $scope): array
    {
        $values = [];
        $annotations = TestCaseAnnotation::getInstance()->getAnnotations($test);

        foreach ($annotations[$scope][self::ANNOTATION] ?? [] as $value) {
            if (!in_array($value, ['enabled', 'disabled'])) {
                throw new LocalizedException(
                    __('Invalid "@%1" annotation, can be "enabled" or "disabled" only.', self::ANNOTATION)
                );
            }
            $values[] = ['state' => $value === 'enabled'];
        }

        return $values;
    }
}
