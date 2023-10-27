<?php
/**
 * MageINIC
 * Copyright (C) 2023 MageINIC <support@mageinic.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category MageINIC
 * @package MageINIC_ExtraFeeGraphql
 * @copyright Copyright (c) 2023 MageINIC (https://www.mageinic.com/)
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MageINIC <support@mageinic.com>
 */

namespace MageINIC\ExtraFeeGraphql\Model\Resolver;

use MageINIC\ExtraFee\Model\ResourceModel\ExtraFee\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Magento\Framework\GraphQl\Query\Resolver\Value;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Cart Details Extra Fee
 */
class CartDetailsExtraFee implements ResolverInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $extraFee;

    /**
     * @param CollectionFactory $extraFee
     */
    public function __construct(
        CollectionFactory           $extraFee,
    ) {
        $this->extraFee = $extraFee;
    }

    /**
     * Fetches the data
     *
     * @param Field $field
     * @param ContextInterface $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return mixed|Value
     * @throws \Exception
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }

        /** @var \Magento\Quote\Model\Quote $cart */
        $cart = $value['model'];

        $payment = $cart->getPayment();
        if (!$payment) {
            return [];
        }
        $selectedPaymentMethod = $payment->getMethod() ?? '';
        $extraFeeCollections = $this->extraFee->create();
        $extraFeeCollections->addFieldToFilter('status', 1);

        foreach ($extraFeeCollections as $extraFee) {
            $paymentMethod = $extraFee->getPaymentMethod();
            if ($paymentMethod === $selectedPaymentMethod) {
                return [
                    'title' => $extraFee->getTitle(),
                    'extra_fee' => $extraFee->getExtraFee()
                ];
            }
        }
        return null;
    }
}
